<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cache;

class AuthorizationsController extends Controller
{
    use TokenResponser;

    public function store(LoginRequest $request){
        $credentials['email'] = $request->email;
        $credentials['password'] = $request->password;

        if ($token = auth()->setTTL(config('auth.validity_period'))->attempt($credentials)) {
            return response()->json($this->respondWithToken($token), 201);
        }
        else{
            return response()->json(['message' => __('auth.failed')], 401);
        }
    }

    public function update(){
        $token = auth()->setTTL(config('auth.validity_period'))->refresh();
        return response()->json($this->respondWithToken($token), 201);
    }

    public function destroy(){
        auth()->logout();
        return response(null, 204);
    }
}
