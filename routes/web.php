<?php

use App\Http\Controllers\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeyController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\UserController;

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

Auth::routes([
    'register' => false
]);

Route::get('/coba', [KeyController::class, 'coba']);

Route::middleware('auth')->group(function () {
    Route::get('/', [Dashboard::class, 'index']);
    Route::get('/users', [UserController::class,'index']);
    Route::get('/users/reset', [UserController::class,'change']);
    Route::post('/user/reset/{user}', [UserController::class,'reset']);

    // Super Admin
    Route::middleware('super')->group(function () {
        Route::resource('keys', KeyController::class);
        Route::resource('users', UserController::class)->except('index');
        
        Route::get('/user/all', [UserController::class,'data']);
        Route::get('/key/all', [KeyController::class, 'data']);
        Route::get('/key/log', [KeyController::class, 'splog']);
        Route::get('/plan/log', [PlanController::class, 'snlog']);
        Route::get('/keys/{key}', [KeyController::class, 'proc']);
    });
    
    // CS
    Route::middleware('admin')->group(function () {

        Route::resource('plans', PlanController::class);
        Route::get('/plan/all', [PlanController::class, 'data']);
        Route::get('/plans/{plan}', [PlanController::class, 'proc']);
    });
    
    Route::get('/combine/all', [Dashboard::class, 'data']);
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
