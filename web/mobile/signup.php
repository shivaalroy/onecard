<?php
include_once("../includes/home.php");
include_once("../includes/check_login_status.php");
// If user is already logged in, header them away
if($profile_ok == true){
    header("location: ".$url);
    exit();
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" charset="UTF-8" content="width=device-width, user-scalable=no">
        <title>Sign Up</title>
        <link rel="icon" href="/img/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="img/mobile/stylesheets/style.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="/javascripts/main.js"></script>
        <script src="/javascripts/ajax.js"></script>
        <script src="/javascripts/signup.js"></script>
    </head>
    <body>
        <?php include_once("templates/_mobile_loggedout_menubar_signup.php"); ?>
        <div class="body_background">
            <div id="pageMiddle_centered" class="pageMiddle_centered">
                <div id="register_centerbox" class="register_centerbox">
                    <h2 class="welcomeTitle" id="welcomeTitle">Sign Up</h2>
                    <h3 class="welcomeDescr" id="welcomeDescr">It's free.</h3>
                    <?php include_once("templates/_mobile_signupform.php"); ?>
                </div>
            </div>
        </div>
        <?php include_once("templates/_mobile_loggedout_footer.php"); ?>
    </body>
</html>