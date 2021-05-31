<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Events\AdminLogEvent;
use App\Models\AdminLog;


use App\Page;
use DB;


use Closure;
use Takaworx\Brix\Entities\ApiResponse;
use Takaworx\Brix\Exceptions\ApiException;



class PageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        // $datum = DB::select('  SELECT  *  FROM `pages` WHERE 1 ORDER BY priority  asc ');
        // return view('page.index')->with('datum',$datum)->with('url',url('/') );;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            die();
        return view('page.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            die();
        $this->validate( $request , [
            'name' =>'required',
            'title' =>'required',
            'content' =>'required',
        ]);

        $count = Page::count(); 
        $count = $count + 1; 

        $datum = new Page;
        $datum->name =  $request->input('name');
        $datum->title =  $request->input('title');
        $datum->priority =  $count;
        $datum->content =  $request->input('content');
        $datum->save();

        return redirect('/page')->with('success',"Post Created");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
            die();
        $datum  =  Page::find($id);
        return view('page.show')->with('datum',$datum);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
            die();
        $datum =  Page::find($id);
    
        return view('page.edit')->with('datum',$datum);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
            die();
       $this->validate( $request , [
            'name' =>'required',
            'title' =>'required',
            'content' =>'required',
        ]);

        $datum = Page::find($id);
        $datum->name =  $request->input('name');
        $datum->title =  $request->input('title');        
        $datum->content =  $request->input('content');
        $datum->save();

        return redirect('/page')->with('success',"Post Created");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            die();
        $datum= Page::find($id);
        $datum->delete();
        return redirect('/page')->with('success', 'Post Removed');
    }

    public function sortpage_real(){

        foreach ($_POST["value"] as $key => $value) {
            $data["priority"] = $key + 1;
            $this->updatePosition_real($data, $value);
        }

        $mydata['value']  = $_POST["value"] ;
        $mydata['success']  = 1 ;

        return  $response = \Response::json($mydata, 200);
    }




    public function deleteAll(Request $request)
    {

        $ids = $request->ids;
        DB::table("pages")->whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>"Products Deleted successfully."]);

    }


    /* api 

        return
        {
         "data": {
                "page": [
                  {
                    "menu_name": "test",
                    "menu_title": "test",
                    "publish_description": "Publish",
                    "priority": 1,
                    "publish": 1,
                    "menu_content": "<p>test<img ....
              }
            ]
          },
          "success": 1,
          "elapsed_time": 0.0010089874267578125
        }

    */

    public function page(Request $request)
    {


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

                $datum  = DB::select('
                    SELECT 
                     id,
                     reserved,
                     name as menu_name,
                     title as menu_title,
                     is_upload,
                     -- IF(publish=1 ,"Publish", "Draft") as publish_description,
                       icon as menu_icon,
                       icon_hover as menu_icon_hover ,
                       pageurl as pageurl_segment,
                     priority, 
                     publish

                     FROM `pages` WHERE 1 ORDER BY priority  asc;'

                );

         }else{


            $datum  = DB::select('
                SELECT 
                 id,
                 reserved,
                 name as menu_name,
                 title as menu_title,
                 is_upload,
                 -- IF(publish=1 ,"Publish", "Draft") as publish_description,
                   icon as menu_icon,
                   icon_hover as menu_icon_hover ,
                   pageurl as pageurl_segment,
                 priority, 
                 publish

                 FROM `pages` WHERE publish = 1 ORDER BY priority  asc;'

            );

 
         }



        $datum  = json_decode(json_encode($datum ), true);

        $data = [];
        $data["domain"] = $_SERVER['SERVER_NAME'];      
        switch ($data["domain"]) {
            case 'deloitte-backend.local.nmgdev.com':
             foreach ($datum as $key => $value) {
                $datum[$key]['menu_icon'] = url($value['menu_icon']);
                $datum[$key]['menu_icon_hover'] = url($value['menu_icon_hover']);
             }

                break; 
            default:
           
           foreach ($datum as $key => $value) {
                $datum[$key]['menu_icon'] = secure_url($value['menu_icon']);
                $datum[$key]['menu_icon_hover'] = secure_url($value['menu_icon_hover']);
            }

        }   
  

        $data['data']['page'] = $datum;
        $data['success'] = 1;
       
        $end_time = microtime(TRUE);
        $data['elapsed_time'] = $end_time - $start_time;
        
        return  $response = \Response::json($data, 200);



      } catch (Exception $e) {
            $data['error'] =1;
         return  $response = \Response::json($data, 200);

      }


    
    }

    //  Frontend admin api

    public function page_fetchdata()
    {

         $start_time = microtime(TRUE);

         $datum  = DB::select(' SELECT  id,name,title,priority,publish,icon,created_at,updated_at,pageurl FROM `pages` WHERE 1 ORDER BY priority  asc;');

        $data['data']['pages'] = $datum;

        $end_time = microtime(TRUE);
        $data['success'] = 1;
        $data['elapsed_time'] = $end_time - $start_time;
        
        return  $response = \Response::json($data, 200);


    }


    public function sort_page(Request $request){

        foreach ($request["value"] as $key => $value) {
            $data["priority"] = $key + 1;
            $this->updatePosition_real($data, $value);
        }

        $mydata['value']  = $request["value"] ;
        $mydata['success']  = 1 ;

        event(new AdminLogEvent($request["profile_id"], AdminLog::TYPE_CMS_PAGE_SORT, [
            'admin' => $request["name"],         
            'location' => "pages cms",
            'data_id' => $request["data_id"],
            'old_index' => $request["old_index"],
            'new_index' => $request["new_index"], 
            'data_name' => $request["data_name"],  
        ]));
     

        return  $response = \Response::json($mydata, 200);

    }


    public function delete(Request $request){
        
        $start_time = microtime(TRUE);

        $datum['data']['request_id'] = $request->id;
        $Faq = Page::find($request->id);
        $Faq->delete();   

        event(new AdminLogEvent($request["profile_id"], AdminLog::TYPE_CMS_PAGE_DELETE, [
                'admin' => $request["name"],  
                'faq_id' => $request->id,   
                'menu_name' => $request["menu_name"]     
        ]));


        $datum['success'] = 1;
        $end_time = microtime(TRUE);
        $data['elapsed_time'] = $end_time - $start_time;

        return  $response = \Response::json($datum, 200);
    }


    public function deletemultiple(Request $request){

        $ids = $request->ids;
        DB::table("pages")->whereIn('id',explode(",",$ids))->delete();
        $string = $request->menu;
        $parts = explode(",", $string);

        $name_category ='';
        foreach ( $parts  as $key => $value) {
          $name_category  .= ' <br /> - '.'`'.$value.'`';
        }

        $string = $request->menu;
        $parts = explode(",", $string);
        $formated_menu = implode(', ', $parts);

        event(new AdminLogEvent($request["profile_id"], AdminLog::TYPE_CMS_PAGE_DELETEDMANYOPTION, [
                'admin' => $request["name"],  
                'deleted'  => $ids,
                'menu_deleted'  => $formated_menu,
                'name_category' => $name_category
        ]));

        $mydata['success']  = 1 ;
        return  $response = \Response::json($mydata, 200);

    }

    public function addpageitem(Request $request)
    {

        $slug =  Page::where('pageurl', '=', $request->input('slug'))->first();
        if ($slug){
    
            $datum['error']['message'] = 'slug already exists';
            $datum['error']['code'] = 1;
            return  $response = \Response::json($datum , 200);
        }
        

        
         // id,name,title,priority,publish,created_at,updated_at
        $start_time = microtime(TRUE);

        $this->validate( $request , [
            'title' => 'required',
            'name' => 'required',
            'publish' =>'required',
            'content' => 'required',
            // 'icon' => 'required'

        ]);

        $is_upload = 0;
    

        if($request->input('icon') == 'img/menu/article-black-24dp.svg'){

            $FileNameToStore1 = 'img/menu/article-black-24dp.svg';

        }else{

            $this->validate( $request , [
                'icon' =>'nullable|mimetypes:text/plain,image/png,image/jpeg,image/svg|max:10000',
            ]);

            // Handle File Upload
            if($request->hasFile('icon')){
                
                // Get filename with the extension
                $filenameWithExt = $request->file('icon')->getClientOriginalName();
                // Get just filename                 
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

                // Get just ext
                $extension = $request->file('icon')->getClientOriginalExtension();
                
                // filename to store 
                $FileNameToStore = $filename.'_'.time().".".$extension;

                // Upload Image 
                $path = $request->file('icon')->storeAs('public/menu_icon',$FileNameToStore);
                
                // return  $response = \Response::json( $path, 200);
                $is_upload = 1;


                $data = [];
                $data["domain"] = $_SERVER['SERVER_NAME'];  
                $FileNameToStore1 = 'storage/menu_icon/'.$FileNameToStore;

                // switch ($data["domain"]) {
                //     case 'deloitte-backend.local.nmgdev.com':
                //         $FileNameToStore1 = 'storage/menu_icon/'.$FileNameToStore;
                //         break; 
                //     default:
                //         $FileNameToStore1  = 'public/storage/menu_icon/'.$FileNameToStore;
                
                // }   
          

            }else{

                $FileNameToStore1 = 'img/menu/article-black-24dp.svg';

            }
  
        }


        if($request->input('icon_hover') == 'img/menu/article-white-24dp.svg'){

             $FileNameToStore_hover = 'img/menu/article-white-24dp.svg';

        }else{

            $this->validate( $request , [
                'icon_hover' =>'nullable|mimetypes:text/plain,image/png,image/jpeg,image/svg|max:10000',
            ]);

            // Handle File Upload
            if($request->hasFile('icon_hover')){
                
                // Get filename with the extension
                $filenameWithExt = $request->file('icon_hover')->getClientOriginalName();
                // Get just filename                 
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

                // Get just ext
                $extension = $request->file('icon_hover')->getClientOriginalExtension();
                
                // filename to store 
                $FileNameToStore = $filename.'_'.time().".".$extension;

                // Upload Image 
                $path = $request->file('icon_hover')->storeAs('public/menu_icon',$FileNameToStore);
                
                // return  $response = \Response::json( $path, 200);
                $is_upload = 1;

                $FileNameToStore_hover = 'storage/menu_icon/'.$FileNameToStore;
                $data = [];

                // $data["domain"] = $_SERVER['SERVER_NAME'];      
                // switch ($data["domain"]) {
                //     case 'deloitte-backend.local.nmgdev.com':
                //         $FileNameToStore_hover = 'storage/menu_icon/'.$FileNameToStore;
                //         break; 
                //     default:
                //         $FileNameToStore_hover  = 'public/storage/menu_icon/'.$FileNameToStore;
                
                // }   
          

            }else{

                $FileNameToStore_hover = 'img/menu/article-white-24dp.svg.svg';

            }
  
        }

        $segment = $this->clean($request->input('name'));
    
        $count = Page::count(); 
        $count = $count + 1; 

        $data = new Page;

        $data->name =  $request->input('name');
        $data->title =  $request->input('title');
        $data->publish = $request->input('publish');
        $data->content = $request->input('content');   
        $data->is_upload = $is_upload;  
       
        $data->icon =  $FileNameToStore1;         
        $data->icon_hover =  $FileNameToStore_hover;

        if( $request->input('slug')){

            $data->pageurl = str_slug($request->input('slug'));

        }else{
            $data->pageurl = str_slug($segment." ".time());
        }
       

        $data->priority =  $count;

        $data->save();

        event(new AdminLogEvent($request["profile_id"], AdminLog::TYPE_CMS_PAGE_ADD, [
                'admin' => $request["profile_name"],  
                'menu'  => $request->input('name')             
        ]));
        
        $datum['success'] = 1;
        $end_time = microtime(TRUE);
        $data['elapsed_time'] = $end_time - $start_time;

        return  $response = \Response::json($datum, 200);
    }

    public function updateitem(Request $request){

        if($request->input('slug')){
            $another_row_slug = DB::table('pages')->where('id','<>', $request->id)->where('pageurl', $request->input('slug'))->value('id');
            if($another_row_slug ){
                $datum['error']['message'] = 'slug already exists';
                $datum['error']['code'] = 1;
                $datum['error']['slug'] = $another_row_slug;
                return  $response = \Response::json($datum , 200);
            }
     
        }


        $start_time = microtime(TRUE);

        $this->validate( $request , [
            'title' =>'required',
            'name' => 'required',
            'publish' => 'required',
            'content' => 'required',
            // 'icon' => 'required'
        ]);

        $is_upload = 0;
        $segment = $this->clean($request->input('name'));

        $data = Page::find($request->id);

        if($request->input('icon') ===  $data->icon ){
         

        }else{

             $this->validate( $request , [

                    'icon' =>'nullable|mimetypes:text/plain,image/png,image/jpeg,image/svg|max:10000',
                ]
            );

            // Handle File Upload
            if($request->hasFile('icon')){
                
                // Get filename with the extension
                $filenameWithExt = $request->file('icon')->getClientOriginalName();
                // Get just filename                 
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

                // Get just ext
                $extension = $request->file('icon')->getClientOriginalExtension();
                
                // filename to store 
                $FileNameToStore = $filename.'_'.time().".".$extension;

                // Upload Image 
                $path = $request->file('icon')->storeAs('public/menu_icon',$FileNameToStore);
                    
                $is_upload = 1;

                $data_url = [];
                $data_url["domain"] = $_SERVER['SERVER_NAME'];      

                $FileNameToStore = 'storage/menu_icon/'.$FileNameToStore;

                // switch ($data_url["domain"]) {
                //     case 'deloitte-backend.local.nmgdev.com':
                        
                //         break; 
                //     default:
                //         $FileNameToStore  = 'public/storage/menu_icon/'.$FileNameToStore;         
                // }                   

            }else{
              
                $FileNameToStore = 'img/menu/article-black-24dp.svg';

            }

            $data->icon = $FileNameToStore;
        }




        if($request->input('icon_hover') ===  $data->icon_hover ){
         

        }else{

             $this->validate( $request , [

                    'icon_hover' =>'nullable|mimetypes:text/plain,image/png,image/jpeg,image/svg|max:10000',
                ]
            );

            // Handle File Upload
            if($request->hasFile('icon_hover')){
                
                // Get filename with the extension
                $filenameWithExt = $request->file('icon_hover')->getClientOriginalName();
                // Get just filename                 
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

                // Get just ext
                $extension = $request->file('icon_hover')->getClientOriginalExtension();
                
                // filename to store 
                $FileNameToStore = $filename.'_'.time().".".$extension;

                // Upload Image 
                $path = $request->file('icon_hover')->storeAs('public/menu_icon',$FileNameToStore);
                    
                $is_upload = 1;

                $data_url = [];

                  $FileNameToStore_hover = 'storage/menu_icon/'.$FileNameToStore;
                $data_url["domain"] = $_SERVER['SERVER_NAME'];      
                // switch ($data_url["domain"]) {
                //     case 'deloitte-backend.local.nmgdev.com':
                //         $FileNameToStore_hover = 'storage/menu_icon/'.$FileNameToStore;
                //         break; 
                //     default:
                //        $FileNameToStore_hover  = 'public/storage/menu_icon/'.$FileNameToStore;           
                //             }                   

            }else{
              
                $FileNameToStore_hover = 'img/menu/article-white-24dp.svg';

            }

            $data->icon_hover = $FileNameToStore_hover;
        }



        $data->name =  $request->input('name');
        $data->title =  $request->input('title');
        $data->content = $request->input('content'); 
        $data->publish = $request->input('publish');
        $data->is_upload = $is_upload;  
      
        if( $request->input('slug')){

            $data->pageurl = str_slug($request->input('slug'));

        }else{
          
        }


        $data->save();

        event(new AdminLogEvent($request["profile_id"], AdminLog::TYPE_CMS_PAGE_EDIT, [
            'admin' => $request["profile_name"],         
            'id' => $request->id, 
            'item' => $request->id, 
            'menu' => $request->input('name'), 
        ]));
        
        $datum['success'] = 1;
        $end_time = microtime(TRUE);
        $data['elapsed_time'] = $end_time - $start_time;

        return  $response = \Response::json($datum, 200);

     }


    public function page_getbyid(Request $request){

        $id = $request['id'];

        $datum =  Page::select('*')->where('id', $id )->get();

        return  $response = \Response::json($datum, 200);

    }

    /* Private method */
    private function updatePosition_real($data,$id){

        if(array_key_exists("Name", $data)){
            $data["Name"] = real_escape_string($data["Name"]);
        }

        foreach ($data as $key => $value) {

            $value = "'$value'";
            $updates[] = "$key=$value";
        }

        $imploadAray =  implode(",", $updates);
     
        $return = DB::update('Update pages Set '.$imploadAray.' Where id='.$id.'');

    }

    public function get_menu($id){

        $start_time = microtime(TRUE);

        // $datum['data'] =  Page::find($id);
        $datum['data'] = Page::select('id','content')->where('id', $id)->get();
        
        $datum['success'] = 1;

        $end_time = microtime(TRUE);

        $datum['elapsed_time'] = $end_time - $start_time;

        return  $response = \Response::json($datum, 200);

    }
    

    public function get_menu_slug($slug,Request $request){



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


                $datum['data'] = Page::select('id','content','title')->where('pageurl', $slug)->get();
                
                $datum['success'] = 1;

                $end_time = microtime(TRUE);

                $datum['elapsed_time'] = $end_time - $start_time;

                return  $response = \Response::json($datum, 200);

            }else{

                $datum['data'] = Page::select('id','content','title')->where('pageurl', $slug)->where('publish', 1)->get();
                
                $datum['success'] = 1;

                $end_time = microtime(TRUE);

                $datum['elapsed_time'] = $end_time - $start_time;

                return  $response = \Response::json($datum, 200);
                


            }

        } catch (Exception $e) {

            $data['error'] =1;
            return  $response = \Response::json($data, 200);

        }



    }

    public function get_menu_slug_checker($slug,$userid){

  
        $start_time = microtime(TRUE);

        // $datum['data'] =  Page::find($id);
        $users = DB::select(' SELECT  is_admin FROM `users` WHERE id='.$userid.';');
        $users = json_decode(json_encode($users), true);

        try {

            if($users[0]['is_admin']){

                $datum['data'] = Page::select('id','content','title')->where('pageurl', $slug)->get();
                
                $datum['success'] = 1;

                $end_time = microtime(TRUE);

                $datum['elapsed_time'] = $end_time - $start_time;

                return  $response = \Response::json($datum, 200);

            }else{

                 $datum['data'] = Page::select('id','content','title')->where('pageurl', $slug)->where('publish', 1)->get();
                
                $datum['success'] = 1;

                $end_time = microtime(TRUE);

                $datum['elapsed_time'] = $end_time - $start_time;

                return  $response = \Response::json($datum, 200);

            }

        } catch (Exception $e) {
            
                $datum['success'] = 1;

                $end_time = microtime(TRUE);

                $datum['elapsed_time'] = $end_time - $start_time;
              
              return  $response = \Response::json($datum, 200);

        }
              


    }

    public function page_checker($userid)
    {

        $start_time = microtime(TRUE);


        $users = DB::select(' SELECT  is_admin FROM `users` WHERE id='.$userid.';');
        $users = json_decode(json_encode($users), true);

        try {

             if($users[0]['is_admin']){

                $datum  = DB::select('
                    SELECT 
                     id,
                     reserved,
                     name as menu_name,
                     title as menu_title,
                     is_upload,
                     -- IF(publish=1 ,"Publish", "Draft") as publish_description,
                       icon as menu_icon,
                       icon_hover as menu_icon_hover,
                       pageurl as pageurl_segment,
                     priority, 
                     publish

                     FROM `pages` WHERE 1 ORDER BY priority  asc;'

                );

             }else{

                $datum  = DB::select('
                    SELECT 
                     id,
                     reserved,
                     name as menu_name,
                     title as menu_title,
                     is_upload,
                     -- IF(publish=1 ,"Publish", "Draft") as publish_description,
                       icon as menu_icon,
                        icon_hover as menu_icon_hover,
                       pageurl as pageurl_segment,
                     priority, 
                     publish

                     FROM `pages` WHERE publish=1 ORDER BY priority  asc;'

                );


             }


            $datum  = json_decode(json_encode($datum ), true);


            $data = [];
            $data["domain"] = $_SERVER['SERVER_NAME'];      
            switch ($data["domain"]) {
                case 'deloitte-backend.local.nmgdev.com':
                 foreach ($datum as $key => $value) {
                    $datum[$key]['menu_icon'] = url($value['menu_icon']);
                      $datum[$key]['menu_icon_hover'] = url($value['menu_icon_hover']);
                 }

                    break; 
                default:
               
               foreach ($datum as $key => $value) {
                    $datum[$key]['menu_icon'] = secure_url($value['menu_icon']);
                     $datum[$key]['menu_icon_hover'] = secure_url($value['menu_icon_hover']);
                }

            }   
         
            $data['data']['page'] = $datum;


            
        } catch (Exception $e) {
            

       


        }
    
        $data['success'] = 1;
       
        $end_time = microtime(TRUE);
        $data['elapsed_time'] = $end_time - $start_time;
        
        return  $response = \Response::json($data, 200);
    
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
                $path = $request->file('upload')->storeAs('public/upload_menu',$FileNameToStore);
           //         // return  $response = \Response::json( $path, 200);
      
                $is_upload = 1;


              $data["domain"] = $_SERVER['SERVER_NAME']; 
              $FileNameToStore = 'storage/upload_menu/'.$FileNameToStore;     
              // switch ($data["domain"]) {
              //      case 'deloitte-backend.local.nmgdev.com':
              //           $FileNameToStore = 'storage/upload_menu/'.$FileNameToStore;
              //         break; 
              //      default:
              //           $FileNameToStore  = 'public/storage/upload_menu/'.$FileNameToStore;
                
              // }   
          


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

    private function clean($string) {

       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

       return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }



}
