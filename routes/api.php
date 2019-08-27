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


/**
 * Marketing Route
 */
Route::group(['prefix' => 'marketing/'], function () {
    Route::get('/form_sales_order', 'Marketing\FormSalesOrderController@index');
    Route::get('/sales_order_detail/{customer_id}', 'Marketing\FormSalesOrderController@sales_order_detail');
    Route::post('sales_order_detail', 'Marketing\FormSalesOrderController@InsertSalesOrderDetail');
});

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

    Route::get('customer', 'MasterData\CustomerController@index')->name('api.customer');
    Route::get('list_customer', 'MasterData\CustomerController@all');
    Route::get('price', 'MasterData\MasterPriceController@index')->name('api.price');
    Route::get('price/{id}', 'MasterData\MasterPriceController@show');
    Route::get('price_customer/{id}', 'MasterData\MasterPriceController@CustomerPrice');
    Route::get('uom', 'MasterData\UomController@index');
});

/**
 * Testing Route
 */

Route::get('/testing', function () {
    $data = \App\Model\Marketing\SalesOrder::get();
    return $data;
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
