<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\MessageBadge;
use App\Models\MessageToken;
use App\Repositories\BlackTokenLogRepository;
use App\Repositories\UserRepository;
use App\Repositories\MessageRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Takaworx\Brix\Entities\ApiResponse;
use Takaworx\Brix\Exceptions\ApiException;
use Illuminate\Support\Facades\DB;

use App\Models\UserLevel;


class UsersController extends Controller
{
    /**
     * Get currently signed in user
     *
     * @param Request $request
     * @return App\Models\User
     */
    public function current(Request $request)
    {

        $user = $request->user()->append('nearest_token_expiration');
      
        if($user['career_level']){

            $career_level = $user['career_level'];

        }else{

            $career_level = 1;

        }

        $max_token_send_to_same_user = DB::select('SELECT max_token_send_to_same_user FROM `user_levels` WHERE career_level='.intval($career_level).';');

        $max_token_send_to_same_user = json_decode(json_encode($max_token_send_to_same_user), true);
         $data['data']['total_max_token_send_to_same_user'] =   $max_token_send_to_same_user['0']['max_token_send_to_same_user'];
        $max_token_send_to_same_user = intval($data['data']['total_max_token_send_to_same_user']);

        $maxtokenallowed = intval($max_token_send_to_same_user);

        if( $maxtokenallowed < 0 ){

            $maxtokenallowed = 0;
        }

        $user['maximum_token_limit'] = $maxtokenallowed;

        return $user;

    }

    /**
     * Fetch a user by id
     *
     * @param int $user_id
     * @param UserRepository $userRepo
     * @return ApiResponse
     */
    public function get($user_id, UserRepository $userRepo)
    {
        $user = $userRepo->find($user_id);

        if (is_null($user)) {
            return ApiResponse::exception(ApiException::notFound());
        }

        return ApiResponse::success($user);
    }

    /**
     * Get a collection of users
     *
     * @param Request $request
     * @param App\Models\User $users
     * @return ApiResponse
     */
    public function index(Request $request, UserRepository $users)
    {
        if ($request->filled('search')) {
            $query = $users->search('name', $request->input('search'));
        } else {
            $query = $users;
        }
        if (!$request->filled('blast')) {
            $query = $query->where('id', '!=', $request->user()->id);
        }

        if ($request->filled('orderBy') && $request->filled('orderDirection')) {
            $query = $query->orderBy($request->input('orderBy'), $request->input('orderDirection'));
        }

        $result = $users->pager($query);

        return ApiResponse::success($result);
    }

    public function badges(Request $request, MessageRepository $messageRepo)
    {
        $userID = $request->user()->id;

        if ($request->filled('user_id')) {
            $userID = $request->input('user_id');
        }

        $badges = MessageBadge::selectRaw('count(id), count(id) AS badge_count, type AS badge_id')
            ->groupBy('badge_id')
            ->where('recipient_user_id', $userID)
            ->get();

        if ($badges instanceof \Exception) {
            return ApiResponse::exception($badges);
        }

        $totalBadges = MessageBadge::where('recipient_user_id', $userID)->count();

        $totalBadgesSent = MessageBadge::where('sender_user_id', $userID)->count();

        $sendCount = MessageToken::where('sender_user_id', $userID)->get()->sum('amount');

        if ($sendCount instanceof \Exception) {
            return ApiResponse::exception($sendCount);
        }

        $receiveCount = MessageToken::where('recipient_user_id', $userID)->get()->sum('amount');

        if ($receiveCount instanceof \Exception) {
            return ApiResponse::exception($receiveCount);
        }

        $result = [
            'badges'           => $badges,
            'totalBadges'      => $totalBadges,
            'totalBadgesSent'  => $totalBadgesSent,
            'sendCount'        => $sendCount,
            'receiveCount'     => $receiveCount,
        ];

        return ApiResponse::success($result);
    }

    /**
     * Get the message of currently logged in user
     *
     * @param Request $request
     * @param MessageRepository $messageRepo
     * @return ApiResponse
     */
    public function nominations(Request $request, MessageRepository $messageRepo)
    {
        $userID = $request->user()->id;

        if ($request->filled('user_id')) {
            $userID = $request->input('user_id');
        }

        if ($request->has('type') && $request->input('type') === 'sent') {
            $query = $messageRepo->where('messages.sender_user_id', $userID);
        } else {
            $query = $messageRepo->where('messages.recipient_user_id', $userID);
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query = $query->where(function ($q) use ($search) {
                $q->where('message', 'like', "%$search%")
                    ->orWhereHas('sender', function ($sq) use ($search) {
                        $sq->where('name', 'like', "%$search%");
                    })
                    ->orWhereHas('recipient', function ($sq) use ($search) {
                        $sq->where('name', 'like', "%$search%");
                    })
                    ->orWhereHas('messageBadge.badge', function ($sq) use ($search) {
                        $sq->where('name', 'like', "%$search%");
                    });
            });
        }

        if (! $request->filled('sort')) {
            $query = $query->orderBy('id', 'desc');
        }

        $result = $messageRepo->pager($query);

        return ApiResponse::success($result);
    }

    public function transactions(
        Request $request,
        BlackTokenLogRepository $blackTokenLogRepo,
        MessageRepository $messageRepo
    ) {
        $user = $request->user();

        switch ($request->input('type')) {
            default:
            case 'sent':
                $repo = $messageRepo;
                $query = $repo->where('messages.sender_user_id', $user->id);
                break;
            case 'received':
                $repo = $messageRepo;
                $query = $repo->where('messages.recipient_user_id', $user->id);
                break;
            case 'black_token':
                $repo = $blackTokenLogRepo;
                $query = $repo->with('user')
                    ->where('user_id', $user->id)
                    ->wheremarks('action', BlackTokenLogRepository::ACTION_CREDIT);
                break;
        }

        if ($request->filled('from')) {
            $from = Carbon::createFromFormat('Y-m-d', $request->input('from'));
            $from->hour = 0;
            $from->minute = 0;
            $from->second = 0;
            $query = $query->where('created_at', '>=', $from->toDateTimeString());
        }

        if ($request->filled('to')) {
            $to = Carbon::createFromFormat('Y-m-d', $request->input('to'));
            $to->hour = 23;
            $to->minute = 59;
            $to->second = 59;
            $query = $query->where('created_at', '<=', $to->toDateTimeString());
        }

        $result = $repo->pager($query);

        if ($result instanceof \Exception) {
            return ApiResponse::exception(
                ApiException::serverError($result->getMessage())
            );
        }

        return ApiResponse::success($result);
    }

    /**
     * Logout the user
     */
    public function logout()
    {
        Auth::logout();

        return redirect()->route('web.login');
    }
}
