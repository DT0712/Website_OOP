<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/services/PaymentService.php';

$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;

if ($order_id <= 0) {
    die("Thiếu order_id");
}

// ===== KIỂM TRA PAYMENT CÓ TỒN TẠI =====
$result = $conn->query("SELECT * FROM payments WHERE order_id = $order_id LIMIT 1");

if (!$result || $result->num_rows === 0) {
    die("Không tìm thấy giao dịch");
}

$service = new PaymentService($conn);

// ===== XỬ LÝ POST =====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? '';

    if ($action === 'success') {

        $service->markAsPaid($order_id);

        header("Location: http://localhost/Website_OOP/Guest/thank_you.php?order=" . $order_id);
        exit;
    }

    if ($action === 'fail') {

        $stmt = $conn->prepare("UPDATE payments SET status='failed' WHERE order_id=?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $stmt->close();

        header("Location: http://localhost/Website_OOP/Guest/payment_fail.php");
        exit;
    }
}
?>