<?php

namespace App;

use App\Data\ResultQuestions;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Result extends Model {

    protected $table = 'results';

    public $timestamps = false;

    protected $casts = [
        'start_time' => 'datetime:Y-m-d H:00',
        'completion_time' => 'datetime:Y-m-d H:00'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id')
            ->withDefault();
    }

    public function activateTesting() {
        return $this->belongsTo(ActiveTest::class, 'activate_id')
            ->withDefault();
    }

    public function isCompleted():bool {
        return $this->completion_time != null;
    }

    public function getResultQuestions():ResultQuestions {
        return new ResultQuestions($this->json_answers);
    }

    public function parseTotalTime():string {
        $sec = $this->completion_time->getTimestamp() - $this->start_time->getTimestamp();

        $hours = floor($sec / 3600);
        $minutes = floor(($sec / 60 ) % 60);
        $seconds = $sec % 60;

        $result = [];
        if ($hours > 0) $result[] = "$hours hour(s).";
        if ($minutes > 0) $result[] = "$minutes min.";
        if ($seconds > 0) $result[] = "$seconds sec.";

        return implode(' ', $result);
    }

    public static function create(User $user, ActiveTest $active, string $ip):Result {
        $result = new Result();

        $result->hash = $result->generateUniqueHash();
        $result->activate_id = $active->id;
        $result->user_id = $user->id;
        $result->ip = $ip;
        $result->start_time = Carbon::now();
        $result->json_answers = $result->parseNewShuffledJsonAnswers();

        return $result;
    }

    public static function generateUniqueHash():string {
        do {
            $hash = Str::random();
        } while (!empty(Result::where('hash', $hash)->first()));

        return $hash;
    }

    public function parseNewShuffledJsonAnswers():string {
        $questions = $this->activateTesting->testing->questions;
        $questions->shuffle();

        $data = [];
        foreach ($questions as $question) {
            $data[] = [
                'id' => $question->id,
                'answers' => $this->shuffleAnswerIds($question->json_answers)
            ];
        }

        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    private function shuffleAnswerIds($json):array {
        $decode = json_decode($json, true);
        $len = count($decode);

        $answersIds = [];
        for ($i = 0; $i < $len; $i++) {
            $answersIds[] = [
                'id' => $i,
                'checked' => false
            ];
        }

        shuffle($answersIds);
        return $answersIds;
    }

    public function updateAnswers($data) {
        $userData = json_decode($this->json_answers, true);

        foreach ($userData as $key => $question) {
            if (array_key_exists($key, $data)) {
                $userAnswers = $data[$key];

                foreach ($question['answers'] as $id => $answer) {
                    $checked = in_array($answer['id'], $userAnswers);
                    $userData[$key]['answers'][$id]['checked'] = $checked;
                }
            }
        }

        $this->json_answers = json_encode($userData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public function updateRating() {
        $questions = new ResultQuestions($this->json_answers);
        $this->rating = round($this->activateTesting->max_rating * ($questions->correctSize() / $questions->size()));
    }
}
