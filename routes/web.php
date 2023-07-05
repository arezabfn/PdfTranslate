<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('landing');
});

Auth::routes();

Route::middleware('auth')->group(function(){
    //Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('/dashboard',App\Http\Controllers\Administrator\DashboardController::class)->parameters(['dashboard' => 'id']);

    Route::resource('/home/unknown',App\Http\Controllers\Administrator\UnknownController::class)->parameters(['unknown'=>'id']);

    Route::resource('/home/simple',App\Http\Controllers\Administrator\SimpleController::class)->parameters(['simple'=>'id']);

    Route::resource('/home/known', App\Http\Controllers\Administrator\KnownController::class)->parameters(['known'=>'id']);

});
