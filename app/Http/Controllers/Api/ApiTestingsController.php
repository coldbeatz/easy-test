<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;

use App\Question;
use App\Testing;
use Exception;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiTestingsController extends Controller {

    use ApiController;

    public function parseAllTestings(Request $request):JsonResponse {
        try {
            $user = $request->user();

            return response()->json($user->testings);
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage());
        }
    }

    public function onMakeTesting(Request $request):JsonResponse {
        try {
            $json = $request->json()->all();

            $title = $json['title'];
            $description = $json['description'];

            $test = Testing::create($title, $description);
            $test->save();

            return response()->json($test->jsonSerialize());
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage());
        }
    }

    public function getTestingById(Request $request):JsonResponse {
        try {
            $json = $request->json()->all();

            $id = $json['id'];
            $test = Testing::find($id);

            return response()->json($test->jsonSerialize());
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage());
        }
    }

    public function onUpdateTesting(Request $request):JsonResponse {
        try {
            $json = $request->json()->all();

            $id = $json['id'];
            $title = $json['title'];
            $description = $json['description'];

            $test = Testing::find($id);

            if ($test->creator_id != Auth::id())
                return $this->jsonError("User is not test creator");

            $test->title = $title;
            $test->description = $description;

            $test->update();

            return response()->json($test->jsonSerialize());
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage());
        }
    }

    public function getTestingQuestions(Request $request):JsonResponse {
        try {
            $json = $request->json()->all();

            $id = $json['testing_id'];
            $test = Testing::find($id);

            $questions = $test->questions->toArray();
            foreach ($questions as $key => $question) {
                $questions[$key]['json_answers'] = json_decode($question['json_answers']);
            }

            return response()->json($questions);
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage());
        }
    }

    public function getQuestionById(Request $request):JsonResponse {
        try {
            $json = $request->json()->all();

            $id = $json['id'];
            $question = Question::find($id);

            $array = $question->toArray();
            $array['json_answers'] = json_decode($array['json_answers']);

            return response()->json($array);
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage());
        }
    }

    public function onMakeQuestion(Request $request):JsonResponse {
        try {
            $json = $request->json()->all();

            $id = $json['testing_id'];
            $text = $json['question'];
            $json = json_encode($json['json_answers'], JSON_UNESCAPED_SLASHES);

            $test = Testing::find($id);

            if ($test->creator_id != Auth::id())
                return $this->jsonError("User is not test creator");

            $question = new Question();
            $question->setData($text, $json, $test->id);
            $question->save();

            return response()->json([
                'created' => true,
                'question_id' => $question->id
            ]);
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage());
        }
    }

    public function onUpdateQuestion(Request $request):JsonResponse {
        try {
            $json = $request->json()->all();

            $id = $json['question_id'];
            $text = $json['question'];
            $json = json_encode($json['json_answers'], JSON_UNESCAPED_SLASHES);

            $question = Question::find($id);

            if ($question == null)
                return $this->jsonError("Question not found");

            if ($question->testing->creator_id != Auth::id())
                return $this->jsonError("User is not test creator");

            $question->setData($text, $json, $question->testing_id);
            $question->update();

            return $this->jsonMessage('success');
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage());
        }
    }

    public function onDeleteQuestion(Request $request):JsonResponse {
        try {
            $json = $request->json()->all();

            $id = $json['question_id'];
            $question = Question::find($id);

            if ($question == null)
                return $this->jsonError("Question not found");

            if ($question->testing->creator_id != Auth::id())
                return $this->jsonError("User is not test creator");

            $question->delete();

            return $this->jsonMessage('success');
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage());
        }
    }

}
