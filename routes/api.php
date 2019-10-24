<?php

use App\Http\Resources\MasterData\UomResource;
use App\Http\Resources\MasterData\VendorResource;
use App\Http\Resources\Mobile\UserProcResource;
use App\Model\MasterData\Customer;
use App\Model\MasterData\Price;
use App\Model\MasterData\Uom;
use App\Model\MasterData\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

Route::group(['prefix' => 'v1', 'namespace' => 'API\\'], function () {
    /*
     * API MOBILE
     * Auth Route
     * Login / Register / Logout
     */
    Route::post('login', 'AuthAPIController@login');
    Route::post('register', 'AuthAPIController@register');
    Route::get('logout', 'AuthAPIController@logout');

    Route::group(['prefix' => 'users', 'middleware' => 'auth:api'], function () {
        Route::group(['prefix' => 'proc'], function () {

            Route::get('/', function () {
                return new UserProcResource(auth()->user());
            });
            Route::group(['prefix' => 'item'], function () {
                Route::get('/', 'Procurement\ItemProcurementAPIController@index');
                Route::get('/get', 'Procurement\ItemProcurementAPIController@indexAPI');
                Route::post('/', 'Procurement\ItemProcurementAPIController@store');
            });

            Route::group(['prefix' => 'procurement'], function () {
                Route::get('/', 'Procurement\ProcurementAPIController@index');
                Route::get('/get', 'Procurement\ProcurementAPIController@indexAPI');
                Route::get('/show/{id}', 'Procurement\ProcurementAPIController@show');
                Route::post('/', 'Procurement\ProcurementAPIController@store');
                Route::post('/storeUser', 'Procurement\ProcurementAPIController@storeUserProc');
            });

            Route::group(['prefix' => 'so_detail'], function () {
                Route::get('/', 'Procurement\SalesOrderDetailAPIController@index');
                Route::get('/api', 'Procurement\SalesOrderDetailAPIController@indexAPI');
            });
        });
    });
    /*
     * Marketing Route
     */
    Route::group(['prefix' => 'marketing/'], function () {
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
    });
    /**
     * Procurement
     */
    Route::group(['prefix' => 'procurement/',''], function () {
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
    });
    /*
     * Route API Warehouse
     */
    Route::group(['prefix' => 'warehouse/'], function () {
        Route::group(['prefix' => 'delivery_order'], function () {
            Route::get('/', 'DeliveryOrderAPIController@index');
            Route::post('/', 'DeliveryOrderAPIController@store');
            Route::get('/create', 'DeliveryOrderAPIController@create');
            Route::get('/show', 'DeliveryOrderAPIController@show');
        });
    });

    /*
     * Route API Route
     */
    Route::group(['prefix' => 'finance'], function () {
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

        Route::get('customer', 'CustomerAPIController@index')->name('api.customer');
        Route::get('list_customer', 'CustomerAPIController@all');

        //    Route::get('price_customer/{id}', 'API\MasterPriceController@CustomerPrice');
//        Route::get('uom', 'MasterData\UomController@index');
//        Route::post('uom', 'MasterData\UomController@store');
    });
});

/*
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
Route::get('/customers', function () {
    $prices = DB::table('pricemaster')->get();
    $customers = Customer::select('id')->get();
    foreach ($customers as $customer) {
        $customer_id[] = $customer->id;
    }

    for ($i = 1; $i <= 32; ++$i) {
        foreach ($prices as $price) {
            if ($price->Unit === 'Kg') {
                $uom = 1;
            } elseif ($price->Unit === 'Pcs') {
                $uom = 2;
            } elseif ($price->Unit === 'Pack') {
                $uom = 3;
            } elseif ($price->Unit === 'Botol') {
                $uom = 4;
            } elseif ($price->Unit === 'Sisir') {
                $uom = 5;
            } elseif ($price->Unit === 'Klg') {
                $uom = 6;
            } elseif ($price->Unit === 'Peti') {
                $uom = 7;
            } elseif ($price->Unit === 'Ltr') {
                $uom = 8;
            } elseif ($price->Unit === 'Box') {
                $uom = 9;
            } elseif ($price->Unit === 'Karung') {
                $uom = 10;
            } elseif ($price->Unit === 'Can') {
                $uom = 11;
            } elseif ($price->Unit === 'Pail') {
                $uom = 12;
            } elseif ($price->Unit === 'Bag') {
                $uom = 13;
            }
            $data[] = [
                'customer_id' => $i,
                'skuid' => $price->SKU,
                'amount' => $price->Pricelist,
                'created_by' => 1,
                'uom_id' => $uom,
                'start_periode' => Carbon::now(),
                'end_periode' => Carbon::now()->addDays(5),
            ];
        }
        DB::table('master_price')->insert($data);
    }

    return response()->json([
        'status' => 'success',
    ], 200);
});
