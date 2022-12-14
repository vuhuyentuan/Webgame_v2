<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\BanksController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RechargeController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SlideController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['middleware' => 'locale'], function() {
    Route::get('language/{language}',[FrontendController::class,'changeLanguage'])->name('langroute');
});

Route::group(['middleware' => 'user'], function () {
    //Admin
    Route::get('/dashboard',[AdminController::class,'index'])->name('dashboard');
    Route::get('/info',[AdminController::class,'info'])->name('info');
     //history
     Route::get('/recharge-histories',[RechargeController::class,'adminRechargeHistory'])->name('admin.recharge_history');
     Route::post('/check-recharge/{id}',[RechargeController::class,'checkRechaege'])->name('admin.check_recharge');
     Route::get('/order-histories',[OrderController::class,'adminOrderHistory'])->name('admin.order_history');
     Route::post('/check-order/{id}',[OrderController::class,'checkOrder'])->name('admin.check_order');
    //products
    Route::post('upload-image', [ProductController::class,'uploadImage'])->name('upload_image');
    Route::post('remove-image', [ProductController::class,'removeImage'])->name('remove_image');
    Route::post('remove-images', [ProductController::class,'removeImages'])->name('remove_images');
    Route::get('products/featured/{id}', [ProductController::class,'featured'])->name('products.featured');
    Route::get('products/show', [ProductController::class,'showPackage'])->name('products.showPackage');
    Route::resource('products', ProductController::class);
    //package
    Route::resource('packages', PackageController::class);
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
    Route::post('/settings/email-config/{id}', [SettingController::class, 'emailConfig'])->name('settings.email_config');
    Route::resource('settings', SettingController::class);
    //contacts
    Route::resource('contacts', ContactController::class);
    //slides
    Route::resource('slides', SlideController::class);
});
Route::group(['middleware' => 'login'], function () {
    Route::get('/user-info',[UserController::class,'userInfo'])->name('user.info');
    Route::post('/info-update',[UserController::class,'updateInfo'])->name('info.update');
    Route::post('/change-password',[UserController::class,'changePassword'])->name('info.change-password');
    //recharge
    Route::get('/recharge',[RechargeController::class,'recharge'])->name('user.recharge');
    Route::post('/recharge-points/{id}',[RechargeController::class,'rechargePoint'])->name('recharge.point');
    Route::get('/recharge-history',[RechargeController::class,'rechargeHistory'])->name('user.recharge_history');
    Route::get('/recharge-show/{id}',[RechargeController::class,'rechargeShow'])->name('recharge.show');
    //order history
    Route::get('/order-history',[OrderController::class,'orderHistory'])->name('user.order_history');
    Route::get('/order-show/{id}',[OrderController::class,'orderShow'])->name('order.show');
});

//Home
Route::get('/',[FrontendController::class,'index'])->name('index');
Route::get('/games/{type}',[FrontendController::class,'allGames'])->name('games');
Route::get('/search/{type}',[FrontendController::class,'allGames'])->name('search');
Route::get('/game-detail/{id}',[FrontendController::class,'gameDetail'])->name('game.detail');
Route::get('/checkout/{id}',[FrontendController::class,'checkout'])->name('checkout');
Route::post('/checkout/{id}',[FrontendController::class,'createBill'])->name('checkout.payment');
Route::get('/about',[FrontendController::class,'about'])->name('about');
Route::get('/contact', [FrontendController::class,'contact'])->name('contact');
//Login
Route::get('/login',[LoginController::class,'viewLogin'])->name('login');
Route::post('/login',[LoginController::class,'postLogin'])->name('post.login');

Route::get('/social-login/redirect/{provider}', [LoginController::class,'redirectToProvider'])->name('social.login');
Route::get('/social-login/{provider}/callback', [LoginController::class,'handleProviderCallback'])->name('social.callback');
//Register
Route::get('/register',[LoginController::class,'viewRegister'])->name('register');
Route::post('/register',[LoginController::class,'postRegister'])->name('post.register');
//Logout
Route::get('/logout',[LoginController::class,'logout'])->name('logout');

Route::post('/reset-password', [ForgotPasswordController::class, 'postResetPassword'])->name('reset_password');
Route::get('/password-new', [ForgotPasswordController::class, 'getPasswordNew'])->name('link_password_new');
Route::post('/password-new', [ForgotPasswordController::class, 'postPasswordNew'])->name('pos_password_new');

Route::get('/delete-bills', [FrontendController::class, 'deleteBills']);
