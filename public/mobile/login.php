<?php
include_once("../includes/home.php");
include_once("../includes/check_login_status.php");
// If user is already logged in, header them away
if($profile_ok == true){
    header("location: ".$url);
    exit();
}

// THIS CODE CHECKS TO SEE IF THERE WAS A FAILED LOGIN ATTEMPT
if(isset($_GET["login_attempt"])){
    // CONNECT TO THE DATABASE
    //include_once("../includes/db_conx.php");
    // GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
    $login_attempt = preg_replace("#[^0-9]#", "", $_GET['login_attempt']);
    $attempt = false;
    if($login_attempt == "1"){
        $attempt = true;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" charset="UTF-8" content="width=device-width, user-scalable=no">
        <title>Log In</title>
        <link rel="icon" href="/images/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="img/mobile/stylesheets/style.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="/javascripts/main.js"></script>
        <script src="/javascripts/ajax.js"></script>
    </head>
    <body>
        <?php include_once("templates/_mobile_loggedout_menubar.php"); ?>
        <div class="body_background">
            <div id="pageMiddle_centered" class="no_width_padding main_box pageMiddle_centered">
                <?php include_once("templates/_mobile_loginform.php"); ?>
            </div>
        </div>
        <?php include_once("templates/_mobile_loggedout_footer.php"); ?>
    </body>
</html>