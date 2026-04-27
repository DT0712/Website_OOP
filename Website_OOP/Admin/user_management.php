<?php
$current_page = basename($_SERVER['PHP_SELF']);
$baseURL = "http://localhost:8000/";
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
body {
    background: #f5f7fb;
}

/* Sidebar */
.sidebar {
    width: 250px;
    background: white;
    height: 100vh;
    padding: 20px;
    box-shadow: 0 0 20px rgba(0,0,0,.05);
    position: fixed;
    top: 0;
    left: 0;
}

.logo {
    font-size: 22px;
    font-weight: 700;
    color: #5b5ce2;
    margin-bottom: 30px;
}

.menu a {
    display: flex;
    align-items: center;
    gap: 10px;

    padding: 12px;
    border-radius: 10px;
    margin-bottom: 8px;

    text-decoration: none;
    color: #555;
    font-size: 14px;

    transition: 0.2s;
}

.menu a.active,
.menu a:hover {
    background: linear-gradient(90deg,#6c5ce7,#5b5ce2);
    color: white;
}

/* Main */
.main {
    margin-left: 260px;
    padding: 20px;
}

/* Card */
.card-box {
    border-radius: 12px;
    padding: 20px;
    background: #fff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

/* Badge */
.badge-active {
    background: #e6f7ee;
    color: green;
}

.badge-inactive {
    background: #fdecea;
    color: red;
}

.filter-btn {
    background: white;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 8px 16px;

    font-size: 14px;
    font-weight: 500;
    color: #333;

    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    transition: all 0.2s ease;
}

/* Hover */
.filter-btn:hover {
    background: #f8f9ff;
    border-color: #5b5ce2;
    color: #5b5ce2;

    box-shadow: 0 4px 12px rgba(91,92,226,0.15);
}

/* Click */
.filter-btn:focus {
    box-shadow: 0 0 0 3px rgba(91,92,226,0.2);
}

/* Dropdown */
.dropdown-menu {
    border-radius: 10px;
    border: 1px solid #eee;
    padding: 5px;
}

/* Item */
.dropdown-item {
    border-radius: 8px;
    font-size: 14px;
    padding: 8px 12px;
}

/* Hover item */
.dropdown-item:hover {
    background: #f1f3ff;
    color: #5b5ce2;
}

/* Add button */
.btn-add-user {
    background: linear-gradient(90deg,#6c5ce7,#5b5ce2);
    color: white;
    padding: 10px 20px;
    border-radius: 15px;
    text-decoration: none;
    font-weight: 500;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-add-user:hover {
    opacity: 0.9;
    transform: translateY(-2px);
}

/* SEARCH STYLE */
.search-box-modern {
    position: relative;
    width: 250px;
    border: 1px solid #1c1a1a;
    border-radius: 8px;
}

.search-box-modern i {
    position: absolute;
    top: 50%;
    left: 12px;
    transform: translateY(-50%);
    color: #aaa;
    font-size: 13px;
}

.search-box-modern input {
    width: 100%;
    padding: 8px 12px 8px 35px;
    border-radius: 8px;
    border: 1px solid #eee;
    background: #f5f7fb;
    font-size: 14px;
    outline: none;
    transition: 0.2s;
}

.search-box-modern input:focus {
    background: #fff;
    border-color: #5b5ce2;
    box-shadow: 0 0 0 2px rgba(91,92,226,0.1);
}

/* BUTTON NHẸ */
.btn-lite {
    border: 1px solid #1c1a1a;
    background: #f5f7fb;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 13px;
    color: #555;
    cursor: pointer;
    transition: 0.2s;
}

.btn-lite:hover {
    background: #fff;
    border-color: #5b5ce2;
    color: #5b5ce2;
}

.action-cell {
    text-align: center;
    vertical-align: middle;
}

.action-wrapper {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
}

.action-btn {
    border: none;
    background: #f1f3f7;
    width: 36px;
    height: 36px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 10px;
    cursor: pointer;
    transition: 0.2s;
}

.action-btn:hover {
    background: #e4e7ec;
    transform: scale(1.05);
}

.action-menu {
    position: absolute;
    top: 110%;
    right: 0;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    min-width: 140px;
    display: none;
    z-index: 999;
    overflow: hidden;
}

.action-menu a {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px;
    text-decoration: none;
    color: #333;
    font-size: 14px;
    border-radius: 8px;
}

.action-menu a:hover {
    background: #f1f3ff;
    color: #5b5ce2;
}

.table {
    border-collapse: separate;
    border-spacing: 0;
}

.table tbody tr {
    border-bottom: 1px solid #eee;
}

.table th,
.table td {
    border-right: 1px solid #eee;
}

.table th:last-child,
.table td:last-child {
    width: 70px;
    border-right: none;
}

.section-divider {
    border-bottom: 1px solid #e1d9d9;
    margin: 15px 0;
}

.avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
}

.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 2000;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="logo">
        VENUS <br>
        <small style="font-size:12px;color:#999">DASHBOARD</small>
    </div>

    <div class="menu">

        <a href="dashboard.php" class="<?= ($current_page == 'dashboard.php') ? 'active' : '' ?>">
            <i class="fa fa-chart-line"></i> Dashboard
        </a>

        <a href="user_page.php?page=user_management" class="<?= ($_GET['page'] ?? '') == 'user_management' ? 'active' : '' ?>">
            <i class="fa fa-users"></i> Quản lý người dùng
        </a>

        <a href="bicycle_management.php" class="<?= ($current_page == 'bicycle_management.php') ? 'active' : '' ?>">
            <i class="fa fa-bicycle"></i> Quản lý xe đạp
        </a>

        <a href="inspection_management.php" class="<?= ($current_page == 'inspection_management.php') ? 'active' : '' ?>">
            <i class="fa fa-check-circle"></i> Kiểm định xe
        </a>

        <a href="transaction_management.php" class="<?= ($current_page == 'transaction_management.php') ? 'active' : '' ?>">
            <i class="fa fa-credit-card"></i> Giao dịch
        </a>

        <a href="message_management.php" class="<?= ($current_page == 'message_management.php') ? 'active' : '' ?>">
            <i class="fa fa-envelope"></i> Tin nhắn
        </a>

        <a href="system_statistics.php" class="<?= ($current_page == 'system_statistics.php') ? 'active' : '' ?>">
            <i class="fa fa-chart-bar"></i> Thống kê
        </a>

    </div>

</div>

<!-- MAIN -->
<div class="main">

    <h3 class="mb-4">👤 Quản lý người dùng</h3>

    <div class="section-divider"></div>

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <a href="user_page.php?page=user_create" class="btn-add-user">
            + Add User
        </a>
    </div>

    <div class="section-divider"></div>

    <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">

        <!-- SEARCH -->
        <div class="search-box-modern">
            <i class="fa fa-search"></i>
            <input type="text" id="searchInput" placeholder="Search">
        </div>

        <!-- SORT -->
        <div class="dropdown">
            <button class="btn-lite dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fa fa-sort"></i> Sort
            </button>

            <ul class="dropdown-menu">
                <li><a class="dropdown-item sort-item" data-sort="name">Name</a></li>
                <li><a class="dropdown-item sort-item" data-sort="email">Email</a></li>
            </ul>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card-box">

        <table class="table align-middle" id="userTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody></tbody>
        </table>

    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">

        <div class="modal-header">
            <h5 class="modal-title text-danger">Xác nhận xóa</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            Bạn có chắc muốn xóa user này?
        </div>

        <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Xóa</button>
        </div>

        </div>
    </div>
    </div>

    <!-- TOAST -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1100">
    <div id="liveToast" class="toast align-items-center text-white border-0" role="alert">
        <div class="d-flex">
        <div class="toast-body" id="toastMessage"></div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
    </div>

    <!-- LOADING -->
    <div id="loadingOverlay" class="loading-overlay d-none">
    <div class="spinner-border text-light"></div>
    </div>

    <script>

    async function loadUsers() {

        let res = await fetch("http://localhost/website_oop/user-service/public/users");
        let data = await res.json();

        let tbody = document.querySelector("#userTable tbody");

        tbody.innerHTML = "";

        data.data.forEach(user => {

            let avatar = user.anh_dai_dien 
                ? "http://localhost/website_oop/file-service/public/" + user.anh_dai_dien
                : "https://i.pravatar.cc/40";

            let row = `
                <tr>
                    <td>${user.id_khach_hang}</td>

                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img src="${avatar}" class="avatar">
                            <b>${user.ho_ten}</b>
                        </div>
                    </td>

                    <td>${user.email}</td>

                    <td class="action-cell">
                        <div class="action-wrapper">
                            <button class="action-btn">
                                <i class="fa fa-ellipsis-vertical"></i>
                            </button>

                            <div class="action-menu">
                                <a href="user_page.php?page=user_detail&id=${user.id_khach_hang}">
                                    <i class="fa fa-eye"></i> View
                                </a>

                                <a href="user_page.php?page=user_edit&id=${user.id_khach_hang}">
                                    <i class="fa fa-pen"></i> Edit
                                </a>

                                <a href="#" onclick="deleteUser(${user.id_khach_hang})">
                                    <i class="fa fa-trash"></i> Delete
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
            `;

            tbody.innerHTML += row;
        });

        attachActionEvents();
    }
     
    const searchInput = document.getElementById("searchInput");
    const rows = document.querySelectorAll("tbody tr");

    // SEARCH
    searchInput.addEventListener("keyup", function() {
        filterTable();
    });

    // FILTER FUNCTION
    function filterTable() {

        const keyword = searchInput.value.toLowerCase();
        const rows = document.querySelectorAll("tbody tr");

        rows.forEach(row => {

            const name = row.children[1].innerText.toLowerCase();
            const email = row.children[2].innerText.toLowerCase();

            if (name.includes(keyword) || email.includes(keyword)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    //Sort
    const sortItems = document.querySelectorAll(".sort-item");
    const tbody = document.querySelector("tbody");

    let sortDirection = 1; // 1 = ASC, -1 = DESC

    sortItems.forEach(item => {
        item.addEventListener("click", (e) => {

            e.preventDefault();

            const type = item.dataset.sort;
            const sortBtn = document.querySelector(".btn-lite");

            sortBtn.innerHTML = `<i class="fa fa-sort"></i> ${type.charAt(0).toUpperCase() + type.slice(1)} ${sortDirection === 1 ? "↑" : "↓"}`;

            sortTable(type);

            // đảo chiều sort
            sortDirection *= -1;
        });
    });

    function sortTable(type) {

        const rowsArray = Array.from(document.querySelectorAll("tbody tr"));

        rowsArray.sort((a, b) => {

            let valA, valB;

            if (type === "name") {
                valA = a.children[1].innerText.toLowerCase();
                valB = b.children[1].innerText.toLowerCase();
            }

            if (type === "email") {
                valA = a.children[2].innerText.toLowerCase();
                valB = b.children[2].innerText.toLowerCase();
            }

            if (type === "role") {
                valA = a.children[3].innerText.toLowerCase();
                valB = b.children[3].innerText.toLowerCase();
            }

            if (valA < valB) return -1 * sortDirection;
            if (valA > valB) return 1 * sortDirection;
            return 0;
        });

        // render lại table
        rowsArray.forEach(row => tbody.appendChild(row));
    }   

    //Action
    function attachActionEvents() {

        document.querySelectorAll(".action-btn").forEach(btn => {

            btn.addEventListener("click", function(e) {
                e.stopPropagation();

                const menu = this.nextElementSibling;

                const isOpen = menu.style.display === "block";

                document.querySelectorAll(".action-menu").forEach(m => m.style.display = "none");

                if (!isOpen) {
                    menu.style.display = "block";
                }
            });

        });
    }

    document.addEventListener("click", function() {
        document.querySelectorAll(".action-menu").forEach(m => {
            m.style.display = "none";
        });
    });

    loadUsers();

    // Delete user
    let deleteId = null;
    let deleteModal = null;

    // init modal
    document.addEventListener("DOMContentLoaded", () => {
        deleteModal = new bootstrap.Modal(document.getElementById("deleteModal"));
    });

    // mở modal
    function deleteUser(id) {
        deleteId = id;
        deleteModal.show();
    }

    document.getElementById("confirmDeleteBtn").addEventListener("click", async () => {

        if (!deleteId) return;

        try {
            showLoading();

            let res = await fetch(`http://localhost/website_oop/user-service/public/users/${deleteId}`, {
                method: "DELETE"
            });

            let data = await res.json();

            deleteModal.hide();

            if (res.ok) {
                showToast("Xóa thành công!", "success");
                loadUsers();
            } else {
                showToast(data.message || "Xóa thất bại", "error");
            }

        } catch (error) {
            console.error(error);
            deleteModal.hide();
            showToast("Lỗi kết nối server", "error");
        } finally {
            hideLoading();
            deleteId = null;
        }
    });

    // TOAST
    function showToast(message, type = "success") {

        const toastEl = document.getElementById("liveToast");
        const toastMsg = document.getElementById("toastMessage");

        toastMsg.innerText = message;

        // reset class
        toastEl.className = "toast align-items-center text-white border-0";

        if (type === "success") toastEl.classList.add("bg-success");
        else if (type === "error") toastEl.classList.add("bg-danger");
        else if (type === "warning") toastEl.classList.add("bg-warning");

        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    }

    // LOADING
    function showLoading() {
        document.getElementById("loadingOverlay").classList.remove("d-none");
    }

    function hideLoading() {
        document.getElementById("loadingOverlay").classList.add("d-none");
    }
    </script>
</div>