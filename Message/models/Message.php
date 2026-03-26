<?php
require_once "config/database.php";

class Message {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    
    public function getConversations($user_id) {
        $query = "SELECT * FROM cuoc_hoi_thoai
                  WHERE buyer_id = :user_id OR seller_id = :user_id
                  ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function getMessages($hoi_thoai_id) {
        $query = "SELECT * FROM tin_nhan
                  WHERE hoi_thoai_id = :hoi_thoai_id
                  ORDER BY created_at ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['hoi_thoai_id' => $hoi_thoai_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function sendMessage($hoi_thoai_id, $nguoi_gui_id, $noi_dung) {
        $query = "INSERT INTO tin_nhan (hoi_thoai_id, nguoi_gui_id, noi_dung)
                  VALUES (:hoi_thoai_id, :nguoi_gui_id, :noi_dung)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            'hoi_thoai_id' => $hoi_thoai_id,
            'nguoi_gui_id' => $nguoi_gui_id,
            'noi_dung'     => $noi_dung
        ]);
    }

    
    public function createConversation($buyer_id, $seller_id, $xe_id) {

        $query = "SELECT id FROM cuoc_hoi_thoai
                  WHERE buyer_id = :buyer_id
                  AND seller_id = :seller_id
                  AND xe_id = :xe_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            'buyer_id'  => $buyer_id,
            'seller_id' => $seller_id,
            'xe_id'     => $xe_id
        ]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        
        if ($existing) {
            return $existing['id'];
        }

        
        $query = "INSERT INTO cuoc_hoi_thoai (buyer_id, seller_id, xe_id)
                  VALUES (:buyer_id, :seller_id, :xe_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            'buyer_id'  => $buyer_id,
            'seller_id' => $seller_id,
            'xe_id'     => $xe_id
        ]);
        return $this->conn->lastInsertId();
    }
}