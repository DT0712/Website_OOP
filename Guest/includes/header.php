    <?php

    if (session_status() == PHP_SESSION_NONE) {
    session_start();
    }

    $current_page = basename($_SERVER['PHP_SELF']);

    // giả lập giỏ hàng (sau này bạn thay bằng DB)
    $cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

    // kiểm tra login
    $is_logged_in = isset($_SESSION['khach_hang']);

    $avatar = $is_logged_in && !empty($_SESSION['khach_hang']['anh_dai_dien'])
        ? $_SESSION['khach_hang']['anh_dai_dien']
        : 'https://i.imgur.com/6VBx3io.png';
    ?>

    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <title>Bike Market</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ICON -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    </head>
    <body>

    <!-- TOP BAR -->
    <div class="topbar">
        <div>
            <?php if($is_logged_in): ?>
                <span>Xin chào, <?= $_SESSION['khach_hang']['ho_ten'] ?></span>
                
            <?php else: ?>
                <a href="login.php"><i class="fa fa-user"></i> Đăng nhập</a>
                <a href="register.php"><i class="fa fa-user-plus"></i> Đăng ký</a>
            <?php endif; ?>

            
        </div>

        <div>
            <i class="fa fa-phone"></i> 0123 456 789
        </div>
    </div>

    <!-- HEADER -->
    <div class="header">

        <!-- LOGO -->
        <div class="logo">
            <a href="index.php" style="color:white;text-decoration:none;">
                Bike<span>Market</span>
            </a>
        </div>

    <!-- MENU -->
    <div class="menu">
        <a href="index.php" class="<?= ($current_page == 'index.php') ? 'active' : '' ?>">HOME</a>

        <a href="bikes.php" class="<?= ($current_page == 'bikes.php') ? 'active' : '' ?>">XE ĐẠP</a>

        <a href="sell.php" class="<?= ($current_page == 'sell.php') ? 'active' : '' ?>">ĐĂNG TIN</a>

        <a href="services.php" class="<?= ($current_page == 'services.php') ? 'active' : '' ?>">DỊCH VỤ</a>

        <a href="views/blog.php" class="<?= ($current_page == 'blog.php') ? 'active' : '' ?>">BLOG</a>

        <a href="contact.php" class="<?= ($current_page == 'contact.php') ? 'active' : '' ?>">LIÊN HỆ</a>

    </div>

    <!-- ICON -->
    <div class="icons">

    <div class="search-box">
        <input type="text" placeholder="Tìm kiếm...">
        <button><i class="fa fa-search"></i></button>
    </div>

    <?php if($is_logged_in): ?>
    <a href="profile.php" class="user-pill">
        <img src="<?= $avatar ?>">
        <span>
            <?= $_SESSION['khach_hang']['ho_ten'] ?>
        </span>
    </a>
<?php else: ?>
        <a href="login.php" style="color:white;margin-right:15px;">
            <i class="fa fa-user"></i>
        </a>
    <?php endif; ?>

    <div class="cart">
        <a href="cart.php" style="color:white;">
            <i class="fa fa-shopping-cart"></i>
        </a>
        <?php if($cart_count > 0): ?>
            <span><?= $cart_count ?></span>
        <?php endif; ?>
    </div>

</div>

    </div>