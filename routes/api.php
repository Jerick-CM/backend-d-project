<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/mail/preview/{uid}', 'MailController@index');

Route::group(['middleware' => 'auth:api'], function () {

    Route::get('/user', 'Users\UsersController@current');
    Route::get('/users/badges', 'Users\UsersController@badges');
    Route::get('/users/nominations', 'Users\UsersController@nominations');
    Route::get('/users/transactions', 'Users\UsersController@transactions');
    Route::get('/users/{user_id}', 'Users\UsersController@get');

    Route::get('/users', 'Users\UsersController@index');
    Route::post('/users/firstOrCreate', 'Users\UsersController@firstOrCreate');


    Route::get('/nominations', 'Rewards\NominationsController@index');

    Route::post('/nominations', 'Rewards\NominationsController@store');

    Route::post('/nominations/{nomination_id}/like', 'Rewards\NominationsController@like');

    Route::get('/rewards', 'Rewards\ShopController@index');

    Route::get('/cart', 'Rewards\CartController@index');
    Route::post('/cart', 'Rewards\CartController@store');

    Route::get('/cart/checkout', 'Rewards\CheckoutController@checkout');

    Route::put('/cart/{inventory_id}', 'Rewards\CartController@update');
    Route::delete('/cart/{inventory_id}', 'Rewards\CartController@delete');

    Route::get('/redeem/history', 'Users\RedeemController@history');

    Route::get('/banners', 'Rewards\BannersController@index');

    Route::get('/contact', 'Rewards\ContactController@index');
    Route::post('/contact', 'Rewards\ContactController@send');

    Route::get('/categories', 'Rewards\CategoryController@index');

    Route::get('/departments', 'Rewards\DepartmentsController@index');

    // api for faq admin
    Route::post('/update-faq-item', 'Admin\FaqsController@updateitem');
    Route::post('/delete-faq-item', 'Admin\FaqsController@delete');
    Route::post('/create-faq-item', 'Admin\FaqsController@addfaqitem');
    Route::post('/sort-faqs', 'Admin\FaqsController@sort_faqs');
    
    Route::post('/delete-faq-selectmultiple', 'Admin\FaqsController@deletemultiple');
    Route::post('api/faq/ckeditor','Admin\FaqsController@ckeditor');

    // api for faqcategories admin
    Route::post('/update-faqcategories-item', 'Admin\FaqCategoriesController@updateitem');
    Route::post('/delete-faqcategories-item', 'Admin\FaqCategoriesController@delete');
    Route::post('/create-faqcategories-item', 'Admin\FaqCategoriesController@addfaqitem');
    Route::post('/sort-faqcategories', 'Admin\FaqCategoriesController@sort_faqcategories');    
    Route::post('/delete-faqcategories-selectmultiple', 'Admin\FaqCategoriesController@deletemultiple');

    // api for pdffile admin    
    Route::post('/update-faq-file','Admin\FaqFileController@faqfile_upload');

    //api for page cms menu
    Route::get('page','Admin\PageController@page');
    Route::post('/sort-page', 'Admin\PageController@sort_page');
    Route::post('/delete-page-item', 'Admin\PageController@delete');
    Route::post('/delete-page-selectmultiple', 'Admin\PageController@deletemultiple');
    Route::post('/create-page-item', 'Admin\PageController@addpageitem');

    Route::post('/update-page-item', 'Admin\PageController@updateitem'); 
    Route::post('api/menu/ckeditor','Admin\PageController@ckeditor');

    //api for edit post blacktoken

    Route::get('/black-token-post/{slug}', 'Rewards\NominationsController@getmessage');

    Route::post('/black-token-post', 'Rewards\NominationsController@updatemessage');
    

    /* Nomination*/
    Route::post('/post-remove-retain-badge', 'Rewards\NominationsController@remove_retain_badge');

    Route::post('/post-remove-retain-token-recipient', 'Rewards\NominationsController@remove_retain_token_recipient');
    Route::post('/nominations/remove-retain-token', 'Rewards\NominationsController@remove_retain_token_recipient');

    Route::post('/refund_black_token', 'Rewards\NominationsController@refund_blacktoken_post');
    Route::post('/nominations/refund_token', 'Rewards\NominationsController@refund_blacktoken_post');

    Route::get('/nominations/get_maximum_recipient_token_limit', 'Rewards\NominationsController@get_maximum_recipient_token_limit');

    Route::post('/nominations/remove_badge', 'Rewards\NominationsController@delete_badge');    
    Route::post('/nominations/remove_message', 'Rewards\NominationsController@delete_message');

    Route::post('/nominations/remove-wallpost', 'Rewards\NominationsController@remove_wallpost');

    /* Nomination*/

    /* Badge Level up reward Token start*/
    Route::get('/api/fetch-myrewards','Admin\BadgeRewards@fetchdata_data');
    Route::post('/api/update-badge-level-rewardtoken','Admin\BadgeRewards@update_data');
    /* Badge Level up reward Token end*/
 
    /* edm */
    Route::get('/api/fetch-edmfooter','Admin\EdmFooterController@fetch_edmfooter');
    Route::get('/api/search-edmfooter','Admin\EdmFooterController@edmfooter_getbyid');
    Route::post('/api/update-edm-footer','Admin\EdmFooterController@update_edm_footer');


    Route::get('/api/fetch-edmheader','Admin\EdmHeaderController@fetch_edmheader');
    Route::get('/api/search-edmheader','Admin\EdmHeaderController@edmheadergetbyid');
    Route::post('/api/update-edm-header','Admin\EdmHeaderController@update_edm_header');
    // Route::post('/api/update-edm-body','Admin\EdmHeaderController@update_edm_body');


    Route::post('api/edm-header/ckeditor','Admin\EdmHeaderController@ckeditor');
    Route::post('api/edm-footer/ckeditor','Admin\EdmFooterController@ckeditor');
    Route::post('api/edm-body/ckeditor','Admin\EdmTemplateBodyController@ckeditor');

    Route::get('/api/fetch-edm-templatebody','Admin\EdmTemplateBodyController@fetch_EdmTemplateBody');
    Route::get('/api/search-edm-templatebody','Admin\EdmTemplateBodyController@EdmTemplateBodygetbyid');

    Route::post('/api/update-edm-templatebody','Admin\EdmTemplateBodyController@update_EdmTemplateBody');
    
    Route::post('/api/create-edm-templatebody','Admin\EdmTemplateBodyController@create_EdmTemplateBody');
    
    Route::post('/api/sendemail-edm-templatebody','Admin\EdmTemplateBodyController@send_testemail');
    Route::post('/api/delete-edm-templatebody', 'Admin\EdmTemplateBodyController@delete_EdmTemplateBody');
});
