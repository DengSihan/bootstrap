<?php

$socials = implode('|', array_diff(array_keys(config('services')), ['mailgun','postmark','ses']));

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

    Route::post('socials/tokens', 'SocialAuthorizationsController@tokens');

    // login from social
    Route::post('socials/authorizations', 'SocialAuthorizationsController@store');

    // login
    Route::post('authorizations', 'AuthorizationsController@store');

    // captchas
    Route::resource('captchas', 'CaptchasController', ['only' => ['store']]);

    // register
    Route::post('users', 'UserController@store');

    // send email verification
    Route::post('email-verifications', 'UserController@sendEmailVerification');

    // verify email verification
    Route::patch('email-verifications', 'UserController@verifyResetByEmail');

    // need authorizations
    Route::group([
        'middleware' => ['auth']
    ], function() use ($socials){
        Route::patch('authorizations', 'AuthorizationsController@update');
        Route::delete('authorizations', 'AuthorizationsController@destroy');

        // get user info
        Route::get('user', 'UserController@show');
        // all social account
        Route::get('user/social', 'UserController@social');
        // update password
        Route::put('user/password', 'UserController@updatePassword');
        // delete social account bind
        Route::delete('user/social/{type}', 'UserController@destroySocial')
            ->where('type', $socials);
    });

});
