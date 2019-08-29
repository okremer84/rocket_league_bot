<?php

require_once 'config.php';

class DB extends PDO
{
    private static $connection = null;

    private function __construct()
    {
        if (is_null(self::$connection)) {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=latin1";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_PERSISTENT => false,
            ];
            try {
                parent::__construct($dsn, DB_USERNAME, DB_PASSWORD, $options);
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
        }
    }

    public static function get_instance() {
        if (is_null(self::$connection)) {
            self::$connection = new DB();
        }

        return self::$connection;
    }
}