<?php
session_start();
include 'config.php';

$user_id = $_SESSION['khach_hang']['id_khach_hang'];

$name = $_POST['name'];
$content = $_POST['description'];
$price = $_POST['price'];
$location = $_POST['location'];

$image = "";

if(!empty($_FILES['main_image']['name'])){
    $dir = "uploads/posts/";
    if(!is_dir($dir)) mkdir($dir,0777,true);

    $filename = time().'_'.$_FILES['main_image']['name'];
    $path = $dir.$filename;

    move_uploaded_file($_FILES['main_image']['tmp_name'],$path);
    $image = $path;
}

mysqli_query($conn,"
INSERT INTO posts(user_id,product_name,content,image,price,location)
VALUES($user_id,'$name','$content','$image','$price','$location')
");

header("Location: sell.php");