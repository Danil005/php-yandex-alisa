<?php

namespace yandex\alisa;

use yandex\alisa\Handler;

class Alisa extends Handler {


    /**
     * Название навыка Алисы.
     * @const String
     */
    const SKILL_NAME     = "АлиВиксед";

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
        if( $this->optionsQuestions(['привет', 'здравствуйте', 'добрый день'], $command) ) {
            $this->sendMessage(
                $this->optionsAnswers(['Приветик', 'Здравствуйте, добрый день.'])
            )->addButton("А что ты умеешь?", false, [
                'help'=>1
            ])->addButton("А еще что?", false, [
                'helpme'=>1
            ]);
            return true;
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
        if( $this->optionsCallback(['help', 'helpme'], $callback) ) {
            $this->sendMessage('Много чего! А ты?');
            return true;
        }
        return false;
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

    public function send() {
        return $this->response;
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