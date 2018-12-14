<?php

namespace MyApp\common;

/**
 * ExceptionCode.class.php
 * @since 2015/07/25
 */
class ExceptionCode
{

    /**
     * エラーコード
     */
    const INVALID_ERR = 1000;
    const INVALID_LOCK = 1001;
    const INVALID_LOGIN_FAIL = 1002;
    const APPLICATION_ERR = 2000;
    const SYSTEM_ERR = 3000;
    const TEMPLATE_ERR = 3001;
    const TEMPLATE_ARG_ERR = 3002;

    /**
     * エラーメッセージ
     * @var array<string>
     */
    private static $_arrMessage = array(
        self::INVALID_ERR => 'エラーが発生しました。'
        , self::INVALID_LOCK => 'アカウントがロックされています。'
        , self::INVALID_LOGIN_FAIL => 'ログインに失敗しました。'
        , self::APPLICATION_ERR => 'アプリケーション・エラーが発生しました。'
        , self::SYSTEM_ERR => 'システム・エラーが発生しました。'
        , self::TEMPLATE_ERR => 'テンプレート[%s]が見つかりません。'
        , self::TEMPLATE_ARG_ERR => '引数に[%s]は利用できません。'
    );

    /**
     * エラーメッセージを取得する
     * @param int $intCode
     * @return string
     */
    static public function getMessage($intCode)
    {
        if (array_key_exists($intCode, self::$_arrMessage)) {
            return self::$_arrMessage[$intCode];
        }
    }

}