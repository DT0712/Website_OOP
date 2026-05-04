<?php
require_once "../config.php";

// ===== FIX SESSION =====
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['user_id'] ?? 1;

// ===== AJAX =====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    ob_clean();
    header('Content-Type: application/json');

    if (!isset($_POST['bicycle_id'])) {
        echo json_encode(["status" => "error", "message" => "Missing ID"]);
        exit;
    }

    $bicycle_id = intval($_POST['bicycle_id']);

    $stmt = $conn->prepare("
        INSERT INTO favorites (user_id, bicycle_id)
        VALUES (?, ?)
        ON DUPLICATE KEY UPDATE bicycle_id = bicycle_id
    ");

    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => $conn->error]);
        exit;
    }

    $stmt->bind_param("ii", $user_id, $bicycle_id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }

    exit;
}

// ===== LẤY DANH SÁCH FAVORITE =====
$result = $conn->query("
    SELECT f.*, b.name, b.main_image, b.price, b.frame_size, b.location, b.condition_status
    FROM favorites f
    LEFT JOIN bicycles b ON f.bicycle_id = b.bicycle_id
    WHERE f.user_id = $user_id
    ORDER BY f.created_at DESC
");

include "../includes/header.php";
?>

<style>
.page-title {
    text-align: center;
    margin: 40px 0;
    font-size: 32px;
    color: red;
}

.fav-container {
    max-width: 1000px;
    margin: auto;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* CARD NGANG */
.fav-item {
    display: flex;
    gap: 20px;
    background: #fff;
    border-radius: 12px;
    padding: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    transition: 0.3s;
}

.fav-item:hover {
    transform: translateY(-5px);
}

/* IMAGE */
.fav-img {
    width: 180px;
    height: 130px;
    object-fit: cover;
    border-radius: 10px;
}

/* INFO */
.fav-info {
    flex: 1;
}

.fav-info h3 {
    margin: 0 0 10px;
}

/* PRICE */
.price {
    color: orange;
    font-weight: bold;
    margin-bottom: 10px;
}

/* META */
.meta {
    font-size: 13px;
    color: #777;
    margin-bottom: 10px;
}

/* BUTTON */
.btn-view {
    display: inline-block;
    padding: 8px 15px;
    background: red;
    color: white;
    border-radius: 5px;
    text-decoration: none;
}

.btn-view:hover {
    background: darkred;
}

.empty {
    text-align: center;
    color: #777;
    font-size: 18px;
}
</style>

<h1 class="page-title">Danh sách Yêu thích</h1>

<div class="fav-container">
<?php if($result && $result->num_rows > 0): ?>
    
    <?php while($row = $result->fetch_assoc()): ?>
        <div class="fav-item">

            <!-- IMAGE -->
            <img src="../<?php echo $row['main_image']; ?>" class="fav-img">

            <!-- INFO -->
            <div class="fav-info">
                <h3><?php echo htmlspecialchars($row['name']); ?></h3>

                <div class="price">
                    <?php echo number_format($row['price']); ?> VNĐ
                </div>

                <div class="meta">
                    Size: <?php echo $row['frame_size']; ?> |
                    Location: <?php echo $row['location']; ?> |
                    Condition: <?php echo $row['condition_status']; ?>
                </div>

                <a href="../detail.php?id=<?php echo $row['bicycle_id']; ?>" class="btn-view">
                    Xem chi tiết
                </a>
            </div>

        </div>
    <?php endwhile; ?>

<?php else: ?>
    <p class="empty">Chưa có sản phẩm yêu thích</p>
<?php endif; ?>
</div>

<?php include "../includes/footer.php"; ?>