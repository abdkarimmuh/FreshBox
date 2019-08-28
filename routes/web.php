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
        Route::get('/form_sales_order', 'Marketing\FormSalesOrderController@index')->name('form_sales_order');
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

Route::get('roles', function () {

    return $user = auth()->user()->getRoleNames();

});
