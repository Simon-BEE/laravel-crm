<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Route::get('/', 'HomeController')->name('base.home');

Auth::routes(['register' => false]);

// ADMIN ROUTES
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function(){
    Route::namespace('Admin')->group(function(){
        Route::get('/', 'DashboardController')->name('home');

        // Customers
        Route::group(['namespace' => 'Customer'], function () {
            Route::get('customers/export', 'CustomerController@exportAll')->name('customers.export.all');
            Route::get('customers/export/{customer}', 'CustomerController@exportCustomer')->name('customers.export.customer');
            Route::get('customers/{user}/password', 'CustomerController@sendPassword')->name('customers.send_password');
            Route::resource('customers', 'CustomerController');
        });

        // Projects
        Route::group(['namespace' => 'Project'], function () {
            Route::resource('projects', 'ProjectController');
            // Route::post('projects', 'ProjectController@index')->name('projects.search');
        });

        // Documents
        Route::group(['namespace' => 'Document'], function () {
            // Invoices
            Route::resource('invoices', 'InvoiceController')->only('index', 'create','store');
            Route::patch('invoices', 'InvoiceController@updateStatus')->name('invoices.status.update');
            Route::post('invoices/projects', 'InvoiceController@getProjectsByCustomer')->name('invoices.customer.projects');
            // Estimates
            Route::resource('estimates', 'EstimateController')->only('index', 'create','store');
            Route::patch('estimates', 'EstimateController@updateStatus')->name('estimates.status.update');
            Route::post('estimates/projects', 'EstimateController@getProjectsByCustomer')->name('estimates.customer.projects');
        });

        // Status
        Route::group(['namespace' => 'Status'], function () {
            Route::resource('status', 'StatusController')
                ->except(['show']);
        });

        // Tickets
        Route::group(['prefix' => 'tickets'], function(){
            // Priority
            Route::group(['namespace' => 'Priority'], function () {
                Route::get('priorities', 'PriorityController@index')->name('priorities.index');
                Route::post('priorities', 'PriorityController@storeOrUpdate')->name('priorities.store');
                Route::patch('priorities/{priority}', 'PriorityController@storeOrUpdate')->name('priorities.update');
                Route::delete('priorities/{priority}', 'PriorityController@destroy')->name('priorities.destroy');
            });

            // Issue
            Route::group(['namespace' => 'Issue'], function () {
                Route::get('issues', 'IssueController@index')->name('issues.index');
                Route::post('issues', 'IssueController@storeOrUpdate')->name('issues.store');
                Route::patch('issues/{issue}', 'IssueController@storeOrUpdate')->name('issues.update');
                Route::delete('issues/{issue}', 'IssueController@destroy')->name('issues.destroy');
            });
        });

        // Archives
        Route::prefix('archives')->group(function () {
            // Customers
            Route::group(['namespace' => 'Customer'], function () {
                Route::get('customers', 'CustomerTrashController@index')->name('archives.customers.index');
                Route::patch('customers/{id}', 'CustomerTrashController@restore')->name('archives.customers.restore');
                Route::delete('customers/{id}', 'CustomerTrashController@destroy')->name('archives.customers.destroy');
            });
            // Projects
            Route::group(['namespace' => 'Project'], function () {
                Route::get('projects', 'ProjectTrashController@index')->name('archives.projects.index');
                Route::patch('projects/{id}', 'ProjectTrashController@restore')->name('archives.projects.restore');
                Route::delete('projects/{id}', 'ProjectTrashController@destroy')->name('archives.projects.destroy');
            });
        });
    });

    // Account
    Route::group(['namespace' => 'Account', 'prefix' => 'account'], function () {
        Route::get('/', 'AccountController@edit')->name('account.edit');
        Route::patch('/', 'AccountController@update')->name('account.update');
        Route::get('/password', 'AccountController@password')->name('account.password');
        Route::patch('/password', 'AccountController@passwordUpdate')->name('account.passwordUpdate');
    });

    // Settings
    Route::group(['namespace' => 'Settings', 'prefix' => 'settings'], function () {
        Route::get('/', 'SettingsController@index')->name('settings.index');
        Route::patch('/', 'SettingsController@update')->name('settings.update');
    });
});

// CUSTOMER ROUTES
Route::middleware(['customer'])->prefix('customer')->name('customer.')->group(function(){
    Route::namespace('Customer')->group(function(){
        Route::get('/', 'DashboardController')->name('home');

        // Projects
        Route::group(['namespace' => 'Project'], function () {
            Route::resource('projects', 'ProjectController')->only(['index', 'show']);
        });

        // Documents
        Route::group(['namespace' => 'Document'], function () {
            Route::get('documents', 'DocumentController@index')->name('documents.index');
            Route::get('documents/invoices/{document}', 'DocumentController@showInvoice')->name('documents.show.invoice');
            Route::get('documents/estimates/{document}', 'DocumentController@showEstimate')->name('documents.show.estimate');
        });

        // Tickets
        Route::group(['namespace' => 'Ticket'], function () {
            Route::resource('tickets', 'TicketController');
        });
    });

    // Account
    Route::group(['namespace' => 'Account', 'prefix' => 'account'], function () {
        Route::get('/', 'AccountController@edit')->name('account.edit');
        Route::patch('/', 'AccountController@update')->name('account.update');
        Route::get('/password', 'AccountController@password')->name('account.password');
        Route::patch('/password', 'AccountController@passwordUpdate')->name('account.passwordUpdate');
    });

    // Settings
    Route::group(['namespace' => 'Settings', 'prefix' => 'settings'], function () {
        Route::get('/', 'SettingsController@index')->name('settings.index');
        Route::patch('/', 'SettingsController@update')->name('settings.update');
    });
});
