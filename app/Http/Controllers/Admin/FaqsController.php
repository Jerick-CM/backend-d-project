<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Events\AdminLogEvent;
use App\Models\AdminLog;


use Illuminate\Http\Request;
use App\Faq;
use App\FaqCategory;
use App\FaqFile;
use App\Contactus;

use DB;

class FaqsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
 

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
 
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
            'value' =>'required',
            'category_id' =>'required',
            // 'priority' =>'required',
            'body' =>'required',
        ]);

        // return 123;

        $Faq = Faq::find($id);
        $Faq->value =  $request->input('value');
        $Faq->category_id =  $request->input('category_id');
        $Faq->priority =  $request->input('priority');
        $Faq->body =  $request->input('body');
        $Faq->save();

        return redirect('/faq')->with('success',"Post Created");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function destroy($id)
    {
       
    }



    public function page()
    {



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


   private function updatePosition_real($data,$id){

        if(array_key_exists("Name", $data)){
            $data["Name"] = real_escape_string($data["Name"]);
        }

        foreach ($data as $key => $value) {

            $value = "'$value'";
            $updates[] = "$key=$value";
        }

        $imploadAray =  implode(",", $updates);
     
        $return = DB::update('Update faqs Set '.$imploadAray.' Where id='.$id.'');

    }


    public function sortpage(){
 
        foreach ($_POST["value"] as $key => $value) {
            $data["Position"] = $key + 1;
            $this->updatePosition($data, $value);
        }

        $mydata['value']  = $_POST["value"] ;
        $mydata['success']  = 1 ;

        return  $response = \Response::json($mydata, 200);
    }

    private function updatePosition($data,$id){

        if(array_key_exists("Name", $data)){
            $data["Name"] = real_escape_string($data["Name"]);
        }

        foreach ($data as $key => $value) {

            $value = "'$value'";
            $updates[] = "$key=$value";
        }

        $imploadAray =  implode(",", $updates);
           
        $return = DB::update('Update studentinfo Set '.$imploadAray.' Where Id='.$id.'');

    }

    public function deleteAll(Request $request)
    {

        $ids = $request->ids;
        DB::table("faqs")->whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>"Products Deleted successfully."]);

    }

   public function destroy_individual($id)
    {
        DB::table("products")->delete($id);
        return response()->json(['success'=>"Product Deleted successfully.", 'tr'=>'tr_'.$id]);
    }

   

    public function faq_fetchdata()
    {

         $start_time = microtime(TRUE);
         $datum  = DB::select('

           SELECT 
            `id`,
            `category_id`,
            (Select value from faq_categories where id=category_id ) as `categoryname`, 
            (Select priority from faq_categories where id=category_id ) as `category_priority`, 
            `value`,
            -- `body`,
            `priority`,
            `created_at`,
            `updated_at`

            FROM `faqs` WHERE 1 ORDER BY category_priority asc,priority  asc;
                         ');

        $data['data']['faq'] = $datum;

        $end_time = microtime(TRUE);
        $data['success'] = 1;
        $data['elapsed_time'] = $end_time - $start_time;
        
        return  $response = \Response::json($data, 200);


    }


    private function group_by($key, $data) {

        $result = array();

        foreach($data as $val) {
            if(array_key_exists($key, $val)){
                $result[$val[$key]][] = $val;
            }else{
                $result[""][] = $val;
            }
        }

        return $result;
    }



    /* API */

    public function faq()
    {

        $start_time = microtime(TRUE);

        $Faqs  = DB::select('

          SELECT 
            -- `id`,
            (Select value from faq_categories where id=category_id ) as `categoryname`, 
            (Select priority from faq_categories where id=category_id ) as `category_priority`, 
            -- `priority`,
            `value` as `title`,
            `body` as `content`
            FROM `faqs` WHERE 1 ORDER BY category_priority asc,priority  asc;');

        
        $resultArray = json_decode(json_encode($Faqs), true);

        foreach ($resultArray as $key => $value) {
          unset($resultArray[$key]['category_priority']);
        }        

        $data['data']['faq'] = $this->group_by("categoryname", $resultArray);
    

        $faqpdf  = FaqFile::select('pdf')->get();

        if ($faqpdf->isEmpty()) {

              $data['data']['faq_pdf'] = $faqpdf;

        }else{
             $data['data']['faq_pdf'] = url('storage/faq_pdf/')."/".$faqpdf[0]['pdf'];  
        }

             
        $data['success'] = 1;
    

        $end_time = microtime(TRUE);
        $data['elapsed_time'] = $end_time - $start_time;
        

        return  $response = \Response::json($data, 200);
    
    }

    // API get category
    public function get_category()
    {
        $datum = FaqCategory::pluck('value', 'id');      
        foreach ( $datum as $key => $value) {

            $datareturn[$key]['id'] = $key;
            $datareturn[$key]['name'] = $value;
        }
        return  $datareturn;
    }

    public function faq_getbyid(Request $request){

        $id = $request['id'];

        $datum =  Faq::select('*')->where('id', $id )->get();

        return  $response = \Response::json($datum, 200);

    }


     public function updateitem(Request $request){

        $start_time = microtime(TRUE);

        $this->validate( $request , [
            'value' =>'required',
            'category_id' =>'required',
            'body' =>'required',
        ]);

        $Faq = Faq::find($request->id);
        $Faq->value =  $request->input('value');
        $Faq->category_id =  $request->input('category_id');
        $Faq->priority =  $request->input('priority');
        $Faq->body =  $request->input('body');
        $Faq->save();

        event(new AdminLogEvent($request["profile_id"], AdminLog::TYPE_CMS_FAQ_EDIT, [
                'admin' => $request["name"],         
                'faq_id' => $request->id, 
                'category_name' => $request->category_name, 
                'title' => $request->value, 
        ]));
        
        $datum['success'] = 1;
        $end_time = microtime(TRUE);
        $data['elapsed_time'] = $end_time - $start_time;

        return  $response = \Response::json($datum, 200);

     }

    public function delete(Request $request){
        
        $start_time = microtime(TRUE);

        $datum['data']['request_id'] = $request->id;
        $Faq = Faq::find($request->id);
        $Faq->delete();   

        event(new AdminLogEvent($request["profile_id"], AdminLog::TYPE_CMS_FAQ_DELETE, [
                 'admin' => $request["name"],  
                 'faq_id' => $request->id,  
                 'value' => $request->value,          
                 'category_name' => $request->category_name, 
        ]));


        $datum['success'] = 1;
        $end_time = microtime(TRUE);
        $data['elapsed_time'] = $end_time - $start_time;

         return  $response = \Response::json($datum, 200);
    }


    //used
    public function addfaqitem(Request $request)
    {
        
        $start_time = microtime(TRUE);

        $this->validate( $request , [
            'value' =>'required',
            'category_id' =>'required',
            'body' =>'required',
        ]);

    
        $count = Faq::count(); 
        $count = $count + 1; 

        $Faq = new Faq;
        $Faq->value =  $request->input('value');
        $Faq->category_id =  $request->input('category_id');
        $Faq->priority =  $count;
        $Faq->body =  $request->input('body');
        $Faq->save();

        event(new AdminLogEvent($request["profile_id"], AdminLog::TYPE_CMS_FAQ_ADD, [
                'admin' => $request["name"],  
                'value' => $request["value"], 
                'category_name' => $request["category_name"], 
                 
        ]));
        
        $datum['success'] = 1;
        $end_time = microtime(TRUE);
        $data['elapsed_time'] = $end_time - $start_time;

        return  $response = \Response::json($datum, 200);
    }

    public function sort_faqs(Request $request){

        foreach ($request["value"] as $key => $value) {
            $data["priority"] = $key + 1;
            $this->updatePosition_real($data, $value);
        }

        $mydata['value']  = $request["value"] ;
        $mydata['success']  = 1 ;


        event(new AdminLogEvent($request["profile_id"], AdminLog::TYPE_CMS_FAQ_SORT, [
                'admin' => $request["name"],
                'location' => "faq",
                'data_id' => $request["data_id"],
                'old_index' => $request["old_index"],
                'new_index' => $request["new_index"],   
                'category_name' => $request["category_name"], 

                'title' => $request["title"],          
        ]));
     

        return  $response = \Response::json($mydata, 200);

    }


    public function deletemultiple(Request $request){

        $ids = $request->ids;
        DB::table("faqs")->whereIn('id',explode(",",$ids))->delete();


        $string = $request->title;
        $parts = explode(",", $string);
        $partcategorytitle = explode(",", $string);
        $formated_title = implode(', ', $parts);


        $string = $request->categoryname;
        $parts = explode(",", $string);
        $partcategory = explode(",", $string);
        $formated_categoryname = implode(', ', $parts);
        $name_category = '';
        foreach ($partcategorytitle as $key => $value) {
          $name_category  .= ' <br /> '.'`'.$value.'`'.', '.'`'. $partcategory[$key].'` ';
        }

        event(new AdminLogEvent($request["profile_id"], AdminLog::TYPE_CMS_FAQ_DELETEDMANYOPTION, [
                'admin' => $request["name"],  
                'deleted'  => $ids,
                'title'  => $formated_title,
                'categoryname'  => $formated_categoryname,
                'name_category' => $name_category
        ]));

        $mydata['success']  = 1 ;
        return  $response = \Response::json($mydata, 200);

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
                $path = $request->file('upload')->storeAs('public/upload_faq',$FileNameToStore);
           //         // return  $response = \Response::json( $path, 200);
      
                $is_upload = 1;
                
                $data["domain"] = $_SERVER['SERVER_NAME']; 
                $FileNameToStore = 'storage/upload_faq/'.$FileNameToStore;

           //      $data = [];
                   
              // switch ($data["domain"]) {
              //      case 'deloitte-backend.local.nmgdev.com':
              //           $FileNameToStore = 'storage/upload_faq/'.$FileNameToStore;
              //         break; 
              //      default:
              //      $FileNameToStore  = 'public/storage/upload_faq/'.$FileNameToStore;
                
              // }   
          

           //  }else{

           //      $FileNameToStore = 'no-image';

           //  }
  

        $mydata['success']  = 1 ;
        $mydata["ret"] =  $filenameWithExt;
        $mydata["data"] = $request->upload;

        switch ($data["domain"]) {
           case 'deloitte-backend.local.nmgdev.com':
                $mydata["url"]=  url($FileNameToStore );

              break; 
           default:
                 
               $mydata["url"]=  secure_url($FileNameToStore );

        } 


        return  $response = \Response::json($mydata, 200);
    }

}
