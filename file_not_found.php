<?php
include_once("php_includes/home.php");
include_once("php_includes/check_login_status.php");
if ($profile_ok == true) {
    $headerBar = "template/tem_loggedin_menubar.php";
    $sql = "SELECT firstname FROM table_userinfo WHERE id='$log_id' AND activated='1' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $row = mysqli_fetch_row($query);
    $log_firstname = $row[0];
} else {
    $headerBar = "template/tem_loggedout_menubar_wloginbtn.php";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Not Found</title>
        <link rel="icon" href="<?php echo $url; ?>img/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="<?php echo $url; ?>style/style.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="<?php echo $url; ?>js/main.js"></script>
    </head>
    <body>
        <?php include_once($headerBar); ?>
        <div class="body_background">
            <div id="pageMiddle_centered" class="pageMiddle_centered">
                <div id="msg_box" class="msg_box white_box">
                    <div id="text_header">Oops! Page Not Found</div>
                    <div id="text_content">The page you are trying to visit does not exist or may be temporarily unavailable. Please try again at a later time.</div>
                </div>
            </div>
        </div>
        <?php include_once("template/tem_loggedout_footer.php"); ?>
    </body>
</html>