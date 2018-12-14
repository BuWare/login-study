<?php

namespace MyApp\common;

class InvalidErrorException extends \Exception
{

    public function __construct($code, \Exception $previous = null)
    {
        $message = ExceptionCode::getMessage($code);
        parent::__construct($message, $code, $previous);
    }

}