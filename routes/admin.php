<?php

Route::group(['prefix' => 'rewards'], function () {
    Route::get('/', 'RewardsController@index');
    Route::post('/', 'RewardsController@store');
    Route::put('/{inventory_id}/credit', 'RewardsController@credit');
    Route::put('/{inventory_id}/debit', 'RewardsController@debit');
    Route::post('/{inventory_id}/photo', 'RewardsController@photo');
    Route::post('/{inventory_id}/photo/sort', 'RewardsController@sortPhoto');
    Route::put('/{inventory_id}/photo/{photo_id}/set-primary', 'RewardsController@setPrimaryPhoto');
    Route::delete('/{inventory_id}/photo/{photo_id}', 'RewardsController@deletePhoto');
    Route::put('/{inventory_id}', 'RewardsController@update');
    Route::delete('/{inventory_id}', 'RewardsController@delete');
});

Route::group(['prefix' => 'redeems'], function () {
    Route::get('/', 'RedeemController@index');
});

Route::group(['prefix' => 'users'], function () {
    Route::get('/', 'UsersController@index');
    Route::get('/summary', 'UsersController@userSummary');
    Route::get('/generate', 'UsersController@generateCsv');
    Route::get('/download', 'UsersController@downloadLog');
    Route::put('/', 'UsersController@batchUpdate');
    Route::put('/recognise', 'UsersController@batchUpdateRecognize');
    Route::post('/blacklist', 'UsersController@blacklist');
});

Route::group(['prefix' => 'transactions'], function () {
    Route::get('/', 'TransactionsController@index');
});

Route::group(['prefix' => 'banners'], function () {
    Route::get('/', 'BannersController@index');
    Route::post('/', 'BannersController@store');
    Route::post('/sort', 'BannersController@sort');
    Route::put('/{banner_id}', 'BannersController@update');
    Route::delete('/{banner_id}', 'BannersController@delete');
});

Route::group(['prefix' => 'edm'], function () {
    Route::get('/', 'EdmController@index');
    Route::post('/', 'EdmController@store');
    Route::post('/{edm_id}', 'EdmController@preview');
    Route::post('/send_blast/{edm_id}', 'EdmController@sendBlast');
    Route::get('/logs', 'EdmController@getLogs');

    Route::post('/masstokenupdate/{edm_id}', 'EdmController@masstokenupdate');

    Route::post('/testmonthlyedm/{edm_id}', 'EdmController@sendmonthlyedm');

});

Route::group(['prefix' => 'logs'], function () {
    Route::get('/', 'LogController@index');
    Route::post('/cms', 'LogController@logcms');
    Route::get('/generate', 'LogController@generateCsv');
    Route::get('/download', 'LogController@downloadLog');
    Route::get('/downloadables', 'LogController@getDownloadableLogs');
});

Route::group(['prefix' => 'positions'], function () {
    Route::get('/', 'PositionsController@index');
    Route::put('/', 'PositionsController@update');
});

Route::group(['prefix' => 'blacklist-logs'], function () {
    Route::get('/', 'BlacklistLogController@index');
    Route::get('/result/{blacklist_log_id}', 'BlacklistLogController@show');
});

Route::group(['prefix' => 'categories'], function () {
    Route::get('/', 'CategoryController@index');
    Route::post('/', 'CategoryController@store');
    Route::put('/{category_id}', 'CategoryController@update');
    Route::delete('/{category_id}', 'CategoryController@delete');
});

Route::group(['prefix' => 'collection'], function () {
    Route::get('/', 'CollectionController@index');
    Route::get('/blocks', 'CollectionController@blocks');
    Route::post('/blocks', 'CollectionController@storeBlock');
    Route::get('/blockdays', 'CollectionController@getBlockDays');
    Route::post('/blockdays', 'CollectionController@updateBlockDays');
    Route::delete('/blocks/{collection_block_id}', 'CollectionController@deleteBlock');
});

Route::group(['prefix' => 'departments'], function () {
    Route::put('/{department_id}', 'DepartmentsController@update');
});

Route::group(['prefix' => 'user-levels'], function () {
    Route::get('/', 'UserLevelsController@index');
    Route::put('/{user_level_id}', 'UserLevelsController@update');
});
