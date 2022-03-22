<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestoreRequest extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'email' => 'required',
            'captcha' => 'required|captcha'
        ];
    }

    public function messages() {
        return [
            'captcha.captcha' => 'Captcha key is not correct'
        ];
    }
}
