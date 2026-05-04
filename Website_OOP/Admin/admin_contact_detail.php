<?php 
include 'config.php';
/** @var mysqli $conn */
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Chi tiết liên hệ</title>

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

// Lấy dữ liệu
$sql = "SELECT * FROM lien_he WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<div class='alert alert-danger'>Không tìm thấy liên hệ.</div>";
    exit;
}

$msg = mysqli_fetch_assoc($result);

// Xử lý phản hồi
if (isset($_POST['btn_reply'])) {

    $phan_hoi = mysqli_real_escape_string($conn, $_POST['phan_hoi']);

    $sql_update = "UPDATE lien_he SET
                    phan_hoi = '$phan_hoi',
                    trang_thai = 'Đã phản hồi'
                   WHERE id = $id";

    if (mysqli_query($conn, $sql_update)) {
        echo "<div class='alert alert-success'>Đã lưu phản hồi thành công!</div>";

        // reload lại data mới
        $result = mysqli_query($conn, "SELECT * FROM lien_he WHERE id = $id");
        $msg = mysqli_fetch_assoc($result);
    } else {
        echo "<div class='alert alert-danger'>Lỗi: " . mysqli_error($conn) . "</div>";
    }
}
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
                        Chi tiết liên hệ #<?= $id ?>
                    </h5>
                </div>

                <div class="card-body">

                    <!-- Thông tin -->
                    <div class="mb-4 p-3 bg-light rounded">
                        <p><strong>Người gửi:</strong> <?= htmlspecialchars($msg['ho_ten']) ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($msg['email']) ?></p>
                        <p><strong>Ngày gửi:</strong> <?= date('d/m/Y H:i', strtotime($msg['ngay_gui'])) ?></p>

                        <hr>

                        <p><strong>Nội dung:</strong></p>
                        <p class="fst-italic">
                            "<?= nl2br(htmlspecialchars($msg['noi_dung'])) ?>"
                        </p>
                    </div>

                    <!-- Form phản hồi -->
                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Phản hồi của Admin:
                            </label>

                            <textarea 
                                name="phan_hoi"
                                class="form-control"
                                rows="5"
                                placeholder="Nhập nội dung trả lời..."
                            ><?= htmlspecialchars($msg['phan_hoi']) ?></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" name="btn_reply" class="btn btn-primary">
                                Lưu & Gửi phản hồi
                            </button>
                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

</div>

</body>
</html>