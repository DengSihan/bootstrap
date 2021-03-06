<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Cache;
use Illuminate\Support\Str;
use App\Http\Requests\Auth\SocialLoginRequest;
use App\Http\Requests\Auth\SocialTokenRequest;

class SocialAuthorizationsController extends Controller
{
    use TokenResponser;

    public function store(SocialLoginRequest $request){
        $cache_key = 'social_' . $request->social;
        $template = Cache::get($cache_key);

        if ($request->action === 'new') {
            $user = User::create([
                    'email' => $request->email,
                    'name' => $template['name'],
                    'password' => \Hash::make($request->password),
                    'avatar' => $template['avatar'],
                    'social' => $template['social']
                ]);

            Cache::forget($cache_key);

            $token = Auth::setTTL(config('auth.validity_period'))->login($user);
            return response()->json($this->respondWithToken($token), 201);
        }
        else{
            $credentials['email'] = $request->email;
            $credentials['password'] = $request->password;

            if (Auth::attempt($credentials)) {

                $user = User::where('email', '=', $request->email)->first();

                $user->avatar = $template['avatar'];

                $social = $user->social;
                foreach ($template['social'] as $type => $id) {
                    $social[$type] = $id;
                }

                $user->social = $social;
                $user->save();

                Cache::forget($cache_key);

                $token = Auth::setTTL(config('auth.validity_period'))->login($user);
                return response()->json($this->respondWithToken($token), 201);
            }
            else{
                return response()->json(['message' => __('auth.failed')], 401);
            }
        }
    }

    public function tokens(SocialTokenRequest $request){
        return $this->verifyByCache('certificate_' . $request->certificate);
    }

    public function redirect(String $type){
        return Socialite::driver($type)->stateless()->redirect();
    }

    public function callback(String $type){

        $credential = Socialite::driver($type)->stateless()->user();
        $expired_at = now()->addMinutes(15);

        if($user = User::where('social->'.$type, '=', $credential->id)->first()){
            $user->update([
                'avatar' => $credential->avatar,
            ]);

            $key = Str::random(15);
            Cache::put('certificate_' . $key, $user->id, $expired_at);
            return redirect(config('app.url') . '/social-certificate/' . $key, 302);
        }
        else{
            $template = [
                'name' => $credential->name,
                'avatar' => $credential->avatar,
                'social' => [
                    $type => $credential->id
                ]
            ];

            $key = Str::random(15);
            Cache::put('social_' . $key, $template, $expired_at);
            return redirect(config('app.url') . '/social-login/' . $key, 302);
        }
    }
}
