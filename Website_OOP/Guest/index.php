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

/* ================= ECO MINIMAL PRO ================= */
.eco-minimal {
    padding: 40px 80px 20px;
    background: linear-gradient(180deg, #f9fafc, #eef2f6);
}

/* HEADER */
/* ===== DARK HEADER FULL ===== */
.eco-dark-header {
    width: 100vw; /* full màn */
    margin-left: calc(-50vw + 50%); /* fix full width khi nằm trong container */
    
    background: linear-gradient(135deg, #1c1c1c, #2b2b2b);
    color: white;
    text-align: center;

    padding: 80px 20px 100px; /* tăng padding dưới */
    position: relative;
    
    margin-bottom: 60px; /* 👉 tạo khoảng cách với section dưới */
}

/* CONTENT CENTER */
.eco-dark-header h2 {
    font-size: 38px;
    margin: 10;
}

.eco-dark-header span {
    color: #4CAF50;
}

.eco-dark-header p {
    margin-top: 12px;
    color: #bbb;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

/* ===== TRIANGLE ===== */
.eco-dark-header::after {
    content: "";
    position: absolute;
    bottom: -20px;
    left: 50%;
    transform: translateX(-50%);
    
    border-left: 30px solid transparent;
    border-right: 30px solid transparent;
    border-top: 20px solid #2b2b2b;
}

/* LAYOUT */
.eco-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
}

/* SIDE */
.eco-side {
    width: 600px;
}

/* ITEM (KHÔNG CÒN CARD) */
.eco-item {
    position: relative;
    margin-bottom: 40px;
    padding-right: 30px;
    padding-left: 30px;
}

/* TEXT */
.eco-item h4 {
    margin: 0 0 8px;
    font-size: 16px;
}

.eco-item p {
    font-size: 14px;
    color: #666;
    line-height: 1.8; /* 👉 cho text dài đẹp */
}

/* ICON */
.eco-item .icon {
    position: absolute;
    width: 42px;
    height: 42px;
    background: linear-gradient(135deg, #4CAF50, #66bb6a);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-size: 16px;
    box-shadow: 0 6px 15px rgba(76,175,80,0.4);
}

/* ===== LEFT SIDE CĂN PHẢI ===== */
.eco-side.left .eco-item {
    text-align: right;
    padding-right: 40px; /* tạo khoảng cho icon */
    padding-left: 0;
}

/* icon bên trái (nằm gần center) */
.eco-side.left .eco-item .icon {
    right: -12px;
    top: 50%;
    transform: translateY(-50%);
}


/* ===== RIGHT SIDE CÁCH ICON ===== */
.eco-side.right .eco-item {
    padding-left: 45px; /* 👉 đẩy text ra xa icon */
    padding-right: 0;
}

.eco-side.right .eco-item .icon {
    left: -12px;
    top: 50%;
    transform: translateY(-50%);
}

/* CENTER */
.eco-center {
    width: 360px;
    position: relative;
}

.eco-center img {
    width: 280px;
    height: 280px;
    object-fit: cover; 
    border-radius: 50%; 
    box-shadow: 
        0 10px 30px rgba(0,0,0,0.2),
        0 0 20px rgba(76,175,80,0.3); /* glow nhẹ */
}
.eco-center {
    transform: translateY(-20px); 
    position: relative;
    display: flex;
    justify-content: center;
}



/* RING */
.ring {
    position: absolute;
    width: 280px;
    height: 280px;
    border-radius: 50%;
    border: 1.5px dashed rgba(76,175,80,0.3);
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    animation: rotate 25s linear infinite;
}

@keyframes rotate {
    from { transform: translate(-50%, -50%) rotate(0deg); }
    to { transform: translate(-50%, -50%) rotate(360deg); }
}
/* ================= FLOATING CHAT FIXED ================= */
#chat-bubble {
    position: fixed;   /* ⭐ KEY: dính theo màn hình */
    right: 25px;
    bottom: 25px;

    width: 65px;
    height: 65px;
    border-radius: 50%;
    background: linear-gradient(135deg,#ff3c00,#ff7b00);
    color: white;
    font-size: 28px;

    display: flex;
    align-items: center;
    justify-content: center;

    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    cursor: pointer;
    z-index: 99999;

    transition: transform .2s, box-shadow .2s;
}

#chat-bubble:hover {
    transform: scale(1.1);
    box-shadow: 0 12px 30px rgba(0,0,0,0.4);
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

<!-- ================= ECO MINIMAL PRO ================= -->
<div class="eco-minimal">

    <div class="eco-dark-header">
        <h2><span>Smart Cycling</span> For Modern Living</h2>
        <p>Khám phá giải pháp di chuyển thông minh, bền vững và nâng cao chất lượng cuộc sống mỗi ngày.</p>
    </div>

    <div class="eco-wrapper">

        <!-- LEFT -->
        <div class="eco-side left">
            <div class="eco-item">
                <h4>Energy Efficiency</h4>
                <p>
                    Xe đạp giúp tiết kiệm tối đa năng lượng và chi phí sử dụng trong thời gian dài, 
                    đồng thời giảm phụ thuộc vào nhiên liệu hóa thạch và các nguồn tài nguyên không tái tạo.
                </p>
                <div class="icon">⚡</div>
            </div>

            <div class="eco-item">
                <h4>Smart Urban Mobility</h4>
                <p>
                    Mang lại khả năng di chuyển linh hoạt trong môi trường đô thị đông đúc, 
                    giúp bạn dễ dàng tránh kẹt xe và tiết kiệm đáng kể thời gian di chuyển hàng ngày.
                </p>
                <div class="icon">💡</div>
            </div>

            <div class="eco-item">
                <h4>Eco Lifestyle</h4>
                <p>
                    Góp phần xây dựng phong cách sống xanh, giảm thiểu tác động tiêu cực đến môi trường 
                    và hướng tới một tương lai bền vững cho cộng đồng và thế hệ sau.
                </p>
                <div class="icon">🌱</div>
            </div>
        </div>

        <!-- CENTER -->
        <div class="eco-center">
            <img src="assets/images/bike-center.png" alt="bike">
            <div class="ring"></div>
        </div>

        <!-- RIGHT -->
        <div class="eco-side right">
            <div class="eco-item">
                <div class="icon">🍃</div>
                <h4>Clean Environment</h4>
                <p>
                    Không tạo ra khí thải độc hại, xe đạp giúp giữ gìn không khí trong lành, 
                    giảm ô nhiễm và cải thiện đáng kể chất lượng môi trường sống trong đô thị.
                </p>
            </div>

            <div class="eco-item">
                <div class="icon">♻️</div>
                <h4>Long-term Usage</h4>
                <p>
                    Với độ bền cao và khả năng bảo trì đơn giản, xe đạp có thể sử dụng trong thời gian dài 
                    mà không phát sinh nhiều chi phí sửa chữa hay thay thế linh kiện.
                </p>
            </div>

            <div class="eco-item">
                <div class="icon">🧬</div>
                <h4>Health & Fitness</h4>
                <p>
                    Đạp xe thường xuyên giúp cải thiện sức khỏe tim mạch, tăng cường thể lực 
                    và mang lại cảm giác thư giãn, giảm căng thẳng sau những giờ làm việc mệt mỏi.
                </p>
            </div>
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
<!-- FLOATING CHAT BUTTON -->
<div id="chat-bubble">
    💬
</div>

<script>
const bubble = document.getElementById("chat-bubble");
bubble.onclick = () => {
    window.location.href = "chatai.php";
}

</script>


<?php include "includes/footer.php"; ?>