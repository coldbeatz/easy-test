<?php


namespace App\Data\Question;

class QuestionType {

    const SINGLE = 0;
    const MULTI = 1;

    public static function getCheckBoxType($ordinal) {
        switch ($ordinal) {
            case self::SINGLE:
                return "radio";
            case self::MULTI:
                return "checkbox";
        }
        return "hidden"; // такого быть не должно
    }
}
