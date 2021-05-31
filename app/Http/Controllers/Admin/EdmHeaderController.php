<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Events\AdminLogEvent;
use App\Models\AdminLog;


use Illuminate\Http\Request;
use App\Models\EdmHeader;
use DB;

class EdmHeaderController extends Controller
{
    public function fetch_edmheader()
    {

         $start_time = microtime(TRUE);
         $datum  = DB::select('

           SELECT 
            `id`,
            `label`,          
            `content`,    
            `created_at`,
            `updated_at`

            FROM `edm_header` WHERE 1;
                         ');

        $data['data']['header'] = $datum;

        $end_time = microtime(TRUE);
        $data['success'] = 1;
        $data['elapsed_time'] = $end_time - $start_time;
        
        return  $response = \Response::json($data, 200);

    }
    public function edmheadergetbyid(Request $request){

        $id = $request['id'];
        $datum =  EdmHeader::select('*')->where('id', $id )->get();

        
        return  $response = \Response::json($datum, 200);

    }

    public function update_edm_header(Request $request){

        $start_time = microtime(TRUE);

        $datah = EdmHeader::find($request->id);

        //1
        // if($request->input('image1') ===  $datah->image1 ){
         
        //   $FileNameToStore1 = $datah->image1;

        // }else{

        //     $this->validate( $request , [
        //         'image1' =>'nullable|mimetypes:text/plain,image/png,image/jpeg,image/svg|max:10000',
        //     ]);

        //     // Handle File Upload
        //     if($request->hasFile('image1')){
                
        //         // Get filename with the extension
        //         $filenameWithExt = $request->file('image1')->getClientOriginalName();
        //         // Get just filename                 
        //         $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        //         // Get just ext
        //         $extension = $request->file('image1')->getClientOriginalExtension();
                
        //         // filename to store 
        //         $FileNameToStore = $filename.'_'.time().".".$extension;

        //         // Upload Image 
        //         $path = $request->file('image1')->storeAs('public/edm_header',$FileNameToStore);
                
        //         // return  $response = \Response::json( $path, 200);
        //         $is_upload = 1;


        //         $data = [];
        //         $data["domain"] = $_SERVER['SERVER_NAME'];      
        //         switch ($data["domain"]) {
        //             case 'deloitte-backend.local.nmgdev.com':
        //                 $FileNameToStore1 = 'storage/edm_header/'.$FileNameToStore;
        //                 break; 
        //             default:
        //                 $FileNameToStore1  = 'storage/edm_header/'.$FileNameToStore;
                
        //         }   
          

        //     }else{

        //         $FileNameToStore1 = '';

        //     }

        // }

        //2
        if($request->input('image2') ===  $datah->image2 ){
         
          $FileNameToStore2 = $datah->image2;
       
        }else{
       
            $this->validate( $request , [
                'image2' =>'nullable|mimetypes:text/plain,image/png,image/jpeg,image/svg|max:10000',
            ]);

            // Handle File Upload
            if($request->hasFile('image2')){
                
                // Get filename with the extension
                $filenameWithExt = $request->file('image2')->getClientOriginalName();
                // Get just filename                 
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

                // Get just ext
                $extension = $request->file('image2')->getClientOriginalExtension();
                
                // filename to store 
                $FileNameToStore = $filename.'_'.time().".".$extension;

                // Upload Image 
                $path = $request->file('image2')->storeAs('public/edm_header',$FileNameToStore);
                
                $data = [];
                $data["domain"] = $_SERVER['SERVER_NAME'];      
                switch ($data["domain"]) {
                    case 'deloitte-backend.local.nmgdev.com':
                        $FileNameToStore2 = 'storage/edm_header/'.$FileNameToStore;
                        break; 
                    default:
                        $FileNameToStore2  = 'storage/edm_header/'.$FileNameToStore;
                
                }   
          

            }else{

                $FileNameToStore2 = '';

            }

        }

        //3
        // if($request->input('image3') ===  $datah->image3 ){
         
        //   $FileNameToStore3 = $datah->image3;
           
        // }else{
           
        //     $this->validate( $request , [
        //         'image3' =>'nullable|mimetypes:text/plain,image/png,image/jpeg,image/svg|max:10000',
        //     ]);

        //     // Handle File Upload
        //     if($request->hasFile('image3')){
                
        //         // Get filename with the extension
        //         $filenameWithExt = $request->file('image3')->getClientOriginalName();
        //         // Get just filename                 
        //         $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        //         // Get just ext
        //         $extension = $request->file('image3')->getClientOriginalExtension();
                
        //         // filename to store 
        //         $FileNameToStore = $filename.'_'.time().".".$extension;

        //         // Upload Image 
        //         $path = $request->file('image3')->storeAs('public/edm_header',$FileNameToStore);
                
        //         $data = [];
        //         $data["domain"] = $_SERVER['SERVER_NAME'];      
        //         switch ($data["domain"]) {
        //             case 'deloitte-backend.local.nmgdev.com':
        //                 $FileNameToStore3 = 'storage/edm_header/'.$FileNameToStore;
        //                 break; 
        //             default:
        //                 $FileNameToStore3  = 'storage/edm_header/'.$FileNameToStore;
                
        //         }   
          

        //     }else{

        //         $FileNameToStore3 = '';

        //     }

        // }



        // //4
        // if($request->input('image4') ===  $datah->image4 ){
         
        //   $FileNameToStore4 = $datah->image4;

        // }else{

        //      $this->validate( $request , [
        //         'image4' =>'nullable|mimetypes:text/plain,image/png,image/jpeg,image/svg|max:10000',
        //       ]);

        //     // Handle File Upload
        //     if($request->hasFile('image4')){
                
        //         // Get filename with the extension
        //         $filenameWithExt = $request->file('image4')->getClientOriginalName();
        //         // Get just filename                 
        //         $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        //         // Get just ext
        //         $extension = $request->file('image4')->getClientOriginalExtension();
                
        //         // filename to store 
        //         $FileNameToStore = $filename.'_'.time().".".$extension;

        //         // Upload Image 
        //         $path = $request->file('image4')->storeAs('public/edm_header',$FileNameToStore);
                
        //         // return  $response = \Response::json( $path, 200);
        //         $is_upload = 1;


        //         $data = [];
        //         $data["domain"] = $_SERVER['SERVER_NAME'];      
        //         switch ($data["domain"]) {
        //             case 'deloitte-backend.local.nmgdev.com':
        //                 $FileNameToStore4 = 'storage/edm_header/'.$FileNameToStore;
        //                 break; 
        //             default:
        //                 $FileNameToStore4 = 'storage/edm_header/'.$FileNameToStore;
                
        //         }   
          

        //     }else{

        //         $FileNameToStore4 = '';

        //     }

        // }

        // //5
        // if($request->input('image5') ===  $datah->image5 ){
         
        //   $FileNameToStore5 = $datah->image5;
        //   // $FileNameToStore2 ="if";
        // }else{
        //     // $FileNameToStore2 ="else";
        //     $this->validate( $request , [
        //         'image5' =>'nullable|mimetypes:text/plain,image/png,image/jpeg,image/svg|max:10000',
        //     ]);

        //     // Handle File Upload
        //     if($request->hasFile('image5')){
                
        //         // Get filename with the extension
        //         $filenameWithExt = $request->file('image5')->getClientOriginalName();
        //         // Get just filename                 
        //         $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        //         // Get just ext
        //         $extension = $request->file('image5')->getClientOriginalExtension();
                
        //         // filename to store 
        //         $FileNameToStore = $filename.'_'.time().".".$extension;

        //         // Upload Image 
        //         $path = $request->file('image5')->storeAs('public/edm_header',$FileNameToStore);
                
        //         $data = [];
        //         $data["domain"] = $_SERVER['SERVER_NAME'];      
        //         switch ($data["domain"]) {
        //             case 'deloitte-backend.local.nmgdev.com':
        //                 $FileNameToStore5 = 'storage/edm_header/'.$FileNameToStore;
        //                 break; 
        //             default:
        //                 $FileNameToStore5  = 'storage/edm_header/'.$FileNameToStore;
                
        //         }   
          
        //     }else{
        //         $FileNameToStore5 = '';
        //     }

        // }

        // //6
        // if($request->input('image6') ===  $datah->image6 ){
         
        //   $FileNameToStore6 = $datah->image6;
           
        // }else{
           
        //     $this->validate( $request , [
        //         'image6' =>'nullable|mimetypes:text/plain,image/png,image/jpeg,image/svg|max:10000',
        //     ]);

        //     // Handle File Upload
        //     if($request->hasFile('image6')){
                
        //         // Get filename with the extension
        //         $filenameWithExt = $request->file('image6')->getClientOriginalName();
        //         // Get just filename                 
        //         $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        //         // Get just ext
        //         $extension = $request->file('image6')->getClientOriginalExtension();
                
        //         // filename to store 
        //         $FileNameToStore = $filename.'_'.time().".".$extension;

        //         // Upload Image 
        //         $path = $request->file('image6')->storeAs('public/edm_header',$FileNameToStore);
                
        //         $data = [];
        //         $data["domain"] = $_SERVER['SERVER_NAME'];   

        //         switch ($data["domain"]) {
        //             case 'deloitte-backend.local.nmgdev.com':
        //                 $FileNameToStore6 = 'storage/edm_header/'.$FileNameToStore;
        //                 break; 
        //             default:
        //                 $FileNameToStore6  = 'storage/edm_header/'.$FileNameToStore;
                
        //         }   
          

        //     }else{

        //         $FileNameToStore6 = '';

        //     }

        // }


        // //7
        // if($request->input('image7') ===  $datah->image7 ){
         
        //   $FileNameToStore7 = $datah->image7;

        // }else{

        //     $this->validate( $request , [
        //         'image7' =>'nullable|mimetypes:text/plain,image/png,image/jpeg,image/svg|max:10000',
        //     ]);

        //     // Handle File Upload
        //     if($request->hasFile('image7')){
                
        //         // Get filename with the extension
        //         $filenameWithExt = $request->file('image7')->getClientOriginalName();
        //         // Get just filename                 
        //         $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        //         // Get just ext
        //         $extension = $request->file('image7')->getClientOriginalExtension();
                
        //         // filename to store 
        //         $FileNameToStore = $filename.'_'.time().".".$extension;

        //         // Upload Image 
        //         $path = $request->file('image7')->storeAs('public/edm_header',$FileNameToStore);
                
        //         // return  $response = \Response::json( $path, 200);
        //         $is_upload = 1;


        //         $data = [];
        //         $data["domain"] = $_SERVER['SERVER_NAME'];      
        //         switch ($data["domain"]) {
        //             case 'deloitte-backend.local.nmgdev.com':
        //                 $FileNameToStore7 = 'storage/edm_header/'.$FileNameToStore;
        //                 break; 
        //             default:
        //                 $FileNameToStore7  = 'storage/edm_header/'.$FileNameToStore;
                
        //         }   
          

        //     }else{

        //         $FileNameToStore7 = '';

        //     }

        // }

        // //8
        // if($request->input('image8') ===  $datah->image8 ){
         
        //   $FileNameToStore8 = $datah->image8;
        
        // }else{
           
        //     $this->validate( $request , [
        //         'image8' =>'nullable|mimetypes:text/plain,image/png,image/jpeg,image/svg|max:10000',
        //     ]);

        //     // Handle File Upload
        //     if($request->hasFile('image8')){
                
        //         // Get filename with the extension
        //         $filenameWithExt = $request->file('image8')->getClientOriginalName();
        //         // Get just filename                 
        //         $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        //         // Get just ext
        //         $extension = $request->file('image8')->getClientOriginalExtension();
                
        //         // filename to store 
        //         $FileNameToStore = $filename.'_'.time().".".$extension;

        //         // Upload Image 
        //         $path = $request->file('image8')->storeAs('public/edm_header',$FileNameToStore);
                
        //         $data = [];
        //         $data["domain"] = $_SERVER['SERVER_NAME'];      
        //         switch ($data["domain"]) {
        //             case 'deloitte-backend.local.nmgdev.com':
        //                 $FileNameToStore8 = 'storage/edm_header/'.$FileNameToStore;
        //                 break; 
        //             default:
        //                 $FileNameToStore8 = 'storage/edm_header/'.$FileNameToStore;
                
        //         }   
          

        //     }else{

        //         $FileNameToStore8 = '';

        //     }

        // }


        // if($request->input('image9') ===  $datah->image9 ){
         
        //   $FileNameToStore9 = $datah->image9;
           
        // }else{
           
        //     $this->validate( $request , [
        //         'image9' =>'nullable|mimetypes:text/plain,image/png,image/jpeg,image/svg|max:10000',
        //     ]);

        //     // Handle File Upload
        //     if($request->hasFile('image9')){
                
        //         // Get filename with the extension
        //         $filenameWithExt = $request->file('image9')->getClientOriginalName();
        //         // Get just filename                 
        //         $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        //         // Get just ext
        //         $extension = $request->file('image9')->getClientOriginalExtension();
                
        //         // filename to store 
        //         $FileNameToStore = $filename.'_'.time().".".$extension;

        //         // Upload Image 
        //         $path = $request->file('image9')->storeAs('public/edm_header',$FileNameToStore);
                
        //         $data = [];
        //         $data["domain"] = $_SERVER['SERVER_NAME'];      
        //         switch ($data["domain"]) {
        //             case 'deloitte-backend.local.nmgdev.com':
        //                 $FileNameToStore9 = 'storage/edm_header/'.$FileNameToStore;
        //                 break; 
        //             default:
        //                 $FileNameToStore9  = 'storage/edm_header/'.$FileNameToStore;
                
        //         }   
          

        //     }else{

        //         $FileNameToStore9 = '';

        //     }

        // }

        // if($request->input('image10') ===  $datah->image10 ){
         
        //   $FileNameToStore10 = $datah->image10;
           
        // }else{
           
        //     $this->validate( $request , [
        //         'image10' =>'nullable|mimetypes:text/plain,image/png,image/jpeg,image/svg|max:10000',
        //     ]);

        //     // Handle File Upload
        //     if($request->hasFile('image10')){
                
        //         // Get filename with the extension
        //         $filenameWithExt = $request->file('image10')->getClientOriginalName();
        //         // Get just filename                 
        //         $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        //         // Get just ext
        //         $extension = $request->file('image10')->getClientOriginalExtension();
                
        //         // filename to store 
        //         $FileNameToStore = $filename.'_'.time().".".$extension;

        //         // Upload Image 
        //         $path = $request->file('image10')->storeAs('public/edm_header',$FileNameToStore);
                
        //         $data = [];
        //         $data["domain"] = $_SERVER['SERVER_NAME'];      
        //         switch ($data["domain"]) {
        //             case 'deloitte-backend.local.nmgdev.com':
        //                 $FileNameToStore10 = 'storage/edm_header/'.$FileNameToStore;
        //                 break; 
        //             default:
        //                 $FileNameToStore10  = 'storage/edm_header/'.$FileNameToStore;
                
        //         }   
          

        //     }else{

        //         $FileNameToStore10 = '';

        //     }

        // }


        $dataheader = EdmHeader::find($request->id);
        // $dataheader->content =  $request->input('content');
        // $dataheader->title =  $request->input('title');

        // $dataheader->preheadertext1 =  $request->input('preheadertext1');
        // $dataheader->preheadertext2 =  $request->input('preheadertext2');
        // $dataheader->preheadertext3 =  $request->input('preheadertext3');
        // $dataheader->preheadertext4 =  $request->input('preheadertext4');
        // $dataheader->preheadertext5 =  $request->input('preheadertext5');

        // $dataheader->preheadertext6 =  $request->input('preheadertext6');
        // $dataheader->preheadertext7 =  $request->input('preheadertext7');

        // $dataheader->label1 =  $request->input('label1');
        // $dataheader->label2 =  $request->input('label2');
        // $dataheader->label3 =  $request->input('label3');
        // $dataheader->label4 =  $request->input('label4');

        // $dataheader->image1 =  $FileNameToStore1;
        $dataheader->link =   $request->input('link');
        $dataheader->image2 =  $FileNameToStore2;
        // $dataheader->image3 =  $FileNameToStore3;

        // $dataheader->image4 =  $FileNameToStore5;
        // $dataheader->image5 =  $FileNameToStore5;
        // $dataheader->image6 =  $FileNameToStore6;

        // $dataheader->image7 =  $FileNameToStore7;
        // $dataheader->image8 =  $FileNameToStore8;
        // $dataheader->image9 =  $FileNameToStore9;
        // $dataheader->image10 = $FileNameToStore10;

        $dataheader->save();

        event(new AdminLogEvent($request["profile_id"], AdminLog::TYPE_EDM_HEADER_EDIT, [
              'admin' => $request["name"],         
              'request_id' => $request->id,             
        ]));
              
        $datum['success'] = 1;
        $end_time = microtime(TRUE);
        $data['elapsed_time'] = $end_time - $start_time;

        return  $response = \Response::json($datum, 200);

     }


    public function ckeditor(Request $request){

      
        $filenameWithExt = $request->file('upload')->getClientOriginalName();
           
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);


        $extension = $request->file('upload')->getClientOriginalExtension();
        

        $FileNameToStore = $filename.'_'.time().".".$extension;

      
        $path = $request->file('upload')->storeAs('public/edmheader',$FileNameToStore);            

        $is_upload = 1;


        $data["domain"] = $_SERVER['SERVER_NAME'];      
        switch ($data["domain"]) {
           case 'deloitte-backend.local.nmgdev.com':
                $FileNameToStore = 'storage/edmheader/'.$FileNameToStore;
                break; 
           default:
                $FileNameToStore  = 'storage/edmheader/'.$FileNameToStore;

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
