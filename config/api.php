<?php

return [
    /**
     * Interface frequency limitation
     */
    'rate_limits' => [
        // general data
        'access' =>  env('RATE_LIMITS', '60,1'),
        // auth relatived
        'sign' =>  env('SIGN_RATE_LIMITS', '10,1'),
    ]
];
