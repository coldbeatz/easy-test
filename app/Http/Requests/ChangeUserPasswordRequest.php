<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeUserPasswordRequest extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'password' => 'required',
            'oldPassword' => 'required',
            'captcha' => 'required|captcha'
        ];
    }

    public function messages() {
        return [
            'captcha.captcha' => 'Captcha key is not correct'
        ];
    }
}
