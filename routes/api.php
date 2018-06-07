<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('contact')->name('contact.')->middleware('bindings')->group(function () {
    Route::get('/', 'ContactController@index')->name('index');
    Route::post('/', 'ContactController@store')->name('store');
    Route::put('/{contact}', 'ContactController@update')->name('update');
    Route::delete('/{contact}', 'ContactController@destroy')->name('destroy');

    Route::get('/{contact}/note', 'ContactNoteController@index')->name('note');
});
