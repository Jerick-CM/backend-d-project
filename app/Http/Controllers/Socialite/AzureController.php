<?php

namespace App\Http\Controllers\Socialite;

use App\Helpers\AzureHelper;
use App\Helpers\GraphHelper;
use App\Http\Controllers\Controller;
use App\Models\BlackTokenLog;
use App\Models\Department;
use App\Models\Position;
use App\Models\ServiceLine;
use App\Models\UserLevel;
use App\Models\User;
use App\Repositories\BlackTokenLogRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Takaworx\Brix\Entities\ApiResponse;
use Takaworx\Brix\Exceptions\ApiException;
use Socialite;

class AzureController extends Controller
{
    /**
     * @var UserRepository repository instance
     */
    protected $userRepo;

    /**
     * @var GraphHelper MS Graph helper instance
     */
    protected $graphHelper;

    /**
     * @var AzureHelper
     */

    /**
     * Initialize the class
     *
     * @param UserRepository
     * @param GraphHelper
     * @return void
     */
    public function __construct(UserRepository $userRepo, GraphHelper $graphHelper, AzureHelper $azureHelper)
    {
        $this->userRepo = $userRepo;
        $this->graphHelper = $graphHelper;
        $this->azureHelper = $azureHelper;
    }

    /**
     * Handle the provider (Microsoft/Azure) callback
     */
    public function handleProviderCallback(Request $request)
    {
        // $auth = $this->azureHelper->login($request);

        // if ($auth instanceof \Throwable) {
        //     \Log::error($auth);
        //     return ApiResponse::error(
        //         500,
        //         json_decode($auth->getResponse()->getBody()->getContents())
        //     );
        // }

        // $token = $auth->access_token;

        // $requestUser = $this->graphHelper
        //     ->setToken($token)
        //     ->run('GET', 'me', null, [
        //         'Content-type' => 'application/json'
        //     ]);

        // if ($requestUser instanceof \Exception) {
        //     dd($azureUser->getResponse()->getBody()->getContents());
        //     throw $azureUser;
        // }

        // $azureUser = json_decode($requestUser->getBody()->getContents());

        $azureUser = new \stdClass;
        $azureUser->id = '679706b0-2d8e-43b1-8392-53c9e7286f79';
        $azureUser->jobTitle = 'Intern';
        $azureUser->onPremisesExtensionAttributes = new \stdClass;
        $azureUser->displayName = 'Bak, Carie-Anne';
        $azureUser->userPrincipalName = 'eric.cao@expressitservice.com';
        $azureUser->onPremisesExtensionAttributes->extensionAttribute6 = 'Intern';
        $azureUser->onPremisesExtensionAttributes->extensionAttribute7 = 'Computing';
        $azureUser->onPremisesExtensionAttributes->extensionAttribute8 = 1;

        $user = $this->findUser($azureUser);

        if (! $user) {
            throw new \Exception("You do not have permission to access the page" . json_encode( $azureUser));
        }

        $authToken = $this->authenticate($user);

        if ($authToken instanceof \Exception) {
            throw $authToken;
        }

        $updateUserAvatar = $this->updateUserAvatar($user, $azureUser);

        if ($updateUserAvatar instanceof \Exception) {
            throw $updateUserAvatar;
        }

        if ($request->expectsJson()) {
            return ApiResponse::success($authToken);
        }

        return redirect()->route('web.home');
    }

    /**
     * Find the azure user in DB if exists
     *
     * @param object $azureUser
     * @return App\Models\User
     */
    protected function findUser($azureUser)
    {
        // Check if user is disabled
        // if (! $azureUser->accountEnabled) {
        //     return null;
        // }

        // $interns = explode(',', config('cron.sync_interns'));

        // // Check if user is intern
        // if (! empty($azureUser->jobTitle) && in_array($azureUser->jobTitle, $interns)) {
        //     return null;
        // }


        // Check if user department is blocked
        // if (config('user.use_department_attr')) {
        //     $department = $azureUser->department;
        // } else {
        //     $department = $azureUser->onPremisesExtensionAttributes->extensionAttribute6;
        // }

        // $excludedDepartments = explode(',', config('cron.sync_exclude_departments'));

        // if (is_null($department) || empty($department) || in_array($department, $excludedDepartments)) {
        //     return null;
        // }
        $user = $this->userRepo
            ->where('azure_id', $azureUser->id)
            ->first();

        if (! $user) {
            return $this->createUser($azureUser);
        }

        return $this->updateUser($user, $azureUser);
    }

    /**
     * Create a new user from the azure user
     *
     * @param object $azureUser
     * @return App\Models\User
     */
    protected function createUser($azureUser)
    {
        $data = [
            'azure_id' => $azureUser->id,
            'name' => $azureUser->displayName,
            'email' => $azureUser->userPrincipalName,
            'is_active' => 1
        ];

        if (config('user.use_department_attr')) {
            $departmentName = $azureUser->department;
        } else {
            $departmentName = $azureUser->onPremisesExtensionAttributes->extensionAttribute6;
        }

        if ($departmentName) {
            $department = Department::firstOrCreate([
                'name' => $departmentName,
            ]);

            $data['department_id'] = $department->id;
        }

        if ($azureUser->jobTitle) {
            $position = Position::firstOrCreate([
                'name' => $azureUser->jobTitle,
            ]);

            $data['position_id'] = $position->id;
        }

        if ($azureUser->onPremisesExtensionAttributes->extensionAttribute7) {
            $serviceLine = ServiceLine::firstOrCreate([
                'name' => $azureUser->onPremisesExtensionAttributes->extensionAttribute7,
            ]);

            $data['service_line_id'] = $serviceLine->id;
        }

        if ($azureUser->onPremisesExtensionAttributes->extensionAttribute8) {
            $userLevel = UserLevel::firstOrCreate([
                'career_level' => $azureUser->onPremisesExtensionAttributes->extensionAttribute8,
            ]);

            $data['career_level'] = $userLevel->career_level;
        }

        $user = $this->userRepo->create($data);

        if (is_null($user->career_level)) {
            return $user;
        }

        $userLevel = UserLevel::where('career_level', $user->career_level)->first();

        if (! $userLevel) {
            app('sentry')->captureException(
                new \Exception("The user's (id: {$user->id}) career level does not exist!")
            );

            return $user;
        }

        $amount = $userLevel->monthly_token_allocation - $user->black_token;

        // Skip if user does not need replenishing of black tokens
        if ($amount <= 0) {
            return $user;
        }

        $blackTokenLogRepo = new BlackTokenLogRepository();

        $blackTokenLogRepo->send([
            'user_id' => $user->id,
            'action'  => BlackTokenLog::ACTION_CREDIT,
            'amount'  => $amount,
        ]);

        return $user;
    }

    /**
     * Synchronize user data with Azure AD
     *
     * @param App\Models\User $user
     * @param object $azureUser
     * @return App\Models\User
     */
    protected function updateUser($user, $azureUser)
    {
        $user->name = $azureUser->displayName;
        $user->email = $azureUser->userPrincipalName;

        if (config('user.use_department_attr')) {
            $departmentName = $azureUser->department;
        } else {
            $departmentName = $azureUser->onPremisesExtensionAttributes->extensionAttribute6;
        }

        if ($departmentName) {
            $department = Department::firstOrCreate([
                'name' => $departmentName,
            ]);

            $user->department_id = $department->id;
        }

        if ($azureUser->jobTitle) {
            $position = Position::firstOrCreate([
                'name' => $azureUser->jobTitle,
            ]);

            $user->position_id = $position->id;
        }

        if ($azureUser->onPremisesExtensionAttributes->extensionAttribute7) {
            $serviceLine = ServiceLine::firstOrCreate([
                'name' => $azureUser->onPremisesExtensionAttributes->extensionAttribute7,
            ]);

            $user->service_line_id = $serviceLine->id;
        }

        if ($azureUser->onPremisesExtensionAttributes->extensionAttribute8) {
            $userLevel = UserLevel::firstOrCreate([
                'career_level' => $azureUser->onPremisesExtensionAttributes->extensionAttribute8,
            ]);

            $user->career_level = $userLevel->career_level;
        }

        $user->save();

        return $user;
    }

    /**
     * Synchronize the user avatar with Azure AD
     *
     * @param App\Models\User $user
     * @param object $azureUser
     * @return App\Models\User|\Exception
     */
    protected function updateUserAvatar($user, $azureUser)
    {
        $user = DB::transaction(function () use ($user, $azureUser) {
            // Get user photo from MS Graph API
            $response = $this->graphHelper->run('GET', 'me/photo/$value');

            if ($response instanceof \Exception) {
                return $user;
            }

            // Get the image file contents
            $userPhoto = $response->getBody()->getContents();

            // Get the image file type
            $userPhotoType = $response->getHeader('Content-Type');
            $userPhotoType = explode('/', $userPhotoType[0]);
            $userPhotoType = strtolower($userPhotoType[1]);
            $userPhotoType = $userPhotoType === 'jpeg' ? 'jpg' : $userPhotoType;

            // Get original photo name for deletion later
            $origPhoto = $user->getOriginal('avatar');

            // Create the new photo using result from Graph and save to DB
            $filename = str_random(32) . '.' . $userPhotoType;

            Storage::put("avatar/$filename", $userPhoto);

            $user->avatar = $filename;
            $user->save();

            // Delete original photo for disk space management
            Storage::delete("avatar/$origPhoto");

            return $user;
        });

        return $user;
    }

    /**
     * Authenticate the given user model
     *
     * @param App\Models\User $user
     * @return bool|\Exception
     */
    protected function authenticate($user)
    {
        try {
            $user = User::where('is_active', 1)->find($user->id);

            if (! $user) {
                throw new \Exception("User not activated");
            }

            $token = $user->createToken("Personal Access Token");
        } catch (\Exception $e) {
            return $e;
        }

        return $token;
    }
}
