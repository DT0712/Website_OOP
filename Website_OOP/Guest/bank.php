<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// ===== LẤY ORDER ID =====
$order_id = isset($_GET['order']) ? (int)$_GET['order'] : 0;

if ($order_id <= 0) {
    die("❌ Thiếu order_id");
}

// ===== XỬ LÝ KHI SUBMIT =====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? '';

    if (!in_array($action, ['success', 'fail'])) {
        die("❌ Action không hợp lệ");
    }

    $status = ($action === 'success') ? 'success' : 'failed';

    // ===== GỌI PAYMENT SERVICE =====
    $ch = curl_init("http://localhost/Website_OOP/payment-service/public/index.php");

    $data = [
        "order_id" => $order_id,
        "status"   => $status
    ];

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => ['Content-Type: application/json']
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        die("❌ Lỗi curl: " . curl_error($ch));
    }

    curl_close($ch);

    $result = json_decode($response, true);

    // DEBUG nếu lỗi
    if (!$result) {
        die("❌ JSON lỗi: " . $response);
    }

    if ($result['status'] !== 'success') {
        die("❌ Payment service lỗi: " . $response);
    }

    // ===== REDIRECT =====
    if ($status === 'success') {
        header("Location: thank_you.php?order=" . $order_id);
    } else {
        header("Location: payment_fail.php");
    }

    exit;
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
            Bạn đang thanh toán đơn hàng 
        </p>

        <hr>

        <p class="mb-4">
            Chọn kết quả thanh toán:
        </p>

        <form method="POST">
            <button name="action" value="success" 
                    class="btn btn-success btn-lg w-100 mb-3">
                Thanh toán thành công
            </button>

            <button name="action" value="fail" 
                    class="btn btn-danger btn-lg w-100">
                Thanh toán thất bại
            </button>
        </form>

    </div>
</div>

</body>
</html>