<?php

Route::group([
    'namespace' => 'Auth',
    'prefix' => 'auth',
    'middleware' => ['throttle:'.config('api.rate_limits.sign')]
], function(){

    // captchas
    Route::resource('captchas', 'CaptchasController', ['only' => ['store']]);

});
