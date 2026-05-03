<?php 
include 'config.php';
/** @var mysqli $conn */
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý Liên hệ & Feedback</title>

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

<!-- ======================== LIÊN HỆ ======================== -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Quản lý Liên hệ</h3>
</div>

<div class="card shadow-sm border-0 mb-5">
<div class="card-body">

<div class="table-responsive">
<table class="table table-hover align-middle">

<thead class="table-light">
<tr>
    <th>ID</th>
    <th>Khách hàng</th>
    <th>Nội dung</th>
    <th>Ngày gửi</th>
    <th>Trạng thái</th>
    <th>Hành động</th>
</tr>
</thead>

<tbody>

<?php
$sql = "SELECT * FROM lien_he ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $status_class = ($row['trang_thai'] == 'Đã phản hồi')
            ? 'bg-success'
            : 'bg-warning text-dark';

        echo "<tr>
            <td>#{$row['id']}</td>

            <td>
                <strong>" . htmlspecialchars($row['ho_ten']) . "</strong><br>
                <small class='text-muted'>" . htmlspecialchars($row['email']) . "</small>
            </td>

            <td>" . htmlspecialchars(mb_substr($row['noi_dung'], 0, 50)) . "...</td>

            <td>" . date('d/m/Y H:i', strtotime($row['ngay_gui'])) . "</td>

            <td>
                <span class='badge {$status_class}'>{$row['trang_thai']}</span>
            </td>

            <td>
                <a href='admin_contact_detail.php?id={$row['id']}'
                   class='btn btn-sm btn-info text-white'>
                   Xem
                </a>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='6' class='text-center'>Không có dữ liệu</td></tr>";
}
?>

</tbody>
</table>
</div>

</div>
</div>


<!-- ======================== FEEDBACK ======================== -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Feedback khách hàng</h3>
</div>

<div class="card shadow-sm border-0">
<div class="card-body">

<div class="table-responsive">
<table class="table table-hover align-middle">

<thead class="table-light">
<tr>
    <th>ID</th>
    <th>Người gửi</th>
    <th>Tiêu đề</th>
    <th>Nội dung</th>
    <th>Ngày gửi</th>
    <th>Hành động</th>
</tr>
</thead>

<tbody>

<?php
$sql_fb = "SELECT * FROM feedback ORDER BY id DESC";
$result_fb = mysqli_query($conn, $sql_fb);

if ($result_fb && mysqli_num_rows($result_fb) > 0) {
    while ($row = mysqli_fetch_assoc($result_fb)) {

        echo "<tr>
            <td>#{$row['id']}</td>

            <td>
                <strong>" . htmlspecialchars($row['name']) . "</strong><br>
                <small class='text-muted'>" . htmlspecialchars($row['email']) . "</small>
            </td>

            <td>" . htmlspecialchars($row['subject']) . "</td>

            <td>" . htmlspecialchars(mb_substr($row['message'], 0, 50)) . "...</td>

            <td>" . date('d/m/Y H:i', strtotime($row['created_at'])) . "</td>

            <td>
                <a href='admin_feedback_detail.php?id={$row['id']}'
                   class='btn btn-sm btn-primary'>
                   Xem
                </a>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='6' class='text-center'>Chưa có feedback</td></tr>";
}
?>

</tbody>
</table>
</div>

</div>
</div>

</div>

</body>
</html>