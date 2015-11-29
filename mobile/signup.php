<?php
include_once("../php_includes/home.php");
include_once("../php_includes/check_login_status.php");
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
        <link rel="icon" href="<?php echo $url; ?>img/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="<?php echo $url; ?>mobile/style/style.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="<?php echo $url; ?>js/main.js"></script>
        <script src="<?php echo $url; ?>js/ajax.js"></script>
        <script src="<?php echo $url; ?>js/signup.js"></script>
    </head>
    <body>
        <?php include_once("template/tem_mobile_loggedout_menubar_signup.php"); ?>
        <div class="body_background">
            <div id="pageMiddle_centered" class="pageMiddle_centered">
                <div id="register_centerbox" class="register_centerbox">
                    <h2 class="welcomeTitle" id="welcomeTitle">Sign Up</h2>
                    <h3 class="welcomeDescr" id="welcomeDescr">It's free.</h3>
                    <?php include_once("template/tem_mobile_signupform.php"); ?>
                </div>
            </div>
        </div>
        <?php include_once("template/tem_mobile_loggedout_footer.php"); ?>
    </body>
</html>