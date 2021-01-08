<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialAuthorizationsController extends Controller
{
    use TokenResponser;

    public function redirect(String $type){
        return Socialite::driver($type)->stateless()->redirect();
    }

    public function callback(String $type){

        $credential = Socialite::driver($type)->stateless()->user();

        if($user = User::where('social->'.$type, '=', $credential->id)->first()){
            $user->update([
                'avatar' => $credential->avatar,
            ]);
        }
        else{
            $user = User::create([
                'name' => $credential->name . time(),
                'avatar' => $credential->avatar,
                'social' => [
                    $type => $credential->id
                ]
            ]);
        }
        $token = Auth::setTTL(config('auth.validity_period'))->login($user);

        return redirect(config('app.url') . '/login?token=' . $token, 302);
    }
}
