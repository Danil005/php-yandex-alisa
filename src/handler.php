<?php

namespace yandex\alisa;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

define('LAZER_DATA_PATH', realpath( __DIR__).'../../blocks');

class Handler {

	/**
	 * Файловая система.
	 * @var \League\Flysystem\Filesystem
	 */
	public $files;

	/**
     * Переменная для обработки Prepare-функции.
     * @var array
     */
    public $vars = [];


	/**
	 * Переменные отправленные на payload c текста.
	 * @var array
	 */
    public $varsPayload = [];

	/**
	 * Handler constructor.
	 */

	public function __construct() {
		$this->files = new Filesystem(new Local(__DIR__ .  "../../blocks"), ['visibility' => 'public']);
	}


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
     * @param int   $type
     *
     * @return mixed|int
     */
    protected function optionsAnswers(Array $list, int $type = 0) {
    	if( $type == 0 ) {
		    $randomMessage = $list[ rand( 0, count( $list ) - 1 ) ];

		    return $randomMessage;
	    } else {
    		return rand( 0, count( $list ) - 1);
	    }
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
     * Подготовленные запросы.
     * @param        $getMessage
     * @param String $command
     *
     * @return bool
     */
    protected function prepare($getMessage, String $command) {
        $var = []; $math = "";
        if( !is_array($getMessage) ) {
            $words = explode(" ", $getMessage);
            $wordsCommand = explode(" ", $command);
	
	
            $s = array_diff($wordsCommand, $words);
	
            foreach ($words as $key => $value) {
                if (strstr($value, '{') && strstr($value, '}')) {
                    $index = substr(strstr($value, '{'), 1,strpos($value, '}') - 1);
                    $var[$index] = $s[$key];
                    $words[$key] = ".*";
                }
            }
            foreach ($words as $key=>$value) {
                if( array_key_exists($key+1, $words) ) {
                    $math .= $value. " ";
                } else {
                    $math .= $value. "";
                }
            }
            $math = "/".$math."/";
            if( preg_match($math, $command) ) {
                $this->vars = $var;
                return true;
            }
        } else {
        	foreach ($getMessage as $k=>$msg) {
        		$math = "";
		        $words = explode(" ", $msg);
		        $wordsCommand = explode(" ", $command);


		        $s = array_diff($wordsCommand, $words);

		        foreach ($words as $key => $value) {
			        if (strstr($value, '{') && strstr($value, '}')) {
				        $index = substr(strstr($value, '{'), 1,strpos($value, '}') - 1);
				        $var[$index] = $s[$key];
				        $words[$key] = ".*";
			        }
		        }
		        foreach ($words as $key=>$value) {
			        if( array_key_exists($key+1, $words) ) {
				        $math .= $value. " ";
			        } else {
				        $math .= $value. "";
			        }
		        }
		        $math = "/".$math."/";
		        if( preg_match($math, $command) ) {
			        $this->vars = $var;
			        return true;
		        } else {
		        	continue;
		        }
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
    protected function objectToArray($d) {
        return json_decode(json_encode(json_decode($d)), true);
    }


    /**
     * Проверка на орфографию и исправление.
     * @param String $message
     *
     * @return mixed|String
     */
    protected function spellingCheck(String $message) {
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

	/**
	 * Файловая система.
	 *
	 * @param $path
	 *
	 * @return \League\Flysystem\Filesystem
	 */
    public function read($path) {
    	return $this->files->read($path);
    }
}