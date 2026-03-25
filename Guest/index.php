<?php
include 'config.php';
include 'includes/header.php';

// Lấy sản phẩm
$sql = "SELECT bicycles.*, brands.name AS brand_name 
        FROM bicycles 
        INNER JOIN brands ON bicycles.brand_id = brands.id";
$result = mysqli_query($conn, $sql);
?>

<style>
/* ================= BANNER ================= */
.banner {
    position: relative;
    height: 500px;
    background: url('https://images.unsplash.com/photo-1503376780353-7e6692767b70') no-repeat center/cover;
    color: white;
    display: flex;
    align-items: center;
    padding-left: 60px;
}

.banner::before {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.4);
}

.banner-content {
    position: relative;
    z-index: 2;
}

.banner-content h1 {
    font-size: 50px;
    margin: 0;
}

.banner-content h2 {
    font-size: 40px;
}

.banner-content p {
    font-size: 20px;
    margin-top: 10px;
}

.banner-content button {
    margin-top: 20px;
    padding: 10px 20px;
    background: red;
    border: none;
    color: white;
    cursor: pointer;
}

/* ================= FEATURES ================= */
.features-section {
    padding: 60px;
    background: #fff;
    text-align: center;
}

.sub-title {
    color: #ff3c00;
    font-weight: bold;
    margin-bottom: 10px;
}

.main-title {
    font-size: 40px;
    margin-bottom: 40px;
}

.main-title span {
    color: #ff3c00;
}

/* GRID */
.features-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

/* CARD */
.feature-card {
    background: #fafafa;
    padding: 30px 20px;
    border-radius: 10px;
    transition: 0.3s;
    border: 1px solid #eee;
}

.feature-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

/* ACTIVE CARD (giống ô giữa trong ảnh) */
.feature-card.active {
    border-bottom: 4px solid #ff3c00;
    background: #fff;
}

/* ICON */
.feature-card .icon {
    font-size: 40px;
    margin-bottom: 15px;
}

/* TEXT */
.feature-card h3 {
    margin-bottom: 10px;
}

.feature-card p {
    font-size: 14px;
    color: #666;
    margin-bottom: 15px;
}

/* LINK */
.feature-card a {
    text-decoration: none;
    font-weight: bold;
    color: #999;
}

.feature-card.active a {
    color: #ff3c00;
}

/* ================= PRODUCT ================= */
.product-section {
    padding: 50px;
    background: #f5f5f5;
}

.product-section h2 {
    text-align: center;
    margin-bottom: 30px;
}

.product-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 25px;
    justify-content: center;
}

/* CARD */
.product-card {
    width: 300px;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    transition: 0.3s;
    position: relative;
}

.product-card:hover {
    transform: translateY(-8px);
}

/* IMAGE */
.product-image {
    position: relative;
    height: 220px;
    background: #f9f9f9;
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-image img {
    max-width: 90%;
    max-height: 180px;
    object-fit: contain;
    transition: 0.3s;
}

.product-card:hover .product-image img {
    transform: scale(1.05);
}

/* PRICE FLOAT */
.price-box {
    position: absolute;
    bottom: -15px;
    left: 50%;
    transform: translateX(-50%);
    background: #fff;
    padding: 8px 20px;
    border-radius: 6px;
    font-weight: bold;
    color: #ff6600;
    box-shadow: 0 3px 8px rgba(0,0,0,0.15);
    font-size: 16px;
}

/* INFO */
.product-info {
    padding: 25px 15px 15px;
    text-align: center;
}

.product-info h3 {
    font-size: 16px;
    margin-bottom: 10px;
}

/* META */
.product-meta {
    font-size: 13px;
    color: #777;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: space-between;
    margin-top: 10px;
}

.product-meta span {
    width: 48%;
}
</style>

<!-- ================= BANNER ================= -->
<div class="banner">
    <div class="banner-content">
        <h1>DOMINATE</h1>
        <h2>THE INTERNET</h2>
        <p>Attract, Engage & Convert more customers</p>
        <button>Explore Now</button>
    </div>
</div>
<!-- ================= FEATURES ================= -->
<div class="features-section">
    <p class="sub-title">// FEATURES //</p>
    <h2 class="main-title">Core Features<span>.</span></h2>

    <div class="features-grid">

        <div class="feature-card">
            <div class="icon">🚲</div>
            <h3>All Kind Brand</h3>
            <p>Chúng tôi cung cấp nhiều dòng xe đạp từ các thương hiệu nổi tiếng.</p>
            <a href="#">Read More</a>
        </div>

        <div class="feature-card">
            <div class="icon">🛠️</div>
            <h3>Expert Mechanics</h3>
            <p>Đội ngũ kỹ thuật viên giàu kinh nghiệm, hỗ trợ tận tâm.</p>
            <a href="#">Read More</a>
        </div>

        <div class="feature-card active">
            <div class="icon">⚙️</div>
            <h3>Repair Vehicles</h3>
            <p>Dịch vụ sửa chữa chuyên nghiệp, nhanh chóng và hiệu quả.</p>
            <a href="#">Read More</a>
        </div>

        <div class="feature-card">
            <div class="icon">🎨</div>
            <h3>Paint & Customize</h3>
            <p>Tùy chỉnh màu sắc và phong cách theo ý thích của bạn.</p>
            <a href="#">Read More</a>
        </div>

    </div>
</div>
<!-- ================= PRODUCT ================= -->
<div class="product-section">
    <h2>🔥 Sản phẩm nổi bật</h2>

    <div class="product-grid">
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
            
            <div class="product-card">

    <div class="product-image">
        <img src="<?php echo $row['main_image']; ?>" alt="">

        <div class="price-box">
            <?php echo number_format($row['price'], 0, ',', '.'); ?> đ
        </div>
    </div>

    <div class="product-info">
        <h3><?php echo $row['name']; ?></h3>

        <div class="product-meta">
            <span>📍 <?php echo $row['location']; ?></span>
            <span>⚙️ <?php echo $row['condition_status']; ?></span>
            <span>📏 Size: <?php echo $row['frame_size']; ?></span>
            <span>🏷️ <?php echo $row['brand_name']; ?></span>
        </div>
    </div>

</div>

        <?php } ?>
    </div>
</div>

<?php include "includes/footer.php"; ?>