<?php
require_once "config.php";
include "includes/header.php";
?>

<link rel="stylesheet" href="assets/css/detail.css">
<?php
$success_message = $_SESSION['success_message'] ?? '';
unset($_SESSION['success_message']);

// đếm số lượng giỏ giống cart.php
$cart_count = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cart_count += $item['quantity'] ?? 0;
    }
}

/* ===== LẤY ID AN TOÀN ===== */
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

/* ===== LẤY FULL THÔNG TIN XE ===== */
$sql = "
SELECT b.*, 
       c.name AS category_name,
       br.name AS brand_name,
       COUNT(o.id) AS total_orders
FROM bicycles b
LEFT JOIN categories c ON b.category_id = c.id
LEFT JOIN brands br ON b.brand_id = br.id
LEFT JOIN orders o ON b.bicycle_id = o.bike_id AND o.status IN ('accepted','deposit_paid','completed')
WHERE b.bicycle_id = $id
GROUP BY b.bicycle_id
LIMIT 1
";

$result = mysqli_query($conn, $sql);

/* ===== LẤY NỘI DUNG TAB CHI TIẾT ===== */
$section_sql = "SELECT * FROM product_sections WHERE bicycle_id = $id LIMIT 1";
$section_result = mysqli_query($conn, $section_sql);
$product_section = mysqli_fetch_assoc($section_result);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    echo "<h2 style='padding:50px'>Không tìm thấy xe</h2>";
    exit;
}
?>

<?php if ($success_message): ?>
<div id="addToCartSuccess" class="position-fixed top-50 start-50 translate-middle" style="z-index: 9999;">
    <div class="bg-white rounded-3 shadow-lg border-0 text-center" style="width: 400px; max-width: 92vw; animation: fadeInUp 0.35s ease-out;">
        <div class="py-4">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem; opacity: 0.9;"></i>
        </div>

        <div class="px-4 pb-4">
            <h5 class="fw-bold text-dark mb-2">Thêm vào giỏ hàng thành công!</h5>
            <p class="text-muted small mb-4"><?php echo $success_message; ?></p>

            <div class="d-flex gap-3">
                <button onclick="closeCartPopup()" 
                        class="btn btn-lg btn-outline-secondary flex-fill rounded-pill">
                    Tiếp tục mua sắm
                </button>

                <a href="cart.php" class="btn btn-lg btn-success flex-fill rounded-pill position-relative">
                    Xem giỏ hàng
                    <?php if ($cart_count > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge bg-danger">
                            <?php echo $cart_count; ?>
                        </span>
                    <?php endif; ?>
                </a>
            </div>
        </div>
    </div>
</div>

<div id="cartPopupBackdrop" class="position-fixed top-0 start-0 w-100 h-100" 
     style="background: rgba(0,0,0,0.45); backdrop-filter: blur(6px); z-index: 9998;"></div>

<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>

<script>
function closeCartPopup() {
    document.getElementById('addToCartSuccess')?.remove();
    document.getElementById('cartPopupBackdrop')?.remove();
}
setTimeout(closeCartPopup, 10000);
</script>
<?php endif; ?>
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

            <div class="info-row">
    <span class="label">Thể loại</span>
    <span class="value"><?php echo $row['category_name']; ?></span>
</div>

<div class="info-row">
    <span class="label">Thương hiệu</span>
    <span class="value"><?php echo $row['brand_name']; ?></span>
</div>

<div class="info-row">
    <span class="label">Lượt mua</span>
    <span class="value"><?php echo $row['total_orders']; ?> đã bán</span>
</div>

            <div class="action-buttons">

<a href="cart.php?action=add&id=<?php echo $row['bicycle_id']; ?>&redirect=detail"
   class="cart-btn">
    <span class="cart-icon">🛒</span>
    Thêm Giỏ Hàng
</a>

<a href="checkout.php?id=<?php echo $row['bicycle_id']; ?>"
   class="order-btn">
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

<!-- ================= TAB ================= -->
<div class="product-tabs">

    <div class="tab-buttons">
        <div class="tab-btn active" onclick="openTab(0)">Chi tiết sản phẩm</div>
        <div class="tab-btn" onclick="openTab(1)">Đánh giá</div>
    </div>

<!-- TAB 1 -->
<div class="tab-content active">

    <?php if($product_section): ?>

        <div class="big-content">
            <?php
                echo $product_section['thong_so'] . "\n\n";
                echo $product_section['qua_tang'] . "\n\n";
                echo $product_section['huong_dan'] . "\n\n";
                echo $product_section['dong_kiem'] . "\n\n";
                echo $product_section['doi_tra'];
            ?>
        </div>

    <?php else: ?>
        <p style="padding-left:120px">Chưa có thông tin chi tiết.</p>
    <?php endif; ?>

</div>

    <!-- TAB 2 -->
    <div class="tab-content">
        <h3>Đánh giá sản phẩm</h3>
        <p>⭐ Chức năng đánh giá sẽ được cập nhật sau.</p>
        <p>Hiện chưa có đánh giá nào.</p>
    </div>

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

function openTab(index) {
    document.querySelectorAll(".tab-btn").forEach(btn => btn.classList.remove("active"));
    document.querySelectorAll(".tab-content").forEach(tab => tab.classList.remove("active"));

    document.querySelectorAll(".tab-btn")[index].classList.add("active");
    document.querySelectorAll(".tab-content")[index].classList.add("active");
}
</script>

<?php include "includes/footer.php"; ?>