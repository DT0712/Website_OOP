<?php 
require_once "config.php";
include "includes/header.php";
?>
<link rel="stylesheet" href="assets/css/bikes.css">
<!-- ===== BANNER ===== -->
<div class="banner">
    <div class="banner-content">
        <h1>FIND YOUR PERFECT BIKE</h1>
        <p>Xe đạp thể thao chất lượng – an toàn – minh bạch</p>
        <div class="price">Từ 2.000.000 VNĐ</div>
    </div>
</div>

<!-- ===== SHOWCASE ===== -->
<div class="showcase">
    <div class="showcase-wrapper">

        <!-- TRÁI -->
        <div class="side">
            <div class="pair">
                <div class="item left"
                    style="background-image:url('assets/images/bike1.png')">
                    <span>ROAD</span>
                </div>

                <div class="item right"
                    style="background-image:url('assets/images/bike1.png')">
                    <span>BIKE</span>
                </div>
            </div>
        </div>

        <!-- GIỮA -->
        <div class="center-text">
            <p>WELCOME TO</p>
            <h2>BIKE MARKET</h2>
            <span>NỀN TẢNG MUA BÁN XE ĐẠP</span>
        </div>

        <!-- PHẢI -->
        <div class="side right-side">
            <div class="pair">

                <!-- đúng thứ tự -->
                <div class="item left"
                    style="background-image:url('assets/images/bike2.jpg')">
                    <span>ROAD</span>
                </div>

                <div class="item right"
                    style="background-image:url('assets/images/bike2.jpg')">
                    <span>BIKE</span>
                </div>

            </div>
        </div>

    </div>
</div>

<!-- ===== FILTER + LIST ===== -->
<div class="featured">
    <h2>DANH SÁCH XE ĐẠP</h2>

<?php
// ===== LẤY FILTER =====
$brand = $_GET['brand'] ?? [];
$category = $_GET['category'] ?? [];
$condition = $_GET['condition'] ?? [];
$size = $_GET['size'] ?? [];
$location = $_GET['location'] ?? [];

$where = [];

// helper
function buildIn($field, $arr, $conn) {
    if (empty($arr)) return null;

    $safe = array_map(function($v) use ($conn) {
        return "'".mysqli_real_escape_string($conn,$v)."'";
    }, $arr);

    return "$field IN (".implode(",", $safe).")";
}

// build query
if ($brand) $where[] = "b.brand_id IN (".implode(",", array_map('intval',$brand)).")";
if ($category) $where[] = "b.category_id IN (".implode(",", array_map('intval',$category)).")";
if ($condition) $where[] = buildIn("b.condition_status",$condition,$conn);
if ($size) $where[] = buildIn("b.frame_size",$size,$conn);
if ($location) $where[] = buildIn("b.location",$location,$conn);

$where_sql = $where ? "WHERE ".implode(" AND ", $where) : "";

// ===== LẤY DATA =====
$sql = "
SELECT b.*, c.name as category_name, br.name as brand_name
FROM bicycles b
LEFT JOIN categories c ON b.category_id = c.id
LEFT JOIN brands br ON b.brand_id = br.id
$where_sql
ORDER BY b.bicycle_id DESC
";

$result = mysqli_query($conn, $sql);

// ===== LẤY DATA FILTER =====
$brands = mysqli_query($conn,"SELECT * FROM brands");
$categories = mysqli_query($conn,"SELECT * FROM categories");
$conditions = mysqli_query($conn,"SELECT DISTINCT condition_status FROM bicycles");
$sizes = mysqli_query($conn,"SELECT DISTINCT frame_size FROM bicycles");
$locations = mysqli_query($conn,"SELECT DISTINCT location FROM bicycles");
?>

<!-- ===== FILTER UI ===== -->
<form method="GET" class="filter-box">

<div class="filter-row">

    <!-- BRAND -->
    <div class="dropdown">
        <button type="button" onclick="toggleDropdown(this)">Brand ▼</button>
        <div class="dropdown-content">
            <?php while($b = mysqli_fetch_assoc($brands)) { ?>
                <label>
                    <input type="checkbox" name="brand[]" value="<?php echo $b['id']; ?>">
                    <?php echo $b['name']; ?>
                </label>
            <?php } ?>
        </div>
    </div>

    <!-- CATEGORY -->
    <div class="dropdown">
        <button type="button" onclick="toggleDropdown(this)">Category ▼</button>
        <div class="dropdown-content">
            <?php while($c = mysqli_fetch_assoc($categories)) { ?>
                <label>
                    <input type="checkbox" name="category[]" value="<?php echo $c['id']; ?>">
                    <?php echo $c['name']; ?>
                </label>
            <?php } ?>
        </div>
    </div>

    <!-- CONDITION -->
    <div class="dropdown">
        <button type="button" onclick="toggleDropdown(this)">Condition ▼</button>
        <div class="dropdown-content">
            <?php while($c = mysqli_fetch_assoc($conditions)) { ?>
                <label>
                    <input type="checkbox" name="condition[]" value="<?php echo $c['condition_status']; ?>">
                    <?php echo $c['condition_status']; ?>
                </label>
            <?php } ?>
        </div>
    </div>

    <!-- SIZE -->
    <div class="dropdown">
        <button type="button" onclick="toggleDropdown(this)">Size ▼</button>
        <div class="dropdown-content">
            <?php while($s = mysqli_fetch_assoc($sizes)) { ?>
                <label>
                    <input type="checkbox" name="size[]" value="<?php echo $s['frame_size']; ?>">
                    <?php echo $s['frame_size']; ?>
                </label>
            <?php } ?>
        </div>
    </div>

    <!-- LOCATION -->
    <div class="dropdown">
        <button type="button" onclick="toggleDropdown(this)">Location ▼</button>
        <div class="dropdown-content">
            <?php while($l = mysqli_fetch_assoc($locations)) { ?>
                <label>
                    <input type="checkbox" name="location[]" value="<?php echo $l['location']; ?>">
                    <?php echo $l['location']; ?>
                </label>
            <?php } ?>
        </div>
    </div>

</div>

<div style="text-align:center; margin-top:20px;">
    <button type="submit" class="apply-btn">Áp dụng lọc</button>
    <a href="bikes.php" class="clear-filter">Xóa lọc</a>
</div>

</form>

<!-- ===== LIST ===== -->
<div class="bike-list">
<?php while($row = mysqli_fetch_assoc($result)) { ?>
    <div class="bike-card">
        <img src="<?php echo $row['main_image']; ?>">

        <span class="star-icon" data-bike-id="<?php echo $row['bicycle_id']; ?>">★</span>

        <div class="price">
            <?php echo number_format($row['price']); ?> VNĐ
        </div>

        <h3><?php echo $row['name']; ?></h3>

        <p class="desc"><?php echo $row['description']; ?></p>

        <div class="meta">
            <span><?php echo $row['frame_size']; ?></span>
            <span><?php echo $row['location']; ?></span>
            <span><?php echo $row['condition_status']; ?></span>
        </div>

        <a href="detail.php?id=<?php echo $row['bicycle_id']; ?>" class="rent-btn">
            XEM CHI TIẾT
        </a>
    </div>
<?php } ?>
</div>
</div>
<script>
function toggleDropdown(btn) {
    const dropdown = btn.nextElementSibling;

    document.querySelectorAll(".dropdown-content").forEach(d => {
        if (d !== dropdown) d.style.display = "none";
    });

    dropdown.style.display =
        dropdown.style.display === "block" ? "none" : "block";
}

document.addEventListener("click", function(e) {
    if (!e.target.closest(".dropdown")) {
        document.querySelectorAll(".dropdown-content").forEach(d => {
            d.style.display = "none";
        });
    }
});

function toggleDropdown(btn) {
    const dropdown = btn.nextElementSibling;

    document.querySelectorAll(".dropdown-content").forEach(d => {
        if (d !== dropdown) d.style.display = "none";
    });

    dropdown.style.display =
        dropdown.style.display === "block" ? "none" : "block";
}

document.addEventListener("click", function(e) {
    if (!e.target.closest(".dropdown")) {
        document.querySelectorAll(".dropdown-content").forEach(d => {
            d.style.display = "none";
        });
    }
});

// ===== FAVORITE STAR =====
function addFavorite(bikeId, starElem) {
    fetch('./services/favorite.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'bicycle_id=' + bikeId
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === 'success') {
            starElem.classList.add('active');
            starElem.style.pointerEvents = 'none';
        } else {
            alert(data.message);
        }
    })
    .catch(err => {
        console.error(err);
        alert('Lỗi server');
    });
}

// Gắn sự kiện click
document.querySelectorAll('.star-icon').forEach(star => {
    const bikeId = star.getAttribute('data-bike-id');

    star.addEventListener('click', function() {
        addFavorite(bikeId, star);
    });
});
</script>


<?php include "includes/footer.php"; ?>