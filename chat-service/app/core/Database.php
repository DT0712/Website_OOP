<?php
class Database {

    public static function connect() {

        $config = require __DIR__ . '/../config/config.php';
        $db = $config['db'];

        $conn = new mysqli(
            $db['host'],
            $db['user'],
            $db['pass'],
            $db['name']
        );

        if ($conn->connect_error) {
            die("DB Connection Error");
        }

        $conn->set_charset("utf8mb4");
        return $conn;
    }
}