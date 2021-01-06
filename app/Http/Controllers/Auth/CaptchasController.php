<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Gregwar\Captcha\CaptchaBuilder;
use Cache;

class CaptchasController extends Controller
{
    public function store(Request $request){

        $key = 'captcha_' . Str::random(15);

        $builder = new CaptchaBuilder(str_pad(random_int(1, 999999), 6, 0, STR_PAD_LEFT));
        $captcha = $builder->build();
        $expired_at = now()->addMinutes(5);

        Cache::put($key, ['value' => $captcha->getPhrase()], $expired_at);

        return response()->json([
            'key' => $key,
            'expired_at' => strtotime($expired_at->toDateTimeString()),
            'image_content' => $captcha->inline()
        ], 201);
    }
}
