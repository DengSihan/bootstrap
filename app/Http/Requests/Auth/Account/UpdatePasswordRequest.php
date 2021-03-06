<?php

namespace App\Http\Requests\Auth\Account;

use App\Http\Requests\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge($this->captchaRules(), [
            'password' => 'required|case_diff|numbers|symbols|min:6',
        ]);
    }
}
