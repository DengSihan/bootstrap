<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as Request;
use Illuminate\Validation\ValidationException;
use Cache;

class FormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function failedValidation($validator)
    {
        $response = response()->json([
            'message' => __('validation.invalid'),
            'errors' => $validator->errors()->messages(),
        ], 422);

        throw new ValidationException($validator, $response);
    }

    public $captcha;

    public function captchaRules(): Array{
        return [
            'captcha_key' => [
                'required',
                function($attribute, $value, $fail){
                    if (!$captcha = Cache::get($value)) {
                        return $fail(__('captcha.expired'));
                    }
                }
            ],
            'verification' => [
                'required',
                function($attribute, $value, $fail){
                    $captcha = Cache::get($this->input('captcha_key'));
                    if (!hash_equals($captcha['value'], $value)) {
                        return $fail(__('captcha.error_value'));
                    }
                    else{
                        Cache::forget($this->input('captcha_key'));
                    }
                }
            ]
        ];
    }
}
