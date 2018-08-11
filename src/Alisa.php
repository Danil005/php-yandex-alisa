<?php

namespace yandex\alisa;


use yandex\alisa\traits\SBlock;
use Lazer\Classes\Database as DB;


class Alisa extends Handler {

	use SBlock;

    /**
     * Версия Алисы по умолчанию.
     * @const String
     */
    const VERSION        = "1.0";

    /**
     * Стартовый текст, который будет воспроизведен при запуске навыка.
     * @var String
     */
    private $startMessage = "";

    /**
     * Стартовый текст, который будет воспроизведен синтезом речи при запуске навыка.
     * @var String
     */
    private $startMessageTTS = "";

    /**
     * Старотовые кнопки, которые будут отоброжаться при запуске навыка.
     * @var array
     */
    private $startButton = [];

    /**
     * Версия Алисы
     * @var String
     */
    private $version = self::VERSION;

    /**
     * Ответ на любые неизвестные запросы.
     * @var string
     */
    private $anyMessage = "Простите, я вас не понимаю.";

    /**
     * Чувствительность к регистру.
     * @var bool
     */
    private $caseSensitive = true;

    /**
     * Проверка на орфографию.
     * @var bool
     */
    private $speller = false;

    /**
     * Система блоков.
     * @var bool
     */
    private $blocks = false;


    /**
     * Переменная для получения ответа.
     * @var array
     */
    private $request;

    /**
     * Переменная для формирования ответа.
     * @var object
     */
    public $response;

	/**
     * Выполнять действия, которые указанны.
     * @param String $command
     *
     * @return bool
     */
    public function cmd(String $command) {
        if( $this->blocks == true ) {
            return $this->executeBlockSystem($command);
        }
        if( $command == "привет" ) {
        	$this->sendGallery([
        		[
        			"file"=>'1.jpg',
			        'title'=>'Текст',
			        'desc'=>"Описание.",
			        "options"=>[
			        	'message'=>"Тест",
			        	'payload'=>[
			        		"function"=>1
				        ]
			        ]
		        ],
		        [
			        "file"=>'2.jpg',
			        'title'=>'Текст',
			        'desc'=>"Описание.",
			        "options"=>[
				        'message'=>"Тест",
				        'payload'=>[
					        "function"=>1
				        ]
			        ]
		        ]
	        ], 'Тест', 'Привет', [
	        	'payload'=>[
	        		'function'=>"test"
		        ]
	        ]);
        }
        return false;
    }

    /**
     * Выполнить дополнительные функции Payload.
     * @param array $callback
     *
     * @return bool
     */
    public function payload(Array $callback) {
    	if( $this->blocks == true ) {
    		return $this->executePayload($callback);
	    }
        return false;
    }

    /**
     * @param $on
     *
     * @return $this
     */
    public function setBlocksActions(bool $on = true) {
        $this->blocks = $on;
        return $this;
    }

	/**
	 * Установить директорию изображений.
	 * @param String $path
	 *
	 * @return $this
	 */
    public function setImagesDir(String $path) {
    	$this->imagesDir = $path;
    	return $this;
    }

    /**
     * Установить проверку на орфографию.
     * @param bool $speller
     *
     * @return $this
     */
    public function setSpellerCorrect(bool $speller = false) {
        $this->speller = $speller;
        return $this;
    }

    /**
     * Установить чувствительность к регистру.
     * @param bool $sensitive
     *
     * @return $this
     */
    public function setCaseSensitive(bool $sensitive = true) {
        $this->caseSensitive = $sensitive;
        return $this;
    }

    /**
     * Установить значение по умолчанию, если чат-бот не смог понять,
     * что от него хотят.
     *
     * @param String $message
     *
     * @return string
     */
    public function setAny(String $message) {
        $this->anyMessage = $message;
        return $this;
    }

    /**
     * Установить стартовое сообщение.
     * @param String $message
     *
     * @return $this
     */
    public function addStartMessage(String $message) {
        $this->startMessage = $message;
        if( empty($this->startMessageTTS) ) {
            $this->startMessageTTS = $message;
        }
        return $this;
    }

    /**
     * Установить стартовое TTS-сообщение (синтез речи).
     * @param String $message
     *
     * @return $this
     */
    public function addStartTTS(String $message) {
        $this->startMessageTTS = $message;
        return $this;
    }

    /**
     * Установить кнопку, которая будут отображаться при старте навыка.
     *
     * @param String $title     - название кнопки
     * @param bool   $hide      - скрыть после нажатия. По умолчанию: false
     * @param array  $payload   - дополнительные данные, которые нужно отправить. По умолчанию: пустой массив
     * @param String $url       - ссылка на сайт. По умолчанию: null
     *
     * @return $this
     */
    public function addStartButton(String $title, bool $hide = false, Array $payload = [], String $url = null) {
        $this->startButton[] = [
            'title'=>$title,
            'payload'=>$payload,
            'url'=>$url,
            'hide'=>$hide
        ];
        return $this;
    }

    /**
     * Метод для установки версии Алисы.
     * @param String $version
     *
     * @return $this
     */
    public function setVersion(String $version = self::VERSION) {
        $this->version = $version;
        return $this;
    }

    public function addButton(String $title, bool $hide = false, Array $payload = [], String $url = null) {
        $this->response['response']['buttons'][] = [
            'title'=>$title,
            'payload'=>$payload,
            'url'=>$url,
            'hide'=>$hide
        ];
        return $this;
    }

    /**
     * Завершить сессию и закрыть навык.
     * @return bool
     */
    public function setEndMessage() {
        $this->response['response']['end_session'] = true;
        return true;
    }

    /**
     * Отправить сообщению пользователю.
     * @param String $message
     * @param String $tts
     * @param bool $speller
     *
     * @return $this
     */
    public function sendMessage(String $message, String $tts = "", bool $speller = false) {
        $msg = ( $speller == true ) ? $this->spellingCheck($message) : $message;
        $this->response = [
            'response' => [
                'text' => $msg,
                'tts'  => $tts,
                'end_session' => false
            ]
        ];
        return $this;
    }

	/**
	 * Отправить галерею.
	 * @param array  $images
	 * @param String $headerText
	 * @param String $footerText
	 * @param array  $footerOpt
	 *
	 * @return $this
	 */
    public function sendGallery(Array $images, String $headerText = "", String $footerText = "", Array $footerOpt = []) {
    	$img = DB::table('images')->findAll()->asArray();
    	$items = [];
	    $this->response['response']['card'] = [
		    "type" => "ItemsList"
	    ];

	    if( $headerText != "" ) {
	    	$this->response['response']['card']['header'] = ["text"=>$headerText];
	    }
    	foreach ($img as $image) {
    		foreach ($images as $k=>$value) {
				if ( $image['image_name'] == substr( md5( $value['file'] ), 0, 16 ) ) {
					$i[$k] = [
						"image_id"    => $image['image_id'],
						"title"       => $value['title'],
						"description" => $value['desc'],
					];
					if( $value['options']['url'] != "" ) {
						$i[$k]["button"]['url'] = $value['options']['url'];
					}
					if( $value['options']['payload'] != "" ) {
						$i[$k]["button"]['payload'] = $value['options']['payload'];
					}
					if( $value['options']['message'] != "" ) {
						$i[$k]["button"]['text'] = $value['options']['message'];
					}
					$items['items'] = $i;
				    $paths[]          = substr( md5( $value['file'] ), 0, 16 );
				}
		    }
	    }

	    $this->response['response']['card'] = array_merge($this->response['response']['card'], $items);
    	if( $footerText != "" ) $this->response['response']['card']['footer'] = ["text"=>$footerText];
    	if( $footerOpt != [] ) $this->response['response']['card']['footer'] = ["button"=>["url"=>$footerOpt['url'], "payload"=>$footerOpt['payload']]];
    	return $this;
    }

	/**
	 * Отправить изображение.
	 * @param         $path
	 * @param string  $title
	 * @param string  $description
	 * @param array   $options
	 *
	 * @return $this
	 */
    public function sendImage($path, String $title = "", String $description = "", Array $options = []) {
    	$img = DB::table('images')->findAll()->asArray();
    	foreach ($img as $key=>$value) {
    		if( $value['image_name'] == substr(md5($path), 0, 16) ) {
			    $this->response['response']['card'] =[
				    "type"        => "BigImage",
				    "image_id"    => $value['image_id'],
				    "title"       => $title,
				    "description" => $description
			    ];
			    if( $options != [] ) {
			    	$this->response['response']['card']['button'] = ['url'=>$options['url'], 'payload'=>$options['payload']];
			    }
    			return $this;
		    }
	    }
	    $mPath = substr(md5($path), 0, 16);
	    die("[ALISA]: Image \"{$mPath}\" not found. [Original: {$path}]");
    }

    /**
     * Запись пришедших данных в текстовый файл.
     *
     * @param String $data
     */
    private function logger(String $data = "") {
        if (!empty($this->request)) {
            if ($data == "") {
                $s = $this->request;
            } else {
                $s = $data;
            }
            file_put_contents(
                'alisa_log.txt',
                date('Y-m-d H:i:s') .
                PHP_EOL . $s . PHP_EOL,
                FILE_APPEND
            );
        }
    }
	protected function sendPayload(String $message, String $tts = "", array $button = []) {
		$this->sendMessage($message, $tts)->addButton($button['title'], $button['hide'], $button['payload'], $button['url']);
		unset($this->request['request']['payload']);
    }


	/**
     * Вывести переменные.
     * @param String $message
     *
     * @return mixed|String
     */
    public function printVars(String $message) {
        $words = explode(" ", $message);
        foreach ($words as $key => $value) {
            if (strstr($value, '{') && strstr($value, '}')) {
                $index = substr(strstr($value, '{'), 1,strpos($value, '}') - 1);
                if( array_key_exists($index, $this->vars) ) {
                    $message = str_replace("{" . $index . "}", $this->vars[$index], $message);
                } else {
                    die("[JSON_BLOCKS#3] Fatal Error: vars {".$index."} not found.");
                }
            }
        }

        return $message;
    }


    /**
     * Прослушивать все запросы, которые приходят на сервер.
     *
     * @return bool|null
     */
    public function listen() {
        $this->request = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        if( isset(
            $this->request['request'],
            $this->request['request']['command'],
            $this->request['session'],
            $this->request['session']['session_id'],
            $this->request['session']['message_id'],
            $this->request['session']['user_id']
        ) ) {
            $this->logger();

            if( $this->speller == true ) {
                $this->request['request']['command'] = $this->spellingCheck($this->request['request']['command']);
            }

            if ( $this->request['request']['command'] == "" ) {
                $this->response = [
                    'response' => [
                        'text' => $this->startMessage,
                        'tts'  => $this->startMessageTTS,
                        'buttons' => $this->startButton,
                        'end_session' => false
                    ]
                ];
            } else {
                if( $this->caseSensitive == true  ) {
                    $command = $this->request['request']['command'];
                } else {
                    $command = mb_strtolower($this->request['request']['command']);
                }
                if ( !$this->cmd($command) ) {
                    $this->response['response']['text'] = $this->anyMessage;
                };
            }

            $this->response = array_merge($this->response,
                [
                    'session' => [
                        'session_id' => $this->request['session']['session_id'],
                        'message_id' => $this->request['session']['message_id'],
                        'user_id' => $this->request['session']['user_id']
                    ],
                    'version' => "{$this->version}"
                ]
            );
            echo json_encode($this->response);
            return true;
        } elseif( $this->request['request']['type'] == "ButtonPressed" ) {
            $this->response = [];
            if ( !$this->payload($this->request['request']['payload']) ) {
                $this->response['response']['text'] = $this->anyMessage;
            };

            $this->response = array_merge($this->response,
                [
                    'session' => [
                        'session_id' => $this->request['session']['session_id'],
                        'message_id' => $this->request['session']['message_id'],
                        'user_id' => $this->request['session']['user_id']
                    ],
                    'version' => "{$this->version}"
                ]
            );
            echo json_encode($this->response);
            return true;
        } else {
            echo $this->response = json_encode([]);
            return false;
        }
    }
}