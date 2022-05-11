<?php

namespace App\Data;

use App\Data\Question\TestQuestionData;
use App\Question;

class TestQuestions extends UserQuestions {

    protected function prepareQuestionsData():void {
        foreach ($this->userData as $questionData) {
            $question = Question::find($questionData->id);

            $data = new TestQuestionData($question, $questionData->answers);
            $this->questions[] = $data;
        }
    }
}
