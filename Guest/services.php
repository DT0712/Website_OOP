<?php 
require_once "config.php";
include "includes/header.php";
?>

<style>
.services-app{
    min-height:80vh;
    background:linear-gradient(180deg,#c68bdc,#f1f2f6);
    padding:60px 20px;
}

/* HEADER */
.app-header{
    text-align:center;
    color:#fff;
    margin-bottom:40px;
}
.app-header h2{
    font-size:32px;
    font-weight:700;
}
.app-header p{
    opacity:0.9;
}

/* GRID */
.service-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:25px;
    max-width:600px;
    margin:auto;
}

/* CARD */
.app-card{
    background:#fff;
    border-radius:18px;
    padding:35px 20px;
    text-align:center;
    text-decoration:none;
    color:#333;
    transition:0.3s;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}
.app-card:hover{
    transform:translateY(-8px);
    box-shadow:0 15px 30px rgba(0,0,0,0.15);
}

/* ICON */
.icon-circle{
    width:70px;
    height:70px;
    border-radius:50%;
    border:3px solid #c68bdc;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:auto;
    margin-bottom:15px;
}
.icon-circle i{
    font-size:28px;
    color:#c68bdc;
}

.app-card h3{
    font-size:18px;
    font-weight:600;
}

/* MOBILE */
@media(max-width:600px){
    .service-grid{
        grid-template-columns:1fr;
    }
}
</style>

<!-- ================= SERVICES APP ================= -->
<section class="services-app">
    <div class="container">

        <div class="app-header">
            <h2>Dịch vụ & tiện ích</h2>
            <p>Hỗ trợ người mua và người bán xe đạp thể thao</p>
        </div>

        <div class="service-grid">

            <a href="services/buyer_order.php" class="app-card">
                <div class="icon-circle">
                    <i class="fa fa-bicycle"></i>
                </div>
                <h3>Quản lý sản phẩm</h3>
            </a>

            <a href="services/chat.php" class="app-card">
                <div class="icon-circle">
                    <i class="fa fa-comments"></i>
                </div>
                <h3>Chat cùng BM</h3>
            </a>

            <a href="services/installment.php" class="app-card">
                <div class="icon-circle">
                    <i class="fa fa-credit-card"></i>
                </div>
                <h3>Trả góp</h3>
            </a>

            <a href="services/feedback.php" class="app-card">
                <div class="icon-circle">
                    <i class="fa fa-envelope"></i>
                </div>
                <h3>Góp ý</h3>
            </a>

            <a href="services/favorite.php" class="app-card">
                <div class="icon-circle">
                    <i class="fa fa-credit-card"></i>
                </div>
                <h3>Yêu Thích</h3>
            </a>

        </div>

    </div>
</section>

<?php include "includes/footer.php"; ?>