<?php

Route::group([ 'prefix' => 'v1' ], function (){
    Route::get('thermometer.json', 'ThermometerController@index');
});

Route::group([ 'prefix' => 'v2' ], function (){
    Route::get('thermometer.json', 'ThermometerController@index');
    Route::get('lights.json', 'LightsController@index');
});
