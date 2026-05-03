<?php 
include 'config.php';
/** @var mysqli $conn */
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Chi tiết Feedback</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    margin: 0;
    display: flex;
    background: #f4f6fb;
}

.sidebar {
    width: 250px;
    min-height: 100vh;
    background: white;
    box-shadow: 0 0 20px rgba(0,0,0,.05);
}

.main-content {
    flex: 1;
    padding: 25px 30px;
}

.card {
    border-radius: 12px;
}
</style>
</head>

<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">

<?php
// Kiểm tra ID
if (!isset($_GET['id'])) {
    header('Location: admin_contacts.php');
    exit();
}

$id = intval($_GET['id']);

// Lấy dữ liệu feedback
$sql = "SELECT * FROM feedback WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<div class='alert alert-danger'>Không tìm thấy feedback.</div>";
    exit;
}

$msg = mysqli_fetch_assoc($result);
?>

<!-- Nút quay lại -->
<a href="admin_contacts.php" class="btn btn-secondary mb-3">
    ← Quay lại
</a>

<div class="row justify-content-center">
<div class="col-md-8">

<div class="card shadow-sm border-0">

<div class="card-header bg-white py-3">
    <h5 class="m-0 text-primary">
        Chi tiết Feedback #<?= $id ?>
    </h5>
</div>

<div class="card-body">

    <!-- Thông tin -->
    <div class="mb-4 p-3 bg-light rounded">

        <p><strong>Người gửi:</strong> 
            <?= htmlspecialchars($msg['name']) ?>
        </p>

        <p><strong>Email:</strong> 
            <?= htmlspecialchars($msg['email']) ?>
        </p>

        <p><strong>Tiêu đề:</strong> 
            <?= htmlspecialchars($msg['subject']) ?>
        </p>

        <p><strong>Ngày gửi:</strong> 
            <?= date('d/m/Y H:i', strtotime($msg['created_at'])) ?>
        </p>

        <hr>

        <p><strong>Nội dung:</strong></p>
        <p class="fst-italic">
            "<?= nl2br(htmlspecialchars($msg['message'])) ?>"
        </p>

    </div>

    <!-- Ghi chú -->
    <div class="alert alert-info">
        Feedback chỉ dùng để tham khảo, không có chức năng phản hồi trực tiếp.
    </div>

</div>

</div>

</div>
</div>

</div>

</body>
</html>