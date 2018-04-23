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

use DB;

Route::get('/', function () {
	if(DB::connection()->getDatabaseName())
    {
       echo "Yes! successfully connected to the DB: ". DB::connection()->getDatabaseName();
    }
});