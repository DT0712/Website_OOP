<?php
class ProductDB {
    private static $conn;

    public static function connect() {
        if (!self::$conn) {
            self::$conn = new mysqli(
                "localhost",
                "root",
                "",
                "oop_bicycle_system"   // DB sản phẩm
            );

            if (self::$conn->connect_error) {
                die("Product DB connection failed");
            }

            self::$conn->set_charset("utf8mb4");
        }
        return self::$conn;
    }
}