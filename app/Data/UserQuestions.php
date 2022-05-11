<?php

namespace App\Data;

abstract class UserQuestions {

    protected $userData;
    protected array $questions = [];

    public function __construct($jsonUserData) {
        $this->userData = json_decode($jsonUserData);
        $this->prepareQuestionsData();
    }

    protected abstract function prepareQuestionsData();

    public function getQuestions():array {
        return $this->questions;
    }

    public function size():int {
        return count($this->questions);
    }
}

