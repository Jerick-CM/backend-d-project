<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\AdminLogMail;
use Illuminate\Support\Facades\Mail;

class PagesController extends Controller
{
    public function index(){

        var_dump('test');
        $email = "jerick@nmgresources.ph";
        
        Mail::to($email)->send(new AdminLogMail($email,$message = 'Log generated at ' .'test' . ' is ready.', $subject ='Activity log generation complete',$isPreview=false));  

    	// return 'Index';
     //    $title = " Welcome to my Laraver Re allignment ";
    	// return view('pages.index')->with('title',$title);

    }
    public function about(){
    	// return 'Index';
        $title = " Welcome to my Laraver Re allignment ";
    	return view('pages.about')->with('title',$title);
    }
    
    public function services(){
    	// return 'Index';

        $data = array(
            'title' => "Services",
            'services' => ['Web Design', 'Programming', 'SEO']
        );

    	return view('pages.services')->with($data);
    }
}
