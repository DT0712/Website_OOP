<?php

class Database {
    private static $conn;

    public static function getConnection() {
        if (!self::$conn) {
            $config = require __DIR__ . '/../config/config.php';

            self::$conn = new mysqli(
                $config['db']['host'],
                $config['db']['user'],
                $config['db']['pass'],
                $config['db']['dbname']
            );

            if (self::$conn->connect_error) {
                die("DB Error");
            }
        }

        return self::$conn;
    }
}