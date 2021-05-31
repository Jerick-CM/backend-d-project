<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\FaqCategory;
use DB;

use App\Events\AdminLogEvent;
use App\Models\AdminLog;

class FaqCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        die();
        //
        // return $posts =  FaqCategory::orderBy('created_at','desc'); //->paginate(10);

        // $FaqCategories =  FaqCategory::orderBy('created_at','desc')->get();
        // return view('faqcategories.index')->with('FaqCategories',$FaqCategories);


        $datum =  FaqCategory::orderBy('priority','asc')->get();
        
        return view('faqcategories.index')->with('datum',$datum)->with('url',url('/'));



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            die();
       return view('faqcategories.create');
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
            'value' =>'required',
        ]);

        $count = FaqCategory::count(); 
        $count = $count + 1; 


        $FaqCategories = new FaqCategory;
        $FaqCategories->value =  $request->input('value');
        $FaqCategories->priority =  $count;
        $FaqCategories->save();
        return redirect('/faqcategory')->with('success',"Post Created");

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
        $FaqCategories =  FaqCategory::find($id);
        return view('faqcategories.show')->with('FaqCategories',$FaqCategories);
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
        $FaqCategories =  FaqCategory::find($id);
        return view('faqcategories.edit')->with('FaqCategories',$FaqCategories);
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
        ]);

        $FaqCategories = FaqCategory::find($id);
        $FaqCategories->value =  $request->input('value');        
        $FaqCategories->save();

        return redirect('/faqcategory')->with('success',"Post Created");

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
        $FaqCategories = FaqCategory::find($id);
        $FaqCategories->delete();
        return redirect('/faqcategory')->with('success', 'Post Removed');

    }

    public function page()
    {

    die();
        $FaqCategories =  FaqCategory::orderBy('created_at','desc')->get();

        return view('faqcategories.page')->with('FaqCategories',$FaqCategories);

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
     
        $return = DB::update('Update faq_categories Set '.$imploadAray.' Where id='.$id.'');

    }

    public function deleteAll(Request $request)
    {

        $ids = $request->ids;
        DB::table("faq_categories")->whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>"Products Deleted successfully."]);


    }


    public function faq_categories_fetchdata(Request $request)
    {

        $start_time = microtime(TRUE);
   
        
        $data['data'] =  FaqCategory::orderBy('priority','asc')->get();
        
        $data['success'] = 1;       
        $end_time = microtime(TRUE);
        $data['elapsed_time'] = $end_time - $start_time;

        return  $response = \Response::json($data, 200);

    }

     public function updateitem(Request $request){

        $start_time = microtime(TRUE);

        $this->validate( $request , [
           'value' =>'required',
        ]);

        $FaqCategories = FaqCategory::find($request->id);
        $FaqCategories->value =  $request->input('value');        
        $FaqCategories->save();
        
        event(new AdminLogEvent($request["profile_id"], AdminLog::TYPE_CMS_FAQ_CATEGORY_EDIT, [
                'admin' => $request["name"],    
                 'faq_categories_id' => $request->id, 
                'item' => $request->item,  
                 'value' => $request->value,    
        ]));

        $datum['success'] = 1;
        $end_time = microtime(TRUE);
        $data['elapsed_time'] = $end_time - $start_time;

        return  $response = \Response::json($datum, 200);

     }

    public function delete(Request $request){
        

        // $datum['data']['id'] = $request->id;
        $start_time = microtime(TRUE);

        $datum['data']['request_id'] = $request->id;
        $Faq = FaqCategory::find($request->id);
        $Faq->delete();   

        event(new AdminLogEvent($request["profile_id"], AdminLog::TYPE_CMS_FAQ_CATEGORY_DELETE, [
                 'admin' => $request["name"],  
                'faq_id' => $request->id,  
                 'value' => $request["value"],       
        ]));


        $datum['success'] = 1;
        $end_time = microtime(TRUE);
        $data['elapsed_time'] = $end_time - $start_time;

         return  $response = \Response::json($datum, 200);
    }


    public function addfaqitem(Request $request){    

        $start_time = microtime(TRUE);

        $this->validate( $request , [
            'value' =>'required',
        ]);
    
        $count = FaqCategory::count(); 
        $count = $count + 1; 

        $FaqCategories = new FaqCategory;
        $FaqCategories->value =  $request->input('value');
        $FaqCategories->priority =  $count;
        $FaqCategories->save();


        event(new AdminLogEvent($request["profile_id"], AdminLog::TYPE_CMS_FAQ_CATEGORY_ADD, [
             'admin' => $request["name"],  
             'value' => $request["value"],        
        ]));

        $datum['success'] = 1;
        $end_time = microtime(TRUE);
        $data['elapsed_time'] = $end_time - $start_time;

        return  $response = \Response::json($datum, 200);

    }

   public function faqcategories_getbyid(Request $request){  

        $id = $request['id'];
 
        $datum =  FaqCategory::select('*')->where('id', $id )->get();

        return  $response = \Response::json($datum, 200);

   }


    public function sort_faqcategories(Request $request){

        foreach ($request["value"] as $key => $value) {
            $data["priority"] = $key + 1;
            $this->updatePosition_real($data, $value);
        }

        event(new AdminLogEvent($request["profile_id"], AdminLog::TYPE_CMS_FAQ_CATEGORY_SORT, [
                'admin' => $request["name"],       
                'location'=>"faqcategories",
                'data_id'=>$request["data_id"],
                'old_index'=>$request["old_index"],
                'new_index'=>$request["new_index"],
                'category_name' => $request["category_name"],
        ]));
     

        $mydata['value']  = $request["value"];
        $mydata['success']  = 1 ;

        return  $response = \Response::json($mydata, 200);
    }


    public function deletemultiple(Request $request){

        $ids = $request->ids;
        DB::table("faq_categories")->whereIn('id',explode(",",$ids))->delete();

        $string = $request->category;
        $parts = explode(",", $string);

        $formated_category = implode(', ', $parts);

        $name_category ='';
        foreach ( $parts  as $key => $value) {
          $name_category  .= ' <br /> - '.'`'.$value.'`';
        }


        event(new AdminLogEvent($request["profile_id"], AdminLog::TYPE_CMS_FAQ_CATEGORY_DELETEDMANYOPTION, [
                    'admin' => $request["name"],  
                 'deleted'  => $ids,
                'category'  => $formated_category,
                'name_category'  => $name_category
        ]));

        $mydata['success']  = 1 ;
        return  $response = \Response::json($mydata, 200);

    }


}
