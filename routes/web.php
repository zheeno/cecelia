<?php

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

Route::get('/', [
    "uses" => "HomeController@index",
    "as" => "home"
]);

Route::get('/home', [
    "uses" => "HomeController@index",
    "as" => "home"
]);

Route::group(['middleware' => 'auth'], function(){ //grouping routes such that only authenticated users can access them

    Route::group(['middleware' => 'admin'], function(){ //grouping routes such that only authenticated users can access them
        
        Route::group(['prefix' => 'console'], function(){

            Route::GET('/', [
                'uses' => 'ConsoleController@dashboard'
            ]);

            Route::GET('/dashboard', [
                'uses' => 'ConsoleController@dashboard',
                'as' => 'console.dashboard'
            ]);

            Route::GET('/categories', [
                'uses' => 'ConsoleController@categories',
                'as' => 'console.categories'
            ]);
            
            Route::GET('/getSubCat', [
                'uses' => 'ConsoleController@getSubCat',
            ]);
            
            Route::GET('/categories/{id}', [
                'uses' => 'ConsoleController@openCategory',
            ]);
            
            Route::GET('/categories/{cat_name}/{sub_cat_id}', [
                'uses' => 'ConsoleController@openSubcategory',
            ]);

            Route::POST('/categories', [
                'uses' => 'ConsoleController@addCategory',
                'as' => 'console.add.category'
            ]);
            
            Route::POST('/updateCategory', [
                'uses' => 'ConsoleController@updateCategory',
                'as' => 'console.update.category'
            ]);
            
            Route::POST('/deleteCategory', [
                'uses' => 'ConsoleController@deleteCategory',
                'as' => 'console.delete.category'
            ]);
            
            Route::POST('/subCategories', [
                'uses' => 'ConsoleController@addSubCategory',
                'as' => 'console.add.subCategory'
            ]);
            
            Route::POST('/addFoodItem', [
                'uses' => 'ConsoleController@addFoodItem',
                'as' => 'console.add.foodItem'
            ]);

            Route::GET('/inventory', [
                'uses' => 'ConsoleController@inventoryManager',
                'as' => 'console.inventory'
            ]);
            
            Route::GET('/inventory/{item_id}', [
                'uses' => 'ConsoleController@inventoryManagerItem',
            ]);
            
            Route::POST('/inventory/updateItem', [
                'uses' => 'ConsoleController@updateInventoryItem',
            ]);
            
            Route::GET('/orders', [
                'uses' => 'ConsoleController@orderManager',
                'as' => 'console.orders'
            ]);
            
            Route::GET('/orders/{id}', [
                'uses' => 'ConsoleController@openOrder'
            ]);
            
            Route::POST('/orders/updateDeliveryStatus', [
                'uses' => 'ConsoleController@updateDeliveryStatus',
                'as' => 'console.orders.updateDelivery'
            ]);
            
            Route::POST('/newMeasureUnit', [
                'uses' => 'ConsoleController@newMeasureUnit',
                'as' => 'console.newMeasureUnit'
            ]);
        });
    });

    Route::group(['prefix' => 'me'], function(){

        Route::GET('/orders', [
            'uses' => 'BuyerController@orders',
            'as' => 'me.orders'
        ]);

        Route::GET('/orders/{id}', [
            'uses' => 'BuyerController@viewOrder',
        ]);
    });

    Route::group(['prefix' => 'market'], function(){

        Route::GET('/checkout', [
            'uses' => 'Api\MarketPlaceController@checkout'
        ]);

        Route::POST('/checkout', [
            'uses' => 'Api\MarketPlaceController@submitCheckout'
        ]);

        Route::POST('/leaveMarket', [
            'uses' => 'Api\MarketPlaceController@leaveMarket'
        ]);
    });
});

Route::group(['prefix' => 'market'], function(){
    Route::GET('/', [
        'uses' => 'Api\MarketPlaceController@openMarketPlace'
    ]);

    Route::GET('/{uri}', [
        'uses' => 'Api\MarketPlaceController@openMarketPlace'
    ]);

    Route::GET('/category/{id}', [
        'uses' => 'Api\MarketPlaceController@openMarketPlace'
    ]);
    
    Route::GET('/category/sub/{id}', [
        'uses' => 'Api\MarketPlaceController@openMarketPlace'
    ]);

    Route::GET('/foodItem/{id}', [
        'uses' => 'Api\MarketPlaceController@openMarketPlace'
    ]);
});


Auth::routes();

