<?php

use App\Http\Resources\MasterData\UomResource;
use App\Http\Resources\MasterData\VendorResource;
use App\Http\Resources\Mobile\UserProcResource;
use App\Model\MasterData\Uom;
use App\Model\MasterData\Vendor;
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

Route::get('users/roles', 'UserController@roles')->name('users.roles');
Route::group(['prefix' => 'v1', 'namespace' => 'ApiV1\\'], function () {
    App::setLocale('id');
    /*
     * API MOBILE
     * Auth Route
     * Login / Register / Logout
     */
    Route::post('login', 'AuthAPIController@login');
    Route::post('register', 'AuthAPIController@register');
    Route::get('logout', 'AuthAPIController@logout');
    Route::post('changePassword', 'AuthAPIController@changePassword');
    Route::get('dashboard/all', 'DashboardAPIController@all');

    Route::group(['prefix' => 'users', 'middleware' => 'auth:api'], function () {
        Route::group(['prefix' => 'proc'], function () {
            Route::get('/', function () {
                return new UserProcResource(auth()->user());
            });

            Route::group(['namespace' => 'Procurement\\'], function () {
                Route::group(['prefix' => 'notif'], function () {
                    Route::get('/', 'NotificationsAPIController@index');
                    Route::post('/', 'NotificationsAPIController@store');
                    Route::post('/read', 'NotificationsAPIController@asRead');
                    Route::get('/detail', 'NotificationsAPIController@getDetailNotif');
                });

                Route::group(['prefix' => 'item'], function () {
                    Route::get('/', 'ItemProcurementAPIController@index');
                    Route::get('/get', 'ItemProcurementAPIController@indexAPI');
                    Route::post('/', 'ItemProcurementAPIController@store');
                });

                Route::group(['prefix' => 'procurement'], function () {
                    Route::get('/', 'ProcurementAPIController@index');
                    Route::get('/get', 'ProcurementAPIController@userProcHasProc');
                    Route::get('/selectBy/{id}', 'ProcurementAPIController@selectBy');
                    Route::post('/', 'ProcurementAPIController@store');
                    Route::post('/storeUser', 'ProcurementAPIController@storeUserProc');
                    Route::post('/reject', 'ProcurementAPIController@reject');
                });

                Route::group(['prefix' => 'so_detail'], function () {
                    Route::get('/', 'SalesOrderDetailAPIController@index');
                    Route::get('/api', 'SalesOrderDetailAPIController@indexAPI');
                });
            });
        });
    });
    /*
     * Marketing Route
     */
    Route::group(['prefix' => 'marketing/', 'namespace' => 'Marketing\\'], function () {
        Route::group(['prefix' => 'sales_order'], function () {
            Route::get('/', 'FormSalesOrderAPIController@index');
            Route::get('/show', 'FormSalesOrderAPIController@show');
            Route::get('/{id}/edit', 'FormSalesOrderAPIController@edit');
            Route::post('/store', 'FormSalesOrderAPIController@store');
            Route::post('/print', 'FormSalesOrderAPIController@print');
            Route::delete('detail/{id}', 'FormSalesOrderAPIController@deleteOrderDetails');
            Route::patch('/update', 'FormSalesOrderAPIController@updateSalesOrderDetails');
            Route::get('/download/{file}', 'FormSalesOrderAPIController@DownloadFile');
        });

        Route::group(['prefix' => 'so_detail'], function () {
            Route::get('/isProc', 'SalesOrderDetailAPIController@soDetailIsConfirm');
            Route::get('/show/{id}', 'SalesOrderDetailAPIController@show');
        });
    });
    /*
     * Procurement
     */
    Route::group(['prefix' => 'procurement/', 'namespace' => 'Procurement\\'], function () {
        Route::get('/', 'ProcurementAPIController@index');
        Route::get('/not-confirmed', 'ProcurementAPIController@listProcurementNotConfirmed');
        Route::get('/confirmed', 'ProcurementAPIController@listProcurementConfirmed');
        Route::get('/show/{id}', 'ProcurementAPIController@show');
    });
    /*
   * Route API Warehouse In
   */
    Route::group(['prefix' => 'warehouseIn/', 'namespace' => 'WarehouseIn\\'], function () {
        Route::group(['prefix' => 'confirm'], function () {
            Route::get('/', 'ConfirmItemsAPIController@index');
            Route::post('/store', 'ConfirmItemsAPIController@store');
        });
        Route::group(['prefix' => 'packageItem'], function () {
            Route::get('/', 'PackageItemAPIController@index');
            Route::get('/show', 'PackageItemAPIController@show');
            Route::post('/print', 'PackageItemAPIController@print');
        });
    });

    /*
     * Route API Warehouse Out
     */
    Route::group(['prefix' => 'warehouse/', 'namespace' => 'WarehouseOut\\'], function () {
        //Delivery Order
        Route::group(['prefix' => 'delivery_order'], function () {
            Route::get('/', 'DeliveryOrderAPIController@index');
            Route::post('/', 'DeliveryOrderAPIController@store');
            Route::get('/create', 'DeliveryOrderAPIController@create');
            Route::get('/show', 'DeliveryOrderAPIController@show');
        });
        //Confirm Delivery Order
        Route::group(['prefix' => 'confirm-delivery-order'], function () {
            Route::get('/', 'ConfirmDeliveryOrderAPIController@index');
            Route::get('/show', 'ConfirmDeliveryOrderAPIController@show');
            Route::patch('/update', 'ConfirmDeliveryOrderAPIController@update');
        });
    });
    /*
     * Route Finance AP API
     */
    Route::group(['prefix' => 'finance-ap', 'namespace' => 'FinanceAP\\'], function () {
        //        Replenish
        Route::group(['prefix' => 'replenish'], function () {
            Route::get('/', 'ReplenishAPIController@index');
            Route::post('/store', 'ReplenishAPIController@store');
            Route::post('/action', 'ReplenishAPIController@returnReplenish');
            Route::patch('/{id}', 'ReplenishAPIController@replenish');
        });
        //        TopUp
        Route::group(['prefix' => 'topup'], function () {
            Route::get('/', 'TopUpProcAPIController@index');
            Route::get('/get', 'TopUpProcAPIController@indexApi');
            Route::get('/show/{id}', 'TopUpProcAPIController@show');
            Route::post('/', 'TopUpProcAPIController@store');
        });
        //        Request Finance
        Route::group(['prefix' => 'payment-advance'], function () {
            Route::get('/', 'RequestFinanceController@index');
            Route::post('/{id}', 'RequestFinanceController@confirm');
            Route::get('/show/{id}', 'RequestFinanceController@show');
            Route::post('/update', 'RequestFinanceController@update');
            Route::get('/requestFinanceDetail/{id}', 'RequestFinanceController@requestFinanceDetail');
            Route::post('/', 'RequestFinanceController@store');

        });

        // Settlement Finance
        Route::group(['prefix' => 'settlement-cash-advance'], function () {
            Route::get('/', 'SettlementFinanceController@index');
            Route::get('/show/{id}', 'SettlementFinanceController@show');
            Route::post('/', 'SettlementFinanceController@store');
        });

        // In/Out Payment
        Route::group(['prefix' => 'in-out-payment'], function () {
            Route::get('/', 'InOutPaymentController@index');
            Route::get('/show/{id}', 'InOutPaymentController@show');
            Route::post('/store', 'InOutPaymentController@store');
            Route::post('/{id}', 'InOutPaymentController@changeStatus');
            Route::post('/', 'InOutPaymentController@store');
        });

        Route::group(['prefix' => 'petty-cash'], function () {
            Route::get('/', 'PettyCashController@index');
            Route::get('/show/{id}', 'PettyCashController@show');
            Route::post('/', 'PettyCashController@store');
        });
    });

    /*
     * Route Finance AR API Route
     */
    Route::group(['prefix' => 'finance', 'namespace' => 'Finance\\'], function () {
        /*
         * Invoice Route
         */
        Route::group(['prefix' => 'invoice_order'], function () {
            Route::get('/', 'InvoiceAPIController@index');
            Route::get('/create', 'InvoiceAPIController@create');
            Route::get('/show', 'InvoiceAPIController@show');
            Route::post('/store', 'InvoiceAPIController@store');
            Route::post('/print', 'InvoiceAPIController@print');
            Route::get('/printRecap', 'InvoiceAPIController@printRecap');
            Route::post('/printRecap', 'InvoiceAPIController@printRecap');
            Route::get('/generateRecapInvoice', 'InvoiceAPIController@generateRecapInvoice');
        });
        /*
         * Recap Invoice Route
         */
        Route::group(['prefix' => 'invoice_recap'], function () {
            Route::get('/', 'InvoiceRecapAPIController@index');
            Route::get('/notSubmitted', 'InvoiceRecapAPIController@InvoiceNotSubmitted');
            Route::get('/submitted', 'InvoiceRecapAPIController@InvoiceSubmitted');
            Route::post('/submitted', 'InvoiceRecapAPIController@StoreSubmitInvoice');
            Route::get('/listNotPaid', 'InvoiceRecapAPIController@listInvoiceRecapNotPaid');
            Route::get('/show/{id}', 'InvoiceRecapAPIController@show');

            Route::get('/paid', 'InvoiceRecapAPIController@InvoicePaid');
            Route::post('/paid', 'PaidInvoiceAPIController@store');
        });
    });

    /*
     * Master Data Route
     */
    Route::group(['prefix' => 'master_data/'], function () {
        Route::group(['prefix' => 'customer'], function () {
            Route::get('/', 'CustomerAPIController@index')->name('api.customer');
            Route::get('/list', 'CustomerAPIController@all');
            Route::get('/list_has_recap', 'CustomerAPIController@ListCustomerHasRecap');
        });
        Route::group(['prefix' => 'price'], function () {
            Route::get('/', 'MasterPriceController@index')->name('api.price');
            Route::get('/getPrice', 'MasterPriceController@getPrice');
            Route::get('/{id}', 'MasterPriceController@show');
            Route::get('customer/{id}', 'MasterPriceController@CustomerPrice');
            Route::get('/{customer_id}/{skuid}', 'MasterPriceController@show');
        });
        Route::group(['prefix' => 'source_order'], function () {
            Route::get('/', 'MasterPriceController@index');
            Route::get('/list', 'SourceOrderAPIController@all');
        });
        Route::group(['prefix' => 'driver'], function () {
            Route::get('/', 'DriverAPIController@index');
            Route::get('/driver', 'DriverAPIController@driver');
            Route::get('/picqc', 'DriverAPIController@picqc');
        });

        Route::group(['prefix' => 'uom'], function () {
            Route::get('/', function () {
                return UomResource::collection(Uom::all());
            });
        });

        Route::group(['prefix' => 'customer-group'], function () {
            Route::get('/', 'MasterDataController@getCustomerGroup');
        });
        Route::group(['prefix' => 'vendor'], function () {
            Route::get('/', function () {
                return VendorResource::collection(Vendor::all());
            });
        });

        Route::group(['prefix' => 'category'], function () {
            Route::get('/', 'MasterDataController@getCategory');
        });
        Route::group(['prefix' => 'bank'], function () {
            Route::get('/', 'MasterDataController@getBank');
        });
        Route::group(['prefix' => 'origin'], function () {
            Route::get('/', 'MasterDataController@getOrigin');
        });

        Route::group(['prefix' => 'users'], function () {
            Route::get('/', 'MasterDataController@getUser');
            Route::get('/{id}', 'MasterDataController@getDetailUser');
        });

        Route::group(['prefix' => 'items'], function () {
            Route::get('/', 'MasterDataController@getItems');
            Route::get('/{id}', 'MasterDataController@getDetailItem');
        });
        Route::group(['prefix' => 'warehouse'], function () {
            Route::get('/', 'MasterDataController@getWarehouse');
        });
        Route::get('customer', 'CustomerAPIController@index')->name('api.customer');
        Route::get('list_customer', 'CustomerAPIController@all');
    });

    Route::group(['prefix' => 'import-data-price-temp', 'namespace' => 'ImportExcel\\'], function () {
        Route::post('/', 'PriceUploadController@store');
        Route::post('/generate', 'PriceUploadController@generateMasterPriceAll');
        Route::get('/export', 'PriceUploadController@exportDuplicateData');
    });
});

Route::resource('users', 'UserController', [
    'names' => [
        'index' => 'users',
    ],
]);

/*
 * Testing Route
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
