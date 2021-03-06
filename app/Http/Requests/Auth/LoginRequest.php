<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge($this->captchaRules(), [
            'email' => 'required|email',
            'password' => 'required|case_diff|numbers|symbols|min:6',
        ]);
    }
}
