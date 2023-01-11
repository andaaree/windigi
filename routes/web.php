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

Auth::routes([
    // 'register' => false
]);

Route::get('/coba', [KeyController::class, 'coba']);

Route::middleware('auth')->group(function () {
    Route::get('/', [Dashboard::class, 'index']);
    // Super Admin
    Route::middleware('super')->group(function () {
        Route::resource('keys', KeyController::class);
        Route::resource('users', UserController::class);
        Route::get('/keys/{key}', [KeyController::class, 'proc']);
        Route::get('/keys/all', [KeyController::class, 'data']);
        Route::get('/combine/all', [Dashboard::class, 'data']);
    });

    // CS
    Route::resource('plans', PlanController::class);
    Route::get('/plans/all', [PlanController::class, 'data']);
    Route::get('/plans/{plan}', [PlanController::class, 'proc']);
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
