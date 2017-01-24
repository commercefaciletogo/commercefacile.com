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


use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(['middleware' => ['country']], function(){

    Route::resource("categories", "CategoriesController");
    Route::resource("sub-categories", "SubCategoriesController");

    Route::resource("cities", "CitiesController");
    Route::resource("regions", "RegionsController");

    Route::get('/locations', ['as' => 'locations.index', 'uses' => 'LocationsController@index']);

    Route::group(['prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localize', 'localeSessionRedirect', 'localizationRedirect' ]], function(){

        Route::group(['prefix' => 'user'], function () {
            Route::get('/login', ['as' => 'user.get.login', 'uses' => 'UserAuth\LoginController@showLoginForm']);
            Route::post('/login', ['as' => 'user.post.login', 'uses' => 'UserAuth\LoginController@login']);
            Route::post('/logout', ['as' => 'user.post.logout', 'uses' => 'UserAuth\LoginController@logout']);

            Route::get('/register', ['as' => 'user.get.register', 'uses' => 'UserAuth\RegisterController@showRegistrationForm']);
            Route::post('/register', ['as' => 'user.post.register', 'uses' => 'UserAuth\RegisterController@register']);

            Route::post('/password/email', ['as' => 'user.post.email', 'uses' => 'UserAuth\ForgotPasswordController@sendResetLinkEmail']);
            Route::post('/password/reset', ['as' => 'user.post.pass.reset', 'uses' => 'UserAuth\ResetPasswordController@reset']);
            Route::get('/password/reset', ['as' => 'user.get.pass.reset', 'uses' => 'UserAuth\ForgotPasswordController@showLinkRequestForm']);
            Route::get('/password/reset/{token}', ['as' => 'user.get.reset.token', 'uses' => 'UserAuth\ResetPasswordController@showResetForm']);
        });


        Route::get('/', ['as' => 'home.page', 'uses' => 'PagesController@home']);


        Route::get("ads", ['as' => 'ads.multiple', 'uses' => 'AdsController@multiple']);
        Route::get("ads/create", ['as' => 'ads.create', 'uses' => 'AdsController@create']);
        Route::post("ads", ['as' => 'ads.save', 'uses' => 'AdsController@save']);
        Route::get("ads/{id}", ['as' => 'ads.single', 'uses' => 'AdsController@single']);







        Route::get('/{user_name}', ['as' => 'user.profile', 'uses' => 'UsersController@profile']);
        Route::get('/{user_name}/settings', ['as' => 'user.profile.settings', 'uses' => 'UsersController@settings']);
        Route::get('/{user_name}/favorites', ['as' => 'user.profile.favorites', 'uses' => 'UsersController@favorites']);
    });

});

