<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('login', 'Auth\AuthController@getLogin');
// Route::post('login', 'Auth\AuthController@postLogin');
// Route::get('logout', 'Auth\AuthController@getLogout');

// Route::auth();
// Route::group(['middleware' => 'auth'], function(){
    Route::get('/', 'CampaignsController@index');
    Route::get('/campaigns/blacklist', 'CampaignsController@getBlacklist');
    Route::resource('/campaigns', 'CampaignsController');
    Route::get('/campaigns/{campaign}/{opt}', 'CampaignsController@show');
    Route::post('/campaigns/{campaign}/drag-into', 'CampaignsController@dragInto');
// });