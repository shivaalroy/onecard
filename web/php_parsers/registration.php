<?php
// Ajax calls this REGISTRATION code to execute
if(isset($_POST["fn"])){
    // CONNECT TO THE DATABASE
    include_once("../php_includes/db_conx.php");
    include_once("../php_includes/home.php");
    // GATHER THE POSTED DATA INTO LOCAL VARIABLES
    //$u = preg_replace('#[^a-z0-9]#i', '', $_POST['u']);
    $fn = preg_replace('#[^a-z]#i', '', $_POST['fn']);
    $ln = preg_replace('#[^a-z]#i', '', $_POST['ln']);
    $e = mysqli_real_escape_string($db_conx, $_POST['e']);
    $p = $_POST['p'];
    $g = preg_replace('#[^a-z]#i', '', $_POST['g']);
    $c = preg_replace('#[^a-z ]#i', '', $_POST['c']);
    // GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
    // DUPLICATE DATA CHECKS FOR USERNAME AND EMAIL
    //$sql = "SELECT id FROM table_users WHERE username='$u' LIMIT 1";
    //$query = mysqli_query($db_conx, $sql);
    //$u_check = mysqli_num_rows($query);
    // -------------------------------------------
    $sql = "SELECT id FROM table_users WHERE email='$e' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $e_check = mysqli_num_rows($query);
    // FORM DATA ERROR HANDLING
    if($fn == "" || $ln == "" || $e == "" || $p == "" || $g == "" || $c == ""){
        echo "Form is incomplete";
        exit();
        /*} else if ($u_check > 0){
        echo "The username you entered is already taken";
        exit();*/
    } else if ($e_check > 0){
        echo "The email address, ".$e.", is already in use in the system";
        exit();
    }/* else if (strlen($p) < 6) {
        echo "Password must be at least 6 characters";
        exit();
    }*/ else if ($p == strtolower($p) || $p == strtoupper($p) || $p == preg_replace('#[^a-z]#i', '', $p) || $p == preg_replace('#[^0-9]#i', '', $p)) {
        echo "Password doesn't contain a lowercase letter, uppercase letter, or number";
        exit();
    } else {
        // END FORM DATA ERROR HANDLING
        // Begin Insertion of data into the database
        // Hash the password and apply your own mysterious unique salt
        /* $cryptpass = crypt($p);
		include_once ("php_includes/randStrGen.php"); change */
        $p_hash = md5($p); //change
        // Add user info into the database table for the main site table
        $sql = "INSERT INTO table_users (email, password, ip, signup, lastlogin, notescheck)
		        VALUES('$e', '$p_hash', '$ip', now(), now(), now())"; //change
        $query = mysqli_query($db_conx, $sql);
        $uid = mysqli_insert_id($db_conx);

        // Establish their row in the userinfo table
        $sql = "INSERT INTO table_userinfo (id, firstname, lastname, gender, country)
		        VALUES('$uid', '$fn', '$ln', '$g', '$c')";
        $query = mysqli_query($db_conx, $sql);
        /* THIS IS NOW IN activation.php
        // Establish their row in the useroptions table
        $sql = "INSERT INTO table_useroptions (id) VALUES ('$uid')";
        $query = mysqli_query($db_conx, $sql);

        // Create directory(folder) to hold each user's files(pics, MP3s, etc.)
        if (!file_exists("user/$uid")) {
            mkdir("user/$uid", 0755);
        }
        */
        // Email the user their activation link
        $to = "$e";
        $from = "no-reply".$hosuff;
        $subject = 'OneCard Account Activation';
        $message = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>OneCard Message</title>
        <link rel="stylesheet" href="'.$url.'style/style.css">
    </head>

    <body>
        <div style="padding:10px; background:#09a360; font-size:24px; color:#fff;">
            <a href="'.$url.'">
                <img src="'.$url.'img/logo.png" height="30" alt="Social Network" style="border:none; float:left; padding-right: 20px;">
            </a>
            Account Activation
        </div>
        <div style="padding:24px; padding-left:100px; font-size:17px;">Hello '.$fn.',<br /><br />Click the link below to activate your account when ready:<br /><br /><a href="'.$url.'activation.php?id='.$uid.'&e='.$e.'&p='.$p_hash.'">Click here to activate your account now</a><br /><br />Login after successful activation using your:<br />* E-mail Address: <b>'.$e.'</b>
        </div>
    </body>
</html>';
        $headers = "From: $from\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";
        mail($to, $subject, $message, $headers);
        echo "signup_success";
        exit();
    }
    exit();
}
?>