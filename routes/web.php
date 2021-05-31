<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::name('login.callback')->get('/token/request', 'Socialite\AzureController@handleProviderCallback');

Route::name('photos.get')->get('/photos/{filename}', 'Users\PhotosController@get');

Route::name('home')->get('/', function () {
    return view('index');
      // return view('test');
});



Route::group(['middleware' => ['auth']], function () {
    Route::get('logout', 'Users\UsersController@logout');
});

Route::get('/test', function () {
    return view('edm.checkout.default'); //email template
});


Route::get('/test_test', function () {
    return view('edm.checkout.default_test');
});

Route::get('/userhelper', 'MyUserHelper@index');

Route::get('/testemail', 'PagesController@index');

// backup index pages 
Route::get('faq_page','Admin\FaqsController@page');
Route::get('faqcategory_page','Admin\FaqCategoriesController@page');
Route::get('contactus_page','Admin\ContactUsController@page');

//test
Route::resource('faqcheck','Admin\FaqsController');// important for resource 


// post method 
Route::post('faq-sorttable','Admin\FaqsController@sortpage');
Route::post('faq-sorttable-real','Admin\FaqsController@sortpage_real');
Route::post('page-sorttable-real','Admin\PageController@sortpage_real');

// delete method 
Route::delete('faqdeleteall', 'Admin\FaqsController@deleteAll');
Route::delete('faqcategoriesdeleteall', 'Admin\FaqCategoriesController@deleteAll');
Route::delete('pagedeleteall', 'Admin\PageController@deleteAll');

Route::post('faqcategory-sorttable-real','Admin\FaqCategoriesController@sortpage_real');
Route::get('api/fetch-page','Admin\PageController@page_fetchdata');

Route::group(['prefix' => 'api'], function()  
{  
	//api faq
	// Route::get('testing','Admin\FaqsController@testing');
	
	Route::get('faq','Admin\FaqsController@faq');
	Route::get('faq-n-contact-us','Admin\FaqsController@faq');

	//api admin faq
	Route::get('fetch-faq','Admin\FaqsController@faq_fetchdata');
	Route::get('get-faq-category','Admin\FaqsController@get_category');
	Route::get('faq-search','Admin\FaqsController@faq_getbyid');

	Route::get('faq-categories','Admin\FaqCategoriesController@api_faqcategories');
	Route::get('cms-page','Admin\PageController@page');

	Route::get('page','Admin\PageController@page');

	Route::get('page/{slug}',['uses' =>'Admin\PageController@page_checker']);
	

	Route::get('fetch-faq-categories','Admin\FaqCategoriesController@faq_categories_fetchdata');

 	Route::get('faqcategories-search','Admin\FaqCategoriesController@faqcategories_getbyid');
 	
	//file upload data
 	Route::get('fetch-faq-pdf','Admin\FaqFileController@faqfile_fetchdata');
	//api get for page cms
    Route::get('page-search','Admin\PageController@page_getbyid');

    Route::get('get-menu/{id}', ['uses' =>'Admin\PageController@get_menu'] );

    Route::get('get-menu-slug/{slug}/{slug2}', ['uses' =>'Admin\PageController@get_menu_slug_checker'] );
    Route::get('get-menu-slug/{slug}', ['uses' =>'Admin\PageController@get_menu_slug'] );

});  