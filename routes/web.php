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

use App\Order;

Route::get('/', function () {



    $params = [
        'API_KEY' => 'd',
        'sandbox' => 'd',
        'name' => 'd',
        'phone_number' => 'd',
        'email' => 'ss',
        'amount' => 'sst',
        'reseller' => 'ss',
        'status' => 'processing',
//        'callback' => 'http://127.0.0.1:8000/callback',
//        'desc' => 'توضیحات پرداخت کننده',


    ];



    $order = Order::create($params);

    $order->save();


    return view('welcome');
});


Route::get('/{id?}', 'ActivityController@show')->name('show');
Route::post('activity/store', 'ActivityController@store')->name('store');


Route::get('redirect/{url}/{id}', 'ActivityController@redirect')->name('redirect');
Route::POST('callback', 'ActivityController@callback')->name('callback');
Route::post('verify', 'ActivityController@verify')->name('verify');
Route::post('store_callback', 'ActivityController@store_callback')->name('store_callback');
