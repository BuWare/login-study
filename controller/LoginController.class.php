<?php

namespace MyApp\controller;

use \MyApp\model\UserModel;
use \MyApp\common\Db;
use \MyApp\common\InvalidErrorException;
use \MyApp\common\ExceptionCode;

/**
 * UserController
 */
class LoginController
{

    /**
     * ログイン成功時の遷移先
     */
    const TARGET_PAGE = '/dashboard.php';

    /**
     * セッションに保存する名前
     */
    const LOGINUSER = 'loginUserModel';

    /**
     * メールアドレスとパスワードでログインする
     * @return void
     */
    static public function login()
    {
        // POSTされていないときは、処理を中断する
        if (!filter_input_array(INPUT_POST)) {
            return;
        }

        //フォームからの値を受け取る
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');

        // いずれかが空文字の場合何もしない
        if ('' == $email || '' == $password) {
            return;
        }

        //トランザクションを開始する
        Db::transaction();

        //  email から ユーザーモデル を取得する
        $objUserModel = new UserModel();
        $objUserModel->getModelByEmail($email);

        //  ロックされたアカウントかどうかをチェックする
        if ($objUserModel->isAccountLock()) {
            Db::commit();
            //  ロックされている
            throw new InvalidErrorException(ExceptionCode::INVALID_LOCK);
        }

        //パスワードチェック
        if (!$objUserModel->checkPassword($password)) {
            //ログイン失敗
            $objUserModel->loginFailureIncrement();
            Db::commit();
            throw new InvalidErrorException(ExceptionCode::INVALID_LOGIN_FAIL);
        }

        //  ログイン失敗をリセット
        $objUserModel->loginFailureReset();

        //コミット
        Db::commit();

        //セッション固定攻撃対策
        session_regenerate_id(true);

        //セッションに保存
        $_SESSION[self::LOGINUSER] = $objUserModel;

        //ページ遷移
        header(sprintf("location: %s", self::TARGET_PAGE));
    }

    /**
     * ログインしているかどうかチェックする
     * @return bool
     */
    static public function checkLogin()
    {
        $objUserModel = (isset($_SESSION[self::LOGINUSER])) ?
            $_SESSION[self::LOGINUSER] :
            null;

        if (is_object($objUserModel) && 0 < $objUserModel->getUserId()) {
            return;
        }
        header('Location: /');
    }

    /**
     * ログイン中のユーザーモデルを取得する
     * @return UserModel
     */
    static public function getLoginUser()
    {
        return $_SESSION[self::LOGINUSER];
    }

    /**
     * ログアウトする
     * @return void
     */
    static public function logout()
    {
        $_SESSION = [];
        session_destroy();
        header('Location: /');
    }

}
