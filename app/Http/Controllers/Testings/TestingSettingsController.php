<?php

namespace App\Http\Controllers\Testings;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestingMakeRequest;

use App\Testing;
use Illuminate\Support\Facades\Auth;

class TestingSettingsController extends Controller {

    public function index($realId) {
        return view("testings/settings", [
            'test' => Testing::getByRealId($realId)
        ]);
    }

    public function update(TestingMakeRequest $request) {
        $test = Testing::getByRealId($request->test);

        if ($test->creator_id != Auth::id())
            return back()->withInput()->withErrors(['fail' => 'User is not test creator']);

        $test->title = $request->input('title');
        $test->description = $request->input('description');

        $test->update();

        return back()
            ->withInput()
            ->with('success', 'Testing data updated');
    }
}
