<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'email' => 'required|unique:users',
            'name' => 'required|max:100',
            'password' => 'required',
            'captcha' => 'required|captcha'
        ];
    }

    public function messages() {
        return [
            'captcha.captcha' => 'Captcha key is not correct'
        ];
    }
}
