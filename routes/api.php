<?php

Route::group([ 'prefix' => 'v1' ], function (){

    Route::get('thermometer.json', 'ThermometerController@index');

});
