<?php
$current_page = basename($_SERVER['PHP_SELF']);
$baseURL = "http://localhost:8000/";
?>

<?php include 'sidebar.php'; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
.sidebar {
    position: fixed !important;
    top: 0;
    left: 0;
    height: 100vh;
    z-index: 1000;
}

.main {
    margin-left: 260px;
    padding: 30px;
    background: #f5f6fa;
    min-height: 100vh;
}

/* Card */
.card-box {
    background: #fff;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

.cover-wrapper {
    position: relative;
    width: 100%;
    height: 250px;
    border-radius: 15px;
    overflow: visible;
}

.cover-wrapper::after {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.15);
    pointer-events: none;
}

.cover-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    background: #ddd;
    display: block;
    font-size: 0;
}

/* nút camera cover */
.cover-camera {
    position: absolute;
    top: 15px;
    right: 15px;
    background: white;
    color: #7c4dff;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

/* Avatar */
.avatar-wrapper {
    position: absolute;
    bottom: -50px;
    left: 50%;
    transform: translateX(-50%);
}

.avatar-preview {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    object-fit: cover;
    border: 5px solid white;
    background: #ccc;
}

/* nút camera avatar */
.avatar-camera {
    position: absolute;
    bottom: 5px;
    right: 5px;
    background: #7c4dff;
    color: white;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 3px 10px rgba(0,0,0,0.2);
}

.camera-btn {
    transition: all 0.2s ease;
}

.camera-btn:hover {
    transform: scale(1.15);
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}

.suggest-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
}

.suggest-item img {
    width: 100%;
    border-radius: 10px;
    cursor: pointer;
    border: 2px solid transparent;
}

.suggest-item img:hover {
    transform: scale(1.05);
}

.suggest-item.active img {
    border: 2px solid #5b5ce2;
}

/* Button */
.btn-primary {
    background: #5b5ce2;
    border: none;
    border-radius: 10px;
}

.btn-primary:hover {
    background: #4a4bd1;
}

.btn-secondary {
    border-radius: 10px;
}
</style>

<div class="main d-flex justify-content-center">

    <div class="card-box" style="width: 100%; max-width: 1000px;">

        <h3 class="mb-4 text-center">➕ Thêm người dùng</h3>

        <form id="addUserForm" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-5">
                    <div class="cover-wrapper mb-5">

                        <!-- Cover -->
                        <img id="coverPreview" class="cover-img">

                        <label class="camera-btn cover-camera">
                            <i class="bi bi-camera-fill"></i>
                            <input type="file" name="cover" hidden onchange="previewCover(event)">
                        </label>

                        <!-- Avatar -->
                        <div class="avatar-wrapper">
                            <img id="preview" class="avatar-preview" src="https://via.placeholder.com/150">

                            <label class="camera-btn avatar-camera">
                                <i class="bi bi-camera-fill"></i>
                                <input type="file" name="avatar" hidden onchange="previewImage(event)">
                            </label>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label">Chọn avatar có sẵn</label>

                        <div id="suggestList" class="suggest-grid"></div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="mb-3">
                        <label class="form-label">Tên</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" name="dien_thoai" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ngày sinh</label>
                        <input type="date" name="ngay_sinh" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" name="dia_chi" class="form-control">
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="user_page.php?page=user_management" class="btn btn-secondary px-4">
                            Hủy
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            💾 Tạo mới
                        </button>
                    </div>
                </div>
            </div>
        </form>

    </div>

    <!-- Modal thông báo thành công -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
        <div class="modal-header bg-success text-white">
            <h5 class="modal-title">Thành công</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
        </div>
        <div class="modal-body">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
            <p class="mt-3 mb-0">Người dùng đã được thêm thành công!</p>
        </div>
        <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-success px-4" data-bs-dismiss="modal">OK</button>
        </div>
        </div>
    </div>
    </div>

    <script>

        async function loadSuggestAvatar() {
            let res = await fetch("http://localhost/website_oop/file-service/public/upload?action=list&type=suggest");
            let data = await res.json();

            let html = "";

            data.files.forEach(file => {
                html += `
                    <div class="suggest-item" onclick="selectAvatar(this, '${file.path}', '${file.url}')">
                        <img src="${file.url}">
                    </div>
                `;
            });

            document.getElementById("suggestList").innerHTML = html;
        }

        loadSuggestAvatar();

        let selectedAvatar = null;

        function selectAvatar(el, path, url) {
            document.querySelectorAll(".suggest-item").forEach(i => i.classList.remove("active"));
            el.classList.add("active");

            document.getElementById("preview").src = url;

            selectedAvatar = path;
        }

        function previewCover(event) {
            const reader = new FileReader();
            reader.onload = function(){
                document.getElementById('coverPreview').src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                document.getElementById('preview').src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);

            // reset chọn sẵn
            selectedAvatar = null;
            document.querySelectorAll(".suggest-item").forEach(i => i.classList.remove("active"));
        }

        document.getElementById("addUserForm").addEventListener("submit", async function(e) {
            e.preventDefault();

            const form = this;

            let avatarFile = form.avatar.files[0];
            let coverFile = form.cover.files[0];

            let avatarPath = null;
            let coverPath = null;

            // Upload avatar
            if (avatarFile) {
                let fd = new FormData();
                fd.append("file", avatarFile);

                let res = await fetch("http://localhost/website_oop/file-service/public/upload?action=upload&type=avatar", {
                    method: "POST",
                    body: fd
                });

                let data = await res.json();
                avatarPath = data.path;
            }

            // Upload cover
            if (coverFile) {
                let fd = new FormData();
                fd.append("file", coverFile);

                let res = await fetch("http://localhost/website_oop/file-service/public/upload?action=upload&type=cover", {
                    method: "POST",
                    body: fd
                });

                let data = await res.json();
                coverPath = data.path;
            }

            // Gửi dữ liệu user
            let userData = new FormData();

            userData.append("name", form.name.value);
            userData.append("email", form.email.value);
            userData.append("password", form.password.value);
            userData.append("dien_thoai", form.dien_thoai.value);
            userData.append("ngay_sinh", form.ngay_sinh.value);
            userData.append("dia_chi", form.dia_chi.value);

            if (selectedAvatar) {
                userData.append("anh_dai_dien", selectedAvatar);
            } else if (avatarPath) {
                userData.append("anh_dai_dien", avatarPath);
            }
            if (coverPath) userData.append("anh_nen", coverPath);

            let res = await fetch("http://localhost/website_oop/user-service/public/users", {
                method: "POST",
                body: userData
            });

            let result = await res.json();

            if (result.status === "success") {
                let successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();

                document.querySelector("#successModal .btn-success").addEventListener("click", () => {
                    window.location.href = "user_page.php?page=user_management";
                });
            } else {
                alert(result.error || "Có lỗi xảy ra");
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</div>