<?php

class Db
{

    /**
     * 接続文字列
     */
    const DSN = 'mysql:dbname=%s;host=localhost;charset=utf8;';

    /**
     * データベース名
     */
    const DBNAME = 'sample';

    /**
     * ユーザー名
     */
    const USER_NAME = 'root';

    /**
     * パスワード
     */
    const PASSWORD = 'password';

    /**
     * PDOインスタンス
     * @var \PDO
     */
    static private $instance = null;

    /**
     * コンストラクタ
     * @access private
     */
    private function __construct()
    {
        // 外部からインスタンス化できないように、private で宣言
    }

    /**
     * インスタンスを取得
     * @return \PDO
     */
    private static function getInstance()
    {
        if (is_null(self::$instance)) {
            $options = array(
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
                , \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
                , \PDO::ATTR_AUTOCOMMIT => true
            );
            self::$instance = new \PDO(
                sprintf(self::DSN, self::DBNAME)
                , self::USER_NAME
                , self::PASSWORD
                , $options
            );
        }
        return self::$instance;
    }

    /**
     * クローン
     * @throws \Exception
     */
    final public function __clone()
    {
        $msg = sprintf('Clone is not allowed against %s', get_class($this));
        throw new \Exception($msg);
    }

    /**
     * トランザクション実行
     */
    public static function transaction()
    {
        self::getInstance()->beginTransaction();
    }

    /**
     * コミット
     */
    public static function commit()
    {
        self::getInstance()->commit();
    }

    /**
     * ロールバック
     */
    public static function rollback()
    {
        self::getInstance()->rollBack();
    }

    /**
     * SELECT実行
     * @param string $sql
     * @param array $arr
     * @return array
     */
    public static function select($sql, array $arr = array())
    {
        $stmt = self::getInstance()->prepare($sql);
        $stmt->execute($arr);
        return $stmt->fetchAll();
    }

    /**
     * INSERT実行
     * @param string $sql
     * @param array $arr
     * @return int
     */
    public static function insert($sql, array $arr)
    {
        if (!self::getInstance()->inTransaction()) {
            throw new \Exception('Not in transaction!');
        }
        $stmt = self::getInstance()->prepare($sql);
        $stmt->execute($arr);
        return self::getInstance()->lastInsertId();
    }

    /**
     * UPDATE実行
     * @param string $sql
     * @param array $arr
     * @return bool
     */
    public static function update($sql, array $arr)
    {
        if (!self::getInstance()->inTransaction()) {
            throw new \Exception('Not in transaction!');
        }
        $stmt = self::getInstance()->prepare($sql);
        return $stmt->execute($arr);
    }

    /**
     * DELETE実行
     * @param string $sql
     * @param array $arr
     */
    public static function delete($sql, array $arr)
    {
        if (!self::getInstance()->inTransaction()) {
            throw new \Exception('Not in transaction!');
        }
        $stmt = self::getInstance()->prepare($sql);
        return $stmt->execute($arr);
    }

}