<?php

namespace App;

use App\Data\Question\QuestionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model {

    use SoftDeletes;

    protected $table = 'questions';
    protected $dates = ['deleted_at'];

    public $timestamps = false;

    public function testing() {
        return $this->belongsTo(Testing::class);
    }

    public static function createWithData($textQuestion, $json, $testId):Question {
        $question = new Question();

        $question->question = $textQuestion;
        $question->json_answers = $json;
        $question->testing_id = $testId;

        $question->response_type = self::parseResponseType($json);
        return $question;
    }

    public function setData($textQuestion, $json, $testId) {
        $this->question = $textQuestion;
        $this->json_answers = $json;
        $this->testing_id = $testId;

        $this->response_type = self::parseResponseType($json);
    }

    private static function parseResponseType($json) {
        $checks = 0;
        foreach (json_decode($json) as $answer) {
            if ($answer->checked) {
                $checks++;
                if ($checks > 1) {
                    return QuestionType::MULTI;
                }
            }
        }
        return QuestionType::SINGLE;
    }
}
