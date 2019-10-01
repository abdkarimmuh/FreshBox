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

Route::group(['prefix' => 'v1'], function () {
    Route::post('login', 'API\AuthAPIController@login');
    Route::post('register', 'API\AuthAPIController@register');
});


/**
 * Marketing Route
 */


/**
 * Warehouse Route
 */
Route::group(['prefix' => 'warehouse/'], function () {
});

/**
 * Finance Route
 */
Route::group(['prefix' => 'finance/'], function () {
});
/**
 * Master Data Route
 */
Route::group(['prefix' => 'master_data/'], function () {

    Route::group(['prefix' => 'customer'], function () {
        Route::get('/', 'API\CustomerAPIController@index')->name('api.customer');
        Route::get('/list', 'API\CustomerAPIController@all');
    });
    Route::group(['prefix' => 'price'], function () {
        Route::get('/', 'API\MasterPriceController@index')->name('api.price');
        Route::get('/{id}', 'API\MasterPriceController@show');
        Route::get('customer/{id}', 'API\MasterPriceController@CustomerPrice');
        Route::get('/{customer_id}/{skuid}', 'API\MasterPriceController@show');
    });
    Route::group(['prefix' => 'source_order'], function () {
        Route::get('/', 'API\MasterPriceController@index');
        Route::get('/list', 'API\SourceOrderAPIController@all');
    });
    Route::group(['prefix' => 'driver'], function () {
        Route::get('/', 'API\DriverAPIController@index');
    });

    Route::get('customer', 'API\CustomerAPIController@index')->name('api.customer');
    Route::get('list_customer', 'API\CustomerAPIController@all');

    //    Route::get('price_customer/{id}', 'API\MasterPriceController@CustomerPrice');
    Route::get('uom', 'MasterData\UomController@index');
    Route::post('uom', 'MasterData\UomController@store');
});


Route::group(['prefix' => 'marketing/', 'middleware' => 'auth:api'], function () {
    Route::group(['prefix' => 'sales_order'], function () {
        Route::get('/', 'API\FormSalesOrderAPIController@index');
        Route::get('/{id}', 'API\FormSalesOrderAPIController@show');
    });
    Route::group(['prefix' => 'sales_order_detail'], function () {
        Route::get('/{customer_id}', 'Marketing\FormSalesOrderController@sales_order_detail');
        Route::post('/', 'Marketing\FormSalesOrderController@InsertSalesOrderDetail');
    });
});

Route::group(['prefix' => 'trx'], function () {
    Route::get('sales_order_details/{id}', 'Marketing\FormSalesOrderController@getSalesOrderDetails');
    Route::patch('sales_order_details', 'Marketing\FormSalesOrderController@updateSalesOrderDetails');
    Route::delete('sales_order_details/{id}', 'Marketing\FormSalesOrderController@deleteOrderDetails');
});
/**
 * Route API Warehouse
 */
Route::group(['prefix' => 'warehouse/'], function () {

    Route::group(['prefix' => 'delivery_order'], function () {
        Route::get('/show/{id}', 'API\DeliveryOrderAPIController@show');
        Route::post('/', 'Warehouse\FormDeliveryOrderController@store');
    });
});
/**
 * Testing Route
 */

Route::get('/testing', function () {
    $data = \App\Model\Marketing\SalesOrder::get();
    return $data;
});

Route::get('/bidding', function () {
});
Route::get('users/roles', 'UserController@roles')->name('users.roles');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users ', function (Request $request) {
    $length = $request->input('length');
    $column = $request->input('column'); //Index
    $orderBy = $request->input('dir', 'asc');
    $searchValue = $request->input('query');

    $query = \App\User::dataTableQuery($column, $orderBy, $searchValue);
    $data = $query->paginate($length);

    return new \JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource($data);
});
