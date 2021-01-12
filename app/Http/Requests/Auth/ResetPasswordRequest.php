<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\FormRequest;
use Cache;

class ResetPasswordRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email_verification' => [
                'required',
                function($attribute, $value, $fail){
                    if (!Cache::get('email_verification_' . $value)) {
                        return $fail(__('email_verification.expired'));
                    }
                }
            ]
        ];
    }
}
