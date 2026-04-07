<?php include "../includes/header.php"; ?>

<div class="container mt-4 mb-5">

    <div class="blog-header">
        <div class="overlay">
            <h1 class="logo1">
                BL<span class="smile-icon"><i class="fa-regular fa-face-smile"></i></span>G
            </h1>
            <p class="subtitle">A PERFECT THEME FOR BLOGGERS</p>
        </div>
    </div>

    <div class="slider-wrapper container">
        <div class="row mb-4">

            <div class="col-md-4">
                <a href="blog_detail.php?id=1" style="text-decoration:none;" class="d-block">
                    <div class="blog-card">
                        <img src="../assets/images/biketop.jpg">
                        <div class="overlay">
                            <span class="tag">NEW</span>
                            Top xe đạp bán chạy tháng
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="blog_detail.php?id=2" style="text-decoration:none;" class="d-block">
                    <div class="blog-card">
                        <img src="../assets/images/biketip.jpg">
                        <div class="overlay">
                            <span class="tag">TIPS</span>
                            Cách chọn xe đạp phù hợp
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="blog_detail.php?id=3" style="text-decoration:none;" class="d-block">
                    <div class="blog-card">
                        <img src="../assets/images/biketravel.jpg">
                        <div class="overlay">
                            <span class="tag">TRAVEL</span>
                            Hành trình đạp xe đáng nhớ
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>

    <div class="row">

        <!-- BÀI VIẾT col-md-8 -->
        <div class="col-md-8">
            <div class="row">

                <div class="col-md-6 mb-4">
                    <a href="blog_detail.php?id=4" style="text-decoration:none;" class="d-block">
                        <div class="blog-card">
                            <img src="../assets/images/bikenewbie.jpg">
                            <div class="overlay">
                                <span class="tag">NEWBIE</span>
                                Xe đạp thể thao cho người mới
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6 mb-4">
                    <a href="blog_detail.php?id=5" style="text-decoration:none;" class="d-block">
                        <div class="blog-card">
                            <img src="../assets/images/bikefix.jpg">
                            <div class="overlay">
                                <span class="tag">TIPS</span>
                                Kinh nghiệm bảo dưỡng xe
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>

        <div class="col-md-4">
            <div class="about-box text-center p-3">
                <a href="../bikes.php" style="text-decoration:none;" class="d-block">
                    <img src="../assets/images/bikestore.jpg"
                        class="rounded-circle mb-2" width="140" height="90"
                        style="object-fit:cover;">
                    <h5>Bike Market</h5>
                    <p>Chuyên cung cấp xe đạp chính hãng,
                    hỗ trợ đặt cọc và giao hàng toàn quốc.</p>
                </a>
            </div>
        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>
</body>
</html>