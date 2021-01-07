<?php

Route::group([
    'namespace' => 'Auth',
    'prefix' => 'auth',
    'middleware' => ['throttle:'.config('api.rate_limits.sign')]
], function(){

    // login
    Route::post('authorizations', 'AuthorizationsController@store');

    // captchas
    Route::resource('captchas', 'CaptchasController', ['only' => ['store']]);

    // need authorizations
    Route::group([
        'middleware' => ['auth']
    ], function(){
        Route::patch('authorizations', 'AuthorizationsController@update');
        Route::delete('authorizations', 'AuthorizationsController@destroy');

        // get user info
        Route::get('user', 'UsersController@show');
    });

});
