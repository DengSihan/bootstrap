<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthorizationsController extends Controller
{
    use TokenResponser;

    public function redirect(String $type){
        return Socialite::driver($type)->stateless()->redirect();
    }

    public function callback(String $type, Request $request){

        \Log::debug($request);

        $user = Socialite::driver($type)->stateless()->user();

        return response()->json($user);
    }
}
