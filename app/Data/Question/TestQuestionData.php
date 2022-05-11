<?php

namespace App\Data\Question;

class TestQuestionData extends QuestionData {

    public function init(bool $check = false):void {
        $json = json_decode($this->question->json_answers);

        foreach ($this->userAnswers as $answer) {
            $temp = $json[$answer->id];
            $temp->id = $answer->id;

            $this->answers[] = $temp;
        }
    }
}
