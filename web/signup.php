<?php
include_once("php_includes/home.php");
include_once("php_includes/check_login_status.php");
// If user is already logged in, header them away
if($profile_ok == true){
    header("location: ".$url);
    exit();
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sign Up</title>
        <link rel="icon" href="/img/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="/stylesheets/style.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:300,600">
        <script src="/js/main.js"></script>
        <script src="/js/ajax.js"></script>
        <script src="/js/signup.js"></script>
    </head>
    <body>
        <?php include_once("templates/_loggedout_menubar_wloginbtn.php"); ?>
        <div class="flat_ui_bg">
            <div id="pageMiddle_centered" class="pageMiddle_centered">
                <div id="register_centerbox" class="register_centerbox">
                    <h2 class="welcomeTitle" id="welcomeTitle">Sign Up</h2>
                    <h3 class="welcomeDescr" id="welcomeDescr">It's free.</h3>
                    <?php include_once("templates/_signupform.php"); ?>
                </div>
            </div>
        </div>
        <?php include_once("templates/_loggedout_footer.php"); ?>
    </body>
</html>