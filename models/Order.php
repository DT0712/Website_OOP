<?php
require_once "config/database.php";

class Order {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getByBuyer($buyer_id) {
        $query = "SELECT o.*, b.name, b.price
                FROM orders o
                JOIN bicycles b ON o.bike_id = b.id
                WHERE o.buyer_id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([$buyer_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $status) {
        $query = "UPDATE orders SET status=? WHERE id=?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$status, $id]);
    }
}