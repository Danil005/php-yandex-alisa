<?php

namespace yandex\alisa;

class handler {


    protected function optionsQuestions(Array $list, String $command) {
        foreach ($list as $options) {
            if( $command == $options ) return true;
        }
        return false;
    }

    protected function optionsAnswers(Array $list) {
        $randomMessage = $list[rand(0, count($list)-1)];
        return $randomMessage;
    }
}