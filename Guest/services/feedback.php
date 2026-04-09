<?php 
require_once "../config.php";
include "../includes/header.php";

$success = "";

// xử lý submit
if(isset($_POST['send_feedback'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $sql = "INSERT INTO feedback(name,email,subject,message)
            VALUES('$name','$email','$subject','$message')";
    mysqli_query($conn,$sql);

    $success = "Cảm ơn bạn đã gửi góp ý ❤️";
}
?>

<style>
.feedback-page{
    min-height:80vh;
    background:linear-gradient(180deg,#c68bdc,#f1f2f6);
    padding:60px 20px;
}

.feedback-box{
    max-width:700px;
    margin:auto;
    background:#fff;
    padding:40px;
    border-radius:18px;
    box-shadow:0 15px 30px rgba(0,0,0,0.15);
}

.feedback-box h2{
    text-align:center;
    margin-bottom:10px;
}

.feedback-box p{
    text-align:center;
    color:#777;
    margin-bottom:30px;
}

.form-group{
    margin-bottom:18px;
}

.form-group label{
    font-weight:600;
}

.form-control{
    width:100%;
    padding:12px;
    border-radius:8px;
    border:1px solid #ddd;
    margin-top:5px;
}

textarea{
    resize:none;
    height:140px;
}

.btn-send{
    width:100%;
    padding:14px;
    background:#c68bdc;
    color:#fff;
    border:none;
    border-radius:10px;
    font-size:16px;
    font-weight:600;
    transition:0.3s;
}

.btn-send:hover{
    background:#b06bcc;
}

.success-msg{
    background:#e8ffe8;
    color:green;
    padding:10px;
    border-radius:8px;
    margin-bottom:15px;
    text-align:center;
}
</style>

<section class="feedback-page">
    <div class="feedback-box">

        <h2>Góp ý & Liên hệ</h2>
        <p>Ý kiến của bạn giúp chúng tôi cải thiện dịch vụ tốt hơn 🚴</p>

        <?php if($success!=""){ ?>
            <div class="success-msg"><?php echo $success; ?></div>
        <?php } ?>

        <form method="POST">

            <div class="form-group">
                <label>Họ và tên</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Chủ đề</label>
                <input type="text" name="subject" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Nội dung góp ý</label>
                <textarea name="message" class="form-control" required></textarea>
            </div>

            <button name="send_feedback" class="btn-send">Gửi góp ý</button>

        </form>
    </div>
</section>

<?php include "../includes/footer.php"; ?>