<?php

use Illuminate\Support\Facades\Route;
URL::forceScheme('https');
Route::group(['namespace'  => 'Laravel_Orange\Orange_Money\Http\Controllers'],function(){
    Route::get('orange','OrangeController@apiCall');
});
