<?php

namespace App\Http\Controllers\Testings;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class TestingsController extends Controller {

    public function index() {
        return view('testings', [
            'testings' => Auth::user()->testings
        ]);
    }
}
