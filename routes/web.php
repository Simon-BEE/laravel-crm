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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes(['register' => false]);

Route::middleware(['auth', 'manager'])->group(function(){
    // Customers
    Route::resource('customers', 'CustomerController');
    Route::get('customers/{user}/password', 'CustomerController@sendPassword')->name('customers.send_password');

    // Projects
    Route::resource('projects', 'ProjectController');

    // Status
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
