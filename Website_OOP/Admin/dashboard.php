<?php
session_start();
include 'config.php';
/** @var mysqli $conn */

$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
    border-radius: 15px;
    transition: 0.3s;
}
.card:hover {
    transform: translateY(-5px);
}

/* Background */
.bg-1 { background: linear-gradient(135deg,#667eea,#764ba2); }
.bg-2 { background: linear-gradient(135deg,#f093fb,#f5576c); }
.bg-3 { background: linear-gradient(135deg,#4facfe,#00f2fe); }

/* Fix chiều cao chart */
canvas {
    max-height: 300px;
}
</style>

</head>

<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">

<?php
// ====================== 1. THỐNG KÊ ======================

// Tổng đơn hàng
$total_orders = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) AS total FROM don_hang"
))['total'] ?? 0;

// Tổng doanh thu
$total_revenue = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COALESCE(SUM(tong_tien),0) AS total FROM don_hang"
))['total'] ?? 0;

// Đơn hôm nay
$today_orders = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) AS total FROM don_hang WHERE DATE(ngay_dat) = CURDATE()"
))['total'] ?? 0;


// ====================== 2. DOANH THU 7 NGÀY ======================
$labels = [];
$data   = [];

$query = mysqli_query($conn, "
    SELECT DATE(ngay_dat) AS ngay, SUM(tong_tien) AS total
    FROM don_hang
    WHERE ngay_dat >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
    GROUP BY DATE(ngay_dat)
    ORDER BY ngay
");

while ($row = mysqli_fetch_assoc($query)) {
    $labels[] = $row['ngay'];
    $data[]   = (int)$row['total'];
}


// ====================== 3. TOP 5 XE BÁN CHẠY ======================
$top_labels = [];
$top_data   = [];

$top_query = mysqli_query($conn, "
    SELECT b.name, SUM(ct.so_luong) AS total
    FROM chi_tiet_don_hang ct
    JOIN bicycles b ON ct.bicycle_id = b.bicycle_id
    GROUP BY ct.bicycle_id
    ORDER BY total DESC
    LIMIT 5
");

while ($row = mysqli_fetch_assoc($top_query)) {
    $top_labels[] = $row['name'];
    $top_data[]   = (int)$row['total'];
}
?>

<h2 class="mb-4 fw-bold">Dashboard hệ thống</h2>

<!-- ====================== CARD ====================== -->
<div class="row g-4 mb-5">

    <div class="col-md-4">
        <div class="card text-white bg-1 shadow h-100">
            <div class="card-body text-center">
                <h5>Tổng đơn hàng</h5>
                <h2><?= $total_orders ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white bg-2 shadow h-100">
            <div class="card-body text-center">
                <h5>Doanh thu</h5>
                <h2><?= number_format($total_revenue) ?>đ</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white bg-3 shadow h-100">
            <div class="card-body text-center">
                <h5>Đơn hôm nay</h5>
                <h2><?= $today_orders ?></h2>
            </div>
        </div>
    </div>

</div>


<!-- ====================== CHART ====================== -->
<div class="row g-4 mb-5">

    <!-- Line -->
    <div class="col-lg-6">
        <div class="card shadow h-100">
            <div class="card-header bg-primary text-white text-center">
                Doanh thu 7 ngày gần nhất
            </div>
            <div class="card-body">
                <canvas id="chart1"></canvas>
            </div>
        </div>
    </div>

    <!-- Bar -->
    <div class="col-lg-6">
        <div class="card shadow h-100">
            <div class="card-header text-white text-center"
                 style="background:linear-gradient(135deg,#667eea,#764ba2);">
                Top 5 xe bán chạy
            </div>
            <div class="card-body">
                <canvas id="chart3"></canvas>
            </div>
        </div>
    </div>

</div>

</div>


<script>
// ===== LINE =====
new Chart(document.getElementById('chart1'), {
    type: 'line',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            label: 'Doanh thu',
            data: <?= json_encode($data) ?>,
            borderColor: '#007bff',
            backgroundColor: 'rgba(0,123,255,0.1)',
            fill: true,
            tension: 0.4
        }]
    }
});

// ===== BAR =====
new Chart(document.getElementById('chart3'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($top_labels) ?>,
        datasets: [{
            label: 'Số lượng bán',
            data: <?= json_encode($top_data) ?>,
            backgroundColor: '#5b5ce2'
        }]
    }
});
</script>

</body>
</html>