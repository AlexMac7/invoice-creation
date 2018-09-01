<?php

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

Route::get('/', function () {
    return redirect('/invoices');
});

Route::get('/invoices', 'InvoiceController@index')->name('invoices.index');
Route::get('/invoices/create', 'InvoiceController@create')->name('invoices.create');
Route::post('/invoices', 'InvoiceController@store')->name('invoices.store');
Route::get('/invoices/{invoice}', 'InvoiceController@show')->name('invoices.show');
Route::patch('/invoices/{invoice}/update', 'InvoiceController@update')->name('invoices.update');
Route::delete('/invoices/{invoice}/delete', 'InvoiceController@delete')->name('invoices.delete');
