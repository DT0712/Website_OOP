<?php
include 'config.php';
include 'includes/header.php';
?>

<link rel="stylesheet" href="assets/Css/home.css">

<?php
$sql = "SELECT bicycles.*, brands.name AS brand_name 
        FROM bicycles 
        INNER JOIN brands ON bicycles.brand_id = brands.id
        WHERE bicycles.is_featured = 1";

$result = mysqli_query($conn, $sql);

// DEBUG lỗi
if (!$result) {
    die("SQL ERROR: " . mysqli_error($conn));
}
?>



<!-- ================= BANNER ================= -->
<div class="banner">
    <img src="assets/images/BikeMarket.png" alt="banner">
</div>

<!-- ================= FEATURES ================= -->
<div class="features-section">
    <p class="sub-title">// GIỚI THIỆU //</p>
    <h2 class="main-title">Điểm nổi bật</h2>

    <div class="features-grid">

        <div class="feature-card">
            <div class="icon">🚲</div>
            <h3>All Kind Brand</h3>
            <p>
                Chúng tôi cung cấp đa dạng các dòng xe đạp từ những thương hiệu nổi tiếng 
                trên thế giới như Giant, Trek, Twitter, đảm bảo chất lượng và độ bền cao. 
                Khách hàng có thể dễ dàng lựa chọn sản phẩm phù hợp với nhu cầu di chuyển, 
                thể thao hoặc giải trí hàng ngày.
            </p>
        </div>

        <div class="feature-card">
            <div class="icon">🛠️</div>
            <h3>Expert Mechanics</h3>
            <p>
                Đội ngũ kỹ thuật viên chuyên nghiệp với nhiều năm kinh nghiệm trong lĩnh vực 
                sửa chữa và bảo trì xe đạp. Chúng tôi luôn sẵn sàng hỗ trợ kiểm tra, tư vấn 
                và khắc phục sự cố nhanh chóng để đảm bảo xe của bạn luôn hoạt động ổn định.
            </p>
        </div>

        <div class="feature-card active">
            <div class="icon">⚙️</div>
            <h3>Repair & Maintenance</h3>
            <p>
                Dịch vụ sửa chữa và bảo dưỡng toàn diện từ cơ bản đến nâng cao, bao gồm 
                thay thế linh kiện, cân chỉnh phanh, bảo dưỡng xích và hệ thống truyền động. 
                Giúp kéo dài tuổi thọ xe và đảm bảo an toàn tối đa khi sử dụng.
            </p>
        </div>

        <div class="feature-card">
            <div class="icon">🎨</div>
            <h3>Customize Your Bike</h3>
            <p>
                Dịch vụ tùy chỉnh xe theo phong cách cá nhân: thay đổi màu sơn, nâng cấp 
                phụ kiện, lựa chọn khung và bánh xe theo ý thích. Giúp bạn sở hữu chiếc xe 
                độc đáo, thể hiện cá tính riêng biệt.
            </p>
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

<div class="product-section">
    <h2>🔥 Sản phẩm nổi bật</h2>

    <div class="product-grid">
        <?php while($row = mysqli_fetch_assoc($result)) { ?>

        <a href="detail.php?id=<?php echo $row['bicycle_id']; ?>" class="product-link">
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
        </a>

        <?php } ?>
    </div>
</div>
<!-- FLOAT BUTTON -->
<div id="chat-bubble">💬</div>
<!-- CHAT WIDGET -->
<div id="chat-widget">

    <div id="chat-header">
        🤖 AI Bike Support
        <span id="chat-close">✖</span>
    </div>

    <div id="chat-messages">
        <div class="msg-ai">Xin chào 👋 Tôi có thể tư vấn xe đạp cho bạn!</div>
    </div>

    <div id="chat-input-box">
        <input id="chat-input" placeholder="Nhập tin nhắn..." />
        <button onclick="sendMessage()">Gửi</button>
    </div>

</div>

<script>
const bubble = document.getElementById("chat-bubble");
const widget = document.getElementById("chat-widget");
const closeBtn = document.getElementById("chat-close");

bubble.addEventListener("click", () => {
    widget.style.display = "flex";
});

closeBtn.addEventListener("click", () => {
    widget.style.display = "none";
});
</script>
<script src="/Website_OOP/Website_OOP/guest/chat/chat.js"></script>


<?php include "includes/footer.php"; ?>