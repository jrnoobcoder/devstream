<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('admin/dashboard',[ App\Http\Controllers\Admin\DashboardController::class, 'index']);
Route::get('login',[ App\Http\Controllers\Auth\AuthController::class, 'login']);
Route::get('register',[ App\Http\Controllers\Auth\AuthController::class, 'register']);
Route::post('store',[ App\Http\Controllers\Auth\AuthController::class, 'store']);
Route::post('userLogin',[ App\Http\Controllers\Auth\AuthController::class, 'userLogin']);
//Admin Routes
Route::group(['prefix' => '/admin', 'middleware' => 'adminAuth'], function(){
    Route::get('/dashboard',[ App\Http\Controllers\Admin\DashboardController::class, 'index']);
});

//User Routes
Route::group(['prefix' => '/user', 'middleware' => 'userAuth'], function(){
    Route::get('/dashboard',[App\Http\Controllers\User\UserController::class, 'dashboard']);
});
