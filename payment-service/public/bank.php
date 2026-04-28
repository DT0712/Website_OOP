<?php
// payment-service/public/bank.php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/services/PaymentService.php';

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

if ($order_id <= 0) {
    die("❌ Thiếu order_id");
}

// Xử lý khi user bấm "Thanh toán thành công"
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? '';

    $service = new PaymentService($conn);

    if ($action === 'success') {
        $service->markAsPaid($order_id);

        // Redirect về web chính
        header("Location: http://localhost/Website_OOP/Guest/thank_you.php?order=" . $order_id);
        exit;
    }

    if ($action === 'fail') {
        // update fail nếu muốn
        $conn->query("UPDATE payments SET status='failed' WHERE order_id=$order_id");

        header("Location: http://localhost/Website_OOP/Guest/payment_fail.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh toán ngân hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-5 text-center" style="max-width: 500px; width: 100%;">
        
        <h3 class="mb-4 text-primary">🏦 Cổng thanh toán ngân hàng</h3>

        <p class="text-muted">
            Bạn đang thanh toán đơn hàng <strong>#<?= $order_id ?></strong>
        </p>

        <hr>

        <p class="mb-4">
            (Demo) Đây là trang giả lập ngân hàng.<br>
            Chọn kết quả thanh toán:
        </p>

        <form method="POST">
            <button name="action" value="success" 
                    class="btn btn-success btn-lg w-100 mb-3">
                ✔ Thanh toán thành công
            </button>

            <button name="action" value="fail" 
                    class="btn btn-danger btn-lg w-100">
                ✖ Thanh toán thất bại
            </button>
        </form>

    </div>
</div>

</body>
</html>