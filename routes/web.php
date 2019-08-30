<?php
Route::get('/', function () {
    return redirect(route('admin.dashboard'));
});

Route::get('home', function () {
    return redirect(route('admin.dashboard'));
});

Route::name('admin.')->prefix('admin')->middleware('auth')->group(function () {
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
        });
    });
    /**
     * Route Menu Warehouse
     */
    Route::name('warehouse.')->prefix('warehouse')->middleware('auth')->group(function () {
        Route::get('/form_delivery_order', 'Marketing\FormSalesOrderController@index')->name('form_delivery_order');
        Route::get('/confirm_deliver_order', 'Marketing\FormSalesOrderController@index')->name('confirm_delivery_order');
    });
    /**
     * Route Menu Finance
     */
    Route::name('finance.')->prefix('finance')->middleware('auth')->group(function () {
        Route::get('/form_invoice_order', 'Marketing\FormSalesOrderController@index')->name('form_invoice_order');
    });
    /**
     * Route Menu Master Data
     */
    Route::name('master_data.')->prefix('master_data')->middleware('auth')->group(function () {
        Route::name('category.')->prefix('category')->group(function () {
            Route::get('/', 'MasterData\CategoryController@index')->name('index');
            Route::get('/create', 'MasterData\CategoryController@create')->name('create');
            Route::post('/create', 'MasterData\CategoryController@store')->name('store');
        });

        Route::name('province.')->prefix('province')->group(function () {
            Route::get('/', 'MasterData\ProvinceController@index')->name('index');
            Route::get('/create', 'MasterData\ProvinceController@create')->name('create');
            Route::post('/create', 'MasterData\ProvinceController@store')->name('store');
        });

        Route::name('residence.')->prefix('residence')->group(function () {
            Route::get('/', 'MasterData\ResidenceController@index')->name('index');
            Route::get('/create', 'MasterData\ResidenceController@create')->name('create');
            Route::post('/create', 'MasterData\ResidenceController@store')->name('store');
        });

        Route::name('driver.')->prefix('driver')->group(function () {
            Route::get('/', 'MasterData\DriverController@index')->name('index');
            Route::get('/create', 'MasterData\DriverController@create')->name('create');
            Route::post('/create', 'MasterData\DriverController@store')->name('store');
        });

        Route::name('origin.')->prefix('origin')->group(function () {
            Route::get('/', 'MasterData\OriginController@index')->name('index');
            Route::get('/create', 'MasterData\OriginController@create')->name('create');
            Route::post('/create', 'MasterData\OriginController@store')->name('store');
        });

        Route::name('uom.')->prefix('uom')->group(function () {
            Route::get('/', 'MasterData\UomController@index')->name('index');
            Route::get('/create', 'MasterData\UomController@create')->name('create');
            Route::post('/create', 'MasterData\UomController@store')->name('store');
        });

        Route::name('item.')->prefix('item')->group(function () {
            Route::get('/', 'MasterData\ItemController@index')->name('index');
            Route::get('/create', 'MasterData\ItemController@create')->name('create');
            Route::post('/create', 'MasterData\ItemController@store')->name('store');
        });
    });
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
        array('type' => 'text', 'label' => 'Category Name', 'name' => 'name', 'place_holder' => 'asdsa'),
        array('type' => 'textarea', 'label' => 'Remarks', 'name' => 'remarks', 'place_holder' => ''),
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
        array('type' => 'text', 'label' => 'Category Name', 'name' => 'name', 'place_holder' => 'asdsa'),
        array('type' => 'textarea', 'label' => 'Remarks', 'name' => 'remarks', 'place_holder' => ''),
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
        array('type' => 'text', 'label' => 'Category Name', 'name' => 'name', 'place_holder' => 'asdsa'),
        array('type' => 'textarea', 'label' => 'Remarks', 'name' => 'remarks', 'place_holder' => ''),
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
