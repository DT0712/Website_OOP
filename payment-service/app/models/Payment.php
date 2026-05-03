<?php

class Payment {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // === TẠO PAYMENT ===
    public function create($order_id, $method, $amount, $status) {

        $sql = "INSERT INTO payments 
                (order_id, method, amount, status) 
                VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("SQL error: " . $this->conn->error);
        }

        $stmt->bind_param("isds", 
            $order_id,  // i
            $method,    // s
            $amount,    // d
            $status     // s
        );

        if (!$stmt->execute()) {
            throw new Exception("Insert payment failed: " . $stmt->error);
        }

        return $this->conn->insert_id;
    }

    // === UPDATE STATUS ===
    public function updateStatus($order_id, $status) {

        $sql = "UPDATE payments 
                SET status = ?, updated_at = NOW() 
                WHERE order_id = ?";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("SQL error: " . $this->conn->error);
        }

        $stmt->bind_param("si", $status, $order_id);

        return $stmt->execute();
    }

    // === LẤY PAYMENT THEO ORDER ===
    public function findByOrderId($order_id) {

        $sql = "SELECT * FROM payments 
                WHERE order_id = ? 
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("SQL error: " . $this->conn->error);
        }

        $stmt->bind_param("i", $order_id);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }
}