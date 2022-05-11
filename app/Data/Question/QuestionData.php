<?php

namespace App\Data\Question;

use App\Question;

abstract class QuestionData {

    protected Question $question;
    protected array $userAnswers;

    protected array $answers = [];

    private string $text;
    private string $inputType;

    public function __construct(Question $question, $userAnswers, $check = false) {
        $this->question = $question;
        $this->userAnswers = $userAnswers;

        $this->text = $question->question;
        $this->inputType = QuestionType::getCheckBoxType($question->response_type);

        $this->init($check);
    }

    public function getText():string {
        return $this->text;
    }

    public function getInputType():string {
        return $this->inputType;
    }

    public function getAnswers():array {
        return $this->answers;
    }

    public abstract function init(bool $check = false):void;
}
