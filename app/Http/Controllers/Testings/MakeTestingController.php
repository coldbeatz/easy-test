<?php

namespace App\Http\Controllers\Testings;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestingMakeRequest;
use App\Testing;

class MakeTestingController extends Controller {

    public function index() {
        return view("testings/make");
    }

    public function create(TestingMakeRequest $request) {
        $test = Testing::create($request->input('title'), $request->input('description'));
        $test->save();

        return redirect()->route('testing', ['test' => $test->real_id]);
    }
}
