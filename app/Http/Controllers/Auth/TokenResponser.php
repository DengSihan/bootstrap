<?php

namespace App\Http\Controllers\Auth;

use Cache;

trait TokenResponser{

    protected function respondWithToken(String $token){
        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }
}
