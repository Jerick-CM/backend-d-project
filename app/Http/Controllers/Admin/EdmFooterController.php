<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Events\AdminLogEvent;
use App\Models\AdminLog;


use Illuminate\Http\Request;
use App\Models\EdmFooter;
use DB;

class EdmFooterController extends Controller
{
    public function fetch_edmfooter()
    {

         $start_time = microtime(TRUE);
         $datum  = DB::select('

           SELECT 
            `id`,
            `label`,          
            `content`,    
            `created_at`,
            `updated_at`

            FROM `edm_footer` WHERE 1;
                         ');

        $data['data']['footer'] = $datum;

        $end_time = microtime(TRUE);
        $data['success'] = 1;
        $data['elapsed_time'] = $end_time - $start_time;
        
        return  $response = \Response::json($data, 200);

    }
    public function edmfooter_getbyid(Request $request){

        $id = $request['id'];
        $datum =  EdmFooter::select('*')->where('id', $id )->get();

        
        return  $response = \Response::json($datum, 200);

    }

    public function update_edm_footer(Request $request){

        $start_time = microtime(TRUE);

        $this->validate( $request , [
            'content' =>'required',
        ]);

        $datafooter = EdmFooter::find($request->id);
        $datafooter->content =  $request->input('content');

        $datafooter->footerlabel1 =  $request->input('footerlabel1');
        $datafooter->footerlabel2 =  $request->input('footerlabel2');
        $datafooter->footerlabel3 =  $request->input('footerlabel3');
        $datafooter->footerlabel4 =  $request->input('footerlabel4');
        $datafooter->footerlabel5 =  $request->input('footerlabel5');

        $datafooter->footerlabel6 =  $request->input('footerlabel6');
        $datafooter->footerlabel7 =  $request->input('footerlabel7');

        $datafooter->save();

        event(new AdminLogEvent($request["profile_id"], AdminLog::TYPE_EDM_FOOTER_EDIT, [
              'admin' => $request["name"],         
              'request_id' => $request->id,             
        ]));
        
        $datum['success'] = 1;
        $end_time = microtime(TRUE);
        $data['elapsed_time'] = $end_time - $start_time;

        return  $response = \Response::json($datum, 200);

     }


    public function ckeditor(Request $request){

           // $this->validate( $request , [
           //      'upload' =>'nullable|mimes:jpg,jpeg,png,bmp,tiff |max:10000',
           //  ]);

           //  if($request->hasFile('upload')){
                
           //      // Get filename with the extension
                $filenameWithExt = $request->file('upload')->getClientOriginalName();
           //      // Get just filename                 
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

           //      // Get just ext
                $extension = $request->file('upload')->getClientOriginalExtension();
                
           //      // filename to store 
                $FileNameToStore = $filename.'_'.time().".".$extension;

           //      // Upload Image 
                $path = $request->file('upload')->storeAs('public/edmheader',$FileNameToStore);
           //         // return  $response = \Response::json( $path, 200);
      
                $is_upload = 1;


              $data["domain"] = $_SERVER['SERVER_NAME'];      
              switch ($data["domain"]) {
                   case 'deloitte-backend.local.nmgdev.com':
                        $FileNameToStore = 'storage/edmheader/'.$FileNameToStore;
                      break; 
                   default:
                        $FileNameToStore  = 'public/storage/edmheader/'.$FileNameToStore;
                
              }   
          


        $mydata['success']  = 1 ;
        $mydata["ret"] =  $filenameWithExt;
        $mydata["data"] = $request->upload;
        switch ($data["domain"]) {
           case 'deloitte-backend.local.nmgdev.com':
                $mydata["url"] =  url($FileNameToStore);

              break; 
           default:
                $mydata["url"] =  secure_url($FileNameToStore );

          }  
        // $mydata["url"]=  secure_url($FileNameToStore );

        return  $response = \Response::json($mydata, 200);
    }
}
