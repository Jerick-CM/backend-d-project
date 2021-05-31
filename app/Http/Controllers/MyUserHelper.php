<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\UserHelper;

class MyUserHelper extends Controller
{
    public function index(){

    	// $test = UserHelper::all();
    	$test = UserHelper::latest()->get();
    	// var_dump($test);

    	// $user = App\User::with('roles')->first();

		var_dump( $test->toArray());


    	// Pizza::latest()->get();
		// echo "hello";
    }
}
