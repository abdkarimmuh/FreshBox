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

Route::get('/users ', function (Request $request) {
    $length = $request->input('length');
    $column = $request->input('column'); //Index
    $orderBy = $request->input('dir', 'asc');
    $searchValue = $request->input('query');

    $query = \App\User::dataTableQuery($column, $orderBy, $searchValue);
    $data = $query->paginate($length);

    return new \JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource($data);
});

Route::get('/data ', function (Request $request) {
    $length = $request->input('length');
    $column = $request->input('column'); //Index
    $orderBy = $request->input('dir', 'asc');
    $searchValue = $request->input('search');

    $query = \App\Testing::dataTableQuery($column, $orderBy, $searchValue);
    $data = $query->paginate(5);

    return new \App\Http\Resources\DataCollectionResource($data);

});
Route::get('/form_sales_order', 'Marketing\FormSalesOrderController@index');
Route::get('/sales_order_detail/{customer_id}', 'Marketing\FormSalesOrderController@sales_order_detail');

Route::get('/testing', function () {
    $data = \App\Model\Marketing\SalesOrder::get();
    return $data;
});
Route::get('users/roles', 'UserController@roles')->name('users.roles');

Route::get('customer', function(){
    return \App\Model\MasterData\Customer::all();
});

Route::post('/master/uom', 'MasterData\UomController@store');

Route::get('/master/category', 'MasterData\CategoryController@index');

