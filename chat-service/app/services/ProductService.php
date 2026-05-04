<?php
require_once __DIR__ . '/ProductDB.php';

class ProductService {

    public static function findProductByName($message) {
        $conn = ProductDB::connect();

        // lấy toàn bộ sản phẩm
        $result = $conn->query(
            "SELECT bicycle_id, name, price, description FROM bicycles"
        );

        $message = strtolower($message);

        while($row = $result->fetch_assoc()) {

            $productName = strtolower($row['name']);

            // nếu tên sản phẩm nằm trong câu hỏi → MATCH
            if (str_contains($message, $productName)) {
                return $row;
            }
        }

        return null;
    }
}