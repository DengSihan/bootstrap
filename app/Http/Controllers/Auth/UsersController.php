<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Hash;
use Auth;

class UsersController extends Controller
{
    use TokenResponser;

    public function show(){
        return response()->json(Auth::user());
    }

    public function store(RegisterRequest $request){
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);
        return response()->json($this->respondWithToken(Auth::setTTL(config('auth.validity_period'))->login($user)), 201);
    }
}
