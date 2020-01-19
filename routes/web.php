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

Route::get('/phpinfo', function() {
    return phpinfo();
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', 'HomeController@index');

Route::group(['namespace' => 'Admin','prefix' => 'admin','middleware'=>'auth'],function() {
    Route::get('/dashboard', 'DashboardController@index');
    Route::resource('/type', 'TypesController');
    Route::resource('/category', 'CategoriesController');
    Route::resource('/sub_category', 'SubCategoriesController');
    Route::resource('/measure', 'MeasuresController');
    Route::resource('/brand', 'BrandsController');
    Route::resource('/product', 'ProductsController');
    Route::resource('/price', 'PricesController');
    Route::resource('/company', 'CompaniesController');
});
