<?php

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

Route::group(['middleware' => 'roles:admin,api'], function () {
    Route::group(['prefix' => '{table}/{entity}', 'where' => ['table' => \App\Services\RealtyParamsService::getEditableTables('|')]], function () {
        Route::patch('/', 'RealtyParamsController@updateEntity');
        Route::delete('/', 'RealtyParamsController@deleteEntity');
        Route::group(['prefix' => 'alternatives'], function () {
            Route::post('/', 'RealtyParamsController@createAlternative');
            Route::patch('{alternative}', 'RealtyParamsController@updateAlternative');
            Route::delete('{alternative}', 'RealtyParamsController@deleteAlternative');
        });
    });
});