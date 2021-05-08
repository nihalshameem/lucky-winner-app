<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//customer authentication
Route::namespace ('App\Http\Controllers\api')->group(function () {
    Route::post('/customer/register', 'CustomersAuthController@register');
    Route::post('/customer/login', 'CustomersAuthController@login');
    Route::post('/customer/profile-update/{token}', 'CustomersAuthController@update');
    Route::post('/customer/change-password/{token}', 'CustomersAuthController@changePassword');
    Route::get('/customer/profile/{token}', 'CustomersAuthController@profile');
});

//customer cash cards
Route::namespace ('App\Http\Controllers\api')->group(function () {
    Route::get('/customer/cash-cards/{token}', 'ApiController@cashCards');
    Route::post('/customer/cash-cards/bid/{token}', 'ApiController@newBid');
    Route::get('/customer/scratch-cards/{token}', 'ApiController@scratchCards');
    Route::post('/customer/scratched/{token}', 'ApiController@scratched');
    Route::get('/customer/wallet/{token}', 'ApiController@wallet');
    Route::post('/customer/withdraw-request/{token}', 'ApiController@withdrawReq');
    Route::get('/customer/minimum-withdraw/{token}', 'ApiController@minWithdraw');
    Route::get('/banners', 'ApiController@bannerList');
    Route::get('/winners', 'ApiController@winners');
});
