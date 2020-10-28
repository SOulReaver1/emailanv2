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

Auth::routes();

// There is routes for login people
Route::group(['middleware' => 'auth'], function () {
  // Profil routes
  Route::resource('/', 'EmailController');
  Route::resource('/bases', 'BaseController');
  Route::prefix('tags')->name('tags.')->group(function () {
    Route::get('delete', 'TagController@delete')->name('delete');
    Route::delete('delete', 'TagController@destroy')->name('destroy');
  });
  Route::resource('/tags', 'TagController')->except('destroy');
  Route::prefix('comparateur')->name('comparator.')->group(function () {
    Route::get('/', 'ComparatorController@index')->name('index');
    Route::get('create', 'ComparatorController@create')->name('create');
    Route::post('create/database', 'ComparatorController@withDatabase')->name('db');
    Route::post('create/files', 'ComparatorController@files')->name('files');
  });
  Route::prefix('repoussoir')->name('encrypt.')->group(function () {
    Route::get('/', 'EncryptController@index')->name('index');
    Route::get('create', 'EncryptController@create')->name('create');
  });
  Route::resource('/fais', 'FaiController');
	Route::resource('user', 'UserController', ['only' => ['create', 'store']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
  Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
  Route::prefix('datatable')->name('datatable.')->group(function () {
    Route::post('fais', 'FaiController@datatable')->name('fais');
    Route::post('bases', 'BaseController@datatable')->name('bases');
    Route::post('emails', 'EmailController@datatable')->name('emails');
  });
  Route::prefix('store')->name('store.')->group(function () {
    Route::post('check', 'StoreFileController@check')->name('check');
    Route::post('/', 'StoreFileController@storeFile')->name('store');
  });
});
