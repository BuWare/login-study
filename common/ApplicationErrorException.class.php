<?php

namespace MyApp\common;

class ApplicationErrorException
{

    /**
     * コンストラクタ
     * @param type $code
     * @param \Exception $previous
     */
    public function __construct($code, \Exception $previous = null)
    {
        $message = ExceptionCode::getMessage($code);
        self::writeLog($message);
        parent::__construct('アプリケーションエラーが発生しました。', $code, $previous);
    }

    /**
     * ログを書く
     * @param type $message
     */
    static private function writeLog($message)
    {

    }

}
