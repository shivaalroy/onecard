<?php
include_once("../includes/home.php");
include_once("../includes/check_login_status.php");
// If user is already logged in, header them away
if($profile_ok == true){
    header("location: ".$url);
    exit();
}

// AJAX CALLS THIS CODE TO EXECUTE
if(isset($_POST["e"])){
    $e = mysqli_real_escape_string($db_conx, $_POST['e']);
    $sql = "SELECT id FROM table_users WHERE email='$e' AND activated='1' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $numrows = mysqli_num_rows($query);
    if($numrows > 0){
        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            $id = $row["id"];
        }
        $sql = "SELECT firstname FROM table_userinfo WHERE id='$id' AND activated='1' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            $fn = $row["firstname"];
        }

        $emailcut = substr($e, 0, 4);
        $randNum = rand(10000,99999);
        $tempPass = "$emailcut$randNum";
        $hashTempPass = md5($tempPass);
        $sql = "UPDATE table_useroptions SET temp_pass='$hashTempPass' WHERE id='$id' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $to = "$e";
        $from = "no-reply".$hosuff;
        $headers ="From: $from\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1 \n";
        $subject ="OneCard Temporary Password";
        $msg = '<h2>Hello '.$fn.'</h2>
        <p>This is an automated message from OneCard. If you did not recently initiate the Forgot Password process, please disregard this email.</p>
        <p>You indicated that you forgot your login password. We can generate a temporary password for you to log in with, then once logged in you can change your password to anything you like.</p>
        <p>After you click the link below your password to login will be:<br /><strong>'.$tempPass.'</strong></p>
        <p><a href="'.$url.'forgot_pass.php?id='.$id.'&p='.$hashTempPass.'">Click here now to apply the temporary password shown below to your account</a></p>
        <p>If you do not click the link in this email, no changes will be made to your account. In order to set your login password to the temporary password you must click the link above.</p>';
        if(mail($to,$subject,$msg,$headers)) {
            echo "success";
            exit();
        } else {
            echo "email_send_failed";
            exit();
        }
    } else {
        echo "no_exist";
    }
    exit();
}

// EMAIL LINK CLICK CALLS THIS CODE TO EXECUTE
if(isset($_GET['id']) && isset($_GET['p'])){
    $id = preg_replace('#[^0-9]#i', '', $_GET['id']);
    $temppasshash = preg_replace('#[^a-z0-9]#i', '', $_GET['p']);
    if(strlen($temppasshash) < 10){
        exit();
    }
    $sql = "SELECT id FROM table_useroptions WHERE id='$id' AND temp_pass='$temppasshash' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $numrows = mysqli_num_rows($query);
    if($numrows == 0){
        header("location: message.php?msg=There is no match for that ID with that temporary password in the system. We cannot proceed.");
        exit();
    } else {
        $row = mysqli_fetch_row($query);
        $id = $row[0];
        $sql = "UPDATE table_users SET password='$temppasshash' WHERE id='$id' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $sql = "UPDATE table_useroptions SET temp_pass='' WHERE id='$id' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        header("location: login.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" charset="UTF-8" content="width=device-width, user-scalable=no">
        <title>Forgot Password</title>
        <link rel="icon" href="/img/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="img/mobile/stylesheets/style.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="/javascripts/main.js"></script>
        <script src="/javascripts/ajax.js"></script>
        <script>
            function forgotpass(){
                var e = _("email").value;
                if(e == ""){
                    _("status").innerHTML = "Type in your email address";
                } else {
                    _("status").innerHTML = ''; //please wait ...
                    var ajax = ajaxObj("POST", "forgot_pass.php");
                    ajax.onreadystatechange = function() {
                        if(ajaxReturn(ajax) == true) {
                            var response = ajax.responseText;
                            if(response == "success"){
                                _("forgotpassword_btn").style.display = "none";
                                _("forgotpasswordform").innerHTML = '<h3>Step 2. An email has been sent to the address: '+e+'<br /> Check your email inbox in a few minutes</h3><p>You can close this window if you like.</p>';
                            } else if (response == "no_exist"){
                                _("status").innerHTML = "Sorry that email address is not in our system";
                            } else if(response == "email_send_failed"){
                                _("status").innerHTML = "Mail function failed to execute";
                            } else {
                                _("status").innerHTML = "An unknown error occurred";
                            }
                        }
                    }
                    ajax.send("e="+e);
                }
            }
        </script>
    </head>
    <body>
        <?php include_once("templates/_mobile_loggedout_menubar_wloginbtn.php"); ?>
        <div class="body_background">
            <div id="pageMiddle_centered" class="pageMiddle_centered">
                <h3>Generate a temporary log in password</h3>
                <form id="forgotpasswordform" class="forgotpasswordform" onsubmit="return false;">
                    <div>Step 1: Enter Your Email Address</div>
                    <input id="email" type="text" onfocus="_('status').innerHTML='';" maxlength="88">
                    <br /><br />
                    <button id="forgotpassword_btn" class="forgotpassword_btn" onclick="forgotpass()">Recover Password</button> 
                    <p id="status"></p>
                </form>
            </div>
        </div>
        <?php include_once("templates/_mobile_loggedout_footer.php"); ?>
    </body>
</html>
