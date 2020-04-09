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
Route::middleware(['admin'])->prefix('admin')->namespace('Admin')->name('admin.')->group(function(){
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
    });

    // Status
    Route::group(['namespace' => 'Status'], function () {
        Route::resource('status/project', 'StatusProjectController')
            ->except(['edit', 'update', 'show'])
            ->names([
                'create' => 'status.projects.create',
                'index' => 'status.projects.index',
                'store' => 'status.projects.store',
                'destroy' => 'status.projects.destroy',
        ]);
        Route::resource('status/ticket', 'StatusTicketController')
            ->except(['edit', 'update', 'show'])
            ->names([
                'create' => 'status.tickets.create',
                'index' => 'status.tickets.index',
                'store' => 'status.tickets.store',
                'destroy' => 'status.tickets.destroy',
        ]);
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

    // Account
    Route::group(['namespace' => 'Account', 'prefix' => 'account'], function () {
        Route::get('/', 'AccountController@index')->name('account.index');
        Route::patch('/', 'AccountController@update')->name('account.update');
    });
});

// CUSTOMER ROUTES
Route::middleware(['customer'])->prefix('customer')->namespace('Customer')->name('customer.')->group(function(){
    Route::get('/', 'DashboardController')->name('home');
});
