<?php
include_once("includes/home.php");
include_once("includes/check_login_status.php");
// If user is already logged in, header them away
if($profile_ok == true){
    header("location:/");
    exit();
}

// THIS CODE CHECKS TO SEE IF THERE WAS A FAILED LOGIN ATTEMPT
if(isset($_GET["login_attempt"])){
    // CONNECT TO THE DATABASE
    //include_once("includes/db_conx.php");
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
        <meta charset="UTF-8">
        <title>Log In</title>
        <link rel="icon" href="/img/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="/stylesheets/style.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:300,600">
        <script src="/javascripts/main.js"></script>
        <script src="/javascripts/ajax.js"></script>
    </head>
    <body>
        <?php include_once("templates/_loggedout_menubar_wsignupbtn.php"); ?>
        <div class="flat_ui_bg">
            <div id="pageMiddle_centered" class="pageMiddle_centered">
                <div id="login_centerbox" class="login_centerbox" style="margin-top: 60px;">
                    <h3 id="login_centerbox_title" class="login_centerbox_title">OneCard Login</h3>
                    <div id="loginstatus" class="loginstatus" <?php if($attempt) {echo "style='display:block;'";} ?>>
                        <p><b>Login Error</b></p>
                        <br />
                        <p>Either the email or password given was incorrect.</p>
                    </div>
                    <!-- LOGIN FORM -->
                    <form id="login_form" action="parsers/logincode.php" onsubmit="disable_btn('login_btn_big')" method="post">
                        <div class="login_form_row">
                            <label for="email" class="login_form_label">Email</label>
                            <input type="email" id="email" name="email" class="login_form_inputtext" maxlength="88">
                        </div>
                        <div class="login_form_row">
                            <label for="password" class="login_form_label">Password</label>
                            <input type="password" id="password" name="password" class="login_form_inputtext" maxlength="100">
                        </div>
                        <div class="login_form_persistent">
                            <div>
                                <input id="persistent_box" class="persistent_box" type="checkbox" name="persistent" value="1" tabindex="3">
                                <label for="persistent_box" class="persistent_label">Keep me logged in</label>
                            </div>
                            <input type="hidden" name="default_persistent" value="0">
                            <input type="hidden" name="device" value="desktop">
                        </div>
                        <div class="login_form_row">
                            <input type="submit" id="login_btn_big" class="login_btn_big" value="Log In">
                        </div>
                        <div class="login_form_row">
                            <a href="img/forgot_pass.php">Forgot Your Password?</a>
                        </div>
                    </form>
                    <!-- LOGIN FORM -->
                </div>
            </div>
        </div>
        <?php include_once("templates/_loggedout_footer.php"); ?>
    </body>
</html>