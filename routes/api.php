<?php

Route::group([ 'prefix' => 'v2' ], function (){

    Route::get('thermometer.json', 'ThermometerController@index');

});
