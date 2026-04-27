<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
.sidebar {
    width: 250px;
    background: white;
    height: 100vh;
    padding: 20px;
    box-shadow: 0 0 20px rgba(0,0,0,.05);
}

.logo {
    font-size: 22px;
    font-weight: 700;
    color: #5b5ce2;
    margin-bottom: 30px;
}

.menu a {
    display: block;
    padding: 12px;
    border-radius: 10px;
    margin-bottom: 8px;
    text-decoration: none;
    color: #555;
    font-size: 14px;
}

.menu a.active,
.menu a:hover {
    background: linear-gradient(90deg,#6c5ce7,#5b5ce2);
    color: white;
}
</style>

<div class="sidebar">

    <div class="logo">
        VENUS <br>
        <small style="font-size:12px;color:#999">
            DASHBOARD
        </small>
    </div>

    <div class="menu">

        <a href="dashboard.php"
        class="<?= ($current_page == 'dashboard.php') ? 'active' : '' ?>">
            <i class="fa fa-chart-line"></i> Dashboard
        </a>

        <a href="index1.php?page=user_management"
        class="<?= ($current_page == 'user_management.php') ? 'active' : '' ?>">
            <i class="fa fa-users"></i> Quản lý người dùng
        </a>

        <a href="bicycle_management.php"
        class="<?= ($current_page == 'bicycle_management.php') ? 'active' : '' ?>">
            <i class="fa fa-bicycle"></i> Quản lý xe đạp
        </a>

        <a href="inspection_management.php"
        class="<?= ($current_page == 'inspection_management.php') ? 'active' : '' ?>">
            <i class="fa fa-check-circle"></i> Kiểm định xe
        </a>

        <a href="transaction_management.php"
        class="<?= ($current_page == 'transaction_management.php') ? 'active' : '' ?>">
            <i class="fa fa-credit-card"></i> Quản lý giao dịch
        </a>

        <a href="message_management.php"
        class="<?= ($current_page == 'message_management.php') ? 'active' : '' ?>">
            <i class="fa fa-envelope"></i> Phản hồi tin nhắn
        </a>

        <a href="system_statistics.php"
        class="<?= ($current_page == 'system_statistics.php') ? 'active' : '' ?>">
            <i class="fa fa-chart-bar"></i> Thống kê hệ thống
        </a>
    </div>

</div>