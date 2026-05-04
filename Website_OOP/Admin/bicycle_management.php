<?php
session_start();
/** @var mysqli $conn */
include 'config.php';

$current_page = basename($_SERVER['PHP_SELF']);

// ====================== XÓA XE ======================
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    mysqli_query($conn, "DELETE FROM bicycles WHERE bicycle_id = $id");

    header("Location: bicycle_management.php");
    exit();
}

// ====================== TÌM KIẾM ======================
$search = $_GET['search'] ?? '';

$sql = "SELECT * FROM bicycles WHERE name LIKE '%$search%' ORDER BY bicycle_id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý xe đạp</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    margin: 0;
    display: flex;
    background: #f4f6fb;
}

/* Sidebar */
.sidebar {
    width: 250px;
    min-height: 100vh;
    background: white;
    box-shadow: 0 0 20px rgba(0,0,0,.05);
}

/* Nội dung */
.main-content {
    flex: 1;
    padding: 25px 30px;
}

/* Card */
.card {
    border-radius: 12px;
}

/* Ảnh */
.bike-img {
    width: 80px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
}

/* Badge */
.badge-status {
    font-size: 12px;
}
</style>
</head>

<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Quản lý xe đạp</h2>

        <a href="bicycle_add.php" class="btn btn-primary">
            + Thêm xe
        </a>
    </div>

    <!-- SEARCH -->
    <form method="GET" class="mb-3">
        <div class="input-group" style="max-width:400px;">
            <input type="text" name="search"
                   value="<?= htmlspecialchars($search) ?>"
                   class="form-control"
                   placeholder="Tìm tên xe...">

            <button class="btn btn-outline-primary">
                Tìm
            </button>
        </div>
    </form>

    <!-- TABLE -->
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Ảnh</th>
                            <th>Tên xe</th>
                            <th>Giá</th>
                            <th>Tình trạng</th>
                            <th>Địa điểm</th>
                            <th>Ngày đăng</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>

                    <tbody>

<?php
if (!$result) {
    echo "<tr><td colspan='8' class='text-danger text-center'>
            Lỗi SQL: " . mysqli_error($conn) . "
          </td></tr>";
}
elseif (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {

        $status_badge = "bg-success";
        if (strpos($row['condition_status'], 'Đã') !== false) {
            $status_badge = "bg-warning text-dark";
        }

        echo "<tr>
                <td>#{$row['bicycle_id']}</td>

                <td>
                    <img src='{$row['main_image']}' class='bike-img'>
                </td>

                <td>
                    <strong>" . htmlspecialchars($row['name']) . "</strong>
                </td>

                <td class='text-danger fw-bold'>
                    " . number_format($row['price']) . "đ
                </td>

                <td>
                    <span class='badge {$status_badge} badge-status'>
                        {$row['condition_status']}
                    </span>
                </td>

                <td>{$row['location']}</td>

                <td>" . date('d/m/Y', strtotime($row['created_at'])) . "</td>

                <td>
                    <a href='bicycle_edit.php?id={$row['bicycle_id']}'
                       class='btn btn-sm btn-warning'>
                        Sửa
                    </a>

                    <a href='?delete={$row['bicycle_id']}'
                       onclick='return confirm(\"Xóa xe này?\")'
                       class='btn btn-sm btn-danger'>
                        Xóa
                    </a>
                </td>
            </tr>";
    }

} else {
    echo "<tr>
            <td colspan='8' class='text-center text-muted'>
                Không có dữ liệu
            </td>
          </tr>";
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