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
            Route::resource('customers', 'CustomerController');
            Route::get('customers/{user}/password', 'CustomerController@sendPassword')->name('customers.send_password');
        });

        // Projects
        Route::group(['namespace' => 'Project'], function () {
            Route::resource('projects', 'ProjectController');
        });

        // Invoices
        Route::group(['namespace' => 'Invoice'], function () {
            Route::resource('invoices', 'InvoiceController')->only('index', 'create','store');
            Route::patch('invoices', 'InvoiceController@updateStatus')->name('invoices.status.update');
            Route::post('invoices/projects', 'InvoiceController@getProjectsByCustomer')->name('invoices.customer.projects');
        });

        // Status
        Route::group(['namespace' => 'Status'], function () {
            Route::resource('status', 'StatusController')
                ->except(['show']);
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
