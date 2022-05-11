<?php

namespace App\Http\Controllers;

use App\ActiveTest;
use App\Http\Requests\TestConnectionRequest;
use App\Result;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller {

    public function index($hash) {
        $result = Result::where('hash', $hash)->first();

        if ($result == null) {
            return $this->redirectFail('Unknown result: ' . $hash);
        }

        $userId = $result->user_id;
        $creatorId = Auth::user()->id;

        if (!$result->isCompleted()) {
            if ($userId != $creatorId) {
                return $this->redirectFail('Auth user access denied');
            }

            return view("testings/test/test", [
                'result' => $result
            ]);
        }

        $active = $result->activateTesting;

        if ($userId != $creatorId || $active->user_id != $creatorId) {
            return $this->redirectFail('Auth user access denied');
        }

        return view("testings/test/result", [
            'result' => $result,
            'user' => $result->user,
            'active' => $active,
            'testing' => $active->testing,
            'questionsData' => $result->getResultQuestions(),
            'isCreator' => $active->user_id != $creatorId
        ]);
    }

    private function redirectFail(string $text):RedirectResponse {
        return redirect()
            ->route('testings')
            ->withInput()
            ->withErrors([
                'fail' => $text
            ]);
    }

    public function onConnected(TestConnectionRequest $request) {
        $code = $request->input('code');

        $active = ActiveTest::where('access_code', $code)->first();
        if ($active == null) {
            return back()->withInput()->withErrors([
                'fail' => 'Active test not fond'
            ]);
        }

        $time = $active->end_time;
        if ($time != null && Carbon::now() > $time) {
            return back()->withInput()->withErrors([
                'access_error' => "Time expired from $time"
            ]);
        }

        $result = Result::create($request->user(), $active, $request->ip());
        $result->save();

        return redirect()->route('test', ['hash' => $result->hash]);
    }

    public function update(Request $request) {
        $result = Result::where('hash', $request->hash)->firstOrFail();
        $save = $request->hidden === 'true';

        if ($result->isCompleted())
            return $this->redirectFail('Test has been completed');

        if ($result->user_id == Auth::user()->id) {
            $result->updateAnswers(array_slice($request->post(), 1));

            if ($save) {
                $result->completion_time = Carbon::now();
                $result->updateRating();
            }

            $result->update();
        }

        if ($save) {
            return back();
        }
    }
}
