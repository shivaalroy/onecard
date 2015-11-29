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
$message = "";
$msg = preg_replace('#[^a-z 0-9.:_()]#i', '', $_GET['msg']);
if($msg == "activation_failure"){
    $message_head = 'Activation Error';
    $message_content = 'Sorry there seems to have been an issue activating your account at this time. We have already notified ourselves of this issue and we will contact you via email when we have identified the issue.';
} else if($msg == "activation_success"){
    $message_head = 'Activation Success';
    $message_content = 'Your account is now activated. <a href="'.$url.'login.php">Click here to log in</a>';
} else if($msg == "verify_account"){
    $firstname = preg_replace('#[^a-z]#i', '', $_GET['fn']);
    $email = mysqli_real_escape_string($db_conx, $_GET['e']);
    $message_head = 'Verify Email';
    $message_content = 'OK '.$firstname.', check your email inbox and junk mail box at <u>'.$email.'</u> in a moment to complete the sign up process by activating your account. You will not be able to do anything on the site until you successfully activate your account.';
} else {
    $message_content = $msg;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Message</title>
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
                    <div id="text_header"><?php echo $message_head; ?></div>
                    <div id="text_content"><?php echo $message_content; ?></div>
                </div>
            </div>
        </div>
        <?php include_once("template/tem_loggedout_footer.php"); ?>
    </body>
</html>