<?php

/**
 * index.php
 */

namespace MyApp;

use MyApp\controller\LoginController;
use MyApp\common\Template;

define('LAYOUT', 'index');

try {
    require_once '../common.php';
    // ログイン
    LoginController::login();
} catch (\Exception $e) {
    // 例外をテンプレートにアサインする
    Template::exception($e);
} finally {
    // テンプレートを表示
    Template::display();
}