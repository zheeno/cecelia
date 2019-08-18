<?php

use Illuminate\Http\Request;

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


Route::group(['prefix' => 'market'], function(){
    
    Route::GET('/', [
        'uses' => 'Api\MarketPlaceController@getMarketPlaceData'
    ]);
    
    Route::GET('/getCategory', [
        'uses' => 'Api\MarketPlaceController@getCategory'
    ]);
    
    Route::GET('/getSubCategory', [
        'uses' => 'Api\MarketPlaceController@getSubCategory'
    ]);

    Route::GET('/getFoodItem', [
        'uses' => 'Api\MarketPlaceController@getFoodItem'
    ]);
    
    Route::POST('/addItemToCart', [
        'uses' => 'Api\MarketPlaceController@addItemToCart'
    ]);
    
    Route::GET('/removeItemFromCart', [
        'uses' => 'Api\MarketPlaceController@removeItemFromCart'
    ]);
    
    Route::GET('/getCartItems', [
        'uses' => 'Api\MarketPlaceController@getCartItemsData'
    ]);

    Route::GET('/genCartToken', [
        'uses' => 'Api\MarketPlaceController@genCartToken'
    ]);
    

    Route::resource('/getCategories', 'Api\CategoryController');
});