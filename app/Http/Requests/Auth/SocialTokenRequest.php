<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\FormRequest;
use Cache;

class SocialTokenRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'certificate' => [
                'required',
                function($attribute, $value, $fail){
                    if (!$certificate = Cache::get('certificate_' . $value)) {
                        return $fail(__('certificate.expired'));
                    }
                }
            ]
        ];
    }
}
