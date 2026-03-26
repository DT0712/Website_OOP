<?php
require_once "config/database.php";

class Order {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getByBuyer($buyer_id) {
        $query = "SELECT o.*, b.name, b.price, b.main_image
                FROM orders o
                JOIN bicycles b ON o.bike_id = b.id
                WHERE o.buyer_id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([$buyer_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateDeposit($id, $amount) {
        $query = "UPDATE orders 
                SET deposit_amount = ?, status = 'deposit_paid'
                WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$amount, $id]);
    }

    public function getPurchasedBrands($buyer_id) {
        $sql = "SELECT br.name, COUNT(*) as total
                FROM orders o
                JOIN bicycles b ON o.bike_id = b.id
                JOIN brands br ON b.brand_id = br.id
                WHERE o.buyer_id = ?
                AND o.status IN ('deposit_paid', 'completed')
                GROUP BY br.id, br.name
                ORDER BY total DESC
                LIMIT 5";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$buyer_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cancelOrder($id) {
        $sql = "UPDATE orders 
                SET status = 'cancelled' 
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function getById($id) {
        $sql = "SELECT * FROM orders WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}