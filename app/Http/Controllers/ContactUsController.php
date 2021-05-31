<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Contactus;
use DB;


class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $datum = Contactus::All();
        return view('contactus.index')->with('datum',$datum);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datum  =  Contactus::find($id);
        return view('contactus.show')->with('datum',$datum);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        // $Faqscategory = FaqCategory::pluck('value', 'id');
        $datum =  Contactus::find($id);
        
        return view('contactus.edit')->with('datum',$datum);
        // ->with('Faqscategory',$Faqscategory);

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


        $this->validate( $request , [
            'fullname' => 'required',
            'email' => 'required',
            'role' => 'required',
            'type' => 'required',
            'option' => 'required',
            'attachmentlabel' => 'required',
        ]);

        // return 123;
        // var_dump($request->input('role'));die();
        // var_dump($role);die();

        $role = json_encode($request->input('role'),true);
        // var_dump($role);die();
        $type = json_encode($request->input('type'),true);
        $option = json_encode($request->input('option'),true);

        $datum = Contactus::find($id);
        $datum->fullname =  $request->input('fullname');
        $datum->email =  $request->input('email');
        $datum->role =  $role;
        $datum->type =  $type;
        $datum->option =  $option; //$request->input('option');
        $datum->attachmentlabel =  $request->input('attachmentlabel');
        $datum->save();

        return redirect('/contactus')->with('success',"Post Created");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $datum = Contactus::find($id);
        $datum->delete();
        return redirect('/contactus')->with('success', 'Post Removed');
    }

    public function page()
    {

        $datum = Contactus::All();
        return view('contactus.page')->with('datum',$datum);

    }



}
