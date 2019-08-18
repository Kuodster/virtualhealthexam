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

use Illuminate\Support\Facades\Route;

// We'll make ORM-based solution as the Home Page
Route::get('/', 'CollectionController@ormSolution')->name('orm');
Route::get('/query-builder', 'CollectionController@querySolution')->name('query');
Route::get('/orm-cached', 'CollectionController@ormCached')->name('orm-cached');
Route::get('/query-builder-cached', 'CollectionController@queryCached')->name('query-cached');
