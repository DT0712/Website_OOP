<?php
require_once "config.php";

class Order {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function getByBuyer($buyer_id) {
        $query = "SELECT o.*, b.name, b.price, b.main_image
                FROM orders o
                JOIN bicycles b ON o.bike_id = b.id
                WHERE o.buyer_id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $buyer_id);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateDeposit($id, $amount) {
        $query = "UPDATE orders 
                SET deposit_amount = ?, status = 'deposit_paid'
                WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("di", $amount, $id);
        return $stmt->execute();
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
        $stmt->bind_param("i", $buyer_id);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function cancelOrder($id) {
        $sql = "UPDATE orders 
                SET status = 'cancelled' 
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getById($id) {
        $sql = "SELECT * FROM orders WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}