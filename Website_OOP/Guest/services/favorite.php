<?php
require_once "../config.php";
session_start();

// Giả lập user đang đăng nhập
$user_id = $_SESSION['user_id'] ?? 1;

// Xử lý AJAX POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bicycle_id'])) {
    $bicycle_id = intval($_POST['bicycle_id']);

    // Chặn trùng lặp
    $stmt = $conn->prepare("INSERT IGNORE INTO favorites (user_id,bicycle_id) VALUES (?,?)");
    $stmt->bind_param("ii", $user_id, $bicycle_id);

    if($stmt->execute()){
        echo "success";
    } else {
        echo "error";
    }
    exit;
}

// Nếu là GET, hiển thị danh sách favorite
$result = $conn->query("
    SELECT f.*, b.name, b.main_image, b.price
    FROM favorites f
    LEFT JOIN bicycles b ON f.bicycle_id = b.bicycle_id
    WHERE f.user_id = $user_id
    ORDER BY f.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Yêu thích</title>
<style>
body { font-family: Arial; background: #f8f9fa; padding: 20px; }
h1 { text-align: center; color: red; }
.fav-list { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; max-width: 1200px; margin: auto; }
.fav-card { background: #fff; border-radius: 10px; overflow: hidden; width: 220px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); position: relative; }
.fav-card img { width: 100%; height: 150px; object-fit: cover; }
.fav-card h3 { margin: 10px; font-size: 16px; }
.fav-card .price { margin: 0 10px 10px; color: orange; font-weight: bold; }
</style>
</head>
<body>

<h1>Danh sách Yêu thích</h1>

<div class="fav-list">
<?php while($row = $result->fetch_assoc()): ?>
    <div class="fav-card">
        <img src="<?php echo $row['main_image']; ?>">
        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
        <div class="price"><?php echo number_format($row['price']); ?> VNĐ</div>
    </div>
<?php endwhile; ?>
</div>

<script>
// Hàm dùng cho bikes.php: thêm favorite bằng AJAX
function addFavorite(bikeId) {
    fetch('favorite.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'bicycle_id=' + bikeId
    })
    .then(res => res.text())
    .then(data => {
        if(data === 'success') {
            alert('Đã thêm vào Yêu thích!');
        } else {
            alert('Đã xảy ra lỗi, thử lại.');
        }
    })
    .catch(err => console.error(err));
}
</script>

</body>
</html>