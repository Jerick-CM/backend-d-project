<?php

namespace App\Console\Commands;

use App\Helpers\GraphHelper;
use App\Models\BlackTokenLog;
use App\Models\Department;
use App\Models\Position;
use App\Models\ServiceLine;
use App\Models\UserLevel;
use App\Models\LikedMessage;
use App\Models\Message;
use App\Models\MessageBadge;
use App\Models\MessageToken;
use App\Models\CartItem;
use App\Models\User;
use App\Repositories\BlackTokenLogRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AzureSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'azure:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize azure data';

    /**
     * Instance of GraphHelper
     *
     * @var GraphHelper
     */
    protected $graphHelper;

    /**
     * Instance of UserRepository
     *
     * @var UserRepository
     */
    protected $users;

    /**
     * Array of successful sync
     *
     * @var array
     */
    protected $success = [];

    /**
     * Array of failed sync
     *
     * @var array
     */
    protected $failed = [];

    /**
     * Array of skipped sync due to being excluded
     *
     * @var array
     */
    protected $skipped = [];

    /**
     * Log report of the synchronization
     *
     * @var string
     */
    protected $log;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(GraphHelper $graphHelper, UserRepository $users)
    {
        parent::__construct();

        $this->graphHelper = $graphHelper;
        $this->users = $users;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->syncUsers();
    }

    public function syncUsers()
    {
        $token = $this->graphHelper->authenticateApp();

        $azureUsers = $this->gatherUsers($token);


        foreach ($azureUsers as $azureUser) {
            if (! $azureUser->accountEnabled) {
                $this->handleDisabledUser($azureUser);
                continue;
            }

            if (config('app.env') == 'production') {
                if ($azureUser->onPremisesExtensionAttributes->extensionAttribute8 == null) {
                    continue;
                }

                if (! $azureUser->onPremisesExtensionAttributes->extensionAttribute8) {
                    continue;
                }
            }

            $interns = explode(',', config('cron.sync_interns'));

            // Check if user is intern
            if (! empty($azureUser->jobTitle) && in_array($azureUser->jobTitle, $interns)) {
                continue;
            }

            $partners = explode(',', config('cron.sync_partners'));
            $pseudoPartners = explode(',', config('cron.sync_pseudo_partners'));

            $isCareerLevel9 = $azureUser->onPremisesExtensionAttributes->extensionAttribute8 == 9;
            $isAzureUserPartner = ! empty($azureUser->employeeType) && in_array($azureUser->employeeType, $partners);
            $isAzureUserPseudoPartner = ! empty($azureUser->jobTitle)
                && in_array($azureUser->jobTitle, $pseudoPartners);

            if ($isAzureUserPseudoPartner) {
                $azureUser->onPremisesExtensionAttributes->extensionAttribute8 = 9;
            }

            if ($isCareerLevel9 || $isAzureUserPartner || $isAzureUserPseudoPartner) {
                $isPartner = 1;
            } else {
                $isPartner = 0;
            }

            $department  = $this->getOrCreateDepartment($azureUser);
            $position    = $this->getOrCreatePosition($azureUser);
            $serviceLine = $this->getOrCreateServiceLine($azureUser);
            $careerLevel = $this->getOrCreateCareerLevel($azureUser);


            if (is_null($department)) {
                $this->log('skipped', $azureUser);
                continue;
            }

            $user = $this->users
                ->withTrashed()
                ->where('azure_id', $azureUser->id)
                ->first();

            $photoResponse = $this->graphHelper
                ->setToken($token)
                ->run('GET', 'users/' . $azureUser->id . '/photo/$value');

            try {
                DB::beginTransaction();

                if (is_null($user)) {
                    $user = $this->createUser(
                        $azureUser,
                        $department,
                        $position,
                        $serviceLine,
                        $careerLevel,
                        $isPartner
                    );
                } else {
                    $user = $this->updateUser(
                        $user,
                        $azureUser,
                        $department,
                        $position,
                        $serviceLine,
                        $careerLevel,
                        $isPartner
                    );
                }

                if (!$photoResponse instanceof \Exception) {
                    $user = $this->updatePhoto($user, $photoResponse);
                }

                $this->log('success', $azureUser);

                DB::commit();
            } catch (\Throwable $e) {
                DB::rollBack();
                $this->log('failed', $azureUser);
                throw $e;
            }
        }

        $this->saveLog();
    }

    protected function gatherUsers($token)
    {
        $results = [];
        $nextQuery = null;

        $syncUsersCountry = config('cron.sync_users_country');

        do {
            if (is_null($nextQuery) && ! is_null($syncUsersCountry)) {
                $url = 'users?$filter=country eq '. "'$syncUsersCountry'";
            } else {
                $url = 'users?' . $nextQuery;
            }

            $response = $this->graphHelper
                ->setToken($token)
                ->run('GET', $url);

            $result = json_decode($response->getBody()->getContents());

            if (property_exists($result, '@odata.nextLink')) {
                $nextLink = stripslashes($result->{'@odata.nextLink'});
                $nextQuery = parse_url($nextLink, PHP_URL_QUERY);
            } else {
                $nextQuery = null;
            }

            $results = array_merge($results, $result->value);
        } while (! is_null($nextQuery));

        return $results;
    }

    protected function createUser($azureUser, $department, $position, $serviceLine, $careerLevel, $isPartner)
    {
        $user = $this->users
            ->create([
                'azure_id' => $azureUser->id,
                'name'     => $azureUser->displayName,
                'email'    => $this->getAzureUserEmail($azureUser),
                'department_id' => $department ? $department->id : null,
                'position_id'   => $position ? $position->id : null,
                'service_line_id' => $serviceLine ? $serviceLine->id : null,
                'career_level'    => $careerLevel ? $careerLevel->career_level : null,
                'is_partner' => $isPartner,
                'is_active' => 1,
            ]);

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

    protected function updateUser($user, $azureUser, $department, $position, $serviceLine, $careerLevel, $isPartner)
    {
        if (! is_null($user->deleted_at)) {
            $this->restoreUser($user);
        }
//        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
//        $out->writeln('$isPartner:' . $isPartner);


        $user->name  = $azureUser->displayName;
        $user->email = $this->getAzureUserEmail($azureUser);
        $user->department_id = $department ? $department->id : null;
        $user->position_id = $position ? $position->id : null;
        $user->service_line_id = $serviceLine ? $serviceLine->id : null;
        $user->career_level  = $careerLevel ? $careerLevel->career_level : null;

        if (($user->is_manual & 1) != 1) //1 - for manual partner; 2 - for manual admin ; 4 - for manual portal access
            $user->is_partner = $isPartner;
        $user->save();

        return $user;
    }

    protected function updatePhoto($user, $response)
    {
        // Get original photo name for deletion later
        $origPhoto = $user->getOriginal('avatar');

        // Get the image file contents
        $userPhoto = $response->getBody()->getContents();

        // Get the image file type
        $userPhotoType = $response->getHeader('Content-Type');
        $userPhotoType = explode('/', $userPhotoType[0]);
        $userPhotoType = strtolower($userPhotoType[1]);
        $userPhotoType = $userPhotoType === 'jpeg' ? 'jpg' : $userPhotoType;

        // Create the new photo using result from Graph and save to DB
        $filename = str_random(32) . '.' . $userPhotoType;

        Storage::put("avatar/$filename", $userPhoto);

        $user->avatar = $filename;
        $user->save();

        // Delete original photo for disk space management
        Storage::delete("avatar/$origPhoto");

        return $user;
    }

    protected function getAzureUserEmail($azureUser)
    {
        return ! is_null($azureUser->mail) ? $azureUser->mail : $azureUser->userPrincipalName;
    }

    protected function getOrCreateDepartment($azureUser)
    {
        if (config('user.use_department_attr')) {
            $department = $azureUser->department;
        } else {
            $department = $azureUser->onPremisesExtensionAttributes->extensionAttribute6;
        }

        $excludedDepartments = explode(',', config('cron.sync_exclude_departments'));

        if (is_null($department) || empty($department) || in_array($department, $excludedDepartments)) {
            return null;
        }

        return Department::firstOrCreate([
            'name' => $department,
        ]);
    }

    protected function getOrCreatePosition($azureUser)
    {
        if (is_null($azureUser->jobTitle) || empty($azureUser->jobTitle)) {
            return null;
        }

        return Position::firstOrCreate([
            'name' => $azureUser->jobTitle,
        ]);
    }

    protected function getOrCreateServiceLine($azureUser)
    {
        $isNull  = is_null($azureUser->onPremisesExtensionAttributes->extensionAttribute7);
        $isEmpty = empty($azureUser->onPremisesExtensionAttributes->extensionAttribute7);

        if ($isNull || $isEmpty) {
            return null;
        }

        return ServiceLine::firstOrCreate([
            'name' => $azureUser->onPremisesExtensionAttributes->extensionAttribute7,
        ]);
    }

    protected function getOrCreateCareerLevel($azureUser)
    {
        $isNull  = is_null($azureUser->onPremisesExtensionAttributes->extensionAttribute8);
        $isEmpty = empty($azureUser->onPremisesExtensionAttributes->extensionAttribute8);

        if ($isNull || $isEmpty) {
            return null;
        }

        return UserLevel::firstOrCreate([
            'career_level' => $azureUser->onPremisesExtensionAttributes->extensionAttribute8,
        ]);
    }

    /**
     * Push the azureUser to either the success, failed, or skipped arrays
     *
     * @param string $type
     * @param object $azureUser
     * @return void
     */
    private function log($type, $azureUser)
    {
        switch ($type) {
            default:
            case 'success':
                $this->success[] = $azureUser;
                break;
            case 'failed':
                $this->failed[] = $azureUser;
                break;
            case 'skipped':
                $this->skipped[] = $azureUser;
                break;
        }
    }

    /**
     * Save the log
     *
     * @return void
     */
    private function saveLog()
    {
        $timestamp = Carbon::now()->toDateTimeString();
        $timestampSafe = Carbon::now()->format('Y-m-d_His');

        $successCount = count($this->success);
        $failedCount  = count($this->failed);
        $skippedCount = count($this->skipped);

        $this->report  = "$successCount users successfully sync'd\n";
        $this->report .= "$failedCount users failed to sync\n";
        $this->report .= "$skippedCount users skipped synchronization due to null department or excluded department\n\n\n";

        $this->report .= "SUCCESSFUL SYNC";

        foreach ($this->success as $successUser) {
            $this->report .= $successUser->id . ", ";
            $this->report .= $successUser->displayName . ", ";
            $this->report .= $successUser->onPremisesExtensionAttributes->extensionAttribute8 . ", ";
            $this->report .= $successUser->jobTitle . ", ";

            if (property_exists($successUser, 'employeeType')) {
                $this->report .= $successUser->employeeType . ", ";
            }

            $this->report .= $successUser->onPremisesExtensionAttributes->extensionAttribute6 . "\n";
        }

        $this->report .= "\n\n";

        $this->report .= "FAILED SYNC";

        foreach ($this->failed as $failedUser) {
            $this->report .= $failedUser->id . ", ";
            $this->report .= $failedUser->displayName . ", ";
            $this->report .= $failedUser->onPremisesExtensionAttributes->extensionAttribute8 . ", ";
            $this->report .= $failedUser->jobTitle . ", ";

            if (property_exists($failedUser, 'employeeType')) {
                $this->report .= $failedUser->employeeType . ", ";
            }

            $this->report .= $failedUser->onPremisesExtensionAttributes->extensionAttribute6 . "\n";
        }

        $this->report .= "\n\n";

        $this->report .= "SKIPPED SYNC";

        foreach ($this->skipped as $skippedUser) {
            $this->report .= $skippedUser->id . ", ";
            $this->report .= $skippedUser->displayName . ", ";
            $this->report .= $skippedUser->onPremisesExtensionAttributes->extensionAttribute8 . ", ";
            $this->report .= $skippedUser->jobTitle . ", ";

            if (property_exists($skippedUser, 'employeeType')) {
                $this->report .= $skippedUser->employeeType . ", ";
            }

            $this->report .= $skippedUser->onPremisesExtensionAttributes->extensionAttribute6 . "\n";
        }

        Storage::put("logs/sync/sync_$timestampSafe.log", $this->report);

        Mail::raw("Attached to this email is the sync log report", function ($message) use ($timestampSafe) {
            $message = $message->attach(storage_path("app/logs/sync/sync_$timestampSafe.log"), [
                'as' => "sync_$timestampSafe.log",
            ]);

            $message->to(explode(',', config('ace.support_email')))->subject("Sync Report");
        });
    }

    /**
     * Delete the user if exists
     *
     * @return void
     */
    private function handleDisabledUser($azureUser)
    {
        $user = $this->users
            ->where('azure_id', $azureUser->id)
            ->first();

        if (! $user) {
            return;
        }

        DB::transaction(function () use ($user) {
            LikedMessage::where('user_id', $user->id)
                ->delete();

            Message::where('sender_user_id', $user->id)
                ->orWhere('recipient_user_id', $user->id)
                ->delete();

            MessageBadge::where('sender_user_id', $user->id)
                ->orWhere('recipient_user_id', $user->id)
                ->delete();

            MessageToken::where('sender_user_id', $user->id)
                ->orWhere('recipient_user_id', $user->id)
                ->delete();

            CartItem::where('user_id', $user->id)
                ->delete();

            User::where('id', $user->id)
                ->delete();
        });
    }

    /**
     * Restore a deleted user
     *
     * @param User $user
     * @return void
     */
    private function restoreUser($user)
    {
        $user->restore();
    }
}
