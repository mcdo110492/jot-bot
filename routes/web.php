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



Route::post('api/authenticate', 'AuthenticateController@authenticate');





Route::group(['prefix' => 'api', 'middleware' => 'jwt.auth'], function()
{
    Route::get('authenticate','AuthenticateController@checkValidity');

    Route::get('minister/all','MinisterController@all');

    Route::get('minister/active','MinisterController@active');
    
    Route::post('minister/status','MinisterController@changeStatus');

    Route::resource('minister','MinisterController');

    Route::resource('priest','PriestController');
    
    Route::resource('baptism','BaptismController');

    Route::post('excel/import/{source}','ExcelImportController@importExcel');

    Route::resource('confirmation','ConfirmationController');

    Route::resource('death','DeathController');
    

    Route::get('marriage','MarriageController@index');

    Route::get('marriage/{id}','MarriageController@show');

    Route::post('marriage','MarriageController@store');

    Route::put('marriage/{id}','MarriageController@update');

    
    Route::get('item/type/all','ItemTypeController@all');

    Route::get('item/type','ItemTypeController@index');

    Route::post('item/type','ItemTypeController@store');

    Route::get('item/type/{id}','ItemTypeController@show');

    Route::put('item/type/{id}','ItemTypeController@update');

    Route::post('item/type/validate','ItemTypeController@checkValue');

    

    Route::get('item/price/all','ItemTypePriceController@all');

    Route::get('item/price','ItemTypePriceController@index');
    
    Route::post('item/price','ItemTypePriceController@store');
    
    Route::get('item/price/{id}','ItemTypePriceController@show');
    
    Route::put('item/price/{id}','ItemTypePriceController@update');

  
    


    Route::get('group','GroupController@index');
    
    Route::post('group','GroupController@store');
    
    Route::get('group/{id}','GroupController@show');
    
    Route::put('group/{id}','GroupController@update');

    Route::post('group/validate','GroupController@checkValue');



    Route::get('item/group','ItemGroupController@index');

    Route::get('item/group/price','ItemGroupController@getItemsPos');
    
    Route::post('item/group','ItemGroupController@store');

    Route::post('item/group/validate','ItemGroupController@checkValue');
    
    Route::delete('item/group/{id}','ItemGroupController@delete');



    Route::post('invoices','InvoicesController@index');

    Route::post('invoices/status','InvoicesController@changeStatus');

    Route::get('invoices/items/{id}','InvoicesController@getItems');

    Route::get('invoice/collection','InvoicesController@totalCollection');

    Route::post('invoice/validate','InvoicesController@checkValue');

    Route::post('invoice','InvoicesController@store');
    

    
    


});




