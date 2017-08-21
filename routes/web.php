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


    Route::resource('price/category','PriceCategoryController');

    Route::post('payment/check/rrNo','PaymentController@checkrrNo');

    Route::resource('payment', 'PaymentController');

    Route::resource('history', 'PaymentHistoryController');

    Route::post('report','ReportController@index');

    Route::resource('profile', 'ProfileController');
    
});




