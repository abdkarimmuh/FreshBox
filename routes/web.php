<?php

use App\Model\Finance\InvoiceOrder;

Route::get('/', function () {
    return redirect(route('admin.dashboard'));
});

Route::get('home', function () {
    return redirect(route('admin.dashboard'));
});

Route::name('admin.')->middleware('auth')->prefix('admin')->group(function () {
    //    Route::get('/{any}', 'DashboardController')->where('any', '.*');
    Route::get('dashboard', 'DashboardController')->name('dashboard');
    Route::get('users/list', 'UserController@index')->name('users.roles');
    Route::resource('users', 'UserController', [
        'names' => [
            'index' => 'users'
        ]
    ]);

    /**
     * Routing Menu Marketing
     */
    Route::name('marketing.')->prefix('marketing')->middleware('auth')->group(function () {
        Route::name('sales_order.')->prefix('form_sales_order')->group(function () {
            Route::get('/', 'Marketing\FormSalesOrderController@index')->name('index');
            Route::get('/create', 'Marketing\FormSalesOrderController@create')->name('create');
            Route::post('/store', 'Marketing\FormSalesOrderController@store')->name('store');
            Route::get('/{id}/edit', 'Marketing\FormSalesOrderController@edit')->name('edit');
            Route::get('/{id}/print', 'Marketing\FormSalesOrderController@print')->name('print');
            Route::get('/download/{file}', 'Marketing\FormSalesOrderController@DownloadFile')->name('download');
        });
    });
    /**
     * Route Menu Warehouse
     */
    Route::name('warehouse.')->prefix('warehouse')->middleware('auth')->group(function () {
        Route::name('delivery_order.')->prefix('delivery_order')->group(function () {
            Route::get('/', 'Warehouse\FormDeliveryOrderController@index')->name('index');
            Route::get('/create', 'Warehouse\FormDeliveryOrderController@create')->name('create');
            Route::post('/store', 'Warehouse\FormDeliveryOrderController@store')->name('store');
            Route::get('/{id}/show', 'Warehouse\FormDeliveryOrderController@show')->name('show');
            Route::get('/{id}/print', 'Warehouse\FormDeliveryOrderController@print')->name('print');
        });

        Route::name('confirm_delivery_order.')->prefix('confirm_delivery_order')->group(function () {
            Route::get('/', 'Warehouse\ConfirmDeliveryOrderController@index')->name('index');
            Route::get('/{id}/create', 'Warehouse\ConfirmDeliveryOrderController@create')->name('create');
            Route::patch('/update', 'Warehouse\ConfirmDeliveryOrderController@update')->name('update');
        });
    });
    /**
     * Route Menu Finance
     */
    Route::name('finance.')->prefix('finance')->middleware('auth')->group(function () {
        Route::name('invoice_order.')->prefix('invoice_order')->group(function () {
            Route::get('/', 'Finance\FormInvoiceOrderController@index')->name('index');
            Route::get('/create', 'Finance\FormInvoiceOrderController@create')->name('create');
            Route::get('/view', 'Finance\FormInvoiceOrderController@show')->name('show');
            Route::post('/store', 'Finance\FormInvoiceOrderController@store')->name('store');
        });
    });

    /**
     * Route Menu Master Data
     */
    Route::name('master_data.')->prefix('master_data')->middleware('auth')->group(function () {
        Route::name('category.')->prefix('category')->group(function () {
            Route::get('/', 'MasterData\CategoryController@index')->name('index');
            Route::get('/create', 'MasterData\CategoryController@create')->name('create');
            Route::post('/create', 'MasterData\CategoryController@store')->name('store');
            Route::get('/{id}/edit', 'MasterData\CategoryController@edit')->name('edit');
            Route::patch('/edit', 'MasterData\CategoryController@update')->name('update');
        });

        Route::name('province.')->prefix('province')->group(function () {
            Route::get('/', 'MasterData\ProvinceController@index')->name('index');
            Route::get('/create', 'MasterData\ProvinceController@create')->name('create');
            Route::post('/create', 'MasterData\ProvinceController@store')->name('store');
            Route::get('/{id}/edit', 'MasterData\ProvinceController@edit')->name('edit');
            Route::patch('/edit', 'MasterData\ProvinceController@update')->name('update');
        });

        Route::name('residence.')->prefix('residence')->group(function () {
            Route::get('/', 'MasterData\ResidenceController@index')->name('index');
            Route::get('/create', 'MasterData\ResidenceController@create')->name('create');
            Route::post('/create', 'MasterData\ResidenceController@store')->name('store');
            Route::get('/{id}/edit', 'MasterData\ResidenceController@edit')->name('edit');
            Route::patch('/edit', 'MasterData\ResidenceController@update')->name('update');
        });

        Route::name('driver.')->prefix('driver')->group(function () {
            Route::get('/', 'MasterData\DriverController@index')->name('index');
            Route::get('/create', 'MasterData\DriverController@create')->name('create');
            Route::post('/create', 'MasterData\DriverController@store')->name('store');
            Route::get('/{id}/edit', 'MasterData\DriverController@edit')->name('edit');
            Route::patch('/edit', 'MasterData\DriverController@update')->name('update');
        });

        Route::name('origin.')->prefix('origin')->group(function () {
            Route::get('/', 'MasterData\OriginController@index')->name('index');
            Route::get('/create', 'MasterData\OriginController@create')->name('create');
            Route::post('/create', 'MasterData\OriginController@store')->name('store');
            Route::get('/{id}/edit', 'MasterData\OriginController@edit')->name('edit');
            Route::patch('/edit', 'MasterData\OriginController@update')->name('update');
        });

        Route::name('uom.')->prefix('uom')->group(function () {
            Route::get('/', 'MasterData\UomController@index')->name('index');
            Route::get('/create', 'MasterData\UomController@create')->name('create');
            Route::post('/create', 'MasterData\UomController@store')->name('store');
            Route::get('/{id}/edit', 'MasterData\UomController@edit')->name('edit');
            Route::patch('/edit', 'MasterData\UomController@update')->name('update');
        });

        Route::name('item.')->prefix('item')->group(function () {
            Route::get('/', 'MasterData\ItemController@index')->name('index');
            Route::get('/create', 'MasterData\ItemController@create')->name('create');
            Route::post('/create', 'MasterData\ItemController@store')->name('store');
        });

        Route::name('bank.')->prefix('bank')->group(function () {
            Route::get('/', 'MasterData\BankController@index')->name('index');
            Route::get('/create', 'MasterData\BankController@create')->name('create');
            Route::post('/create', 'MasterData\BankController@store')->name('store');
            Route::get('/{id}/edit', 'MasterData\BankController@edit')->name('edit');
            Route::patch('/edit', 'MasterData\BankController@update')->name('update');
        });

        Route::name('vendor.')->prefix('vendor')->group(function () {
            Route::get('/', 'MasterData\VendorController@index')->name('index');
            Route::get('/create', 'MasterData\VendorController@create')->name('create');
            Route::post('/create', 'MasterData\VendorController@store')->name('store');
            Route::get('/{id}/edit', 'MasterData\VendorController@edit')->name('edit');
            Route::patch('/edit', 'MasterData\VendorController@update')->name('update');
        });

        Route::name('source_order.')->prefix('source_order')->group(function () {
            Route::get('/', 'MasterData\SourceOrderController@index')->name('index');
            Route::get('/create', 'MasterData\SourceOrderController@create')->name('create');
            Route::post('/create', 'MasterData\SourceOrderController@store')->name('store');
            Route::get('/{id}/edit', 'MasterData\SourceOrderController@edit')->name('edit');
            Route::patch('/edit', 'MasterData\SourceOrderController@update')->name('update');
        });

        Route::name('customer_type.')->prefix('customer_type')->group(function () {
            Route::get('/', 'MasterData\CustomerTypeController@index')->name('index');
            Route::get('/create', 'MasterData\CustomerTypeController@create')->name('create');
            Route::post('/create', 'MasterData\CustomerTypeController@store')->name('store');
            Route::get('/{id}/edit', 'MasterData\CustomerTypeController@edit')->name('edit');
            Route::patch('/edit', 'MasterData\CustomerTypeController@update')->name('update');
        });

        Route::name('customer_group.')->prefix('customer_group')->group(function () {
            Route::get('/', 'MasterData\CustomerGroupController@index')->name('index');
            Route::get('/create', 'MasterData\CustomerGroupController@create')->name('create');
            Route::post('/create', 'MasterData\CustomerGroupController@store')->name('store');
            Route::get('/{id}/edit', 'MasterData\CustomerGroupController@edit')->name('edit');
            Route::patch('/edit', 'MasterData\CustomerGroupController@update')->name('update');
        });

        Route::name('customer.')->prefix('customer')->group(function () {
            Route::get('/', 'MasterData\CustomerController@index')->name('index');
            Route::get('/create', 'MasterData\CustomerController@create')->name('create');
            Route::post('/create', 'MasterData\CustomerController@store')->name('store');
        });

        Route::name('price.')->prefix('price')->group(function () {
            Route::get('/', 'MasterData\PriceController@index')->name('index');
            Route::get('/create', 'MasterData\PriceController@create')->name('create');
            Route::post('/create', 'MasterData\PriceController@store')->name('store');
        });

        Route::name('modules.')->prefix('modules')->group(function () {
            Route::get('/', 'MasterData\ModulesController@index')->name('index');
        });
    });
});
Route::get('/invoice', function () {
    return InvoiceOrder::all();
});
Route::middleware('auth')->get('logout', function () {
    Auth::logout();
    return redirect(route('login'))->withInfo('You have successfully logged out!');
})->name('logout');

Auth::routes(['verify' => true]);

Route::name('js.')->group(function () {
    Route::get('dynamic.js', 'JsController@dynamic')->name('dynamic');
});

// Get authenticated user
Route::get('users/auth', function () {
    return response()->json(['user' => Auth::check() ? Auth::user() : false]);
});

/**
 * Route For Testing
 */
Route::get('/assign', function () {
    return auth()->user()->givePermissionTo('manage-users');
});

Route::get('/testing', function () {

    $columns = [
        array('title' => 'Id', 'field' => 'id'),
        array('title' => 'Name', 'field' => 'name'),
        array('title' => 'Created By', 'field' => 'created_by_name'),
    ];

    $config = [
        //Title Required
        'title' => 'asd',
        /**
         * Route Can Be Null
         */
        //Route For Button Add
        'route-add' => 'testing.create',
        //Route For Button Edit
        'route-edit' => 'testing.edit',
        //Route For Button View
        'route-view' => 'testing.create',
        //Route For Button Search
        'route-search' => 'admin.master_data.driver.index',
    ];
    $data = \App\Model\MasterData\Category::paginate(5);

    return view('admin.crud.index', compact('columns', 'data', 'config'));
});

Route::get('/testing/{id}/edit', function ($id) {
    //Form Generator
    $forms = [
        array('type' => 'text', 'label' => 'Category Name', 'name' => 'name', 'place_holder' => 'asdsa', 'mandatory' => true),
        array('type' => 'textarea', 'label' => 'Remarks', 'name' => 'remarks', 'place_holder' => '', 'mandatory' => false),
    ];
    $config = [
        //Form Title
        'title' => 'Edit Category',
        //Form Action Using Route Name
        'action' => 'testing.create',
        //Form Method
        'method' => 'PATCH',
        //Back Button Using Route Name
        'back-button' => 'testing.create'
    ];

    $data = \App\Model\MasterData\Category::findOrFail($id);

    return view('admin.crud.create_or_edit', compact('forms', 'data', 'config'));
})->name('testing.edit');

Route::get('/testing/create', function () {

    //Form Generator
    $forms = [
        array('type' => 'text', 'label' => 'Category Name', 'name' => 'name', 'place_holder' => 'asdsa', 'mandatory' => true),
        array('type' => 'textarea', 'label' => 'Remarks', 'name' => 'remarks', 'place_holder' => '', 'mandatory' => false),
    ];
    $config = [
        //Form Title
        'title' => 'Create Category',
        //Form Action Using Route Name
        'action' => 'testing.create',
        //Form Method
        'method' => 'POST',
        //Back Button Using Route Name
        'back-button' => 'testing.create'
    ];

    $data = \App\Model\MasterData\Category::paginate(5);

    return view('admin.crud.create_or_edit', compact('forms', 'data', 'config'));
})->name('testing.create');

Route::get('/testing/delete', function () {

    //Form Generator
    $forms = [
        array('type' => 'text', 'label' => 'Category Name', 'name' => 'name', 'place_holder' => 'asdsa', 'mandatory' => true),
        array('type' => 'textarea', 'label' => 'Remarks', 'name' => 'remarks', 'place_holder' => '', 'mandatory' => false),
    ];
    $config = [
        //Form Title
        'title' => 'Create Category',
        //Form Action Using Route Name
        'action' => 'testing.create',
        //Form Method
        'method' => 'POST',
        //Back Button Using Route Name
        'back-button' => 'testing.create'
    ];

    $data = \App\Model\MasterData\Category::paginate(5);

    return view('admin.crud.create_or_edit', compact('forms', 'data', 'config'));
})->name('testing.delete');

Route::get('roles', function () {

    return $user = auth()->user()->getRoleNames();
});
