<?php


namespace App\Http\Controllers\Testings;

use App\ActiveTest;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActivateTestRequest;

use App\Testing;

use Chartisan\PHP\Chartisan;
use DateTimeImmutable;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivateTestingController extends Controller {

    public function index($realId, $activeId = null) {
        $active = null;
        if ($activeId != null) {
            $active = ActiveTest::findOrFail($activeId);

            if ($active->testing->creator_id != Auth::id())
                return abort(404);
        }

        return view("testings/activate", [
            'active' => $active
        ]);
    }

    public function onActivate(ActivateTestRequest $request) {
        $dateValue = $request->input('date') . ' ' . $request->input('time');
        $dateTo = $request->input('useDate') !== 'on' ? null : DateTimeImmutable::createFromFormat('m/d/Y H:i', $dateValue);

        $test = Testing::getByRealId($request->test);
        if ($test->creator_id != Auth::id())
            return back()->withInput();

        $active = new ActiveTest();

        $active->testing_id = $test->id;
        $active->user_id = Auth::id();

        $active->start_time = new DateTimeImmutable();
        $active->end_time = $dateTo;

        $active->title = $request->input('title');
        $active->max_rating = $request->input('rating');
        $active->access_code = $active->generateUniqueAccessCode();

        $active->show_user_answers = $request->input('showUserAnswers') === 'on';
        $active->show_correct_answers = $request->input('showCorrectAnswers') === 'on';

        $active->save();

        return redirect()
            ->route('edit-activate', ['test' => $test->real_id, 'id' => $active->id])
            ->withInput()
            ->with('success', 'Testing has been activated');
    }

    public function onEditActivate(ActivateTestRequest $request) {
        $active = ActiveTest::findOrFail($request->id);
        if ($active->testing->creator_id != Auth::id())
            return back()->withInput();

        $dateValue = $request->input('date') . ' ' . $request->input('time');
        $dateTo = $request->input('useDate') !== 'on' ? null : DateTimeImmutable::createFromFormat('m/d/Y H:i', $dateValue);

        $active->end_time = $dateTo;

        $active->title = $request->input('title');
        $active->max_rating = $request->input('rating');

        $active->show_user_answers = $request->input('showUserAnswers') === 'on';
        $active->show_correct_answers = $request->input('showCorrectAnswers') === 'on';

        $active->update();

        return back()
            ->withInput()
            ->with('success', 'Testing activation has been updated');
    }

    public function onDeleteActivate(Request $request) {
        $active = ActiveTest::findOrFail($request->id);
        if ($active->testing->creator_id != Auth::id())
            return back()->withInput();

        $active->end_time = new DateTimeImmutable();

        $active->update();
        $active->delete();

        return redirect()
            ->route('testing', ['test' => $request->test])
            ->withInput()
            ->with('success', 'Activate testing has been deleted');;
    }

    public function ratingsChart(Request $request) {
        $active = ActiveTest::findOrFail($request->id);
        if ($active->testing->creator_id != Auth::id())
            return back()->withInput();

        $ratings = [];
        $counts = [];

        foreach ($active->results() as $result) {
            $rating = $result->rating;

            if (in_array($rating, $ratings)) {
                $key = array_search($rating, $counts);
                $counts[$key]++;
            } else {
                $ratings[] = $rating;
                $counts[] = 1;
            }
        }

        return Chartisan::build()
            ->labels($ratings)
            ->dataset('Rating', $counts)
            ->toJSON();
    }

    public function userResultsHTML(Request $request):JsonResponse {
        $active = ActiveTest::findOrFail($request->id);
        if ($active->testing->creator_id != Auth::id())
            return response()->json(['html'=> null]);

        $view = view('testings/statistic-list', [
            'results' => $active->results()
        ])->render();

        return response()->json(['html'=> $view]);
    }
}
