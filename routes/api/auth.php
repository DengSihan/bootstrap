<?php

$socials = 'github|apple|weixin';

Route::group([
    'namespace' => 'Auth',
    'prefix' => 'auth',
    'middleware' => ['throttle:'.config('api.rate_limits.sign')]
], function() use ($socials){

    // social login redirect
    Route::get('socials/{type}/authorizations', 'SocialAuthorizationsController@redirect')
        ->where('type', $socials);

    // social login callback
    Route::get('socials/{type}/authorizations/callback', 'SocialAuthorizationsController@callback')
        ->where('type', $socials);

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
