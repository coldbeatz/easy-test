<?php

namespace App\Http\Controllers\Testings;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;

use App\Question;
use App\Testing;
use Illuminate\Http\Request;

class QuestionController extends Controller {

    public function index($realId, $questionId = null) {
        return view("testings/question", [
            'question' => $questionId != null ? Question::findOrFail($questionId) : null
        ]);
    }

    public function onCreateQuestion(QuestionRequest $request) {
        $test = Testing::getByRealId($request->test);

        $question = new Question();
        $question->setData($request->input('question'), $request->input('jsonHidden'), $test->id);
        $question->save();

        return redirect()->route('testing', ['test' => $test->real_id])
            ->withInput()
            ->with('success', 'Question created');;
    }

    public function onUpdateQuestion(QuestionRequest $request) {
        $test = Testing::getByRealId($request->test);

        $question = Question::findOrFail($request->id);

        $question->setData($request->input('question'), $request->input('jsonHidden'), $test->id);
        $question->update();

        return redirect()->route('testing', [
            'test' => $test->real_id
        ]);
    }

    public function onRemoveQuestion(Request $request) {
        $question = Question::findOrFail($request->input('hiddenId'));
        $question->delete();

        return back()
            ->withInput()
            ->with('success', 'Question deleted');
    }
}
