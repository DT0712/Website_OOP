<?php 
$current_page = basename($_SERVER['PHP_SELF']);
include "../includes/header.php";
include "../config.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

$sql = "SELECT * FROM posts WHERE id = $id";
$result = $conn->query($sql);
$post = $result->fetch_assoc();

if (!$post) {
    $sql = "SELECT * FROM posts LIMIT 1";
    $result = $conn->query($sql);
    $post = $result->fetch_assoc();
}
?>

<div class="container mt-4 mb-5" style="max-width: 800px;">

    <!-- Breadcrumb -->
    <nav style="font-size:13px; color:#999; margin-bottom:20px;">
        <a href="blog.php" style="color:#e60000; text-decoration:none;">← Quay lại Blog</a>
    </nav>

    <!-- Tag -->
    <span style="background:#00bcd4; color:white; padding:4px 12px; 
                 border-radius:20px; font-size:12px; font-weight:bold;">
        <?= $post['tag'] ?>
    </span>

    <!-- Tiêu đề -->
    <h2 style="margin-top:15px; font-weight:700;">
        <?= $post['title'] ?>
    </h2>

    <!-- Tác giả -->
    <small class="text-muted">By <?= $post['date'] ?></small>

    <!-- Ảnh chính -->
    <img src="<?= $post['image'] ?>" 
         style="width:100%; height:400px; object-fit:cover; 
                border-radius:15px; margin:20px 0;">

    <!-- Nội dung -->
    <div style="font-size:15px; line-height:1.8; color:#333;">
        <?= $post['content'] ?>
    </div>

    <!-- Divider -->
    <hr style="margin:40px 0;">

    <!-- Bài viết liên quan -->
    <h5 style="font-weight:700; margin-bottom:20px;">Bài viết liên quan</h5>

    <?php
    $sql_related = "SELECT * FROM posts WHERE id != $id LIMIT 4";
    $related = $conn->query($sql_related);
    ?>

    <div class="row">
        <?php while($p = $related->fetch_assoc()): ?>
            <div class="col-md-6 mb-3">
                <a href="blog_detail.php?id=<?= $p['id'] ?>" 
                   style="text-decoration:none; color:inherit;">
                    <div class="post-card">
                        <img src="<?= $p['image'] ?>" 
                             style="width:100%; height:160px; 
                                    object-fit:cover; border-radius:10px;">
                        <h6 style="margin-top:8px; font-weight:600;">
                            <?= $p['title'] ?>
                        </h6>
                        <small class="text-muted">By <?= $p['date'] ?></small>
                    </div>
                </a>
            </div>
        <?php endwhile; ?>
    </div>

</div>

<?php include "../includes/footer.php"; ?>
</body>
</html>