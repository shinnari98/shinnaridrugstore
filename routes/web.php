<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderFailController;

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
    return view('welcome');
});

Route::get('/index', [HomeController::class, 'index'])->name('index');
Route::get('/homepage', [LoginController::class, 'homepage'])->middleware('auth')->name('homepage');

Route::get('/ajax-search-products', [HomeController::class, 'ajaxSearch'])->name('ajax-search-products');
Route::post('/like', [ProductController::class, 'like'])->name('product.like')/* ->middleware('auth') */;
Route::get('/addCart', [ProductController::class, 'addCart'])->name('product.cart');
Route::get('/deleteCart', [ProductController::class, 'deleteCart'])->name('product.deleteCart');
Route::get('/star', [ProductController::class, 'addStar'])->name('product.star')->middleware('auth');

Route::get('/login', [LoginController::class, 'logIndex'])->name('get.login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/register', [LoginController::class, 'regisIndex'])->name('register.index');
Route::post('/register', [LoginController::class, 'register'])->name('register');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['prefix' => 'contact'], function () {
    Route::get('/', [ContactController::class, 'contact'])->name('contact.userIndex');
    Route::post('/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
    Route::post('/complete', [ContactController::class, 'complete'])->name('contact.complete');
});

Route::group(['prefix' => '/product'], function () {
    Route::get('/{id}', [ProductController::class, 'showUser'])->name('product.showUser');
    Route::get('/type/{id}',[ProductController::class,'typeProduct'])->name('product.type');
});

Route::group(['prefix' => 'admin', 'middleware' => 'checkAdmin'], function () {
    Route::get('/', [AdminController::class, 'adminIndex'])->name('admin.index');
    Route::get('/type/{id}',[ProductController::class,'typeProduct'])->name('admin.productType');
    Route::resources([
        'user' => UserController::class,
        'product' => ProductController::class,
        'order' => OrderController::class,
        'contact' => ContactController::class,
    ]);
    Route::post('/contact/feedback', [ContactController::class, 'Adminfeedback'])->name('admin.feedback');
    Route::post('/contact/feedback/send', [ContactController::class, 'Sendfeedback'])->name('admin.sendFeedback');
});

Route::group(['prefix' => '/payment', 'middleware' => 'checkUser'], function () {
    Route::get('/', [OrderController::class, 'payment'])->name('payment');
    Route::post('/confirm', [OrderController::class, 'orderSend'])->name('payment.send');
    Route::post('/complete', [OrderController::class, 'orderComplete'])->name('payment.complete');
    Route::post('/payNow', [OrderController::class, 'payNow'])->name('payment.now');
    Route::get('/payNow/index', [OrderController::class, 'payNowIndex'])->name('payNow.index');
    Route::post('/payNow/send', [OrderController::class, 'payNowSend'])->name('payNow.send');
    Route::post('/payNow/complete', [OrderController::class, 'payNowComplete'])->name('payNow.complete');
    Route::get('/payment/complete', [OrderController::class, 'paymentComplete'])->name('paymentComplete');
});

Route::group(['prefix' => '/user', 'middleware' => 'auth'], function () {
    Route::get('/profile', [UserController::class, 'showMyProfile'])->name('user.showUser');
    Route::get('/profile/edit', [UserController::class, 'editMyProfile'])->name('user.editProfile');
    Route::put('/profile/update', [UserController::class, 'updateMyProfile'])->name('user.updateProfile');

    Route::get('/order-history', [OrderController::class, 'showMyOrder'])->name('user.showOrder');
    Route::get('/order-history/edit/{id}', [OrderController::class, 'editMyOrder'])->name('order.userEdit')->middleware('checkMyOrder');
    Route::put('/order-history/update', [OrderController::class, 'updateMyOrder'])->name('order.userUpadate');

    Route::get('/order/{id}/cancel', [OrderController::class, 'reason'])->name('user.order.cancel');
    Route::post('/order/fail', [OrderController::class, 'orderFailCreat'])->name('user.orderFail');
});

Route::group(['prefix' => '/producer', 'middleware' => 'checkProducer'], function () {
    Route::get('/profile', [UserController::class, 'showMyProfile'])->name('producer.showUser');
    Route::get('/profile/edit', [UserController::class, 'editMyProfile'])->name('producer.editProfile');
    Route::put('/profile/update', [UserController::class, 'updateMyProfile'])->name('producer.updateProfile');

    Route::get('/order', [OrderController::class, 'showProducerAll'])->name('producer.order');
    Route::get('/order/{id}', [OrderController::class, 'show'])->name('producer.orderShow')->middleware('checkProducerOrder');
    Route::get('/order/{id}/edit', [OrderController::class, 'edit'])->name('producer.orderEdit')->middleware('editProducerOrder');
    Route::put('/order/{id}/', [OrderController::class, 'update'])->name('producer.orderUpdate');
    Route::get('/order/{id}/cancel', [OrderController::class, 'reason'])->name('producer.order.cancel');
    Route::post('/order/fail', [OrderController::class, 'orderFailCreat'])->name('producer.orderFail');

    Route::get('/product', [ProductController::class, 'showMyProduct'])->name('producer.showProduct');
    Route::get('/product/create', [ProductController::class, 'create'])->name('producer.productCreate');
    Route::post('/product', [ProductController::class, 'store'])->name('producer.productStore');
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('producer.productShow')->middleware('checkProducerProduct');
    Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('producer.productEdit')->middleware('checkProducerProduct');
    Route::put('product/{id}', [ProductController::class, 'update'])->name('producer.productUpdate');
    Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('producer.productDestroy')->middleware('checkProducerProduct');
});
