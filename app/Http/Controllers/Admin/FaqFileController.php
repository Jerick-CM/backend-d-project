<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\FaqFile;
use DB;
use App\Events\AdminLogEvent;
use App\Models\AdminLog;

class FaqFileController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
       die();
        $datum =  FaqFile::orderBy('created_at','desc')->get();
        return view('faqupload.index')->with('datum',$datum);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
            die();
         return view('faqupload.create');
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
            'pdf' =>'required|nullable|mimes:pdf|max:10000',
        ]);

        // Handle File Upload
        if($request->hasFile('pdf')){
            
            // Get filename with the extension
            $filenameWithExt = $request->file('pdf')->getClientOriginalName();
            // Get just filename                 
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            // Get just ext
            $extension = $request->file('pdf')->getClientOriginalExtension();
            
            // filename to store 
            $FileNameToStore = $filename.'_'.time().".".$extension;

            // Upload Image 
            $path = $request->file('pdf')->storeAs('public/faq_pdf',$FileNameToStore);

        }else{

            $FileNameToStore = 'nofile.pdf';

        }

        $datum = new FaqFile;
        $datum->pdf =  $FileNameToStore;
        $datum->save();
        return redirect('/faqfile')->with('success',"Post Created");
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
        $datum =  FaqFile::find($id);
        return view('faqupload.show')->with('datum',$datum);
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
        $datum =  FaqFile::find($id);
        return view('faqupload.edit')->with('datum',$datum);
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
            'pdf' =>'required|nullable|mimes:pdf|max:10000',
        ]);

        // Handle File Upload
        if($request->hasFile('pdf')){
            
            // Get filename with the extension
            $filenameWithExt = $request->file('pdf')->getClientOriginalName();
            // Get just filename                 
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            // Get just ext
            $extension = $request->file('pdf')->getClientOriginalExtension();
            
            // filename to store 
            $FileNameToStore = $filename.'_'.time().".".$extension;

            // Upload Image 
            $path = $request->file('pdf')->storeAs('public/faq_pdf',$FileNameToStore);

        }else{

            $FileNameToStore = 'nofile.pdf';

        }

        $datum = FaqFile::find($id);
        $datum->pdf =  $FileNameToStore;
        $datum->save();
        return redirect('/faqfile')->with('success',"FAQ File Updated");

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
        $datum  = FaqFile::find($id);
        $datum->delete();
        return redirect('/faqcategory')->with('success', 'Post Removed');
    }

    // frontend api

    public function faqfile_fetchdata(){
        
        $start_time = microtime(TRUE);
        $datum =  FaqFile::orderBy('created_at','desc')->get();
        $data['data']['faqfile'] = $datum;

        $end_time = microtime(TRUE);
        $data['success'] = 1;
        $data['elapsed_time'] = $end_time - $start_time;
        
        return  $response = \Response::json($data, 200);


    }

    public function faqfile_upload(Request $request){


         $start_time = microtime(TRUE);
        $this->validate( $request , [
            'pdf' =>'required|nullable|mimes:pdf|max:10000',
        ]);

        // Handle File Upload
        if($request->hasFile('pdf')){
            
            // Get filename with the extension
            $filenameWithExt = $request->file('pdf')->getClientOriginalName();
            // Get just filename                 
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            // Get just ext
            $extension = $request->file('pdf')->getClientOriginalExtension();
            
            // filename to store 
            $FileNameToStore = $filename.'_'.time().".".$extension;

            // Upload Image 
            $path = $request->file('pdf')->storeAs('public/faq_pdf',$FileNameToStore);

        }else{

            $FileNameToStore = 'nofile.pdf';

        }

        $datum = FaqFile::find($request->id);
        $datum->pdf =  $FileNameToStore;
        $datum->save();

        event(new AdminLogEvent($request["profile_id"], AdminLog::TYPE_CMS_FAQ_UPLOAD, [
                'admin' => $request["name"],         
        ]));



        $end_time = microtime(TRUE);
        $data['success'] = 1;
        $data['elapsed_time'] = $end_time - $start_time;

        return  $response = \Response::json($data, 200);

    }

}
