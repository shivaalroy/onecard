<?php
include_once("../includes/home.php");
include_once("../includes/check_login_status.php");
if ($profile_ok == true) {
    $headerBar = "templates/_mobile_loggedin_menubar.php";
    $sql = "SELECT firstname FROM table_userinfo WHERE id='$log_id' AND activated='1' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $row = mysqli_fetch_row($query);
    $log_firstname = $row[0];
} else {
    $headerBar = "templates/_mobile_loggedout_menubar.php";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" charset="UTF-8" content="width=device-width, user-scalable=no">
        <title>Not Found</title>
        <link rel="icon" href="/images/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="img/mobile/stylesheets/style.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="/javascripts/main.js"></script>
    </head>
    <body>
        <?php include_once($headerBar); ?>
        <div class="body_background">
            <div id="pageMiddle_centered" class="pageMiddle_centered">
                <div id="msg_box" class="msg_box main_box white_box">
                    <div id="text_header">Oops! Page Not Found</div>
                    <div id="text_content">The page you are trying to visit does not exist or may be temporarily unavailable. Please try again at a later time.</div>
                </div>
            </div>
        </div>
        <?php include_once("templates/_mobile_loggedout_footer.php"); ?>
    </body>
</html>