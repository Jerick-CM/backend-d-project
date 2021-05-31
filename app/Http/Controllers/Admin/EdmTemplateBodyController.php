<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Events\AdminLogEvent;
use App\Models\AdminLog;

use App\Mail\UniversalMail;

use Illuminate\Http\Request;
use App\Models\EdmTemplateBody;
use DB;

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Takaworx\Brix\Entities\ApiResponse;
use Takaworx\Brix\Exceptions\ApiException;

class EdmTemplateBodyController extends Controller
{


    public function fetch_EdmTemplateBody()
    {

         $start_time = microtime(TRUE);
         // $datum  = DB::select('
         //   SELECT 
         //    `id`,
         //    `label`,          
         //    `content`,    
         //    `created_at`,
         //    `updated_at`

         //    FROM `edm_template_body` WHERE 1;
         //                 ');

        $datum =  EdmTemplateBody::select('*')->get();
        $data['data']['template'] = $datum;

        $end_time = microtime(TRUE);
        $data['success'] = 1;
        $data['elapsed_time'] = $end_time - $start_time;
        
        return  $response = \Response::json($data, 200);

    }
    public function EdmTemplateBodygetbyid(Request $request){

        $id = $request['id'];
        $datum =  EdmTemplateBody::select('*')->where('id', $id )->get();

        
        return  $response = \Response::json($datum, 200);

    }

    public function update_EdmTemplateBody(Request $request){

        $start_time = microtime(TRUE);

        // $this->validate( $request , [
        //     'content' =>'required',
        // ]);

        $datatemplatebody = EdmTemplateBody::find($request->id);
    

        if($request->has('locationdate')) {
            $datatemplatebody->locationdate =  $request->input('locationdate');
        }



        if($request->has('content')) {
            $datatemplatebody->content =  $request->input('content');
        }

        if($request->has('href1')) {
            $datatemplatebody->href1 =  $request->input('href1');
        }

        if($request->has('href2')) {
            $datatemplatebody->href2 =  $request->input('href2');
        }


        if($request->has('header1')) {
        
            if($request->input('header1') ===  $datatemplatebody->header1 ){
                
                $FileNameToStore1 = $datatemplatebody->header1;

            }else{

                $this->validate( $request , [
                    'header1' =>'nullable|mimetypes:text/plain,image/png,image/jpeg,image/svg|max:10000',
                ]);

                if($request->hasFile('header1')){
                    
   
                    $filenameWithExt = $request->file('header1')->getClientOriginalName();
                  
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

                    $extension = $request->file('header1')->getClientOriginalExtension();
            
                    $FileNameToStore = $filename.'_'.time().".".$extension;

                    $path = $request->file('header1')->storeAs('public/EdmTemplateBody',$FileNameToStore);
                    
                    $FileNameToStore1 = 'storage/EdmTemplateBody/'.$FileNameToStore;
            
              
                }else{

                    $FileNameToStore1 = '';

                }

            }

            $datatemplatebody->header1 =  $FileNameToStore1;

        }




        if($request->has('header2')) {
        
            if($request->input('header2') ===  $datatemplatebody->header2 ){
                
                $FileNameToStore2 = $datatemplatebody->header2;

            }else{

                $this->validate( $request , [
                    'header2' =>'nullable|mimetypes:text/plain,image/png,image/jpeg,image/svg|max:10000',
                ]);

                if($request->hasFile('header2')){
                    
   
                    $filenameWithExt = $request->file('header2')->getClientOriginalName();
                  
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

                    $extension = $request->file('header2')->getClientOriginalExtension();
            
                    $FileNameToStore = $filename.'_'.time().".".$extension;

                    $path = $request->file('header2')->storeAs('public/EdmTemplateBody',$FileNameToStore);
                    
                    $FileNameToStore2 = 'storage/EdmTemplateBody/'.$FileNameToStore;
            
              
                }else{

                    $FileNameToStore2 = '';

                }

            }

            $datatemplatebody->header2 =  $FileNameToStore2;

        }


        if($request->has('header3')) {
            $datatemplatebody->header3 =  $request->input('header3');
        }


        if($request->has('header4')) {
            $datatemplatebody->header4 =  $request->input('header4');
        }


        if($request->has('header5')) {
            $datatemplatebody->header5 =  $request->input('header5');
        }

        if($request->has('label')) {
              $datatemplatebody->label =  $request->input('label');
        }

        if($request->has('title')) {
            $datatemplatebody->title =  $request->input('title');
        }

        if($request->has('subject')) {
           $datatemplatebody->subject =  $request->input('subject');
        }

        $datatemplatebody->placeholder1 =  $request->input('placeholder1');
        $datatemplatebody->placeholder2 =  $request->input('placeholder2');
        $datatemplatebody->placeholder3 =  $request->input('placeholder3');
        $datatemplatebody->placeholder4 =  $request->input('placeholder4');
        $datatemplatebody->placeholder5 =  $request->input('placeholder5');

        $datatemplatebody->placeholder6 =  $request->input('placeholder6');
        $datatemplatebody->placeholder7 =  $request->input('placeholder7');
        $datatemplatebody->placeholder8 =  $request->input('placeholder8');
        $datatemplatebody->placeholder9 =  $request->input('placeholder9');
        $datatemplatebody->placeholder10 =  $request->input('placeholder10');


        $datatemplatebody->placeholder11 =  $request->input('placeholder11');
        $datatemplatebody->placeholder12 =  $request->input('placeholder12');
        $datatemplatebody->placeholder13 =  $request->input('placeholder13');
        $datatemplatebody->placeholder14 =  $request->input('placeholder14');
        $datatemplatebody->placeholder15 =  $request->input('placeholder15');

        $datatemplatebody->placeholder16 =  $request->input('placeholder16');
        $datatemplatebody->placeholder17 =  $request->input('placeholder17');
        $datatemplatebody->placeholder18 =  $request->input('placeholder18');
        $datatemplatebody->placeholder19 =  $request->input('placeholder19');
        $datatemplatebody->placeholder20 =  $request->input('placeholder20');


        $datatemplatebody->placeholder21 =  $request->input('placeholder21');
        $datatemplatebody->placeholder22 =  $request->input('placeholder22');
        $datatemplatebody->placeholder23 =  $request->input('placeholder23');
        $datatemplatebody->placeholder24 =  $request->input('placeholder24');
        $datatemplatebody->placeholder25 =  $request->input('placeholder25');

        $datatemplatebody->placeholder26 =  $request->input('placeholder26');
        $datatemplatebody->placeholder27 =  $request->input('placeholder27');
 
        $datatemplatebody->save();


        event(new AdminLogEvent($request["profile_id"], AdminLog::TYPE_EDM_TEMPLATE_BODY, [
              'admin' => $request["name"],         
              'request_id' => $request->id,             
              'label' => $request->label,             
              'table_id' => $request->table_id,             
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

                 //Upload Image 
                $path = $request->file('upload')->storeAs('public/EdmTemplateBody',$FileNameToStore);
                // return  $response = \Response::json( $path, 200);
      
                $is_upload = 1;


              $data["domain"] = $_SERVER['SERVER_NAME'];      
              switch ($data["domain"]) {
                   case 'deloitte-backend.local.nmgdev.com':
                        $FileNameToStore = 'storage/EdmTemplateBody/'.$FileNameToStore;
                        break; 
                   default:
                        $FileNameToStore  = 'storage/EdmTemplateBody/'.$FileNameToStore;
                
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

    public function create_EdmTemplateBody(Request $request)
    {

        $start_time = microtime(TRUE);

        $this->validate( $request , [
            'label' =>'required',
            // 'title' =>'required',
            'subject' =>'required',
            'content' =>'required',
        ]);

        $count = EdmTemplateBody::count(); 
        $count = $count + 1; 


        $EdmTemplateBody = new EdmTemplateBody;
        $EdmTemplateBody->label =  $request->input('label');
        // $EdmTemplateBody->title =  $request->input('title');
        $EdmTemplateBody->subject =  $request->input('subject');
        $EdmTemplateBody->content =  $request->input('content');

        if($request->has('locationdate')) {
            $EdmTemplateBody->locationdate =  $request->input('locationdate');
        }

        if($request->has('href1')) {
            $EdmTemplateBody->href1 =  $request->input('href1');
        }

        if($request->has('href2')) {
            $EdmTemplateBody->href2 =  $request->input('href2');
        }


        if($request->has('header1')) {
        
            if($request->input('header1') ===  'img/edm/main-banner.jpg' ){
                
                $FileNameToStore1 = 'img/edm/main-banner.jpg';

            }else{

                $this->validate( $request , [
                    'header1' =>'nullable|mimetypes:text/plain,image/png,image/jpeg,image/svg|max:10000',
                ]);

                if($request->hasFile('header1')){
                    
   
                    $filenameWithExt = $request->file('header1')->getClientOriginalName();
                  
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

                    $extension = $request->file('header1')->getClientOriginalExtension();
            
                    $FileNameToStore = $filename.'_'.time().".".$extension;

                    $path = $request->file('header1')->storeAs('public/EdmTemplateBody',$FileNameToStore);
                    
                    $FileNameToStore1 = 'storage/EdmTemplateBody/'.$FileNameToStore;
            
              
                }else{

                    $FileNameToStore1 = '';

                }

            }

            $EdmTemplateBody->header1 =  $FileNameToStore1;

        }


        if($request->has('header2')) {
        
            if($request->input('header2') ===  'img/edm/welcome_banner_default.jpg' ){
                
                $FileNameToStore2 = 'img/edm/welcome_banner_default.jpg';

            }else{

                $this->validate( $request , [
                    'header2' =>'nullable|mimetypes:text/plain,image/png,image/jpeg,image/svg|max:10000',
                ]);

                if($request->hasFile('header2')){
                    
                    $filenameWithExt = $request->file('header2')->getClientOriginalName();
                  
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

                    $extension = $request->file('header2')->getClientOriginalExtension();
            
                    $FileNameToStore = $filename.'_'.time().".".$extension;

                    $path = $request->file('header2')->storeAs('public/EdmTemplateBody',$FileNameToStore);
                    
                    $FileNameToStore2 = 'storage/EdmTemplateBody/'.$FileNameToStore;
            
              
                }else{

                    $FileNameToStore2 = '';

                }

            }

            $EdmTemplateBody->header2 =  $FileNameToStore2;

        }

        $EdmTemplateBody->save();
        event(new AdminLogEvent($request["profile_id"], AdminLog::TYPE_EDM_TEMPLATE_BODY_CREATE, [
            'admin' => $request["name"],         
            'request_id' => $request->id,             
            'label' => $request->label,                         
            // 'title' => $request->title,                         
            'subject' => $request->subject,                         
        ]));

        $datum['success'] = 1;
        $datum['data']['id'] = $EdmTemplateBody->id;

        $end_time = microtime(TRUE);
        $data['elapsed_time'] = $end_time - $start_time;

        // return  $response = \Response::json($datum, 200);

        return ApiResponse::success([
           'elapsed_time' => $end_time - $start_time,
           'data' => array('id' => $EdmTemplateBody->id ),
           'success' => 1
        ]);

    }

    public function send_testemail(Request $request)
    {


        $start_time = microtime(TRUE);


        $id = $request->edm_templatebody_id;
        $datum =  EdmTemplateBody::select('*')->where('id', $id )->get();


        $time = Carbon::createFromFormat('Y-m-d H:i:s', $datum[0]['updated_at'])->format('h:i A');
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $datum[0]['updated_at'])->format('d F Y');
        // Mail::to($message->recipient->email)->send(new UniversalMail(   

        if($request->has('email')) {
            Mail::to($request->email)->send(new UniversalMail(
                 $request->user()->id,
                 $request->email,
                 $date,
                 false,
                $request->edm_templatebody_id 
            ));  
        }

        // Mail::to("jmangaluz@gmail.com")->send(new UniversalMail(
        //      $request->user()->id,
        //      $email = "jmangaluz@gmail.com",
        //      $date,
        //      false,
        //     $request->edm_templatebody_id 
        // ));
        
        $datum['success'] = 1;
        $end_time = microtime(TRUE);
        $data['elapsed_time'] = $end_time - $start_time;

        return  $response = \Response::json($datum, 200);
    }

    public function delete_EdmTemplateBody(Request $request){

        $start_time = microtime(TRUE);

        $id = $request->template_body_id;
        $EdmTemplateBody = EdmTemplateBody::find($id);
        $EdmTemplateBody->delete();  


        event(new AdminLogEvent($request["profile_id"], AdminLog::TYPE_EDM_TEMPLATE_BODY_DELETE, [
            'admin' => $request["name"],         
            'request_id' => $request->template_body_id,             
            'label' => $request->label,                                                         
        ]));


        $datum['success'] = 1;

        $end_time = microtime(TRUE);
        $data['elapsed_time'] = $end_time - $start_time;

        return  $response = \Response::json($datum, 200);


    }

    // public function ckeditor(Request $request){

      
    //     $filenameWithExt = $request->file('upload')->getClientOriginalName();
           
    //     $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);


    //     $extension = $request->file('upload')->getClientOriginalExtension();
        

    //     $FileNameToStore = $filename.'_'.time().".".$extension;

      
    //     $path = $request->file('upload')->storeAs('public/edmbody',$FileNameToStore);            

    //     $is_upload = 1;


    //     $data["domain"] = $_SERVER['SERVER_NAME'];      
    //     switch ($data["domain"]) {
    //        case 'deloitte-backend.local.nmgdev.com':
    //             $FileNameToStore = 'storage/edmbody/'.$FileNameToStore;
    //             break; 
    //        default:
    //             $FileNameToStore  = 'storage/edmbody/'.$FileNameToStore;

    //     }   
  
    //     $mydata['success']  = 1 ;
    //     $mydata["ret"] =  $filenameWithExt;
    //     $mydata["data"] = $request->upload;
    //     switch ($data["domain"]) {
    //        case 'deloitte-backend.local.nmgdev.com':
    //             $mydata["url"] =  url($FileNameToStore);
    //           break; 
    //        default:
    //             $mydata["url"] =  secure_url($FileNameToStore );

    //     }  
    //     // $mydata["url"]=  secure_url($FileNameToStore );

    //     return  $response = \Response::json($mydata, 200);
    // }
}
