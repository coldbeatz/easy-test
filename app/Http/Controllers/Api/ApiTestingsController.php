<?php

namespace App\Http\Controllers\Api;

use App\ActiveTest;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;

use App\Question;
use App\Testing;

use DateTimeImmutable;
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

            if (empty($test))
                return $this->jsonError("Test is not exists");

            return response()->json($test->jsonSerialize());
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage());
        }
    }

    public function onDeleteTesting(Request $request):JsonResponse {
        try {
            $json = $request->json()->all();

            $id = $json['id'];
            $test = Testing::find($id);

            if (empty($test))
                return $this->jsonError("Test is not exists");

            if ($test->creator_id != Auth::id())
                return $this->jsonError("User is not test creator");

            foreach ($test->activatedTestings() as $active) {
                $active->end_time = new DateTimeImmutable();

                $active->update();
                $active->delete();
            }

            $test->delete();
            return $this->jsonMessage('success');
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

            if (empty($test))
                return $this->jsonError("Test is not exists");

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
            if (empty($test))
                return $this->jsonError("Test is not exists");

            if ($test->creator_id != Auth::id())
                return $this->jsonError("User is not test creator");

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
            if (empty($question))
                return $this->jsonError("Question is not exists");

            if ($question->testing->creator_id != Auth::id())
                return $this->jsonError("User is not test creator");

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

    public function onActivateTesting(Request $request):JsonResponse {
        try {
            $json = $request->json()->all();

            $datetime = $json['datetime'];
            $testId = $json['test_id'];
            $title = $json['title'];
            $rating = $json['rating'];

            $showUserAnswers = $json['showUserAnswers'];
            $showCorrectAnswers = $json['showCorrectAnswers'];

            $dateTo = $datetime == null ? null : DateTimeImmutable::createFromFormat('m/d/Y H:i', $datetime);

            $test = Testing::find($testId);
            if ($test == null)
                return $this->jsonError("Test not found");

            if ($test->creator_id != Auth::id())
                return $this->jsonError("User is not test creator");

            $active = new ActiveTest();

            $active->testing_id = $test->id;
            $active->user_id = Auth::id();

            $active->start_time = new DateTimeImmutable();
            $active->end_time = $dateTo;

            $active->title = $title;
            $active->max_rating = $rating;
            $active->access_code = $active->generateUniqueAccessCode();

            $active->show_user_answers = $showUserAnswers;
            $active->show_correct_answers = $showCorrectAnswers;

            $active->save();

            return response()->json($active->jsonSerialize());
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage());
        }
    }

    public function onEditActivate(Request $request):JsonResponse {
        try {
            $json = $request->json()->all();

            $datetime = $json['datetime'];
            $id = $json['id'];
            $title = $json['title'];
            $rating = $json['rating'];

            $showUserAnswers = $json['showUserAnswers'];
            $showCorrectAnswers = $json['showCorrectAnswers'];

            $dateTo = $datetime == null ? null : DateTimeImmutable::createFromFormat('m/d/Y H:i', $datetime);

            $active = ActiveTest::find($id);
            if ($active->testing->creator_id != Auth::id())
                return $this->jsonError("User is not test creator");

            $active->end_time = $dateTo;

            $active->title = $title;
            $active->max_rating = $rating;

            $active->show_user_answers = $showUserAnswers;
            $active->show_correct_answers = $showCorrectAnswers;

            $active->update();

            return $this->jsonMessage('success');
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage());
        }
    }

    public function getActivate(Request $request):JsonResponse {
        try {
            $json = $request->json()->all();

            $id = $json['id'];

            $active = ActiveTest::find($id);
            if ($active->testing->creator_id != Auth::id())
                return $this->jsonError("User is not test creator");

            return response()->json($active->jsonSerialize());
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage());
        }
    }

    public function allActivates(Request $request):JsonResponse {
        try {
            $json = $request->json()->all();

            $id = $json['test_id'];

            $test = Testing::find($id);
            if ($test->creator_id != Auth::id())
                return $this->jsonError("User is not test creator");

            $all = [];

            foreach($test->activatedTestings as $activated) {
                $all[] = $activated;
            }

            return response()->json($all);
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage());
        }
    }

    public function onDeleteActivate(Request $request):JsonResponse {
        try {
            $json = $request->json()->all();

            $id = $json['id'];

            $active = ActiveTest::find($id);
            if ($active->testing->creator_id != Auth::id())
                return $this->jsonError("User is not test creator");

            $active->end_time = new DateTimeImmutable();

            $active->update();
            $active->delete();

            return $this->jsonMessage('success');
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage());
        }
    }

    public function getResults(Request $request):JsonResponse {
        try {
            $json = $request->json()->all();

            $id = $json['activate_id'];

            $active = ActiveTest::find($id);
            if ($active->testing->creator_id != Auth::id())
                return $this->jsonError("User is not test creator");

            return response()->json($active->results()->jsonSerialize());
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage());
        }
    }
}
