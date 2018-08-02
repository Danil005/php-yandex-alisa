<?php

namespace yandex\alisa;

class Alisa {

    private $request;
    public $response;

    /**
     * Запись пришедших данных в текстовый файл.
     */
    private function logger() {
        if( !empty($this->request) ) {
            file_put_contents(
                'alisa_log.txt',
                date('Y-m-d H:i:s') .
                PHP_EOL . $this->request . PHP_EOL,
                FILE_APPEND
            );
        }
    }

    /**
     * Прослушивать все запросы, которые приходят на сервер.
     *
     * @return array
     */
    public function listen() {
        $this->request = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        if( isset(
            $data['request'],
            $data['request']['command'],
            $data['session'],
            $data['session']['session_id'],
            $data['session']['message_id'],
            $data['session']['user_id']
        ) ) {
            $this->logger();
            return $this->response;
        } else {
            $this->response = json_encode([]);
        }
    }
}