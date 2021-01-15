<?php

Route::group([
    'namespace' => 'Resource',
    'middleware' => ['throttle:'.config('api.rate_limits.access')]
], function(){

    Route::get('/users', 'UsersController@index');

});
