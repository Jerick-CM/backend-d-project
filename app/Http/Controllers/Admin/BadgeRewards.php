<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Events\AdminLogEvent;
use App\Models\AdminLog;


use Illuminate\Http\Request;
use App\Models\Myrewards;


use DB;

class BadgeRewards extends Controller
{


    public function fetchdata_data()
    {

         $start_time = microtime(TRUE);
         $datum  = DB::select('

           SELECT 
            `id`,
            `description`,
            `rewardstoken`,            
            `created_at`,
            `updated_at`

            FROM `myrewards` WHERE 1 ORDER BY id asc;
           ');

        $data['data']['badge_rewards_token'] = $datum;

        $end_time = microtime(TRUE);
        $data['success'] = 1;
        $data['elapsed_time'] = $end_time - $start_time;
        
        return  $response = \Response::json($data, 200);

    }

    public function update_data(Request $request)
    {

        $start_time = microtime(TRUE);

        $data = Myrewards::find($request->id);

        $datum['rewardstoken_old'] = $data['rewardstoken'];

        $data->rewardstoken =  $request->input('rewardstoken');
        $data->save();

        event(new AdminLogEvent($request["profile_id"], AdminLog::TYPE_BADGE_REWARDSTOKEN, [
              'admin' => $request["profile_name"],  
              'id'  => $request->id,
              'rewardstoken_description'  =>   $request->input('description'),
              'rewardstoken_old'  =>  $datum['rewardstoken_old'],
              'rewardstoken_new'  =>  $request->input('rewardstoken')
        ]));



        $datum['success'] = 1;
        $end_time = microtime(TRUE);
        $data['elapsed_time'] = $end_time - $start_time;

        return  $response = \Response::json($datum, 200);
    }


}
