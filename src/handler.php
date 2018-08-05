<?php

namespace yandex\alisa;

class handler {


    /**
     * Вариация вопросов.
     * @param array  $list
     * @param String $command
     *
     * @return bool
     */
    protected function optionsQuestions(Array $list, String $command) {
        foreach ($list as $options) {
            if( $command == $options ) return true;
        }
        return false;
    }

    /**
     * Вариация ответов.
     * @param array $list
     *
     * @return mixed
     */
    protected function optionsAnswers(Array $list) {
        $randomMessage = $list[rand(0, count($list)-1)];
        return $randomMessage;
    }

    /**
     * Опциональный выбор Callback (Операция ИЛИ)
     * @param array $list
     * @param array $callback
     *
     * @return bool
     */
    protected function optionsCallback(Array $list, Array $callback) {
        foreach ($list as $options) {
            foreach ($callback as $name=>$value) {
                if( $options == $name ) return true;
            }
        }
        return false;
    }

    /**
     * Преобразовывает объект в массив.
     * @param $d
     *
     * @return array|Object
     */
    function objectToArray($d) {
        return json_decode(json_encode(json_decode($d)), true);
    }

    /**
     * Проверка на орфографию и исправление.
     * @param String $message
     *
     * @return mixed|String
     */
    public function spellingCheck(String $message) {
        $ch = curl_init();
        $options = [
            CURLOPT_URL => "https://speller.yandex.net/services/spellservice.json/checkText",
            CURLOPT_POST => TRUE,
            CURLOPT_POSTFIELDS => "text=".$message."&format=html&lang=ru",
            CURLOPT_RETURNTRANSFER => TRUE
        ];
        curl_setopt_array($ch, $options);
        $r=$this->objectToArray(curl_exec($ch));

        if (curl_errno($ch)) {
            echo curl_error($ch)."\n";
        }
        curl_close($ch);
        foreach ($r as $value) {
            $word = $value['word'];
            $change = $value['s'][0];
            $message = str_replace($word, $change, $message);
        }
        return $message;
    }
}