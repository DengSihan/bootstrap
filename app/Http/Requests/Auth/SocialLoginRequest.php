<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\FormRequest;
use Illuminate\Validation\Rule;
use Cache;
use App\Models\User;

class SocialLoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge($this->captchaRules(), [
            'action' => [
                'required',
                Rule::in(['new', 'exist'])
            ],
            'name' => [
                'required',
                'max:64',
                'min:4',
                function($attribute, $value, $fail){
                    $action = $this->input('action');
                    if ($action === 'new' && \DB::table('users')->where('name', '=', $value)->count()) {
                        $fail(__('validation.unique', ['attribute' => $attribute]));
                    }
                }
            ],
            'password' => 'required|case_diff|numbers|symbols|min:6',
            'social' => [
                'required',
                function($attribute, $value, $fail){
                    if (!$social = Cache::get('social_' . $value)) {
                        return $fail(__('social.expired'));
                    }
                }
            ]
        ]);
    }
}
