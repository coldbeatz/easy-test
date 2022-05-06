<?php

namespace App\Http\Controllers\Testings;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;

use App\Question;
use App\Testing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller {

    public function index($realId, $questionId = null) {
        return view("testings/question", [
            'question' => $questionId != null ? Question::findOrFail($questionId) : null
        ]);
    }

    public function onCreateQuestion(QuestionRequest $request) {
        $test = Testing::getByRealId($request->test);

        if ($test->creator_id != Auth::id())
            return back()->withInput()->withErrors(['fail' => 'User is not test creator']);

        $question = new Question();
        $question->setData($request->input('question'), $request->input('jsonHidden'), $test->id);
        $question->save();

        return redirect()->route('testing', ['test' => $test->real_id])
            ->withInput()
            ->with('success', 'Question created');;
    }

    public function onUpdateQuestion(QuestionRequest $request) {
        $test = Testing::getByRealId($request->test);

        if ($test->creator_id != Auth::id())
            return back()->withInput()->withErrors(['fail' => 'User is not test creator']);

        $question = Question::findOrFail($request->id);

        $question->setData($request->input('question'), $request->input('jsonHidden'), $test->id);
        $question->update();

        return redirect()->route('testing', [
            'test' => $test->real_id
        ]);
    }

    public function onRemoveQuestion(Request $request) {
        $question = Question::findOrFail($request->input('hiddenId'));

        if ($question->testing->creator_id != Auth::id())
            return back()->withInput()->withErrors(['fail' => 'User is not test creator']);

        $question->delete();

        return back()
            ->withInput()
            ->with('success', 'Question deleted');
    }
}
