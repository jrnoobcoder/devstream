<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\GenreController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[ AuthController::class, 'login']);
Route::get('admin/dashboard',[ AdminDashboard::class, 'index']);
Route::get('login',[ AuthController::class, 'login']);
Route::get('register',[ AuthController::class, 'register']);
Route::post('store',[ AuthController::class, 'store']);
Route::post('userLogin',[ AuthController::class, 'userLogin']);
Route::get('logout', [AuthController::class, 'logout']);
//Admin Routes
Route::group(['prefix' => '/admin', 'middleware' => 'adminAuth'], function(){
    Route::get('/dashboard',[ AdminDashboard::class, 'index']);
    Route::get('/genre',[ GenreController::class, 'index'])->name('genre');
    Route::get('/add-genre', [GenreController::class, 'create'])->name('add-genre');
});

//User Routes
Route::group([ 'prefix' => '/user','middleware' => 'userAuth'], function(){
    Route::get('/dashboard',[App\Http\Controllers\User\UserController::class, 'dashboard']);
});
