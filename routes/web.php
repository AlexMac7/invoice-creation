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

//Invoice
Route::get('/invoices', 'InvoiceController@index')->name('invoices.index');
Route::get('/invoices/create', 'InvoiceController@create')->name('invoices.create');
Route::post('/invoices', 'InvoiceController@store')->name('invoices.store');
Route::get('/invoices/{invoice}', 'InvoiceController@show')->name('invoices.show');
Route::get('/invoices/{invoice}/edit', 'InvoiceController@edit')->name('invoices.edit');
Route::patch('/invoices/{invoice}', 'InvoiceController@update')->name('invoices.update');
Route::delete('/invoices/{invoice}', 'InvoiceController@delete')->name('invoices.delete');

//Order Items
Route::get('invoices/{invoice}/order-items/create', 'OrderItemController@create')->name('order-items.create');
Route::post('/order-items', 'OrderItemController@store')->name('order-items.store');
//todo above for create
Route::get('/order-items/{orderItem}/edit', 'OrderItemController@edit')->name('order-items.edit');
Route::patch('/order-items/{orderItem}', 'OrderItemController@update')->name('order-items.update');
Route::delete('/order-items/{orderItem}', 'OrderItemController@delete')->name('order-items.delete');

//Payments
Route::get('invoices/{invoice}/payments/create', 'PaymentController@create')->name('payments.create');
Route::post('/payments', 'PaymentController@store')->name('payments.store');
//todo above for create
Route::get('/payments/{payment}/edit', 'PaymentController@edit')->name('payments.edit');
Route::patch('/payments/{payment}', 'PaymentController@update')->name('payments.update');
Route::delete('/payments/{payment}', 'PaymentController@delete')->name('payments.delete');
