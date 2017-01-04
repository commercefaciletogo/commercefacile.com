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


Route::group(['middleware' => ['web']], function(){
    Route::get('/', function () {
        return view('welcome');
    });
});



Route::get('/location', function(){
    geoip()->getClientIP();
    return [
        'ip' => geoip()->getClientIP(),
        'location' => geoip()->getLocation()->getAttribute("country"),
    ];
});
