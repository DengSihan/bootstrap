<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\Account\UpdatePasswordRequest;
use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Hash;
use Auth;
use Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\Auth\VerificationEmail;

class UserController extends Controller
{
    use TokenResponser;

    public function show(){
        return response()->json(Auth::user());
    }

    public function store(RegisterRequest $request){
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response()->json($this->respondWithToken(Auth::setTTL(config('auth.validity_period'))->login($user)), 201);
    }

    public function social(){
        return response()->json(Auth::user()->social ?? '{}');
    }

    public function updatePassword(UpdatePasswordRequest $request){
        $request->user()->update([
            'password' => \Hash::make($request->password)
        ]);
        return response()->noContent();
    }

    public function destroySocial(Request $request){
        $user = $request->user();

        $social = $user->social;
        unset($social[$request->type]);
        $user->social = $social;
        $user->update();

        return response()->noContent();
    }

    public function sendEmailVerification(ForgetPasswordRequest $request){

        $user = User::where('email', '=', $request->email)->first();

        $expired_at = now()->addMinutes(5);
        $verification = Str::random(10);

        Mail::to($user)->send(new VerificationEmail($verification));

        Cache::put('email_verification_' . $verification, $user->id, $expired_at);

        return response()->json([
            'expired_at' => strtotime($expired_at)
        ], 201);
    }

    public function verifyResetByEmail(ResetPasswordRequest $request){
        return $this->verifyByCache('email_verification_' . $request->email_verification);
    }
}
