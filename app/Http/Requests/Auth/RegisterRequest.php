<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge($this->captchaRules(), [
            'name' => 'required|unique:users|max:64|min:4',
            'password' => 'required|case_diff|numbers|symbols|min:6',
        ]);
    }
}
