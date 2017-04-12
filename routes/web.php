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

Route::resource("sub-categories", "SubCategoriesController");

Route::resource("cities", "CitiesController");
Route::resource("regions", "RegionsController");

Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localize', 'localeSessionRedirect', 'localizationRedirect' ]], function(){


    Route::get('sell-fast', ['as' => 'pages.misc.sell', 'uses' => 'PagesController@sell']);
    Route::get('about-us', ['as' => 'pages.misc.about', 'uses' => 'PagesController@about']);
    Route::get('contact-us', ['as' => 'pages.misc.contact', 'uses' => 'PagesController@contact']);
    Route::get('stay-safe', ['as' => 'pages.misc.safe', 'uses' => 'PagesController@safe']);
    Route::get('privacy', ['as' => 'pages.misc.privacy', 'uses' => 'PagesController@privacy']);
    Route::get('terms', ['as' => 'pages.misc.terms', 'uses' => 'PagesController@terms']);
    Route::get('faq', ['as' => 'pages.misc.faq', 'uses' => 'PagesController@faq']);




    Route::group(['prefix' => 'admin'], function () {

        Route::get('/login', ['as' => 'admin.get.login', 'uses' => 'AdminAuth\LoginController@showLoginForm']);
        Route::post('/login', ['as' => 'admin.post.login', 'uses' => 'AdminAuth\LoginController@login']);

        Route::group(['middleware' => ['admin']], function(){
            Route::get('/logout', ['as' => 'admin.get.logout', 'uses' => 'AdminAuth\LoginController@logout']);

            Route::group(['prefix' => 'api'], function(){
                Route::get('ads', ['as' => 'api.ads', 'uses' => 'AdsApiController@all']);
                Route::get('ads/status', ['as' => 'api.ads.status', 'uses' => 'AdsApiController@status']);
                Route::post('ads/{id}', ['as' => 'api.ad.review', 'uses' => 'AdsApiController@review']);
            });

            Route::get('/dashboard', ['as' => 'admin.dashboard', 'uses' => 'AdminPagesController@dashboardPage']);
            Route::get('/ads', ['as' => 'admin.ads', 'uses' => 'AdminPagesController@adsPage']);
            Route::get('/ads/{id}', ['as' => 'admin.ad.action', 'uses' => 'AdminPagesController@adPage']);
            Route::get('/employees', ['as' => 'admin.employees', 'uses' => 'AdminPagesController@employeesPage']);
            Route::get('/users', ['as' => 'admin.users', 'uses' => 'AdminPagesController@usersPage']);
        });
    });







    Route::resource("categories", "CategoriesController");
    Route::get('/locations', ['as' => 'locations.index', 'uses' => 'LocationsController@index']);
    Route::get('/locations/{id}', ['as' => 'locations.index', 'uses' => 'LocationsController@cities']);

    Route::get(LaravelLocalization::transRoute('routes.login'), ['as' => 'user.get.login', 'uses' => 'UserAuth\LoginController@showLoginForm']);
    Route::post(LaravelLocalization::transRoute('routes.login'), ['as' => 'user.post.login', 'uses' => 'UserAuth\LoginController@login']);
    Route::post(LaravelLocalization::transRoute('routes.logout'), ['as' => 'user.post.logout', 'uses' => 'UserAuth\LoginController@logout']);

    Route::get(LaravelLocalization::transRoute('routes.register'), ['as' => 'user.get.register', 'uses' => 'UserAuth\RegisterController@showRegistrationForm']);
    Route::post(LaravelLocalization::transRoute('routes.register'), ['as' => 'user.post.register', 'uses' => 'UserAuth\RegisterController@registerUser']);
    Route::post(LaravelLocalization::transRoute('routes.phone_verify'), ['as' => 'user.post.phone.verify', 'uses' => 'UserAuth\RegisterController@authenticatePhone']);

    Route::post(LaravelLocalization::transRoute('routes.password-email'), ['as' => 'user.post.pass.phone', 'uses' => 'UserAuth\ForgotPasswordController@sendResetCode']);
    Route::post(LaravelLocalization::transRoute('routes.password-reset'), ['as' => 'user.post.pass.reset', 'uses' => 'UserAuth\ResetPasswordController@reset']);
    Route::get(LaravelLocalization::transRoute('routes.password-reset'), ['as' => 'user.get.pass.reset', 'uses' => 'UserAuth\ForgotPasswordController@showLinkRequestForm']);
    Route::get(LaravelLocalization::transRoute('routes.password-reset-token'), ['as' => 'user.get.reset.pass', 'uses' => 'UserAuth\ResetPasswordController@showResetForm']);


    Route::get('/', ['as' => 'home.page', 'uses' => 'PagesController@home']);

    Route::group(['middleware' => 'user'], function(){
//        ads/create
        Route::get(LaravelLocalization::transRoute('routes.ads-create'), ['as' => 'ads.create', 'uses' => 'AdsController@create']);

//        ads/{id}/edit
        Route::get(LaravelLocalization::transRoute('routes.ads-single-edit'), ['as' => 'ads.single.edit', 'uses' => 'AdsController@edit']);

//        ads/{id}/update
        Route::post(LaravelLocalization::transRoute('routes.ads-single-update'), ['as' => 'ads.single.update', 'uses' => 'AdsController@update']);
        Route::post(LaravelLocalization::transRoute('routes.ads-single-update-cancel'), ['as' => 'ads.single.update.cancel', 'uses' => 'AdsController@cancelUpdate']);

//        ads/{id}/report
        Route::post(LaravelLocalization::transRoute('routes.ads-single-report'), ['as' => 'ads.single.report', 'uses' => 'AdsController@report']);
        Route::post(LaravelLocalization::transRoute('routes.ads-single-dereport'), ['as' => 'ads.single.dereport', 'uses' => 'AdsController@report']);

//        ads/{id}/favorite
        Route::post(LaravelLocalization::transRoute('routes.ads-single-favorite'), ['as' => 'ads.single.favorite', 'uses' => 'AdsController@favorite']);
        Route::post(LaravelLocalization::transRoute('routes.ads-single-unfavorite'), ['as' => 'ads.single.unfavorite', 'uses' => 'AdsController@favorite']);

//        ads/{id}
        Route::post(LaravelLocalization::transRoute('routes.ads'), ['as' => 'ads.save', 'uses' => 'AdsController@save']);

//        ads/{id}/delete
        Route::delete(LaravelLocalization::transRoute('routes.ads-single-delete'), ['as' => 'ads.single.delete', 'uses' => 'AdsController@delete']);
    });

    Route::get(LaravelLocalization::transRoute('routes.ads'), ['as' => 'ads.multiple', 'uses' => 'AdsController@multiple']);

    Route::get('ads/search', ['as' => 'ads.multiple.search', 'uses' => 'AdsController@search']);

    Route::get(LaravelLocalization::transRoute('routes.ads-single'), ['as' => 'ads.single', 'uses' => 'AdsController@single']);





//        user profile
    Route::get('/{user_name}/public', ['as' => 'user.profile.public', 'uses' => 'UsersController@publicProfile']);

    Route::group(['middleware' => ['redirectIfNotLogin', 'user', 'redirectIfNotOwner']], function(){
        Route::get('/{user_name}', ['as' => 'user.profile', 'uses' => 'UsersController@profile']);
        Route::get(LaravelLocalization::transRoute('routes.user-settings'), ['as' => 'user.profile.settings', 'uses' => 'UsersController@settings']);
        Route::post('/{user_name}/settings/update-profile', ['as' => 'user.profile.settings.update.profile', 'uses' => 'UsersController@updateProfile']);
        Route::post('/{user_name}/settings/update-password', ['as' => 'user.profile.settings.update.password', 'uses' => 'UsersController@updatePassword']);
        Route::get(LaravelLocalization::transRoute('routes.user-favorites'), ['as' => 'user.profile.favorites', 'uses' => 'UsersController@favorites']);
    });
});
