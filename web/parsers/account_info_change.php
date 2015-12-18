<?php
// Ajax calls this contact info change code to execute
if(isset($_POST["firstname"])){
    // CONNECT TO THE DATABASE
    include_once("../includes/check_login_status.php");
    //initialize the user's contact information into variables
    $sql = "SELECT * FROM table_userinfo WHERE id='$log_id' AND activated='1' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $arr = mysqli_fetch_assoc($query);
    $log_firstname = $arr['firstname'];
    $log_lastname = $arr['lastname'];
    //$log_email = $arr['email'];
    $log_gender = $arr['gender'];
    $log_city = $arr['city'];
    $log_country = $arr['country'];
    // GATHER THE POSTED DATA INTO LOCAL VARIABLES
    $sql_set1 = "";
    $unsync_set1 = "";
    foreach ($arr as $key => $val) {
        if(isset($_POST[$key])){
            if ($_POST[$key] == "`|[({eWIf5S0PhgzHmUtITl7I})]|`") {
                if ($val != "") {
                    $sql_set1 .= $key."='', ";
                    if (substr($key, -3) != "lbl") {
                        $unsync_set1 .= $key."='0', ";
                    }
                }
            } else if ($key == "city") {
                $$key = preg_replace('#[^a-z\ ]#i', '', $_POST[$key]);
                if ($$key != $val) {
                    $sql_set1 .= $key."='".$$key."', ";
                }
            } else if (substr($key, -3) == "lbl") {
                $$key = preg_replace('#[^a-z0-9\ ]#i', '', $_POST[$key]);
                if ($$key != $val) {
                    $sql_set1 .= $key."='".$$key."', ";
                }
            } else if (substr($key, 0, 2) == "em") {
                $$key = mysqli_real_escape_string($db_conx, $_POST[$key]);
                if ($$key != $val) {
                    $sql_set1 .= $key."='".$$key."', ";
                }
            } else if (substr($key, 0, 2) == "ph") {
                $$key = preg_replace('#[^0-9]#i', '', $_POST[$key]);
                if ($$key != $val) {
                    $sql_set1 .= $key."='".$$key."', ";
                }
            } else if (substr($key, 0, 3) == "web") {
                $$key = mysqli_real_escape_string($db_conx, $_POST[$key]);
                if ($$key != $val) {
                    $sql_set1 .= $key."='".$$key."', ";
                }
            } else if (substr($key, 0, 2) == "ad") {
                $$key = preg_replace('#[^a-z0-9\,\.\-\;\ ]#i', '', $_POST[$key]);
                if ($$key != $val) {
                    $sql_set1 .= $key."='".$$key."', ";
                }
            } else if (substr($key, 0, 3) == "oun") {
                $$key = preg_replace('#[^a-z0-9\.]#i', '', $_POST[$key]);
                if ($$key != $val) {
                    $sql_set1 .= $key."='".$$key."', ";
                }
            }
        }
    }
    $firstname = preg_replace('#[^a-z]#i', '', $_POST['firstname']);
    $lastname = preg_replace('#[^a-z]#i', '', $_POST['lastname']);
    //$email = mysqli_real_escape_string($db_conx, $_POST['email']);
    $country = preg_replace('#[^a-z ]#i', '', $_POST['country']);
    // GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
    //$log_email_safe = mysqli_real_escape_string($db_conx, $log_email);

    if($firstname == "" || $lastname == "" || $country == ""){
        echo "The form submission is missing values.";
        exit();
    } else {
        // END FORM DATA ERROR HANDLING
        // Update User's Contact Info into the database table
        $sql_set2 = "firstname='$firstname', lastname='$lastname', country='$country', ".$sql_set1;
        $sql_set3 = substr($sql_set2, 0, -2);
        $sql1 = "UPDATE table_userinfo SET $sql_set3 WHERE id='$log_id' AND activated='1' LIMIT 1";
        $query1 = mysqli_query($db_conx, $sql1);

        // unshare any contact info if it is being emptied
        $query2 = true;
        if ($unsync_set1 != "") {
            $unsync_set2 = substr($unsync_set1, 0, -2);
            $sql2 = "UPDATE table_friends SET $unsync_set2 WHERE sharer='$log_id'";
            $query2 = false;
            $query2 = mysqli_query($db_conx, $sql2);
        }
        if ($query1 == true && $query2 == true) {
            echo "info_change_success";
        } else {
            echo "error";
        }
        exit();
    }
    exit();
}

// Ajax calls this email change code to execute
if(isset($_POST["new_email"])){
    // CONNECT TO THE DATABASE
    include_once("../includes/home.php");
    include_once("../includes/check_login_status.php");
    //initialize the user's contact information into variables
    $sql = "SELECT * FROM table_users WHERE id='$log_id' AND activated='1' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $arr = mysqli_fetch_assoc($query);
    $log_email = $arr['email'];

    $sql = "SELECT firstname FROM table_userinfo WHERE id='$log_id' AND activated='1' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $arr = mysqli_fetch_assoc($query);
    $fn = $arr['firstname'];

    // GATHER THE POSTED DATA INTO LOCAL VARIABLES
    $email = mysqli_real_escape_string($db_conx, $_POST['new_email']);
    $log_email_safe = mysqli_real_escape_string($db_conx, $log_email);
    // DUPLICATE DATA CHECKS FOR EMAIL
    // -------------------------------------------
    $sql_e_check = "SELECT id FROM table_users WHERE email='$email' LIMIT 1";
    $query = mysqli_query($db_conx, $sql_e_check);
    $e_check = mysqli_num_rows($query);
    $row = mysqli_fetch_assoc($query);
    $id = $row["id"];

    // FORM DATA ERROR HANDLING
    if ($e_check > 0){
        if ($id == $log_id) {
            echo "you_are_user";
        } else {
            echo "taken";
        }
        exit();
    } else {
        // END FORM DATA ERROR HANDLING
        // Set the new email in the useroptions table and send a verification email
        $randNum = rand(100,999);
        $ref = $email.$randNum;
        $sql = "UPDATE table_useroptions SET temp_email='$ref' WHERE id='$log_id' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        if ($query === true) {
            $hashRef = md5($ref);
            $to = "$email";
            $from = "no-reply".$hosuff;
            $subject = 'OneCard Email Verification';
            $message = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>OneCard Message</title>
        <link rel="stylesheet" href="'.$url.'stylesheets/style.css">
    </head>

    <body>
        <div style="padding:10px; background:#09a360; font-size:24px; color:#fff;">
            <a href="'.$url.'">
                <img src="'.$url.'img/logo.png" height="30" alt="Social Network" style="border:none; float:left; padding-right: 20px;">
            </a>
            Verify New Email
        </div>
        <div style="padding:24px; padding-left:100px; font-size:14px;">
        Hello '.$fn.',
        <br />
        <br />
        <a href="'.$url.'change_email.php?id='.$log_id.'&ref='.$hashRef.'">Click here</a> to verify your email
        <br />
        <br />
        You will be logged out and you must login with the new email: <strong>'.$email.'</strong>
        </div>
    </body>
</html>';
            $headers = "From: $from\n";
            $headers .= "MIME-Version: 1.0\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\n";
            mail($to, $subject, $message, $headers);
            echo "email_change_success";
        } else {
            echo "error";
        }
        exit();
    }
    exit();
}

//Ajax calls this password change code to execute
if(isset($_POST["old_password"]) && isset($_POST["new_password"])){
    // CONNECT TO THE DATABASE
    include_once("../includes/home.php");
    include_once("../includes/check_login_status.php");

    // GATHER THE POSTED DATA INTO LOCAL VARIABLES
    $old_p = $_POST['old_password'];
    $old_pHash = md5($old_p);
    $sql = "SELECT password FROM table_users WHERE id='$log_id' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $row = mysqli_fetch_assoc($query);
    $log_old_pass = $row['password'];
    if ($old_pHash != $log_old_pass) {
        echo "wrong_pass";
        exit;
    }

    $p = $_POST['new_password'];
    $pHash = md5($p);

    if ($p == strtolower($p) || $p == strtoupper($p) || $p == preg_replace('#[^a-z]#i', '', $p) || $p == preg_replace('#[^0-9]#i', '', $p)) {
        echo "below_par";
        exit();
    }
    $sql = "UPDATE table_users SET password='$pHash' WHERE id='$log_id' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    if ($query === true) {
        echo "pass_change_success";
        //header("location: message.php?msg=Please login with the password you just set");
        exit;
    } else {
        echo "error";
        exit;
    }
    exit();
}

//Ajax calls this preferences change code to execute
if(isset($_POST["sort_order"]) && isset($_POST["disp_order"])){
    // CONNECT TO THE DATABASE
    include_once("../includes/home.php");
    include_once("../includes/check_login_status.php");

    // GATHER THE POSTED DATA INTO LOCAL VARIABLES
    $sort_order = $_POST['sort_order'];
    $disp_order = $_POST['disp_order'];

    $sql = "UPDATE table_useroptions SET sort_order='$sort_order', disp_order='$disp_order' WHERE id='$log_id' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    if ($query === true) {
        echo "pref_change_success";
        exit;
    } else {
        echo "error";
        exit;
    }
    exit();
}
?>