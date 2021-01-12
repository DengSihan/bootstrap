<?php

namespace App\Http\Controllers\Auth;

use Cache;
use Auth;
use App\Models\User;

trait TokenResponser{

    protected function respondWithToken(String $token){
        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }

    protected function verifyByCache(String $cache_key){
        $id = Cache::get($cache_key);

        $user = User::find($id);

        Cache::forget($cache_key);
        $token = Auth::setTTL(config('auth.validity_period'))->login($user);
        return response()->json($this->respondWithToken($token), 201);
    }
}
