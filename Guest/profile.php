<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'config.php';

if (!isset($_SESSION['khach_hang'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['khach_hang'];
$id_kh = $user['id_khach_hang'];

// Hàm xóa ảnh cũ an toàn
function deleteOldImage($old_path) {
    if (!empty($old_path) && file_exists($old_path) && strpos($old_path, 'uploads/') === 0) {
        @unlink($old_path);
    }
}

/* ======================== XỬ LÝ AVATAR ======================== */
// Upload avatar từ máy
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['avatar_upload']) && $_FILES['avatar_upload']['error'] === UPLOAD_ERR_OK) {
    $target_dir = "uploads/avatars/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

    $file = $_FILES['avatar_upload'];
    $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $fileName = time() . '_' . uniqid() . '.' . $ext;
    $target_file = $target_dir . $fileName;

    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        echo "<script>alert('File không phải là ảnh!');</script>";
    } elseif ($file["size"] > 5000000) {
        echo "<script>alert('File quá lớn (tối đa 5MB)');</script>";
    } elseif (!in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
        echo "<script>alert('Chỉ chấp nhận JPG, JPEG, PNG, GIF, WEBP');</script>";
    } else {
        deleteOldImage($user['anh_dai_dien']);

        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            $sql = "UPDATE khach_hang SET anh_dai_dien = ? WHERE id_khach_hang = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("si", $target_file, $id_kh);
                $stmt->execute();
                $stmt->close();

                $_SESSION['khach_hang']['anh_dai_dien'] = $target_file;

                echo "<script>alert('Cập nhật avatar thành công!'); window.location='profile.php';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Lỗi khi tải lên file avatar.');</script>";
        }
    }
}

// Chọn avatar từ thư viện (local folder)
// Chọn avatar từ thư viện (local folder) - ĐÃ SỬA KHÔNG XÓA ẢNH THƯ VIỆN
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['set_unsplash_avatar'])) {
    $url = filter_var($_POST['avatar_url'], FILTER_SANITIZE_URL);

    // CHỈ XÓA ẢNH CŨ NẾU NÓ LÀ ẢNH UPLOAD CÁ NHÂN (có timestamp trong tên)
    // Ảnh thư viện có tên avatar1.jpg -> avatar8.jpg → KHÔNG XÓA
    if (!empty($user['anh_dai_dien']) && 
        strpos(basename($user['anh_dai_dien']), 'avatar') !== 0 &&  // Không bắt đầu bằng "avatar"
        strpos($user['anh_dai_dien'], 'uploads/avatars/') === 0) {  // Là ảnh trong folder avatars
        deleteOldImage($user['anh_dai_dien']);
    }

    $sql = "UPDATE khach_hang SET anh_dai_dien = ? WHERE id_khach_hang = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("si", $url, $id_kh);
        $stmt->execute();
        $stmt->close();

        $_SESSION['khach_hang']['anh_dai_dien'] = $url;

        echo "<script>alert('Thay đổi avatar thành công!'); window.location='profile.php';</script>";
        exit;
    }
}

/* ======================== XỬ LÝ ẢNH BÌA ======================== */
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['cover_upload']) && $_FILES['cover_upload']['error'] === UPLOAD_ERR_OK) {
    $target_dir = "uploads/covers/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

    $file = $_FILES['cover_upload'];
    $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $fileName = time() . '_' . uniqid() . '.' . $ext;
    $target_file = $target_dir . $fileName;

    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        echo "<script>alert('File ảnh bìa không phải là ảnh!');</script>";
    } elseif ($file["size"] > 10000000) {
        echo "<script>alert('File ảnh bìa quá lớn (tối đa 10MB)');</script>";
    } elseif (!in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
        echo "<script>alert('Chỉ chấp nhận JPG, JPEG, PNG, GIF, WEBP');</script>";
    } else {
        deleteOldImage($user['anh_nen'] ?? '');

        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            $sql = "UPDATE khach_hang SET anh_nen = ? WHERE id_khach_hang = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("si", $target_file, $id_kh);
                $stmt->execute();
                $stmt->close();

                $_SESSION['khach_hang']['anh_nen'] = $target_file;

                echo "<script>alert('Cập nhật ảnh bìa thành công!'); window.location='profile.php';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Lỗi khi tải lên ảnh bìa.');</script>";
        }
    }
}

/* ======================== DỮ LIỆU KHÁC ======================== */
$dob = '01/01/1990';
$address = ['country'=>'Việt Nam','city'=>'Hà Nội','street'=>'123 Đường ABC','postal'=>'10000'];

$password_success = $password_error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'change_password') {
    // Code đổi mật khẩu giữ nguyên như cũ
    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
        $password_error = 'Vui lòng nhập đầy đủ thông tin.';
    } elseif ($new_password !== $confirm_password) {
        $password_error = 'Mật khẩu mới và xác nhận không khớp.';
    } elseif (strlen($new_password) < 6) {
        $password_error = 'Mật khẩu mới phải ít nhất 6 ký tự.';
    } else {
        $sql_old = "SELECT mat_khau FROM khach_hang WHERE id_khach_hang = ?";
        $stmt_old = $conn->prepare($sql_old);
        $stmt_old->bind_param("i", $id_kh);
        $stmt_old->execute();
        $old_result = $stmt_old->get_result();
        if ($old_row = $old_result->fetch_assoc()) {
            if (password_verify($old_password, $old_row['mat_khau'])) {
                $hashed_new = password_hash($new_password, PASSWORD_DEFAULT);
                $sql_update = "UPDATE khach_hang SET mat_khau = ? WHERE id_khach_hang = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("si", $hashed_new, $id_kh);
                if ($stmt_update->execute()) {
                    $password_success = 'Cập nhật mật khẩu thành công!';
                } else {
                    $password_error = 'Lỗi cập nhật. Vui lòng thử lại.';
                }
            } else {
                $password_error = 'Mật khẩu cũ không đúng.';
            }
        }
    }
}


?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài khoản của tôi - BikeMarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/Css/style.css">
    <link rel="stylesheet" href="assets/css/profile.css">

</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="container my-4">
    <div class="row">
        <div class="col-md-3">
            <div class="profile-card">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link active" href="#profile" onclick="switchTab('profile')"><i class="bi bi-person me-2"></i>Tài khoản</a></li>
                    <li class="nav-item"><a class="nav-link" href="#settings" onclick="switchTab('settings')"><i class="bi bi-gear me-2"></i>Cài đặt</a></li>
                </ul>
            </div>
        </div>

        <div class="col-md-9">
            <!-- HEADER VỚI ẢNH BÌA -->
            <div class="profile-card mb-4">
                <div class="profile-header text-center position-relative <?= !empty($user['anh_nen']) ? 'has-cover' : '' ?>">
                    <?php if (!empty($user['anh_nen'])): ?>
                        <img src="<?= htmlspecialchars($user['anh_nen']) ?>" alt="Ảnh bìa" class="cover-image">
                    <?php endif; ?>

                    <div class="bubble bubble-1"></div>
                    <div class="bubble bubble-2"></div>
                    <div class="bubble bubble-3"></div>

                    <button class="change-cover-btn" data-bs-toggle="modal" data-bs-target="#coverModal">
                        <i class="fas fa-camera"></i>
                    </button>

                    <div class="avatar-container mt-4">
                        <?php if (!empty($user['anh_dai_dien'])): ?>
                            <img src="<?= htmlspecialchars($user['anh_dai_dien']) ?>" alt="Avatar" class="avatar">
                        <?php else: ?>
                            <div class="avatar d-flex align-items-center justify-content-center bg-light">
                                <i class="fas fa-user text-primary fs-1"></i>
                            </div>
                        <?php endif; ?>
                        <button class="change-avatar-btn" data-bs-toggle="modal" data-bs-target="#avatarModal">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>
                    <h2 class="user-name"><?= htmlspecialchars($user['ho_ten']) ?></h2>
                    <p class="user-location mb-0">Khách hàng thân thiết</p>
                </div>
            </div>

            <!-- Tab thông tin cá nhân -->
            <div id="profile" class="tab-content active">
                <div class="profile-card">
                    <div class="section-header d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-person-badge me-2"></i>Thông tin cá nhân</span>
                        <button class="edit-btn" onclick="editPersonal()">Chỉnh sửa</button>
                    </div>
                    <div class="info-grid">
                        <div class="info-row"><span class="info-label">Họ và tên</span><span class="info-value"><?= htmlspecialchars($user['ho_ten']) ?></span></div>
                        <div class="info-row"><span class="info-label">Email</span><span class="info-value"><?= htmlspecialchars($user['email']) ?></span></div>
                        <div class="info-row"><span class="info-label">Ngày sinh</span><span class="info-value"><?= $dob ?></span></div>
                        <div class="info-row"><span class="info-label">Số điện thoại</span><span class="info-value"><?= htmlspecialchars($user['dien_thoai'] ?? 'Chưa cập nhật') ?></span></div>
                    </div>
                </div>

                <div class="profile-card">
                    <div class="section-header d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-geo-alt me-2"></i>Địa chỉ giao hàng</span>
                        <button class="edit-btn" onclick="editAddress()">Chỉnh sửa</button>
                    </div>
                    <div class="info-grid">
                        <div class="info-row"><span class="info-label">Quốc gia</span><span class="info-value"><?= $address['country'] ?></span></div>
                        <div class="info-row"><span class="info-label">Thành phố</span><span class="info-value"><?= $address['city'] ?></span></div>
                        <div class="info-row"><span class="info-label">Địa chỉ</span><span class="info-value"><?= $address['street'] ?></span></div>
                        <div class="info-row"><span class="info-label">Mã bưu điện</span><span class="info-value"><?= $address['postal'] ?></span></div>
                    </div>
                </div>
            </div>

 
            <!-- Tab cài đặt -->
            <div id="settings" class="tab-content">
                <div class="profile-card">
                    <div class="section-header"><i class="bi bi-shield-lock me-2"></i>Thay đổi mật khẩu</div>
                    <div class="info-grid">
                        <?php if ($password_success): ?><div class="alert alert-success"><?= $password_success ?></div><?php endif; ?>
                        <?php if ($password_error): ?><div class="alert alert-danger"><?= $password_error ?></div><?php endif; ?>
                        <form method="POST" class="p-3">
                            <input type="hidden" name="action" value="change_password">
                            <div class="row">
                                <div class="col-md-4 mb-3"><input type="password" name="old_password" class="form-control" placeholder="Mật khẩu cũ" required></div>
                                <div class="col-md-4 mb-3"><input type="password" name="new_password" class="form-control" placeholder="Mật khẩu mới" required></div>
                                <div class="col-md-4 mb-3"><input type="password" name="confirm_password" class="form-control" placeholder="Xác nhận" required></div>
                            </div>
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL THAY ẢNH ĐẠI DIỆN -->
<div class="modal fade" id="avatarModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header text-white" style="background:linear-gradient(135deg,#9c27b0,#3f51b5);">
                <h5 class="modal-title fw-bold">Thay đổi ảnh đại diện</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="avatar_upload" class="form-label fw-bold fs-5">Chọn ảnh đại diện từ máy tính</label>
                        <input type="file" name="avatar_upload" id="avatar_upload" accept="image/*" class="form-control form-control-lg" required>
                    </div>
                    <p class="text-muted mb-4">Hỗ trợ: JPG, PNG, GIF, WEBP (tối đa 5MB)</p>
                    <button type="submit" class="btn btn-primary btn-lg px-5">
                        Tải lên & Đặt làm avatar
                    </button>
                </form>

                <hr class="my-5">
                <h6 class="fw-bold mb-4">Hoặc chọn từ thư viện gợi ý của web</h6>
                <div class="row g-4">
<?php
                    $avatar_dir = "uploads/avatars/suggest/";
                    // Tạo danh sách 8 ảnh cố định avatar1 đến avatar8
                    $local_avatars = [];
                    for ($i = 1; $i <= 8; $i++) {
                        $possible_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                        $found = false;
                        foreach ($possible_extensions as $ext) {
                            $file_path = $avatar_dir . "avatar" . $i . "." . $ext;
                            if (file_exists($file_path)) {
                                $local_avatars[] = $file_path;
                                $found = true;
                                break;
                            }
                        }
                        // Nếu không tìm thấy ảnh nào cho số i, thêm placeholder (tùy chọn)
                        if (!$found) {
                            $local_avatars[] = 'https://via.placeholder.com/600?text=Avatar+' . $i;
                        }
                    }

                    foreach ($local_avatars as $img): ?>
                        <div class="col-6 col-md-4 col-lg-3">
                            <form method="POST">
                                <input type="hidden" name="set_unsplash_avatar" value="1">
                                <input type="hidden" name="avatar_url" value="<?= $img ?>">
                                <button type="submit" class="btn p-0 border-0 rounded-4 overflow-hidden shadow w-100">
                                    <img src="<?= $img ?>" class="img-fluid rounded-4" style="height:140px;object-fit:cover;" onerror="this.src='https://via.placeholder.com/600?text=No+Image';">
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                    
                </div>
                <div class="text-center mt-4 text-muted small">Ảnh gợi ý từ thư mục suggest (uploads/avatars/suggest/)</div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL ẢNH BÌA -->
<div class="modal fade" id="coverModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header text-white" style="background:linear-gradient(135deg,#673ab7,#e91e63);">
                <h5 class="modal-title fw-bold">Thay đổi ảnh bìa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <form method="POST" enctype="multipart/form-data">
                    <input type="file" name="cover_upload" accept="image/*" class="form-control form-control-lg" required>
                    <p class="text-muted mt-2">Khuyến nghị: 1500x500px trở lên</p>
                    <button type="submit" class="btn btn-primary btn-lg mt-3 px-5">
                        Tải lên & Đặt làm ảnh bìa
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/profile.js"></script>
</body>
</html>