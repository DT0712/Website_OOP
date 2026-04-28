<?php
$current_page = basename($_SERVER['PHP_SELF']);
$baseURL = "http://localhost:8000/";
?>

<?php include 'sidebar.php'; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>

.card {
    border-radius: 15px;
}

.card-header {
    border-radius: 15px 15px 0 0;
    font-weight: 600;
}

.cover-wrapper {
    position: relative;
}

.cover-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 15px;
}

.change-cover {
    position: absolute;
    bottom: 10px;
    right: 10px;
}

/* Avatar */
.avatar-preview {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #eee;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.avatar-suggest {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    max-height: 200px;
    overflow-y: auto;
}

.avatar-suggest img {
    width: 100%;
    aspect-ratio: 1/1;
    border-radius: 50%;
    cursor: pointer;
    border: 2px solid transparent;
    transition: 0.2s;
}

.avatar-suggest img:hover {
    border: 2px solid #5b5ce2;
    transform: scale(1.05);
}

/* avatar đang chọn */
.avatar-selected {
    border: 3px solid #5b5ce2 !important;
}

/* Buttons */
.btn-save {
    background: #5b5ce2;
    color: white;
    border-radius: 10px;
    padding: 8px 16px;
}

.btn-save:hover {
    background: #4a4bd1;
}

.btn-cancel {
    background: #eee;
    border-radius: 10px;
    padding: 8px 16px;
}

.btn-cancel:hover {
    background: #ddd;
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

.camera-btn {
    position: absolute;
    bottom: 5px;
    right: 5px;
    background: #000;
    color: white;
    border-radius: 50%;
    padding: 8px;
    cursor: pointer;
    font-size: 14px;
}

.camera-btn:hover {
    background: #333;
}

/* Ẩn icon mặc định của Edge/Chrome */
input[type="password"]::-ms-reveal {
    display: none;
}

input[type="password"]::-ms-clear {
    display: none;
}

input[type="password"]::-webkit-credentials-auto-fill-button {
    display: none !important;
}
</style>

<div class="main">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">✏️ Chỉnh sửa người dùng</h4>
            </div>

            <div class="card-body">

                <form id="editForm" enctype="multipart/form-data">

                    <div class="cover-wrapper mb-5">

                        <!-- Cover -->
                        <img id="coverPreview"
                            src="https://via.placeholder.com/800x200"
                            class="cover-img">

                        <!-- Button chọn cover -->
                        <label class="camera-btn">
                            <i class="bi bi-camera-fill"></i>
                            <input type="file" name="cover" hidden onchange="previewCover(event)">
                        </label>

                    </div>

                    <div class="row">

                        <!-- AVATAR -->
                        <div class="col-md-4 text-center">
                            <div class="avatar-upload position-relative d-inline-block">
                                <img id="preview" class="avatar-preview">

                                <label class="camera-btn">
                                    <i class="bi bi-camera-fill"></i>
                                    <input type="file" name="avatar" hidden onchange="previewImage(event)">
                                </label>
                            </div>

                            <!-- AVATAR CÓ SẴN -->
                            <div class="mt-4">
                                <p class="fw-semibold mb-2">Avatar có sẵn</p>
                                <div id="avatarList" class="avatar-suggest"></div>
                            </div>
                        </div>

                        <!-- FORM INFO -->
                        <div class="col-md-8">

                            <div class="mb-3">
                                <label class="form-label">Tên</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" id="email"
                                    class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Mật khẩu</label>
                                <div class="position-relative">
                                    <input type="password"
                                        id="password"
                                        name="password"
                                        class="form-control pe-5"
                                        placeholder="Nhập mật khẩu mới (nếu muốn thay đổi)"
                                        oninput="handlePasswordInput()">

                                    <i class="bi bi-eye d-none"
                                    id="eyeIcon"
                                    onclick="togglePassword()"
                                    style="
                                            position: absolute;
                                            right: 12px;
                                            top: 50%;
                                            transform: translateY(-50%);
                                            cursor: pointer;
                                            font-size: 18px;
                                    ">
                                    </i>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" name="phone" id="phone"
                                    class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Ngày sinh</label>
                                <input type="date" name="ngay_sinh" id="dob"
                                    class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Địa chỉ</label>
                                <input type="text" name="dia_chi" id="address"
                                    class="form-control">
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-save">
                                    💾 Lưu thay đổi
                                </button>

                                <a href="user_page.php?page=user_management" class="btn btn-cancel">
                                    Hủy
                                </a>
                            </div>

                        </div>

                    </div>

                </form>

            </div>
        </div>

    </div>

<div class="modal fade" id="successModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center p-3">
      <div class="modal-body">
        <p id="modalText"></p>
        <button class="btn btn-primary" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<script>

let currentAvatar = null;
let oldAvatar = null;
let currentCover = null;

const API = "http://localhost/website_oop/user-service/public/users";

function getUserId() {
    const params = new URLSearchParams(window.location.search);
    return params.get("id");
}

async function loadUser() {

    const id = getUserId();

    if (!id) {
        alert("Thiếu ID");
        return;
    }

    let res = await fetch(`${API}/${id}`);

    if (!res.ok) {
        alert("Không tìm thấy user");
        return;
    }

    let user = await res.json();

    oldAvatar = user.anh_dai_dien;
    currentCover = user.anh_nen;

    document.getElementById("name").value = user.ho_ten;
    document.getElementById("email").value = user.email;
    document.getElementById("phone").value = user.dien_thoai;
    document.getElementById("address").value = user.dia_chi;
    document.getElementById("dob").value = user.ngay_sinh;
    document.getElementById("password").value = "";

    document.getElementById("coverPreview").src =
        user.anh_nen
        ? "http://localhost/website_oop/file-service/storage/" + user.anh_nen
        : "https://via.placeholder.com/800x200";

    document.getElementById("preview").src =
        user.anh_dai_dien
        ? "http://localhost/website_oop/file-service/storage/" + user.anh_dai_dien
        : "https://i.pravatar.cc/150";
}

async function loadAvatarSuggest() {

    let res = await fetch("http://localhost/website_oop/file-service/public/upload?action=list&type=suggest");
    let data = await res.json();

    let container = document.getElementById("avatarList");
    container.innerHTML = "";

    if (data.status !== "success") {
        console.error("Lỗi load avatar:", data.message);
        return;
    }

    data.files.forEach(item => {

        let img = document.createElement("img");
        img.src = item.url;

        img.onclick = () => {

            // remove selected cũ
            document.querySelectorAll(".avatar-suggest img").forEach(i => {
                i.classList.remove("avatar-selected");
            });

            // set selected mới
            img.classList.add("avatar-selected");

            // set preview
            document.getElementById("preview").src = img.src;

            // lưu path
            currentAvatar = item.path;
        };

        container.appendChild(img);
    });
}

loadUser();

loadAvatarSuggest();

document.getElementById("editForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    const id = getUserId();

    let avatarFile = document.querySelector("[name='avatar']").files[0];
    let coverFile = document.querySelector("[name='cover']").files[0];

    let avatarPath = null;
    let coverPath = null;

    // upload avatar
    if (avatarFile) {
        let fd = new FormData();
        fd.append("file", avatarFile);

        if (oldAvatar) {
            fd.append("old_path", oldAvatar);
        }

        let res = await fetch("http://localhost/website_oop/file-service/public/upload?action=upload&type=avatar", {
            method: "POST",
            body: fd
        });

        let data = await res.json();
        avatarPath = data.path;
    } else if (currentAvatar) {
        avatarPath = currentAvatar;

        if (oldAvatar && oldAvatar !== currentAvatar) {
            await fetch("http://localhost/website_oop/file-service/public/delete?file=" 
                + encodeURIComponent(oldAvatar));
        }
    }

    // upload cover
    if (coverFile) {
        let fd = new FormData();
        fd.append("file", coverFile);

        if (currentCover) {
            fd.append("old_path", currentCover);
        }
        
        let res = await fetch("http://localhost/website_oop/file-service/public/upload?action=upload&type=cover", {
            method: "POST",
            body: fd
        });

        let data = await res.json();
        coverPath = data.path;
    }

    const formData = new FormData();

    formData.append("name", document.querySelector("[name='name']").value);
    formData.append("email", document.querySelector("[name='email']").value);
    formData.append("dien_thoai", document.querySelector("[name='phone']").value);
    formData.append("ngay_sinh", document.querySelector("[name='ngay_sinh']").value);
    formData.append("dia_chi", document.querySelector("[name='dia_chi']").value);

    const password = document.querySelector("[name='password']").value;

    if (password) {
        formData.append("password", password);
    }

    if (avatarPath) formData.append("anh_dai_dien", avatarPath);
    if (coverPath) formData.append("anh_nen", coverPath);

    let res = await fetch(`${API}/${id}`, {
        method: "POST",
        body: formData
    });

    let result = await res.json();

    if (res.ok) {
        showModal("Cập nhật thành công!", true);
    } else {
        showModal("Lỗi: " + (result.error || "Update thất bại"));
    }
});

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
}

function showModal(message, redirect = false) {

    document.getElementById("modalText").innerText = message;

    let modal = new bootstrap.Modal(document.getElementById("successModal"));
    modal.show();

    if (redirect) {
        document.getElementById("successModal")
            .addEventListener('hidden.bs.modal', function () {
                window.location.href = "user_page.php?page=user_management";
            }, { once: true });
    }
}

function handlePasswordInput() {
    const input = document.getElementById("password");
    const icon = document.getElementById("eyeIcon");

    if (input.value.length > 0) {
        icon.classList.remove("d-none");
    } else {
        icon.classList.add("d-none");
        input.type = "password";
        icon.classList.replace("bi-eye-slash", "bi-eye");
    }
}

function togglePassword() {
    const input = document.getElementById("password");
    const icon = document.getElementById("eyeIcon");

    if (input.type === "password") {
        input.type = "text";
        icon.classList.replace("bi-eye", "bi-eye-slash");
    } else {
        input.type = "password";
        icon.classList.replace("bi-eye-slash", "bi-eye");
    }
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>