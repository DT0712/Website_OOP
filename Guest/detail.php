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
    height: 650px;
    position: relative;
    overflow: hidden;
    background: #f4f4f4;
}

/* nền trắng chéo */
.detail-banner::before {
    content: "";
    position: absolute;
    width: 65%;
    height: 100%;
    background: #fff;
    clip-path: polygon(0 0, 100% 0, 80% 100%, 0% 100%);
    z-index: 1;
}

/* nền ảnh + overlay */
.detail-banner::after {
    content: "";
    position: absolute;
    right: 0;
    width: 60%;
    height: 100%;
    background:
        linear-gradient(135deg, rgba(255,0,0,0.4), rgba(0,0,0,0.9)),
        url('assets/images/bgxe.jpg') no-repeat center;
    background-size: cover;
    clip-path: polygon(20% 0, 100% 0, 100% 100%, 0% 100%);
    z-index: 0;
}

/* ===== LEFT ===== */
.detail-left {
    width: 45%;
    padding: 80px;
    z-index: 2;
}

.detail-left h1 {
    font-size: 34px;
    font-weight: bold;
}

.detail-left h2 {
    font-size: 26px;
    color: red;
}

/* ===== INFO TABLE ===== */
.info-table {
    margin-top: 25px;
}

.info-row {
    display: flex;
    gap: 20px;
    padding: 8px 0;
    border-bottom: 1px solid #eee;
}

.label {
    width: 130px;
    color: #888;
    font-size: 14px;
}

.value {
    flex: 1;
    text-align: left;
    font-weight: bold;
    color: #222;
    line-height: 1.6;
}

/* nút */
.order-btn {
    margin-top: 20px;
    padding: 12px 25px;
    background: #000;
    color: #fff;
    border: none;
    cursor: pointer;
    position: relative;
}

.order-btn::after {
    content: "";
    position: absolute;
    right: -20px;
    top: 0;
    border-left: 20px solid #000;
    border-top: 22px solid transparent;
    border-bottom: 22px solid transparent;
}

/* ===== RIGHT ===== */
.detail-right {
    width: 55%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: relative;
    z-index: 2;
}

.detail-right img {
    max-width: 75%;
    transform: translateX(-80px);
    z-index: 2;
    filter: drop-shadow(0 20px 30px rgba(0,0,0,0.5));
}

/* ánh sáng */
.detail-right::before {
    content: "";
    position: absolute;
    width: 300px;
    height: 300px;
    background: red;
    filter: blur(120px);
    right: 80px;
}

/* ===== THUMBNAILS ===== */
.thumbs {
    margin-top: 20px;
    display: flex;
    gap: 10px;
}

.thumbs img {
    width: 70px;
    height: 70px;
    object-fit: cover;
    cursor: pointer;
    border: 2px solid transparent;
    transition: 0.3s;
    background: #fff;
    padding: 3px;
}

.thumbs img:hover,
.thumbs img.active {
    border: 2px solid red;
}
</style>


<div class="detail-banner">

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

            <button class="order-btn">ĐẶT HÀNG</button>
            
            <!-- Nút nhắn tin - kết nối sang Message Service -->
            <a href="/Website_OOP/Message/index.php?action=create&seller_id=<?= $row['seller_id'] ?>&xe_id=<?= $row['id'] ?>"
                class="order-btn" 
                style="margin-top:10px; display:inline-block; background:red; text-decoration:none; margin-left:100px;">
                 NHẮN TIN VỚI NGƯỜI BÁN
            </a>

        </div>

    </div>

    <!-- RIGHT -->
    <div class="detail-right">

        <img id="mainImage" 
             src="<?php echo $row['main_image']; ?>" 
             onerror="this.src='assets/images/default-bike.png'">

        <div class="thumbs">
            <img src="<?php echo $row['main_image']; ?>" onclick="changeImage(this)">
            <img src="<?php echo $row['sub_image1']; ?>" onclick="changeImage(this)">
            <img src="<?php echo $row['sub_image2']; ?>" onclick="changeImage(this)">
            <img src="<?php echo $row['sub_image3']; ?>" onclick="changeImage(this)">
        </div>

    </div>

</div>

<script>
function changeImage(img) {
    document.getElementById("mainImage").src = img.src;

    document.querySelectorAll(".thumbs img").forEach(el => {
        el.classList.remove("active");
    });

    img.classList.add("active");
}

// active mặc định
document.querySelector(".thumbs img").classList.add("active");
</script>

<?php include "includes/footer.php"; ?>