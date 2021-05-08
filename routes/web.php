<?php

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
    if (Auth::check()) {
        return redirect('/home');
    }
    return view('welcome');
});

Auth::routes();

// Admin Dashboard
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin cards
Route::namespace ('App\Http\Controllers')->group(function () {
    Route::get('/profile', 'HomeController@profile');
    Route::post('/profile/update', 'HomeController@profileUpdate');
    Route::post('/min-withdraw/update', 'HomeController@minWithdraw');
    Route::post('/withdraw-request/list', 'HomeController@minWithdraw');
});

// Admin cash cards
Route::namespace ('App\Http\Controllers\admin')->group(function () {
    Route::any('/cash-cards/list', 'CashCardsController@cashCardList');
    Route::post('/cash-cards/list/search', 'CashCardsController@search');
    Route::any('/cash-cards/add', 'CashCardsController@addPage');
    Route::post('/cash-cards/add/new', 'CashCardsController@addNew');
    Route::get('/cash-cards/edit/{id}', 'CashCardsController@editPage');
    Route::post('/cash-cards/update/{id}', 'CashCardsController@update');
    Route::post('/cash-cards/delete/{id}', 'CashCardsController@delete');
});

// Admin cash card bids
Route::namespace ('App\Http\Controllers\admin')->group(function () {
    Route::any('/bids/list', 'BidsController@bidList');
    Route::any('/bids/delete/{id}', 'BidsController@delete');
});

// Admin scartch cards
Route::namespace ('App\Http\Controllers\admin')->group(function () {
    Route::any('/scratch-cards/list', 'ScratchCardsController@scratchCardList');
    Route::any('/scratch-cards/list/search', 'ScratchCardsController@search');
    Route::any('/scratch-card/create/{id}', 'ScratchCardsController@createPage');
    Route::post('/scratch-card/add/new/{id}', 'ScratchCardsController@addNew');
    Route::get('/scratch-cards/edit/{id}', 'ScratchCardsController@editPage');
    Route::post('/scratch-cards/update/{id}', 'ScratchCardsController@update');
    Route::get('/scratch-cards/view/{id}', 'ScratchCardsController@single');
    Route::post('/scratch-cards/delete/{id}', 'ScratchCardsController@delete');
    Route::get('/scratch-cards/winners', 'ScratchCardsController@winners');
});

// Admin customers
Route::namespace ('App\Http\Controllers\admin')->group(function () {
    Route::any('/customers/list', 'CustomersController@customerList');
    Route::any('/customers/list/search', 'CustomersController@search');
    Route::get('/customers/details/{id}', 'CustomersController@detail');
    Route::post('/customers/delete/{id}', 'CustomersController@delete');
});

// Admin withdraw requests
Route::namespace ('App\Http\Controllers\admin')->group(function () {
    Route::get('/withdraw-request/list', 'RequestsController@reqList');
    Route::get('/withdraw-request/decline/{id}', 'RequestsController@reqDecline');
    Route::get('/withdraw-request/paid/{id}', 'RequestsController@paid');
    Route::get('/withdraw-request/req-sheet', 'RequestsController@reqSheet');
});

// Admin paids
Route::namespace ('App\Http\Controllers\admin')->group(function () {
    Route::get('/paids/list', 'PaidsController@paidList');
    Route::get('/paids/details/{id}', 'PaidsController@single');
    Route::post('/paids/delete/{id}', 'PaidsController@delete');
    Route::get('/paids/sheet', 'PaidsController@sheet');
});

// Admin banners
Route::namespace ('App\Http\Controllers\admin')->group(function () {
    Route::any('/banners/list', 'BannersController@bannerList');
    Route::any('/banners/add', 'BannersController@addPage');
    Route::post('/banners/add/new', 'BannersController@addNew');
    Route::get('/banners/edit/{id}', 'BannersController@editPage');
    Route::post('/banners/update/{id}', 'BannersController@update');
    Route::post('/banners/delete/{id}', 'BannersController@delete');
});