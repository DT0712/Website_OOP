<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$current_page = basename($_SERVER['PHP_SELF']);
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="assets/css/header.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<!-- TOPBAR -->
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

<?php
$page = '';
$views = 'views/';
if ($current_page == 'blog.php' || $current_page == 'blog_detail.php') {
    $page = '../';
    $views = '';
}
?>

<!-- MENU -->
<div class="menu">
    <a href="<?= $page ?>index.php" class="<?= ($current_page == 'index.php') ? 'active' : '' ?>">HOME</a>
    <a href="<?= $page ?>bikes.php">XE ĐẠP</a>
    <a href="<?= $page ?>sell.php">ĐĂNG TIN</a>
    <a href="<?= $page ?>services.php">DỊCH VỤ</a>
    <a href="<?= $views ?>blog.php">BLOG</a>
    <a href="<?= $page ?>contact.php">LIÊN HỆ</a>
</div>

<!-- ICON -->
<div class="icons">

    <!-- SEARCH -->
    <div class="search-box">
        <input type="text" id="searchInput" placeholder="Tìm kiếm">
        <button><i class="fa fa-search"></i></button>
        <div id="searchDropdown"></div>
    </div>

    <!-- USER -->
    <?php if($is_logged_in): ?>
        <a href="profile.php" class="user-pill">
            <img src="<?= $avatar ?>">
            <span><?= $_SESSION['khach_hang']['ho_ten'] ?></span>
        </a>
    <?php else: ?>
        <a href="login.php" style="color:white;margin-right:15px;">
            <i class="fa fa-user"></i>
        </a>
    <?php endif; ?>

    <!-- CART -->
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

<!-- JS SEARCH -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchInput');
    const searchDropdown = document.getElementById('searchDropdown');

    if (!searchInput || !searchDropdown) return;

    let timeout;

    searchInput.addEventListener('input', function () {
        const query = this.value.trim();
        clearTimeout(timeout);

        if (query.length < 1) {
            searchDropdown.classList.remove('show');
            searchDropdown.innerHTML = '';
            return;
        }

        timeout = setTimeout(() => {

            fetch(`search_suggest.php?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {

                    if (!data || data.length === 0) {
                        searchDropdown.innerHTML =
                            '<div class="search-no-results">Không tìm thấy</div>';
                        searchDropdown.classList.add('show');
                        return;
                    }

                    searchDropdown.innerHTML = data.map(item => `
                        <div class="search-suggestion" onclick="selectSuggestion(${item.bicycle_id})">
                            <img src="../${item.main_image}" 
                                 onerror="this.src='assets/images/default-bike.png'">
                            <div class="search-suggestion-info">
                                <h6>${item.name}</h6>
                                <p>${formatPrice(item.price)}₫</p>
                            </div>
                        </div>
                    `).join('');

                    searchDropdown.classList.add('show');

                })
                .catch(err => {
                    console.error(err);
                    searchDropdown.innerHTML =
                        '<div class="search-no-results">Lỗi tải</div>';
                    searchDropdown.classList.add('show');
                });

        }, 300);
    });

    // click ngoài
    document.addEventListener('click', function (e) {
        if (!searchInput.contains(e.target) && !searchDropdown.contains(e.target)) {
            searchDropdown.classList.remove('show');
        }
    });

    // chuyển trang
    window.selectSuggestion = function (id) {
        window.location.href = `detail.php?id=${id}`;
    }

    function formatPrice(price) {
        return new Intl.NumberFormat('vi-VN').format(price);
    }

    // Enter search
    searchInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            window.location.href = `bikes.php?search=${searchInput.value}`;
        }
    });

});
</script>