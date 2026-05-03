<?php
session_start();
/** @var mysqli $conn */
include 'config.php';

// ================= THÊM XE =================
if (isset($_POST['add'])) {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $condition = $_POST['condition'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    $image = "assets/images/no-image.png"; // mặc định

    // ===== UPLOAD ẢNH =====
    if (!empty($_FILES['image']['name'])) {

        // Lưu file thật trong Admin/assets/images
        $target_dir = "assets/images/";
        $file_name = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $target_file; // lưu DB KHÔNG có ../
        }
    }

    // ===== INSERT =====
    $sql = "INSERT INTO bicycles (name, price, condition_status, location, description, main_image)
            VALUES ('$name', '$price', '$condition', '$location', '$description', '$image')";

    mysqli_query($conn, $sql);

    header("Location: bicycle_management.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thêm xe đạp</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: #f5f6fa;
}

.form-card {
    max-width: 950px;
    margin: 40px auto;
    background: white;
    border-radius: 14px;
    padding: 30px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.08);
}

.form-title {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 25px;
}

/* preview ảnh */
.preview-img {
    width: 160px;
    height: 120px;
    object-fit: cover;
    border-radius: 10px;
    border: 1px solid #ddd;
}

/* upload box */
.upload-box {
    border: 2px dashed #ddd;
    padding: 25px;
    text-align: center;
    border-radius: 10px;
    cursor: pointer;
    transition: 0.2s;
}

.upload-box:hover {
    background: #fafafa;
}

/* button */
.btn-save {
    background: #ee4d2d;
    color: white;
    padding: 10px 25px;
    border-radius: 8px;
    border: none;
}

.btn-save:hover {
    background: #d63c1f;
}
</style>
</head>

<body>

<div class="form-card">

    <div class="form-title">➕ Thêm xe đạp</div>

    <form method="POST" enctype="multipart/form-data">

        <div class="row">

            <!-- LEFT -->
            <div class="col-md-6">

                <label>Tên xe</label>
                <input type="text" name="name" class="form-control mb-3" required>

                <label>Giá</label>
                <input type="number" name="price" class="form-control mb-3" required>

                <label>Tình trạng</label>
                <input type="text" name="condition" class="form-control mb-3" placeholder="Mới / Đã sử dụng">

                <label>Địa điểm</label>
                <input type="text" name="location" class="form-control mb-3">

            </div>

            <!-- RIGHT -->
            <div class="col-md-6">

                <label>Ảnh xe</label>

                <div class="upload-box mb-3">
                    <input type="file" name="image" id="imageInput" hidden>
                    <label for="imageInput">📷 Chọn ảnh</label>
                </div>

                <!-- preview -->
                <img id="previewNew" class="preview-img d-none">

            </div>

        </div>

        <label>Mô tả</label>
        <textarea name="description" class="form-control mb-4" rows="4"></textarea>

        <button name="add" class="btn btn-save">
            Lưu
        </button>

        <a href="bicycle_management.php" class="btn btn-secondary">
            Quay lại
        </a>

    </form>

</div>

<script>
// preview ảnh
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