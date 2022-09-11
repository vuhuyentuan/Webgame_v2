<?php

use App\Http\Controllers\FrontendController;
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

Route::group(['middleware' => 'locale'], function() {
    Route::get('language/{language}',[FrontendController::class,'changeLanguage'])->name('langroute');
});

//Home
Route::get('/',[FrontendController::class,'index'])->name('index');
