<?php

Route::get('/', function() {
    return redirect('realty-params');
});
Route::get('realty-params', 'RealtyParamsController@index')->name('mainPage');
Route::post('realty-params', 'RealtyParamsController@store');
Route::get('realty-params/create', 'RealtyParamsController@create');
Route::post('realty-params/create-realty-type', 'RealtyParamsController@storeRealtyType');
Route::get('realty-params/create-realty-type', 'RealtyParamsController@createRealtyType');