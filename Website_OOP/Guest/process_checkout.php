<?php
session_start();
include 'config.php';

// === BƯỚC 1: KIỂM TRA ===
if (
    $_SERVER['REQUEST_METHOD'] !== 'POST' ||
    !isset($_SESSION['khach_hang']) ||
    empty($_SESSION['cart'])
) {
    header("Location: cart.php");
    exit;
}

$kh_id       = (int)$_SESSION['khach_hang']['id_khach_hang'];
$ho_ten      = trim($_POST['ho_ten']);
$dien_thoai  = trim($_POST['dien_thoai']);
$email       = trim($_POST['email'] ?? '');
$dia_chi     = trim($_POST['dia_chi']);
$ghi_chu     = trim($_POST['ghi_chu'] ?? '');
$phuong_thuc = $_POST['phuong_thuc'] ?? 'cod';

if (!in_array($phuong_thuc, ['cod', 'bank'])) {
    $phuong_thuc = 'cod';
}

// === BƯỚC 2: TÍNH TỔNG TIỀN (SỬA: dùng bảng bicycles) ===
$tong_tien = 0;

foreach ($_SESSION['cart'] as $item) {
    $id_sp    = (int)$item['id'];
    $so_luong = (int)$item['quantity'];

    $sql = "SELECT price FROM bicycles WHERE bicycle_id = ? LIMIT 1";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id_sp);
        $stmt->execute();
        $result = $stmt->get_result();

        $gia = ($result->num_rows > 0) 
            ? $result->fetch_assoc()['price'] 
            : 0;

        $tong_tien += $gia * $so_luong;
        $stmt->close();
    }
}

// === BƯỚC 3: TẠO ĐƠN HÀNG ===
$sql = "INSERT INTO don_hang 
(id_khach_hang, ho_ten, dien_thoai, email, dia_chi, ghi_chu, phuong_thuc_thanh_toan, tong_tien, trang_thai, ngay_dat)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'cho_xac_nhan', NOW())";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL lỗi: " . $conn->error);
}

$stmt->bind_param(
    "issssssd",
    $kh_id,
    $ho_ten,
    $dien_thoai,
    $email,
    $dia_chi,
    $ghi_chu,
    $phuong_thuc,
    $tong_tien
);

if (!$stmt->execute()) {
    die("Lỗi tạo đơn: " . $stmt->error);
}

$don_hang_id = $conn->insert_id;
$stmt->close();

// === BƯỚC 4: GỌI PAYMENT SERVICE ===
$paymentData = [
    "order_id" => $don_hang_id,
    "amount"   => $tong_tien,
    "method"   => $phuong_thuc
];

$ch = curl_init("http://localhost/Website_OOP/payment-service/public/");

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($paymentData),
    CURLOPT_HTTPHEADER => ['Content-Type: application/json']
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    die("Lỗi payment-service: " . curl_error($ch));
}

curl_close($ch);
// DEBUG 
if (!$response) {
    die("Payment service không trả dữ liệu");
}

$result = json_decode($response, true);

// === BƯỚC 5: LƯU CHI TIẾT ĐƠN HÀNG (SỬA: bicycle_id) ===
foreach ($_SESSION['cart'] as $item) {
    $id_sp    = (int)$item['id'];
    $so_luong = (int)$item['quantity'];

    $gia_result = $conn->query("SELECT price FROM bicycles WHERE bicycle_id = $id_sp LIMIT 1");
    $gia = ($gia_result && $gia_result->num_rows > 0)
        ? $gia_result->fetch_assoc()['price']
        : 0;

    $sql_detail = "INSERT INTO chi_tiet_don_hang 
    (id_don_hang, bicycle_id, so_luong, don_gia)
    VALUES (?, ?, ?, ?)";

    $stmt_detail = $conn->prepare($sql_detail);

    if ($stmt_detail) {
        $stmt_detail->bind_param("iiid", $don_hang_id, $id_sp, $so_luong, $gia);
        $stmt_detail->execute();
        $stmt_detail->close();
    }
}

// === BƯỚC 6: XÓA GIỎ ===
unset($_SESSION['cart']);

// === BƯỚC 7: ĐIỀU HƯỚNG ===
if (!isset($result['status'])) {
    die("Payment service lỗi response");
}

if ($result['status'] === 'success') {
    header("Location: thank_you.php?order=" . $don_hang_id);
} 
else if ($result['status'] === 'pending') {
    header("Location: bank.php?order=" . $don_hang_id);
} 
else {
    header("Location: payment_fail.php");
}

exit;
?>