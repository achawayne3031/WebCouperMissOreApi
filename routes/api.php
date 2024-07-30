<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



///// Staff Auth Routes /////
Route::group(
    [
        'middleware' => ['cors'],
        'prefix' => 'staff/auth',
        'namespace' => 'App\Http\Controllers',
    ],
    function ($router) {
        Route::post('/login', 'AuthController@login');
        Route::post('/register', 'AuthController@staff_register');
    }
);




///// Staff Protected Routes /////
Route::group(
    [
        'middleware' => ['cors', 'jwt', 'staff'],
        'namespace' => 'App\Http\Controllers\Staff',
    ],
    function ($router) {
        Route::get('/users', 'UserController@users');
        Route::get('/users/{id}', 'UserController@view');
        Route::get('/staff/dashboard', 'DashboardController@dashboard');
        Route::get('/placed-orders', 'UserController@placed_orders');
    }
);




///// Staff Protected Routes /////
Route::group(
    [
        'middleware' => ['cors', 'jwt', 'staff'],
        'prefix' => 'staff/menu',
        'namespace' => 'App\Http\Controllers\Staff',
    ],
    function ($router) {
        Route::post('/create', 'MenuController@create');
        Route::post('/update', 'MenuController@update');
        Route::post('/delete', 'MenuController@delete');

    }
);






///// Customer Auth Routes /////
Route::group(
    [
        'middleware' => ['cors'],
        'prefix' => 'customer/auth',
        'namespace' => 'App\Http\Controllers',
    ],
    function ($router) {
        Route::post('/login', 'AuthController@login');
        Route::post('/register', 'AuthController@customer_register');
    }
);




///// Customer Protected Routes /////
Route::group(
    [
        'middleware' => ['cors', 'jwt', 'customer'],
        'namespace' => 'App\Http\Controllers\Customer',
    ],
    function ($router) {
        Route::get('/profile ', 'CustomerController@profile');
    }
);




///// Customer Protected Routes /////
Route::group(
    [
        'middleware' => ['cors', 'jwt', 'customer'],
        'prefix' => 'menus',
        'namespace' => 'App\Http\Controllers\Customer',
    ],
    function ($router) {
        Route::get('/', 'MenuController@menus');
        Route::get('/discounted', 'MenuController@discounted');
        Route::get('/drinks ', 'MenuController@drinks');
        Route::post('/place-order ', 'MenuController@place_order');
        Route::get('/{id}', 'MenuController@view');
    }
);








