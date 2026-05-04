<?php
session_start();
/** @var mysqli $conn */
include 'config.php';

if (!isset($_GET['id'])) {
    header("Location: bicycle_management.php");
    exit();
}

$id = intval($_GET['id']);

// Lấy dữ liệu
$result = mysqli_query($conn, "SELECT * FROM bicycles WHERE bicycle_id = $id");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "Không tìm thấy xe!";
    exit();
}

// ================= UPDATE =================
if (isset($_POST['update'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = intval($_POST['price']);
    $condition = mysqli_real_escape_string($conn, $_POST['condition']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $image = $row['main_image'];

    // Upload ảnh mới
    if (!empty($_FILES['image']['name'])) {

        // 👉 Lưu file trong Admin/assets/images
        $target_dir = "assets/images/";
        $file_name = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {

            // 👉 Lưu DB KHÔNG có ../
            $image = "assets/images/" . $file_name;
        }
    }

    $sql = "UPDATE bicycles SET
                name = '$name',
                price = '$price',
                condition_status = '$condition',
                location = '$location',
                description = '$description',
                main_image = '$image'
            WHERE bicycle_id = $id";

    mysqli_query($conn, $sql);

    header("Location: bicycle_management.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Chỉnh sửa xe</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: #f5f6fa;
}

.form-card {
    max-width: 900px;
    margin: 40px auto;
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.08);
}

.form-title {
    font-size: 22px;
    font-weight: bold;
    margin-bottom: 20px;
}

.preview-img {
    width: 160px;
    height: 120px;
    object-fit: cover;
    border-radius: 10px;
    border: 1px solid #ddd;
}

.upload-box {
    border: 2px dashed #ddd;
    padding: 20px;
    text-align: center;
    border-radius: 10px;
    cursor: pointer;
}

.upload-box:hover {
    background: #fafafa;
}

.btn-save {
    background: #ee4d2d;
    color: white;
    padding: 10px 25px;
    border-radius: 8px;
}

.btn-save:hover {
    background: #d73211;
}
</style>
</head>

<body>

<div class="form-card">

    <div class="form-title">Chỉnh sửa xe đạp</div>

    <form method="POST" enctype="multipart/form-data">

        <div class="row">

            <!-- LEFT -->
            <div class="col-md-6">

                <label>Tên xe</label>
                <input type="text" name="name" class="form-control mb-3"
                       value="<?= htmlspecialchars($row['name']) ?>">

                <label>Giá</label>
                <input type="number" name="price" class="form-control mb-3"
                       value="<?= $row['price'] ?>">

                <label>Tình trạng</label>
                <input type="text" name="condition" class="form-control mb-3"
                       value="<?= $row['condition_status'] ?>">

                <label>Địa điểm</label>
                <input type="text" name="location" class="form-control mb-3"
                       value="<?= htmlspecialchars($row['location']) ?>">

            </div>

            <!-- RIGHT -->
            <div class="col-md-6">

                <label>Ảnh hiện tại</label><br>

                <!-- ✅ QUAN TRỌNG: dùng giống management -->
                <img src="<?= $row['main_image'] ?>" 
                     class="preview-img mb-3"
                     onerror="this.src='assets/images/no-image.png'">

                <label>Đổi ảnh</label>
                <div class="upload-box mb-3">
                    <input type="file" name="image" id="imageInput" hidden>
                    <label for="imageInput">📷 Chọn ảnh</label>
                </div>

                <img id="previewNew" class="preview-img d-none">

            </div>

        </div>

        <label>Mô tả</label>
        <textarea name="description" class="form-control mb-4"><?= htmlspecialchars($row['description']) ?></textarea>

        <button name="update" class="btn btn-save">
            Lưu thay đổi
        </button>

        <a href="bicycle_management.php" class="btn btn-secondary">
            Quay lại
        </a>

    </form>

</div>

<script>
// preview ảnh mới
document.getElementById("imageInput").onchange = e => {
    const file = e.target.files[0];
    if (file) {
        const preview = document.getElementById("previewNew");
        preview.src = URL.createObjectURL(file);
        preview.classList.remove("d-none");
    }
};
</script>

</body>
</html>