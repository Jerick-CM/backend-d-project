<?php

namespace App\Http\Controllers\Rewards;

use App\Http\Controllers\Controller;
use App\Http\Requests\Nominations\SendNominationRequest;
use App\Http\Requests\Nominations\LikeNominationRequest;
use App\Mail\NominationSenderMail;
use App\Mail\NominationRecipientMail;
use App\Mail\WelcomeMail;
use App\Mail\NominationTierPromotionMail;


use App\Models\Message;
use App\Models\User;
use App\Models\MessageToken;
use App\Models\MessageBadge;
use App\Models\Badge;
use App\Models\Myrewards;

use App\Events\AdminLogEvent;
use App\Models\AdminLog;

// App\Repositories are models
use App\Repositories\MessageRepository;
use App\Repositories\UserRepository;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Takaworx\Brix\Entities\ApiResponse;
use Takaworx\Brix\Exceptions\ApiException;

class NominationsController extends Controller
{
    /**
     * Get a collection of the model
     *
     * @param Request $request
     * @param MessageRepository $messageRepo
     * @return ApiResponse
     */
    public function index(Request $request, MessageRepository $messageRepo)
    {
        $query = $messageRepo;

        if ($request->filled('start')) {
            $query = $query->where('id', '<=', $request->input('start'));
            // $query = $query->where('id', '<=', $request->input('start'))->where('deleted', '=', 0);
        }

        if ($request->has('departments')) {
            $query = $query->whereHas('recipient', function ($q) use ($request) {
                $q->whereIn('department_id', $request->departments);
                // $q->whereIn('department_id', $request->departments)->where('deleted', '=', 0);
            });
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query = $query->where(function ($q) use ($search) {
                $q->where('message', 'like', "%$search%")
                     // ->where('deleted', '=', 0)

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
            // $query = $query->orderBy('id', 'desc');
            $did = $request->user()->department_id ? $request->user()->department_id : 'NULL';
            $slid = $request->user()->service_line_id ? $request->user()->service_line_id : 'NULL';
            $query = $query->joinRelations('recipient')
                ->joinRelations('recipient.department')
                ->joinRelations('recipient.serviceLine')
                ->orderByRaw("FIELD(departments.id, $did) DESC, FIELD(service_lines.id, $slid) DESC, id DESC");
        }

        return $messageRepo->pager($query);
    }

    /**
     * Create a new record of the model
     *
     * @param SendNominationRequest $request
     * @param MessageRepository $messageRepo
     * @param UserRepository $userRepo
     * @return ApiResponse
     */

    public function store(SendNominationRequest $request, MessageRepository $messageRepo, UserRepository $userRepo)
    {

        // if ($request->user()->black_token < $request->input('credits')) {

        //     return ApiResponse::exception(ApiException::badRequest([
        //         'black_token' => __('nomination.black_token.insufficient')

        //         // __ double undescrore mean language reference in laravel
        //         // resouces/lang/en/nomination/ 'black_token'=> [ 'insufficient' => string ]

        //     ]));

        // }

        try {

            $recipient_user_id = $request->input('id');

            //badgecount before START

            $MessageBadge_recipient = MessageBadge::where('recipient_user_id', '=',$recipient_user_id)->get();
            $datum['badgecount_old'] = $MessageBadge_recipient->count();
            $message['badgecount_old'] = $datum['badgecount_old'];

            if(intval($datum['badgecount_old']) <= 60 || intval($datum['badgecount_old']) == Null){

                $tier_old = 1;
                $tier_old_description = 'Rising Star';

            }elseif (intval($datum['badgecount_old']) > 60  && intval($datum['badgecount_old']) <= 240 ) {

                $tier_old = 2;
                $tier_old_description =  'Shining Star';

            }elseif (intval($datum['badgecount_old']) > 240  && intval($datum['badgecount_old']) <= 480 ) {

                $tier_old= 3;
                $tier_old_description =  'Shooting Star';

            }elseif (intval($datum['badgecount_old']) > 480  && intval($datum['badgecount_old']) <= 800 ) {

                $tier_old = 4;
                $tier_old_description =  'Super Star';

            }elseif (intval($datum['badgecount_old']) > 800 ) {

                $tier_old = 5;
                $tier_old_description = 'Megastar';
            }

            //badgecount before END


            DB::beginTransaction();

            $sender_user_id = $request->user()->id;

            $badge_type = $request->input('badge_id');
            $token_amount = 0;

            if ($request->filled('credits')) {
                $token_amount = $request->input('credits');
            }

            $message = $messageRepo->sendMessage(
                $sender_user_id,
                $recipient_user_id,
                $badge_type,
                $token_amount,
                $request->input('message')
            );

            DB::commit();

            //badgecount after START
            $MessageBadge_recipient = MessageBadge::where('recipient_user_id', '=', $request->input('id'))->get();
            $datum['badgecount_new'] = $MessageBadge_recipient->count();

            $message['badgecount_old'] = $datum['badgecount_old'];
            $message['badgecount_new'] = $datum['badgecount_new'];

            if(intval($datum['badgecount_new']) <= 60 || intval($datum['badgecount_new']) == Null){

                $tier_new = 1;
                $tier_new_description = 'Rising Star';

            }elseif (intval($datum['badgecount_new']) > 60  && intval($datum['badgecount_new']) <= 240 ) {

                $tier_new = 2;
                $tier_new_description =  'Shining Star';

            }elseif (intval($datum['badgecount_new']) > 240  && intval($datum['badgecount_new']) <= 480 ) {

                $tier_new= 3;
                $tier_new_description =  'Shooting Star';

            }elseif (intval($datum['badgecount_new']) > 480  && intval($datum['badgecount_new']) <= 800 ) {

                $tier_new = 4;
                $tier_new_description =  'Super Star';

            }elseif (intval($datum['badgecount_new']) > 800 ) {

                $tier_new = 5;
                $tier_new_description = 'Megastar';

            }

            //badgecount after END

            if( $tier_new != $tier_old ){

                $myrewardstable = Myrewards::find( intval($tier_new - 1));

                $table_users = User::find($message['recipient_user_id']);

                if($table_users['green_token']){
                    $greentoken = intval($table_users['green_token']);
                    $total_green_token = intval($table_users['green_token']) + intval($myrewardstable['rewardstoken']);

                }else{
                    $greentoken = 0;
                    $total_green_token = 0 + intval($myrewardstable['rewardstoken']);
                }
                switch ($tier_new) {
                    case 2:
                    //Shining Star
                    $table_users->rising_shining_star_token =  intval($myrewardstable['rewardstoken']);
                    break;
                    case 3:
                    //Shooting Star
                    $table_users->shining_shooting_star_token =  intval($myrewardstable['rewardstoken']);
                    break;
                    case 4:
                    //Super Star
                    $table_users->shooting_super_star_token =  intval($myrewardstable['rewardstoken']);

                    break;
                    case 5:
                    //Megastar
                    $table_users->super_mega_star_token =  intval($myrewardstable['rewardstoken']);

                    break;
                }
                $table_users->green_token = $total_green_token;
                $table_users->save();

                $data = Message::find($message->id);

                event(new AdminLogEvent($data['recipient']['id'], AdminLog::TYPE_PROMOTION_REWARDSTOKEN, [
                    'admin' => 'autogenerated',
                    'tier_old' => $tier_new_description,
                    'tier_new' => $tier_old_description,
                    'recipient_name' => $data['recipient']['name'],
                    'recipient_id' => $data['recipient']['id'],
                    'sender_name' => $data['sender']['name'],
                    'sender_id' => $data['sender']['id'],
                    'green_token_before' => $greentoken,
                    'green_token_after' => $total_green_token,
                    'rewardtoken' => intval($myrewardstable['rewardstoken']),
                    'badge_name' => $data['badge']['name'],
                    'badge_id' => $data['badge']['id']
                ]));

                // Mail to recipient
                $mymessage =  __('edm.badgepromotion.description', [
                        'oldbadge' =>  $tier_old_description,
                        'newbadge' =>  $tier_new_description,
                        'rewardstoken' =>   intval($myrewardstable['rewardstoken'])
                ]);

                switch (intval($tier_new)) {
                    // case 1:
                    //     $tier_next = 'Shining Star';
                    // break;
                    case 2:
                        $tier_next = 'Shooting Star';
                    break;
                    case 3:
                        $tier_next = 'Super Star';
                    break;
                    case 4:
                        $tier_next = 'Megastar';
                    break;
                    case 5:
                        $tier_next = '';
                    break;
                }

                // $tier_next = '';

                $messagerewardstoken = intval($myrewardstable['rewardstoken']);

                $time = Carbon::createFromFormat('Y-m-d H:i:s', $message->created_at)->format('h:i A');
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $message->created_at)->format('d F Y');

               switch ($_SERVER['SERVER_NAME']){
                    case 'deloitte-backend.local.nmgdev.com':

                        break;
                    default:

                        Mail::to($message->recipient->email)->send(new NominationTierPromotionMail(
                            $userRepo->find($recipient_user_id),
                            $userRepo->find($sender_user_id),

                            $mymessage,
                            $message->badge,
                            $token_amount,
                            $date,
                            $time,
                            false,
                            $tier_old_description,
                            $tier_new_description,
                            $messagerewardstoken,
                            $tier_next,
                            false

                        ));

                }

            }


        } catch (\Exception $e) {

            \Log::info($e);
            DB::rollBack();
            return ApiResponse::exception(ApiException::serverError($e->getMessage()));

        }

        $date = Carbon::createFromFormat('Y-m-d H:i:s', $message->created_at)->format('d F Y');
        $time = Carbon::createFromFormat('Y-m-d H:i:s', $message->created_at)->format('h:i A');

        switch ($_SERVER['SERVER_NAME']){

            case 'deloitte-backend.local.nmgdev.com':

                break;
            default:
            // Mail to sender
            Mail::to($message->sender->email)->send(new NominationSenderMail(

                $userRepo->find($sender_user_id),
                $userRepo->find($recipient_user_id),
                $message->message,
                $message->badge,
                $token_amount,
                $date,
                $time,
                $isPreview = false,
                $editpreview = false,
                $content = ''
            ));

            // // Mail to recipient
            Mail::to($message->recipient->email)->send(new NominationRecipientMail(

                $userRepo->find($recipient_user_id),
                $userRepo->find($sender_user_id),
                $message->message,
                $message->badge,
                $token_amount,
                $date,
                $time,
                $isPreview = false,
                $editpreview = false,
                $content = ''
            ));
        }

        return ApiResponse::success($message);
    }

    /**
     * Like the nomination with the given nomination_id
     *
     * @param int $nomination_id
     * @param LikeNominationRequest $request
     * @param MessageRepository $nominationRepo
     * @return ApiResponse
     */

    public function like($nomination_id, LikeNominationRequest $request, MessageRepository $messageRepo)
    {

        $result = DB::transaction(function () use ($nomination_id, $request, $messageRepo) {
            return $messageRepo->like($nomination_id, $request->user()->id);
        });

        return ApiResponse::success($result);
    }


    public function getmessage( $slug , Request $request){


        $start_time = microtime(TRUE);

        $access_token = $request->header('Authorization');

        $auth_header = explode(' ', $access_token);
        $token = $auth_header[1];

        $token_parts = explode('.', $token);
        $token_header = $token_parts[0];


        $token_header_json = base64_decode($token_header);
        $token_header_array = json_decode($token_header_json, true);


        $user_token = $token_header_array['jti'];
        $user_id = DB::table('oauth_access_tokens')->where('id', $user_token)->value('user_id');

        $users = DB::select(' SELECT  is_admin FROM `users` WHERE id='.$user_id.';');
        $users = json_decode(json_encode($users), true);


        try {

            if($users[0]['is_admin']){


                $datum['data'] = DB::select(' SELECT

                    `id`,
                    `sender_user_id` ,
                    (Select name from users where id=sender_user_id ) as `sender_user_name`,
                    `recipient_user_id`,
                    (Select name from users where id=recipient_user_id ) as `recipient_user_name`,

                    `message_token_id`,
                    (Select amount from message_tokens where id=message_token_id ) as `message_token_amount`,

                    `message_badge_id`,
                    `message`,
                    `is_badge_removed`,
                    `is_recipient_removed`,
                    `created_at`,
                    `updated_at`
                    FROM `messages` WHERE id='.$slug.';');

                // return  $response = \Response::json($datum, 200);

            }else{



            }


            $datum['success'] = 1;


            $end_time = microtime(TRUE);
            $datum['elapsed_time'] = $end_time - $start_time;
            return  $response = \Response::json($datum, 200);


        } catch (Exception $e) {


            $end_time = microtime(TRUE);
            $datum['elapsed_time'] = $end_time - $start_time;
            $data['error'] =1;
            return  $response = \Response::json($data, 200);

        }

    }

    public function updatemessage( Request $request){

        $start_time = microtime(TRUE);

        $access_token = $request->header('Authorization');

        $auth_header = explode(' ', $access_token);
        $token = $auth_header[1];

        $token_parts = explode('.', $token);
        $token_header = $token_parts[0];


        $token_header_json = base64_decode($token_header);
        $token_header_array = json_decode($token_header_json, true);


        $user_token = $token_header_array['jti'];
        $user_id = DB::table('oauth_access_tokens')->where('id', $user_token)->value('user_id');

        $users = DB::select(' SELECT  id,is_admin,name FROM `users` WHERE id='.$user_id.';');
        $users = json_decode(json_encode($users), true);

        try {

            if($users[0]['is_admin']){

                $data = Message::find($request->id);

                $datum['data'] = $data;
                $datum['recipient_name'] = $data['recipient']['name'];
                $datum['sender_name'] = $data['sender']['name'];

                $datum['recipient_id'] = $data['recipient']['id'];
                $datum['sender_id'] = $data['sender']['id'];

                $datum['message'] = $data['message'];
                $data->message =  $request->input('message');
                $data->save();
                $datum['success'] = 1;

                event(new AdminLogEvent($users[0]["id"], AdminLog::TYPE_POSTMESSAGE_AND_SENDTOKEN, [
                    'admin' => $users[0]["name"],
                    'id' => $users[0]["id"],

                    'from_message' => $data['sender']['name'],
                    'to_message' => $data['recipient']['name'],

                    'old_message' => $datum['message'],
                    'new_message' => $request->input('message'),

                    'recipient_id' => $datum['recipient_id'],
                    'sender_id' => $datum['sender_id'],


                ]));

            }else{

                $datum['error'] = 'Not admin';
            }

            $end_time = microtime(TRUE);
            $datum['elapsed_time'] = $end_time - $start_time;
            return  $response = \Response::json($datum, 200);

        } catch (Exception $e) {

            $end_time = microtime(TRUE);
            $datum['elapsed_time'] = $end_time - $start_time;
            $data['error'] =1;
            return  $response = \Response::json($data, 200);

        }

    }


    public function remove_retain_badge( Request $request){

        $start_time = microtime(TRUE);

        $access_token = $request->header('Authorization');

        $auth_header = explode(' ', $access_token);
        $token = $auth_header[1];

        $token_parts = explode('.', $token);
        $token_header = $token_parts[0];


        $token_header_json = base64_decode($token_header);
        $token_header_array = json_decode($token_header_json, true);


        $user_token = $token_header_array['jti'];
        $user_id = DB::table('oauth_access_tokens')->where('id', $user_token)->value('user_id');

        $users = DB::select(' SELECT  id,is_admin,name FROM `users` WHERE id='.$user_id.';');
        $users = json_decode(json_encode($users), true);

        try {

            if($users[0]['is_admin']){

                $data = Message::find($request->id);

                $datum['data'] = $data;
                $datum['recipient_name'] = $data['recipient']['name'];
                $datum['sender_name'] = $data['sender']['name'];
                $datum['sender_id'] = $data['sender']['id'];
                $datum['message_badge_id'] = $data['message_badge_id'];

                $datum['badgename'] = $data['badge']['name'];

                $datum['recipient_id'] = $data['recipient']['id'];
                $datum['sender_id'] = $data['sender']['id'];


                if( intval($data['is_badge_removed']) == intval($request->remove)){

                    $datum['state']  = "State is the same";
                    $datum['success'] = 1;
                    unset($datum['badgename']);
                    unset($datum['recipient_name']);

                }else{

                    $data->is_badge_removed =   intval($request->remove);
                    $data->save();
                    $datum['message']  = " Remove / Retain Badge Success.";
                    $datum['success'] = 1;

                    if($request->remove){

                        //badgecount before

                        $MessageBadge_recipient = MessageBadge::where('recipient_user_id', '=', $datum['recipient_id'])->get();
                        $datum['badgecount_old'] = $MessageBadge_recipient->count();


                        if(intval($datum['badgecount_old']) <= 60 || intval($datum['badgecount_old']) == Null){

                            $tier_old = 1;
                            $tier_old_description = 'Rising Star';

                        }elseif (intval($datum['badgecount_old']) > 60  && intval($datum['badgecount_old']) <= 240 ) {

                            $tier_old = 2;
                            $tier_old_description =  'Shining Star';

                        }elseif (intval($datum['badgecount_old']) > 240  && intval($datum['badgecount_old']) <= 480 ) {

                            $tier_old= 3;
                            $tier_old_description =  'Shooting Star';

                        }elseif (intval($datum['badgecount_old']) > 480  && intval($datum['badgecount_old']) <= 800 ) {

                            $tier_old = 4;
                            $tier_old_description =  'Super Star';

                        }elseif (intval($datum['badgecount_old']) > 800 ) {

                            $tier_old = 5;
                            $tier_old_description = 'Megastar';
                        }


                        $MessageBadge = MessageBadge::find($datum['message_badge_id']);
                        $MessageBadge->delete();

                        //badgecount after

                            $MessageBadge_recipient = MessageBadge::where('recipient_user_id', '=', $datum['recipient_id'])->get();
                            $datum['badgecount_new'] = $MessageBadge_recipient->count();

                            if(intval($datum['badgecount_new']) <= 60 || intval($datum['badgecount_new']) == Null){

                                $tier_new = 1;
                                $tier_new_description = 'Rising Star';

                            }elseif (intval($datum['badgecount_new']) > 60  && intval($datum['badgecount_new']) <= 240 ) {

                                $tier_new = 2;
                                $tier_new_description =  'Shining Star';

                            }elseif (intval($datum['badgecount_new']) > 240  && intval($datum['badgecount_new']) <= 480 ) {

                                $tier_new= 3;
                                $tier_new_description =  'Shooting Star';

                            }elseif (intval($datum['badgecount_new']) > 480  && intval($datum['badgecount_new']) <= 800 ) {

                                $tier_new = 4;
                                $tier_new_description =  'Super Star';

                            }elseif (intval($datum['badgecount_new']) > 800 ) {

                                $tier_new = 5;
                                $tier_new_description = 'Megastar';

                            }

                        if( $tier_new != $tier_old ){

                            $users_table = User::find($datum['recipient_id']);
                            $users_table->tier_id = $tier_new;

                            $greentoken = $users_table->green_token;
                            // return badge token
                            switch ($tier_new) {
                                case 1:
                                    //retract Shining Star
                                    $refundtoken =  $users_table->rising_shining_star_token;
                                    $users_table->rising_shining_star_token = 0;
                                break;
                                case 2:
                                    //retract Shooting Star
                                    $refundtoken = $users_table->shining_shooting_star_token;
                                    $users_table->shining_shooting_star_token = 0;
                                break;
                                case 3:
                                    //retract Super Star
                                    $refundtoken = $users_table->shooting_super_star_token;
                                    $users_table->shooting_super_star_token = 0;
                                break;
                                case 4:
                                    //retract Megastar
                                    $refundtoken = $users_table->super_mega_star_token;
                                    $users_table->super_mega_star_token = 0;
                                break;

                            }

                            if($greentoken){

                                $greentoken = intval($greentoken);
                                $total_green_token = intval($greentoken) - $refundtoken;

                            }else{

                                $total_green_token = 0;

                            }

                            if( $total_green_token < 0 ){
                                $users_table->green_token = 0;
                            }else{
                                $users_table->green_token = $total_green_token;
                            }

                            $users_table->save();

                            event(new AdminLogEvent($users[0]["id"], AdminLog::TYPE_UPDATE_TIER, [

                                'admin' => $users[0]["name"],
                                'messages_id' => $request->id,
                                'badge_name' => $datum['badgename'],

                                'sender_name' => $datum['sender_name'],
                                'sender_id' => $datum['sender_id'],


                                'recipient_name' => $datum['recipient_name'],
                                'recipient_id' => $datum['recipient_id'],
                                'tier_old' => $tier_old_description,
                                'tier_new' => $tier_new_description,

                            ]));

                        }


                        event(new AdminLogEvent($users[0]["id"], AdminLog::TYPE_REMOVERETAIN_REMOVE_BADGES, [
                            'admin' => $users[0]["name"],
                            'messages_id' => $request->id,
                            'badge_name' => $datum['badgename'],
                            'recipient_name' => $datum['recipient_name'],
                            'sender_name' => $data['sender']['name']
                        ]));


                    }else{

                            //badgecount before
                            $MessageBadge_recipient = MessageBadge::where('recipient_user_id', '=', $datum['recipient_id'])->get();
                            $datum['badgecount_old'] = $MessageBadge_recipient->count();


                            if(intval($datum['badgecount_old']) <= 60 || intval($datum['badgecount_old']) == Null){

                                $tier_old = 1;
                                $tier_old_description = 'Rising Star';

                            }elseif (intval($datum['badgecount_old']) > 60  && intval($datum['badgecount_old']) <= 240 ) {

                                $tier_old = 2;
                                $tier_old_description =  'Shining Star';

                            }elseif (intval($datum['badgecount_old']) > 240  && intval($datum['badgecount_old']) <= 480 ) {

                                $tier_old= 3;
                                $tier_old_description =  'Shooting Star';

                            }elseif (intval($datum['badgecount_old']) > 480  && intval($datum['badgecount_old']) <= 800 ) {

                                $tier_old = 4;
                                $tier_old_description =  'Super Star';

                            }elseif (intval($datum['badgecount_old']) > 800 ) {

                                $tier_old = 5;
                                $tier_old_description = 'Megastar';
                            }

                        MessageBadge::withTrashed()->find($datum['message_badge_id'])->restore();
                        $MessageBadge_recipient = MessageBadge::where('recipient_user_id', '=', $datum['recipient_id'])->get();
                        $datum['badgecount'] = $MessageBadge_recipient->count();

                            //badgecount after
                            $MessageBadge_recipient = MessageBadge::where('recipient_user_id', '=', $datum['recipient_id'])->get();
                            $datum['badgecount_new'] = $MessageBadge_recipient->count();

                            if(intval($datum['badgecount_new']) <= 60 || intval($datum['badgecount_new']) == Null){

                                $tier_new = 1;
                                $tier_new_description = 'Rising Star';

                            }elseif (intval($datum['badgecount_new']) > 60  && intval($datum['badgecount_new']) <= 240 ) {

                                $tier_new = 2;
                                $tier_new_description =  'Shining Star';

                            }elseif (intval($datum['badgecount_new']) > 240  && intval($datum['badgecount_new']) <= 480 ) {

                                $tier_new= 3;
                                $tier_new_description =  'Shooting Star';

                            }elseif (intval($datum['badgecount_new']) > 480  && intval($datum['badgecount_new']) <= 800 ) {

                                $tier_new = 4;
                                $tier_new_description =  'Super Star';

                            }elseif (intval($datum['badgecount_new']) > 800 ) {

                                $tier_new = 5;
                                $tier_new_description = 'Megastar';

                            }

                        if( $tier_new != $tier_old ){

                            $users_table = User::find($datum['recipient_id']);
                            $users_table->tier_id = $tier_new;
                            $users_table->save();

                            event(new AdminLogEvent($users[0]["id"], AdminLog::TYPE_UPDATE_TIER, [

                                'admin' => $users[0]["name"],
                                'messages_id' => $request->id,
                                'badge_name' => $datum['badgename'],

                                'sender_name' => $datum['sender_name'],
                                'sender_id' => $datum['sender_id'],

                                'recipient_name' => $datum['recipient_name'],
                                'recipient_id' => $datum['recipient_id'],
                                'tier_old' => $tier_old_description,
                                'tier_new' => $tier_new_description,

                            ]));

                        }

                        event(new AdminLogEvent($users[0]["id"], AdminLog::TYPE_REMOVERETAIN_RETAIN_BADGES, [
                            'admin' => $users[0]["name"],
                            'messages_id' => $request->id,
                            'badge_name' => $datum['badgename'],
                            'recipient_name' => $datum['recipient_name'],
                            'sender_name' => $data['sender']['name']
                        ]));

                    }

                    unset($datum['badgename']);
                    unset($datum['recipient_name']);

                }

            }else{

                $datum['error'] = 'Not admin';
            }

            $end_time = microtime(TRUE);
            $datum['elapsed_time'] = $end_time - $start_time;
            return  $response = \Response::json($datum, 200);

        } catch (Exception $e) {

            $end_time = microtime(TRUE);
            $datum['elapsed_time'] = $end_time - $start_time;
            $data['error'] =1;
            return  $response = \Response::json($data, 200);

        }

    }


    public function remove_retain_token_recipient( Request $request){

        $start_time = microtime(TRUE);

        $access_token = $request->header('Authorization');

        $auth_header = explode(' ', $access_token);
        $token = $auth_header[1];

        $token_parts = explode('.', $token);
        $token_header = $token_parts[0];


        $token_header_json = base64_decode($token_header);
        $token_header_array = json_decode($token_header_json, true);

        $user_token = $token_header_array['jti'];
        $user_id = DB::table('oauth_access_tokens')->where('id', $user_token)->value('user_id');

        $users = DB::select(' SELECT  id,is_admin,name FROM `users` WHERE id='.$user_id.';');
        $users = json_decode(json_encode($users), true);

        try {

            if($users[0]['is_admin']){

                $data = Message::find($request->id);

                $datum['data'] = $data;
                $datum['recipient_name'] = $data['recipient']['name'];
                $datum['sender_name'] = $data['sender']['name'];
                $datum['recipient_id'] = $data['recipient']['id'];
                $datum['sender_id'] = $data['sender']['id'];
                $datum['badgename'] =  $data['badge']['name'];
                $datum['green_tokens'] = $data['green_tokens'];

                if( $data['is_refunded']){

                    $datum['message']  = "Token has already been refunded.";
                    $datum['error'] = true;

                }else{

                    if( intval($data['is_recipienttoken_removed']) === intval($request->remove) ){

                        $datum['message']  = "Same request have been repeated.";
                        $datum['success'] = 1;
                        unset($datum['badgename']);
                        unset($datum['recipient_name']);
                        unset($datum['recipient_id']);

                    }else{

                        $data->is_recipienttoken_removed =  intval($request->remove);

                        $data->save();
                        $datum['success'] = 1;

                        if($request->remove){

                            if($data['is_reclaimed_token']){

                                /*
                                    To avail claiming the given green token more than once
                                    is_reclaimed_token tag is used to check if remove token is already removed once
                                                                                                                     */

                                $datum['message']  = "Token is already reclaimed.";

                            }else{

                                $messages_table = Message::find($request->id);
                                $messages_table->is_reclaimed_token = 1;
                                $messages_table->save();

                                /* reclaim given black  token start */
                                $table_users = User::find($datum['recipient_id']);

                                if($table_users['green_token']){

                                    $reclaim_token = intval($table_users['green_token']) - intval($datum['green_tokens']);

                                    if ($reclaim_token < 0){
                                        $reclaim_token = 0;
                                    }

                                }else{
                                    $reclaim_token = 0;
                                }

                                $table_users->green_token = $reclaim_token;
                                $table_users->save();

                                /* reclaim given black  token end */

                                event(new AdminLogEvent($users[0]["id"], AdminLog::TYPE_REMOVERETAIN_REMOVE_TOKEN, [
                                    'admin' => $users[0]["name"],
                                    'messages_id' => $request->id,
                                    'badge_name' => $datum['badgename'],
                                    'recipient_name' => $datum['recipient_name'],
                                    'recipient_id' => $datum['recipient_id'],
                                    'sender_name' => $datum['sender_name'],
                                    'sender_id' => $datum['sender_id'],
                                    'green_token' => $datum['green_tokens'],

                                ]));

                                $datum['message']  = "Remove token success";

                                unset($datum['green_tokens']);


                            }

                        }else{

                            if($data['is_reclaimed_token']){


                                $messages_table = Message::find($request->id);
                                $messages_table->is_reclaimed_token = null;
                                $messages_table->save();


                                $table_users = User::find($datum['recipient_id']);

                                if($table_users['green_token']){

                                    $return_token = intval($table_users['green_token']) + intval($datum['green_tokens']);

                                }else{

                                    $return_token =  intval($datum['green_tokens']);
                                }

                                $table_users->green_token = $return_token;
                                $table_users->save();

                                /*
                                    To avail claiming the given green token more than once
                                    is_reclaimed_token tag is used to check if remove token is already removed once
                                                                                                                     */
                                event(new AdminLogEvent($users[0]["id"], AdminLog::TYPE_REMOVERETAIN_RETAIN_TOKEN, [
                                    'admin' => $users[0]["name"],
                                    'messages_id' => $request->id,
                                    'badge_name' => $datum['badgename'],
                                    'recipient_name' => $datum['recipient_name'],
                                    'recipient_id' => $datum['recipient_id'],
                                    'sender_name' => $datum['sender_name'],
                                    'sender_id' => $datum['sender_id'],
                                    'green_token' => $datum['green_tokens'],

                                ]));

                                $datum['message']  = "Retain token success";

                                unset($datum['green_tokens']);

                            }else{

                                 $datum['message']  = "Re-assign token already returned";
                            }

                        }

                        unset($datum['badgename']);
                        unset($datum['recipient_name']);
                        unset($datum['recipient_id']);

                    }

                }


            }else{

                $datum['error'] = 'Not admin';
            }

            $end_time = microtime(TRUE);
            $datum['elapsed_time'] = $end_time - $start_time;
            return  $response = \Response::json($datum, 200);

        } catch (Exception $e) {

            $end_time = microtime(TRUE);
            $datum['elapsed_time'] = $end_time - $start_time;
            $data['error'] =1;
            return  $response = \Response::json($data, 200);

        }


    }


    public function refund_blacktoken_post( Request $request){

        $start_time = microtime(TRUE);

        $access_token = $request->header('Authorization');

        $auth_header = explode(' ', $access_token);
        $token = $auth_header[1];

        $token_parts = explode('.', $token);
        $token_header = $token_parts[0];


        $token_header_json = base64_decode($token_header);
        $token_header_array = json_decode($token_header_json, true);

        $user_token = $token_header_array['jti'];
        $user_id = DB::table('oauth_access_tokens')->where('id', $user_token)->value('user_id');

        $users = DB::select(' SELECT  id,is_admin,name FROM `users` WHERE id='.$user_id.';');
        $users = json_decode(json_encode($users), true);

        try {

            if($users[0]['is_admin']){

                $data = Message::find($request->id);

                $datum['data'] = $data;
                $datum['recipient_name'] = $data['recipient']['name'];
                $datum['recipient_id'] = $data['recipient']['id'];
                $datum['badgename'] =  $data['badge']['name'];
                $datum['green_tokens'] = $data['green_tokens'];

                $datum['message_badge_id'] = $data['message_badge_id'];
                $datum['message_token_id'] = $data['message_token_id'];


                $datum['sender_id'] = $data['sender']['id'];
                $datum['sender_name'] = $data['sender']['name'];



                $table_users_old = User::find($datum['sender_id']);


                if( $data['is_refunded']){

                    $datum['message']  = "Token has already been refunded.";
                    $datum['success'] = 1;

                }else{


                    /* tag is_recipienttoken_removed = 1 */
                    $data->is_recipienttoken_removed =  intval(1);
                    $data->save();

                    $datum['success'] = 1;


                    if($data['is_reclaimed_token']){

                        /*
                            To avail claiming the given green token more than once
                            is_reclaimed_token tag is used to check if remove token is already removed once
                                                                                                             */
                        $datum['message_for_remove_green_token']  = "Token is already removed by admin.";

                    }else{

                        $messages_table0 = Message::find($request->id);
                        $messages_table0->is_reclaimed_token = 1;
                        $messages_table0->save();

                        /* reclaim given black  token start */
                        $table_users0 = User::find($datum['recipient_id']);

                        /*avoild null value*/
                        if($table_users0['green_token']){
                            $reclaim_token = intval($table_users0['green_token']) - intval($datum['green_tokens']);

                            if ($reclaim_token < 0){
                                $reclaim_token = 0;
                            }

                        }else{
                            $reclaim_token = 0;
                        }


                        $table_users0->green_token = $reclaim_token;
                        $table_users0->save();
                        /* reclaim given black  token end */


                    }

                    $messages_table1 = Message::find($request->id);
                    $messages_table1->deleted = 1;
                    $messages_table1->is_refunded = 1;
                    $messages_table1->save();
                    // $messages_table1->delete();

                    $table_users1 = User::find($datum['sender_id']);

                    if($table_users1['black_token']){
                        if($datum['green_tokens']){
                            $refund_token = intval($table_users1['black_token']) + intval($datum['green_tokens']);

                        }else{
                            $refund_token = intval($table_users1['black_token']);
                        }

                    }else{

                        if($datum['green_tokens']){
                            $refund_token = intval($datum['green_tokens']);
                        }else{
                            $refund_token = 0;
                        }

                    }

                    $table_users1->black_token = $refund_token;
                    $table_users1->save();

                    $datum['message']  = "Refund back token to sender is successful.";


                    event(new AdminLogEvent($users[0]["id"], AdminLog::TYPE_POST_REFUND_TOKEN, [
                        'admin' => $users[0]["name"],
                        'messages_id' => $request->id,
                        'badge_name' => $datum['badgename'],
                        'recipient_name' => $datum['recipient_name'],
                        'sender_name' => $datum['sender_name'],
                        'green_token' => $datum['green_tokens'],

                        'black_token_before'  => $table_users_old['black_token'],
                        'black_token_after' => $refund_token,
                    ]));

                    unset($datum['badgename']);
                    unset($datum['recipient_name']);
                    unset($datum['recipient_id']);
                }



            }else{

                $datum['error'] = 'Not admin';
            }

            $end_time = microtime(TRUE);
            $datum['elapsed_time'] = $end_time - $start_time;
            return  $response = \Response::json($datum, 200);

        } catch (Exception $e) {

            $end_time = microtime(TRUE);
            $datum['elapsed_time'] = $end_time - $start_time;
            $data['error'] =1;
            return  $response = \Response::json($data, 200);

        }




    }

    public function get_maximum_recipient_token_limit(Request $request){

        $start_time = microtime(TRUE);

        $access_token = $request->header('Authorization');

        $auth_header = explode(' ', $access_token);
        $token = $auth_header[1];

        $token_parts = explode('.', $token);
        $token_header = $token_parts[0];

        $token_header_json = base64_decode($token_header);
        $token_header_array = json_decode($token_header_json, true);

        $user_token = $token_header_array['jti'];
        $user_id = DB::table('oauth_access_tokens')->where('id', $user_token)->value('user_id');

        $users = DB::select(' SELECT  id,name,career_level FROM `users` WHERE id='.$user_id.';');
        $users = json_decode(json_encode($users), true);

        try {
            $sender_user_id = intval($users[0]['id']);
            $recipient_user_id = intval($request->recipient_id);

            if($users[0]['career_level']){

                $career_level = $users[0]['career_level'];

            }else{

                $career_level = 1;

            }

            $max_token_send_to_same_user = DB::select('SELECT max_token_send_to_same_user FROM `user_levels` WHERE career_level='.intval($career_level).';');

            $max_token_send_to_same_user = json_decode(json_encode($max_token_send_to_same_user), true);

            $data['data']['total_max_token_send_to_same_user'] =   $max_token_send_to_same_user['0']['max_token_send_to_same_user'];
            $max_token_send_to_same_user = intval($data['data']['total_max_token_send_to_same_user']);

            $token_recipient =   MessageToken::where('sender_user_id', '=',$sender_user_id)
                                            ->where('recipient_user_id', '=',$recipient_user_id)
                                             ->whereYear('created_at', Carbon::now()->year)
                                             ->whereMonth('created_at', Carbon::now()->month)->sum('amount');

            $data['data']['sender_user_id'] = intval($users[0]['id']);
            $data['data']['recipient_user_id'] = intval($request->recipient_id);

            if($token_recipient){
                $data['data']['total_sent_tokens_to_user'] = intval($token_recipient);
            }else{
                $data['data']['total_sent_tokens_to_user'] = 0;
                $token_recipient = 0;
            }

            // $maxtokenallowed = intval($max_token_send_to_same_user) - intval($token_recipient);
            $maxtokenallowed = intval($max_token_send_to_same_user);

            if( $maxtokenallowed < 0 ){

                $maxtokenallowed = 0;
            }

            $data['data']['maximum_token_limit'] = $maxtokenallowed;
            $data['success'] = 1;

        } catch (Exception $e) {
            $data['error'] = 1;
        }

        $end_time = microtime(TRUE);
        $data['elapsed_time'] = $end_time - $start_time;

        return  $response = \Response::json($data, 200);

    }

    public function delete_message( Request $request){


        if($request->id ){

            $messages_table = Message::find($request->id);

            event(new AdminLogEvent($request->user()->id, AdminLog::TYPE_DELETE_MESSAGES, [
                'admin' => $request->user()->name,
                'messages' => $messages_table->message,
                'messages_id' => $messages_table->id
            ]));

            $messages_table->delete();

            return ApiResponse::success([
                // 'user' =>$request->user(),
                'messege' => $messages_table->message,
                'success' => 1,
                'id' => $request->id
            ]);

        }else{

            $errormsg  = 'Missing id';
            return ApiResponse::error(400,[
                'success' => 0,
                'errormsg' => $errormsg
            ]);
        }

    }

    public function delete_badge( Request $request){

         if($request->id ){

            $message_badges_table = MessageBadge::find($request->id);
            // $message_badges_table->delete();

            $badges_id = $message_badges_table->type;

            $badges_table =  Badge::find($message_badges_table->type);

            event(new AdminLogEvent($request->user()->id, AdminLog::TYPE_DELETE_BADGE, [
                'admin' => $request->user()->name,
                'message_badges_id' =>   $message_badges_table->id,
                'badge_name' => $badges_table->name,
                'badge_id' => $badges_table->id
            ]));

            $message_badges_table->delete();
            return ApiResponse::success([
                // 'user' =>$request->user(),
                'success' => 1,
                'id' => $request->id
            ]);

        }else{

            $errormsg  = 'Missing id';
            return ApiResponse::error(400,[
                'success' => 0,
                'errormsg' => $errormsg
            ]);

        }

    }

    public function remove_wallpost2(Request $request){


        switch ($request->request_type) {
            case 'badge':

                $data = Message::find($request->id);

                $datum['data'] = $data;
                $datum['recipient_name'] = $data['recipient']['name'];
                $datum['sender_name'] = $data['sender']['name'];
                $datum['sender_id'] = $data['sender']['id'];
                $datum['message_badge_id'] = $data['message_badge_id'];
                $datum['recipient_id'] =  $data['recipient']['id'];
                $datum['badgename'] = $data['badge']['name'];
                $MessageBadge_recipient = MessageBadge::where('recipient_user_id', '=', $datum['recipient_id'])->get();
                $datum['badgecount_old'] = $MessageBadge_recipient->count();

                if(intval($datum['badgecount_old']) <= 60 || intval($datum['badgecount_old']) == Null){

                    $tier_old = 1;
                    $tier_old_description = 'Rising Star';

                }elseif (intval($datum['badgecount_old']) > 60  && intval($datum['badgecount_old']) <= 240 ) {

                    $tier_old = 2;
                    $tier_old_description =  'Shining Star';

                }elseif (intval($datum['badgecount_old']) > 240  && intval($datum['badgecount_old']) <= 480 ) {

                    $tier_old= 3;
                    $tier_old_description =  'Shooting Star';

                }elseif (intval($datum['badgecount_old']) > 480  && intval($datum['badgecount_old']) <= 800 ) {

                    $tier_old = 4;
                    $tier_old_description =  'Super Star';

                }elseif (intval($datum['badgecount_old']) > 800 ) {

                    $tier_old = 5;
                    $tier_old_description = 'Megastar';
                }


                $MessageBadge = MessageBadge::withTrashed()->find($datum['message_badge_id']);

                if (  $MessageBadge->deleted_at) {
                    $errormsg  = 'Badge already deleted.';
                    return ApiResponse::error(400,[
                        'success' => 0,
                        'errormsg' => $errormsg
                    ]);
                }else{
                    $MessageBadge->delete();
                }


                $MessageBadge_recipient = MessageBadge::where('recipient_user_id', '=', $datum['recipient_id'])->get();
                $datum['badgecount_new'] = $MessageBadge_recipient->count();

                if(intval($datum['badgecount_new']) <= 60 || intval($datum['badgecount_new']) == Null){

                    $tier_new = 1;
                    $tier_new_description = 'Rising Star';

                }elseif (intval($datum['badgecount_new']) > 60  && intval($datum['badgecount_new']) <= 240 ) {

                    $tier_new = 2;
                    $tier_new_description =  'Shining Star';

                }elseif (intval($datum['badgecount_new']) > 240  && intval($datum['badgecount_new']) <= 480 ) {

                    $tier_new= 3;
                    $tier_new_description =  'Shooting Star';

                }elseif (intval($datum['badgecount_new']) > 480  && intval($datum['badgecount_new']) <= 800 ) {

                    $tier_new = 4;
                    $tier_new_description =  'Super Star';

                }elseif (intval($datum['badgecount_new']) > 800 ) {

                    $tier_new = 5;
                    $tier_new_description = 'Megastar';

                }

                if( $tier_new != $tier_old ){

                    $users_table = User::find($datum['recipient_id']);
                    $users_table->tier_id = $tier_new;

                    $greentoken = $users_table->green_token;
                    // return badge token
                    switch ($tier_new) {
                        case 1:
                            //retract Shining Star
                            $refundtoken =  $users_table->rising_shining_star_token;
                            $users_table->rising_shining_star_token = 0;
                        break;
                        case 2:
                            //retract Shooting Star
                            $refundtoken = $users_table->shining_shooting_star_token;
                            $users_table->shining_shooting_star_token = 0;
                        break;
                        case 3:
                            //retract Super Star
                            $refundtoken = $users_table->shooting_super_star_token;
                            $users_table->shooting_super_star_token = 0;
                        break;
                        case 4:
                            //retract Megastar
                            $refundtoken = $users_table->super_mega_star_token;
                            $users_table->super_mega_star_token = 0;
                        break;

                    }

                    if($greentoken){

                        $greentoken = intval($greentoken);
                        $total_green_token = intval($greentoken) - $refundtoken;

                    }else{

                        $total_green_token = 0;

                    }

                    if( $total_green_token < 0 ){
                        $users_table->green_token = 0;
                    }else{
                        $users_table->green_token = $total_green_token;
                    }

                    $users_table->save();

                    event(new AdminLogEvent($request->user()->id, AdminLog::TYPE_UPDATE_TIER, [

                        'admin' =>$request->user()->name,
                        'messages_id' => $request->id,
                        'badge_name' => $datum['badgename'],

                        'sender_name' => $datum['sender_name'],
                        'sender_id' => $datum['sender_id'],


                        'recipient_name' => $datum['recipient_name'],
                        'recipient_id' => $datum['recipient_id'],
                        'tier_old' => $tier_old_description,
                        'tier_new' => $tier_new_description,

                    ]));

                }

                event(new AdminLogEvent($request->user()->id, AdminLog::TYPE_REMOVERETAIN_REMOVE_BADGES, [
                    'admin' => $request->user()->name,
                    'messages_id' => $request->id,
                    'badge_name' => $datum['badgename'],
                    'recipient_name' => $datum['recipient_name'],
                    'sender_name' => $data['sender']['name']
                ]));

                return ApiResponse::success([
                    'user' => $request->user(),
                    'success' => 1,
                    'id' => $request->id
                ]);

            break;
            case 'message':

                if($request->id){

                    $messages_table = Message::withTrashed()->find($request->id);

                    if (  $messages_table->deleted_at) {
                        $errormsg  = 'Message already deleted.';
                        return ApiResponse::error(400,[
                            'success' => 0,
                            'errormsg' => $errormsg
                        ]);
                    }else{
                        $messages_table->message = '';
                        $messages_table->save();
                        // $messages_table->delete();
                    }

                    event(new AdminLogEvent($request->user()->id, AdminLog::TYPE_DELETE_MESSAGES, [
                        'admin' => $request->user()->name,
                        'messages' => $messages_table->message,
                        'messages_id' => $messages_table->id
                    ]));

                    return ApiResponse::success([
                        'user' => $request->user(),
                        'messege' => $messages_table->message,
                        'success' => 1,
                        'id' => $request->id
                    ]);

                }else{

                    $errormsg  = 'Missing id';
                    return ApiResponse::error(400,[
                        'success' => 0,
                        'errormsg' => $errormsg
                    ]);

                }

            break;
            case 'refund':


                $data = Message::find($request->id);

                $datum['data'] = $data;
                $datum['recipient_name'] = $data['recipient']['name'];
                $datum['recipient_id'] = $data['recipient']['id'];
                $datum['badgename'] =  $data['badge']['name'];
                $datum['green_tokens'] = $data['green_tokens'];

                $datum['message_badge_id'] = $data['message_badge_id'];
                $datum['message_token_id'] = $data['message_token_id'];


                $datum['sender_id'] = $data['sender']['id'];
                $datum['sender_name'] = $data['sender']['name'];

                $table_users_old = User::find($datum['sender_id']);

                if( $data['is_refunded']){

                    $datum['message']  = "Token has already been refunded.";
                    $datum['success'] = 1;
                    return ApiResponse::error(400,[
                        'success' => 0,
                        'errormsg' => $datum['message']
                    ]);
                }else{

                    /* tag is_recipienttoken_removed = 1 */
                    $data->is_recipienttoken_removed =  intval(1);
                    $data->save();

                    $datum['success'] = 1;


                    if($data['is_reclaimed_token']){

                        /*
                            To avail claiming the given green token more than once
                            is_reclaimed_token tag is used to check if remove token is already removed once
                                                                                                             */
                        $datum['message_for_remove_green_token']  = "Token is already removed by admin.";
                         return ApiResponse::error(400,[
                            'success' => 0,
                            'errormsg' => $datum['message_for_remove_green_token']
                        ]);

                    }else{

                        $messages_table0 = Message::find($request->id);
                        $messages_table0->is_reclaimed_token = 1;
                        $messages_table0->save();

                        /* reclaim given black  token start */
                        $table_users0 = User::find($datum['recipient_id']);

                        /*avoild null value*/
                        if($table_users0['green_token']){
                            $reclaim_token = intval($table_users0['green_token']) - intval($datum['green_tokens']);

                            if ($reclaim_token < 0){
                                $reclaim_token = 0;
                            }

                        }else{
                            $reclaim_token = 0;
                        }


                        $table_users0->green_token = $reclaim_token;
                        $table_users0->save();
                        /* reclaim given black  token end */


                    }

                    $messages_table1 = Message::find($request->id);
                    $messages_table1->deleted = 1;
                    $messages_table1->is_refunded = 1;
                    $messages_table1->save();
                    // $messages_table1->delete();

                    $table_users1 = User::find($datum['sender_id']);

                    if($table_users1['black_token']){
                        if($datum['green_tokens']){
                            $refund_token = intval($table_users1['black_token']) + intval($datum['green_tokens']);

                        }else{
                            $refund_token = intval($table_users1['black_token']);
                        }

                    }else{

                        if($datum['green_tokens']){
                            $refund_token = intval($datum['green_tokens']);
                        }else{
                            $refund_token = 0;
                        }

                    }

                    $table_users1->black_token = $refund_token;
                    $table_users1->save();

                    $datum['message']  = "Refund back token to sender is successful.";


                    event(new AdminLogEvent($request->user()->id, AdminLog::TYPE_POST_REFUND_TOKEN, [
                        'admin' => $request->user()->name,
                        'messages_id' => $request->id,
                        'badge_name' => $datum['badgename'],
                        'recipient_name' => $datum['recipient_name'],
                        'sender_name' => $datum['sender_name'],
                        'green_token' => $datum['green_tokens'],

                        'black_token_before'  => $table_users_old['black_token'],
                        'black_token_after' => $refund_token,
                    ]));

                    unset($datum['badgename']);
                    unset($datum['recipient_name']);
                    unset($datum['recipient_id']);

                    return ApiResponse::success([
                        'user' => $request->user(),
                        'success' => 1,
                        'id' => $request->id
                    ]);

                }

            break;

        }

     }

    public function remove_wallpost(Request $request){

        $data = Message::withTrashed()->find($request->id);

        $datum['data'] = $data;
        $datum['recipient_name'] = $data['recipient']['name'];
        $datum['sender_name'] = $data['sender']['name'];
        $datum['sender_id'] = $data['sender']['id'];
        $datum['message_badge_id'] = $data['message_badge_id'];
        $datum['recipient_id'] =  $data['recipient']['id'];
        $datum['badgename'] = $data['badge']['name'];

        $MessageBadge_recipient = MessageBadge::where('recipient_user_id', '=', $datum['recipient_id'])->get();

        $datum['badgecount_old'] = $MessageBadge_recipient->count();

        if(intval($datum['badgecount_old']) <= 60 || intval($datum['badgecount_old']) == Null){

            $tier_old = 1;
            $tier_old_description = 'Rising Star';

        }elseif (intval($datum['badgecount_old']) > 60  && intval($datum['badgecount_old']) <= 240 ) {

            $tier_old = 2;
            $tier_old_description =  'Shining Star';

        }elseif (intval($datum['badgecount_old']) > 240  && intval($datum['badgecount_old']) <= 480 ) {

            $tier_old= 3;
            $tier_old_description =  'Shooting Star';

        }elseif (intval($datum['badgecount_old']) > 480  && intval($datum['badgecount_old']) <= 800 ) {

            $tier_old = 4;
            $tier_old_description =  'Super Star';

        }elseif (intval($datum['badgecount_old']) > 800 ) {

            $tier_old = 5;
            $tier_old_description = 'Megastar';
        }


        $MessageBadge = MessageBadge::withTrashed()->find($datum['message_badge_id']);

        if ($MessageBadge->deleted_at) {

         
        }else{

            event(new AdminLogEvent($request->user()->id, AdminLog::TYPE_REMOVERETAIN_REMOVE_BADGES, [
                'admin' => $request->user()->name,
                'messages_id' => $request->id,
                'badge_name' => $datum['badgename'],
                'recipient_name' => $datum['recipient_name'],
                'sender_name' => $data['sender']['name']
            ]));

            $MessageBadge->delete();
        }


   
        $MessageBadge_recipient = MessageBadge::where('recipient_user_id', '=', $datum['recipient_id'])->get();
        
        $datum['badgecount_new'] = $MessageBadge_recipient->count();

        if(intval($datum['badgecount_new']) <= 60 || intval($datum['badgecount_new']) == Null){

            $tier_new = 1;
            $tier_new_description = 'Rising Star';

        }elseif (intval($datum['badgecount_new']) > 60  && intval($datum['badgecount_new']) <= 240 ) {

            $tier_new = 2;
            $tier_new_description =  'Shining Star';

        }elseif (intval($datum['badgecount_new']) > 240  && intval($datum['badgecount_new']) <= 480 ) {

            $tier_new= 3;
            $tier_new_description =  'Shooting Star';

        }elseif (intval($datum['badgecount_new']) > 480  && intval($datum['badgecount_new']) <= 800 ) {

            $tier_new = 4;
            $tier_new_description =  'Super Star';

        }elseif (intval($datum['badgecount_new']) > 800 ) {

            $tier_new = 5;
            $tier_new_description = 'Megastar';

        }

        if( $tier_new != $tier_old ){

            $users_table = User::find($datum['recipient_id']);
            $users_table->tier_id = $tier_new;

            $greentoken = $users_table->green_token;
            // return badge token
            switch ($tier_new) {
                case 1:
                    //retract Shining Star
                    $refundtoken =  $users_table->rising_shining_star_token;
                    $users_table->rising_shining_star_token = 0;
                break;
                case 2:
                    //retract Shooting Star
                    $refundtoken = $users_table->shining_shooting_star_token;
                    $users_table->shining_shooting_star_token = 0;
                break;
                case 3:
                    //retract Super Star
                    $refundtoken = $users_table->shooting_super_star_token;
                    $users_table->shooting_super_star_token = 0;
                break;
                case 4:
                    //retract Megastar
                    $refundtoken = $users_table->super_mega_star_token;
                    $users_table->super_mega_star_token = 0;
                break;

            }

            if($greentoken){

                $greentoken = intval($greentoken);
                $total_green_token = intval($greentoken) - $refundtoken;

            }else{

                $total_green_token = 0;

            }

            if( $total_green_token < 0 ){
                $users_table->green_token = 0;
            }else{
                $users_table->green_token = $total_green_token;
            }


            $users_table->save();

            event(new AdminLogEvent($request->user()->id, AdminLog::TYPE_UPDATE_TIER, [

                'admin' =>$request->user()->name,
                'messages_id' => $request->id,
                'badge_name' => $datum['badgename'],

                'sender_name' => $datum['sender_name'],
                'sender_id' => $datum['sender_id'],


                'recipient_name' => $datum['recipient_name'],
                'recipient_id' => $datum['recipient_id'],
                'tier_old' => $tier_old_description,
                'tier_new' => $tier_new_description,

            ]));

        }



   

        //refund

        $data = Message::withTrashed()->find($request->id);
        $message_token_id = $data->message_token_id;
        $datum['data'] = $data;
        $datum['recipient_name'] = $data['recipient']['name'];
        $datum['recipient_id'] = $data['recipient']['id'];
        $datum['badgename'] =  $data['badge']['name'];
        $datum['green_tokens'] = $data['green_tokens'];

        $datum['message_badge_id'] = $data['message_badge_id'];
        $datum['message_token_id'] = $data['message_token_id'];

        $datum['sender_id'] = $data['sender']['id'];
        $datum['sender_name'] = $data['sender']['name'];

        $table_users_old = User::find($datum['sender_id']);

        if( $data['is_refunded']){

            $datum['message']  = "Token has already been refunded.";
            $datum['success'] = 1;

            $data->delete();
                
            $message_tokens = MessageToken::withTrashed()->find($message_token_id);
            $message_tokens->delete();

            return ApiResponse::success([
                'message' =>$datum['message'],
                'user' => $request->user(),
                'success' => 1,
                'id' => $request->id
            ]);

            // return ApiResponse::error(400,[
            //     'success' => 0,
            //     'errormsg' => $datum['message']
            // ]);

        }else{

            /* tag is_recipienttoken_removed = 1 */
            $data->is_recipienttoken_removed =  intval(1);
            $message_token_id = $data->message_token_id;
            $data->save();

            $datum['success'] = 1;


            if($data['is_reclaimed_token']){

                /*
                    To avail claiming the given green token more than once
                    is_reclaimed_token tag is used to check if remove token is already removed once
                                                                                                     */
                $datum['message_for_remove_green_token']  = "Token is already removed by admin.";
                $data->delete();

                $message_tokens = MessageToken::withTrashed()->find($message_token_id);
                $message_tokens->delete();

                return ApiResponse::success([
                    'message' =>$datum['message_for_remove_green_token'],
                    'user' => $request->user(),
                    'success' => 1,
                    'id' => $request->id
                ]);


                // return ApiResponse::error(400,[
                //     'success' => 0,
                //     'errormsg' => $datum['message_for_remove_green_token']
                // ]);

            }else{

                $messages_table0 = Message::withTrashed()->find($request->id);
                $messages_table0->is_reclaimed_token = 1;
                $messages_table0->save();

                /* reclaim given black  token start */
                $table_users0 = User::find($datum['recipient_id']);

                /*avoild null value*/
                if($table_users0['green_token']){
                    $reclaim_token = intval($table_users0['green_token']) - intval($datum['green_tokens']);

                    if ($reclaim_token < 0){
                        $reclaim_token = 0;
                    }

                }else{
                    $reclaim_token = 0;
                }


                $table_users0->green_token = $reclaim_token;
                $table_users0->save();

                /* reclaim given black  token end */


            }

            $messages_table1 = Message::withTrashed()->find($request->id);
            $messages_table1->deleted = 1;
            $message_token_id = $messages_table1->message_token_id;
            $messages_table1->is_refunded = 1;
            $messages_table1->save();
          
            // $messages_table1->delete();

            $table_users1 = User::find($datum['sender_id']);

            if($table_users1['black_token']){
                if($datum['green_tokens']){
                    $refund_token = intval($table_users1['black_token']) + intval($datum['green_tokens']);

                }else{
                    $refund_token = intval($table_users1['black_token']);
                }

            }else{

                if($datum['green_tokens']){
                    $refund_token = intval($datum['green_tokens']);
                }else{
                    $refund_token = 0;
                }

            }

            $table_users1->black_token = $refund_token;
            $table_users1->save();

            $datum['message']  = "Refund back token to sender is successful.";


            event(new AdminLogEvent($request->user()->id, AdminLog::TYPE_POST_REFUND_TOKEN, [
                'admin' => $request->user()->name,
                'messages_id' => $request->id,
                'badge_name' => $datum['badgename'],
                'recipient_name' => $datum['recipient_name'],
                'sender_name' => $datum['sender_name'],
                'green_token' => $datum['green_tokens'],

                'black_token_before'  => $table_users_old['black_token'],
                'black_token_after' => $refund_token,
            ]));


            $messages_table1->delete();

            $message_tokens = MessageToken::withTrashed()->find($message_token_id);
            $message_tokens->delete();

            unset($datum['badgename']);
            unset($datum['recipient_name']);
            unset($datum['recipient_id']);

            return ApiResponse::success([
                'user' => $request->user(),
                'success' => 1,
                'id' => $request->id
            ]);

        }


   }
}
