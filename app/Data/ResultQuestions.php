<?php

namespace App\Data;

use App\Data\Question\ResultQuestionData;
use App\Question;

class ResultQuestions extends UserQuestions {

    private int $correctQuestionsCount = 0;

    protected function prepareQuestionsData():void {
        foreach ($this->userData as $questionData) {
            $question = Question::find($questionData->id);

            $data = new ResultQuestionData($question, $questionData->answers);
            $this->questions[] = $data;

            if ($data->isCorrectQuestion()) {
                $this->correctQuestionsCount++;
            }
        }
    }

    public function correctSize():int {
        return $this->correctQuestionsCount;
    }

    public function getRatingPercent() {
        return number_format($this->correctSize() / $this->size() * 100, 1);
    }
}
