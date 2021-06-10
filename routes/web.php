<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/halo', function(){
    return 'Halo developer';
});

Route::get('/halo/{php}', function($php){
    return 'Halo developer '.$php;
});

Route::get('/hello/{php?}', function($php = 'php'){
    return 'Halo developer '.$php;
});

Route::get('/list-item', [CategoryController::class, 'showAllItems']);

Route::get('category/select2', [CategoryController::class, 'getDataSelect2'])->name('category.select2');
Route::resource('category', CategoryController::class);
Route::resource('movie', MovieController::class);
Route::resource('user', UserController::class);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

