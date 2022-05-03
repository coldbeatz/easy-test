<?php

namespace App\Http\Controllers\Testings;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestingMakeRequest;
use App\Testing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MakeTestingController extends Controller {

    public function index() {
        return view("testings/make");
    }

    public function create(TestingMakeRequest $request) {
        $test = new Testing();

        $test->title = $request->input('title');
        $test->description = $request->input('description');
        $test->creator_id = Auth::id();
        $test->real_id = $this->generateRealId();

        $test->save();

        return redirect()->route('testing', ['test' => $test->real_id]);
    }

    private function generateRealId():string {
        do {
            $id = Str::random(16);
            $testing = Testing::where('real_id', $id)->get();
        } while (!$testing->isEmpty());

        return $id;
    }
}
