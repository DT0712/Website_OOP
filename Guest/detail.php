<?php
require_once "config.php";
include "includes/header.php";

/* ===== LẤY ID AN TOÀN ===== */
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$sql = "SELECT * FROM bicycles WHERE id = $id LIMIT 1";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    echo "<h2 style='padding:50px'>Không tìm thấy xe</h2>";
    exit;
}
?>

<style>
/* ===== HERO ===== */
.detail-banner {
    display: flex;
    position: relative;
    overflow: hidden;
    min-height: 500px;
    background: transparent;
    margin-top: 30px;
}

/* nền trắng */
.detail-banner::before {
    content: "";
    position: absolute;
    width: 37%;
    height: 100%;
    background: #fff;
    clip-path: polygon(0 0, 100% 0, 80% 100%, 0% 100%);
    z-index: 1;
}

/* nền xanh */
.detail-banner::after {
    content: "";
    position: absolute;
    right: 0;
    top: 0;
    bottom: 0;
    width: 37%;
    background:
        linear-gradient(135deg, rgba(37,99,235,0.6), rgba(15,23,42,0.9)),
        url('assets/images/bgxe.jpg') no-repeat center;
    background-size: cover;
    clip-path: polygon(20% 0, 100% 0, 100% 100%, 0% 100%);
    z-index: 0;
}

/* ===== KHỐI ĐỎ ===== */
.red-shape {
    position: absolute;
    bottom: 0px;
    left: 63%;
    width: 220px;
    height: 50px;
    background: linear-gradient(90deg, #ff3b30, #c62828);
    clip-path: polygon(5% 0, 86% 0, 80% 100%, 0% 100%);
    z-index: 2;
}

/* ===== LEFT ===== */
.detail-left {
    width: 45%;
    padding: 80px 80px 80px 120px;
    z-index: 2;
}

.detail-left h1 { font-size: 38px; }
.detail-left h2 { color: red; }

/* ===== INFO ===== */
.info-table { margin-top: 25px; }

.info-row {
    display: flex;
    gap: 20px;
    padding: 8px 0;
    border-bottom: 1px solid #eee;
}

.label { width: 130px; color: #888; }
.value { flex: 1; font-weight: normal; }

/* ===== RIGHT ===== */
.detail-right {
    width: 30%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    z-index: 2;
}

/* ===== MAIN IMAGE ===== */
#mainImage {
    max-width: 100%;
    margin-bottom: 30px;
    margin-right: -350px;
    filter: drop-shadow(0 20px 30px rgba(0,0,0,0.5));
    transition: 0.3s;
}

/* ===== THUMB ===== */
.thumbs-outside {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 30px;
    padding: 12px;
    background: #fff;
    border-radius: 14px;
    width: fit-content;
    margin-left: auto;
    margin-right: 40px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

.thumbs-outside img {
    width: 90px;
    height: 90px;
    object-fit: cover;
    cursor: pointer;
    border-radius: 8px;
    border: 1px solid #eee;
    opacity: 0.85;
    transition: 0.25s;
}

.thumbs-outside img:hover {
    opacity: 1;
    transform: scale(1.08);
}

.thumbs-outside img.active {
    border-color: #ee4d2d;
    opacity: 1;
    transform: scale(1.1);
}

/* ===== BUTTON GROUP ===== */
.action-buttons {
    display: flex;
    gap: 15px;
    margin-top: 25px;
}

.action-buttons a {
    text-decoration: none;
    padding: 15px 26px;
    font-size: 16px;
    border-radius: 10px;
    cursor: pointer;
    transition: 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 144px;
    
}

/* nút giỏ */
.cart-btn {
    background: #fff;
    color: #e53935;
    border: 2px solid #e53935;  
}

.cart-btn:hover {
    background: #ffe5e5;
}

/* nút đặt hàng */
.order-btn {
    background: linear-gradient(90deg, #ff3b30, #c62828);
    color: #fff;
    border: none;
}

.order-btn:hover {
    transform: scale(1.05);
}

/* icon */
.cart-icon {
    font-size: 22px;
    margin-right: 8px;
}
</style>

<!-- ===== MAIN ===== -->
<div class="detail-banner">

    <!-- KHỐI ĐỎ -->
    <div class="red-shape"></div>

    <!-- LEFT -->
    <div class="detail-left">
        <h1><?php echo htmlspecialchars($row['name']); ?></h1>
        <h2><?php echo number_format($row['price'], 0, ',', '.'); ?> VNĐ</h2>

        <div class="info-table">
            <div class="info-row">
                <span class="label">Nơi sản xuất</span>
                <span class="value"><?php echo htmlspecialchars($row['location']); ?></span>
            </div>

            <div class="info-row">
                <span class="label">Tình trạng</span>
                <span class="value"><?php echo htmlspecialchars($row['condition_status']); ?></span>
            </div>

            <div class="info-row">
                <span class="label">Kích thước</span>
                <span class="value"><?php echo htmlspecialchars($row['frame_size']); ?></span>
            </div>

            <div class="info-row">
                <span class="label">Mô tả</span>
                <span class="value" style="font-weight: normal; color:#555;">
                    <?php echo htmlspecialchars($row['description']); ?>
                </span>
            </div>

            <div class="action-buttons">
    <a href="#" class="cart-btn">
        <span class="cart-icon">🛒</span>
        Thêm Giỏ Hàng
    </a>
<a href="cart.php" 
   class="order-btn <?= ($current_page == 'cart.php') ? 'active' : '' ?>">
   Đặt Hàng
</a>
</div>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="detail-right">
        <img id="mainImage"
             src="<?php echo $row['main_image']; ?>"
             onerror="this.src='assets/images/default-bike.png'">
    </div>

</div>

<!-- ===== THUMBNAILS ===== -->
<div class="thumbs-outside">
    <?php foreach (['main_image','sub_image1','sub_image2','sub_image3'] as $img): ?>
        <?php if (!empty($row[$img])): ?>
            <img src="<?php echo $row[$img]; ?>" onclick="changeImage(this)">
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<script>
function changeImage(img) {
    const main = document.getElementById("mainImage");

    main.style.opacity = 0;

    setTimeout(() => {
        main.src = img.src;
        main.style.opacity = 1;
    }, 150);

    document.querySelectorAll(".thumbs-outside img").forEach(el => {
        el.classList.remove("active");
    });

    img.classList.add("active");
}

document.addEventListener("DOMContentLoaded", function () {
    const first = document.querySelector(".thumbs-outside img");
    if (first) first.classList.add("active");
});
</script>

<?php include "includes/footer.php"; ?>