<?php

namespace App\Data\Question;

class ResultQuestionData extends QuestionData {

    private bool $correctQuestion = true;

    public function init(bool $check = false):void {
        $json = json_decode($this->question->json_answers);

        foreach ($this->userAnswers as $answer) {
            $temp = $json[$answer->id];
            $temp->userChecked = $answer->checked;
            $temp->id = $answer->id;

            if ($answer->checked === $temp->checked) {
                $temp->state = 'correct';
                $temp->isCorrect = true;
            } else {
                $temp->state = $answer->checked ? 'incorrect' : 'missing';
                $temp->isCorrect = false;
                $temp->checked = true;

                if ($this->correctQuestion)
                    $this->correctQuestion = false;
            }
            $this->answers[] = $temp;
        }
    }

    public function isCorrectQuestion():bool {
        return $this->correctQuestion;
    }
}
