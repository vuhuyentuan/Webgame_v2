<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BanksController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TranslateController;
use App\Http\Controllers\UserController;
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

//Admin
Route::get('/admin',[AdminController::class,'index'])->name('admin');
//User
Route::post('/users/banned/{id}',[UserController::class,'banned'])->name('users.banned');
Route::post('/users/unbanned/{id}',[UserController::class,'unbanned'])->name('users.unbanned');
Route::get('/users/create',[UserController::class,'create'])->name('users.create');
Route::post('/users/store',[UserController::class,'store'])->name('users.store');
Route::get('/users/{id}/edit',[UserController::class,'edit'])->name('users.edit');
Route::post('/users/update',[UserController::class,'update'])->name('users.update');
Route::get('/users/destroy/{id}',[UserController::class,'destroy'])->name('users.destroy');
Route::get('/users',[UserController::class,'index'])->name('users.index');
//banks
Route::resource('banks', BanksController::class);
//language
Route::resource('languages', LanguageController::class);
//translations
Route::get('build/{id}',[TranslateController::class,'build'])->name('translations.build');
Route::get('loadStrings',[TranslateController::class,'loadStrings'])->name('translations.loadStrings');
Route::get('list-trans/{id}',[TranslateController::class,'listTrans'])->name('translations.list-trans');
Route::resource('translations', TranslateController::class);
// setting
Route::post('/settings/update-general/{id}',[SettingController::class,'updateGeneral'])->name('settings.update_general');
Route::post('/settings/update-contact/{id}',[SettingController::class,'updateContact'])->name('settings.update_contact');
Route::resource('settings', SettingController::class);
//Home
Route::get('/',[FrontendController::class,'index'])->name('index');
