<?php

namespace App\Http\Controllers;

use Mews\Captcha\Facades\Captcha;

class CaptchaController extends Controller {

    public function refreshCaptcha() {
        return response()->json([
            'captcha' => Captcha::src()
        ]);
    }
}
