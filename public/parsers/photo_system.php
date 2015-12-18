<?php
include_once("../includes/home.php");
include_once("../includes/check_login_status.php");
if($profile_ok != true){
    exit();
}

if (isset($_FILES["avatar"]["name"]) && $_FILES["avatar"]["tmp_name"] != ""){
    $fileName = $_FILES["avatar"]["name"];
    $fileTmpLoc = $_FILES["avatar"]["tmp_name"];
    $fileType = $_FILES["avatar"]["type"];
    $fileSize = $_FILES["avatar"]["size"];
    $fileErrorMsg = $_FILES["avatar"]["error"];
    $kaboom = explode(".", $fileName);
    $fileExt = end($kaboom);
    list($width, $height) = getimagesize($fileTmpLoc);
    $db_file_name = rand(100000000000,999999999999).".".$fileExt;
    if($fileSize > 5500000) {
        header("location: ".$url."message.php?msg=ERROR: Your image file was larger than 1MB");
        exit();
    } else if (!preg_match("/\.(jpg|png)$/i", $fileName) ) {
        header("location: ".$url."message.php?msg=ERROR: Your image was not a .jpg or .png file");
        exit();
    } else if ($fileErrorMsg == 1) {
        header("location: ".$url."message.php?msg=ERROR: An unknown error occurred");
        exit();
    }
    if($width < 50 || $height < 50){
        header("location: ".$url."message.php?msg=ERROR: Your image has no dimensions or is too small");
        exit();
    }
    $sql = "SELECT avatar1 FROM table_userinfo WHERE id='$log_id' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $row = mysqli_fetch_row($query);
    $avatar = $row[0];
    if($avatar != ""){
        $picurl = "../user/$log_id/$avatar";
        if (file_exists($picurl)) { unlink($picurl); }
    }
    $moveResult = move_uploaded_file($fileTmpLoc, "../user/$log_id/$db_file_name");
    if ($moveResult != true) {
        header("location: ".$url."message.php?msg=ERROR: File upload failed");
        exit();
    }
    include_once("../includes/image_editing.php");
    $target_file = "../user/$log_id/$db_file_name";
    $resized_file = "../user/$log_id/$db_file_name";
    $wmax = 400;
    $hmax = 400;
    img_resize($target_file, $resized_file, $wmax, $hmax, $fileExt);
    $target_file = "../user/$log_id/$db_file_name";
    $thumbnail = "../user/$log_id/$db_file_name";
    $wthumb = 380;
    $hthumb = 380;
    ak_img_thumb($target_file, $thumbnail, $wthumb, $hthumb, $fileExt);
    $sql = "UPDATE table_userinfo SET avatar1='$db_file_name' WHERE id='$log_id' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    mysqli_close($db_conx);
    header("location: ".$url."myinfo.php");
    exit();
}
?>