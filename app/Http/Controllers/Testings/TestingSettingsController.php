<?php

namespace App\Http\Controllers\Testings;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestingMakeRequest;

use App\Testing;

use DateTimeImmutable;
use Illuminate\Http\Request;
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

    public function onDelete(Request $request) {
        $test = Testing::getByRealId($request->test);

        foreach ($test->activatedTestings() as $active) {
            $active->end_time = new DateTimeImmutable();

            $active->update();
            $active->delete();
        }

        $test->delete();

        return redirect()
                ->route('testings')
                ->withInput()
                ->with('success', 'Testing has been deleted');
    }
}
