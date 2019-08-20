<?php
Route::get('/', function () {
    return redirect(route('admin.dashboard'));
});

Route::get('home', function () {
    return redirect(route('admin.dashboard'));
});
Route::name('admin.')->prefix('admin')->middleware('auth')->group(function () {
    Route::get('/{any}', 'DashboardController')->where('any', '.*');
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
Route::get('/assign', function () {
    return auth()->user()->givePermissionTo('manage-users');
});
