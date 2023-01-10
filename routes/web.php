<?php

use App\Http\Controllers\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeyController;
use App\Http\Controllers\PlanController;

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

Route::get('/', [Dashboard::class,'index']);
Route::get('/coba',[KeyController::class,'coba']);
Route::resource('keys',KeyController::class);
Route::resource('plans',PlanController::class);
Route::get('/keys/{key}',[KeyController::class,'proc']);
Route::get('/plans/{plan}',[PlanController::class,'proc']);

// DataTables needs

Route::get('/keys/all',[KeyController::class,'data']);
Route::get('/plans/all',[PlanController::class,'data']);
Route::get('/combine/all',[Dashboard::class,'data']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
