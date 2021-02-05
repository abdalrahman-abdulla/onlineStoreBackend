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
Route::group([
    'prefix' => 'admin',
    'middleware' => ['api','admin'],

], function ($router) {
    Route::get('users', 'admin\userController@index');
    Route::post('users', 'admin\userController@store');
    Route::put('users/{id}', 'admin\userController@update');
    //categoryController
    Route::get('categories', 'admin\categoryController@index');
    Route::post('categories', 'admin\categoryController@store');
    Route::put('categories/{id}', 'admin\categoryController@update');
    Route::delete('categories/{id}', 'admin\categoryController@destroy');
    //subcategoryController
    Route::get('subcategory', 'admin\subcategoryController@index');
    Route::get('subcategory/{id}', 'admin\subcategoryController@show');
    Route::post('subcategory', 'admin\subcategoryController@store');
    Route::put('subcategory/{id}', 'admin\subcategoryController@update');
    Route::delete('subcategory/{id}', 'admin\subcategoryController@destroy');
    //items
    Route::get('items', 'admin\itemController@index');
    Route::post('items', 'admin\itemController@store');
    Route::post('save', 'admin\itemController@savePhoto');
    Route::put('items/{id}', 'admin\itemController@update');
    Route::delete('items/{id}', 'admin\itemController@destroy');
    //orders
    Route::get('orders', 'admin\orderController@index');
    Route::delete('orders/{id}', 'admin\orderController@destroy');
    Route::get('orders/{id}', 'admin\orderController@show');


});
//start user route
Route::get('{slug}/items', 'user\itemController@index');
Route::get('items/{slug}', 'user\itemController@item');
Route::get('categories/{slug}', 'user\itemController@categorypage');
Route::get('categories', 'user\itemController@categories');
Route::get('homedata', 'user\itemController@homedata');


//checkout
Route::post('canceled', 'user\checkout@canceled');
Route::post('checkout', 'user\checkout@checkout');
Route::post('status', 'user\checkout@status');
//auth


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'authController@login');
    Route::post('logout', 'authController@logout');
    Route::post('refresh', 'authController@refresh');
    Route::post('me', 'authController@me');
    Route::post('register', 'authController@register');
});



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
