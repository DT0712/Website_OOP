<?php
$current_page = basename($_SERVER['PHP_SELF']);
$baseURL = "http://localhost:8000/";
?>

<?php include 'sidebar.php'; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.user-detail-card {
    padding: 30px;
    border-radius: 16px;
    background: #fff;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.user-detail-content {
    display: flex;
    align-items: center;
    gap: 30px;
}

/* AVATAR */
.avatar-box {
    flex: 0 0 90px;
}

.avatar-lg {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #f1f3f7;
}

/* INFO LEFT */
.user-info-box h4 {
    font-weight: 600;
    color: #333;
}

.city {
    font-size: 13px;
    color: #5b5ce2;
}

/* Grid info */
.info-grid {
    display: flex;
    gap: 40px;
}

.info-item {
    display: flex;
    flex-direction: column;
}

.label {
    font-size: 12px;
    color: #999;
}

.value {
    font-size: 14px;
    font-weight: 500;
    color: #333;
}

.sidebar {
    position: fixed !important;
    top: 0;
    left: 0;
    height: 100vh;
    z-index: 1000;
}

.main {
    margin-left: 260px;
    padding: 20px;
}
</style>

<div class="main">
    <div class="card-box user-detail-card">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="title mb-0">👤 THÔNG TIN KHÁCH HÀNG</h5>
        </div>

        <div class="user-detail-content">

            <!-- AVATAR -->
            <div class="avatar-box">
                <img id="avatar" class="avatar-lg">
            </div>

            <!-- INFO -->
            <div class="user-info-box">
                <h4 class="mb-1" id="name"></h4>
                <span class="city" id="address"></span>

                <div class="info-grid mt-3">
                    <div class="info-item">
                        <span class="label">Số điện thoại</span>
                        <span class="value" id="phone"></span>
                    </div>

                    <div class="info-item">
                        <span class="label">Email</span>
                        <span class="value" id="email"></span>
                    </div>

                    <div class="info-item">
                        <span class="label">Ngày sinh</span>
                        <span class="value" id="dob"></span>
                    </div>

                    <div class="info-item">
                        <span class="label">Ngày tham gia</span>
                        <span class="value" id="created"></span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>

        const API = "http://localhost/website_oop/user-service/public/users";

        function getUserId() {
            const params = new URLSearchParams(window.location.search);
            return params.get("id");
        }

        async function loadUser() {
            const id = getUserId();

            let res = await fetch(`${API}/${id}`);
            let user = await res.json();

            document.getElementById('name').innerText = user.ho_ten;
            document.getElementById('address').innerHTML = `<i class="fa fa-location-dot me-1"></i> ` + (user.dia_chi || 'Chưa cập nhật');
            document.getElementById('phone').innerText = user.dien_thoai;
            document.getElementById('email').innerText = user.email;
            document.getElementById('dob').innerText = user.ngay_sinh || 'Chưa cập nhật';
            document.getElementById('created').innerText = user.ngay_tao;

            document.getElementById("avatar").src =
                user.anh_dai_dien
                ? "http://localhost/website_oop/file-service/storage/" + user.anh_dai_dien
                : "https://i.pravatar.cc/100";
        }

        loadUser();
    </script>
</div>