<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivateTestRequest extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'title' => 'required|max:255',
            'rating' => 'numeric|min:1',
            'date' => 'required',
            'time' => 'required'
        ];
    }
}
