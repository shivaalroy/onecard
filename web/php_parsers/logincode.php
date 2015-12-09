<?php
session_start();
include_once("../php_includes/home.php");
// AJAX CALLS THIS LOGIN CODE TO EXECUTE
if(isset($_POST["email"])){
    // CONNECT TO THE DATABASE
    include_once("../php_includes/db_conx.php");
    // GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
    $e = mysqli_real_escape_string($db_conx, $_POST['email']);
    $p = md5($_POST['password']);
    $d = mysqli_real_escape_string($db_conx, $_POST['device']);
    // GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
    // FORM DATA ERROR HANDLING
    if($e == "" || $p == ""){
        if ($d == 'desktop') {
            header("location:/login.php?login_attempt=1");
        } else if ($d == 'mobile') {
            header("location:/mobile/login.php?login_attempt=1");
        } else {
            header("location:/login.php?login_attempt=1");
        }
        exit();
    } else {
        // END FORM DATA ERROR HANDLING
        $sql = "SELECT id, password FROM table_users WHERE email='$e' AND activated='1' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $row = mysqli_fetch_row($query);
        $db_id = $row[0];
        $db_pass_str = $row[1];
        if($p != $db_pass_str){
            if ($d == 'desktop') {
                header("location:/login.php?login_attempt=1");
            } else if ($d == 'mobile') {
                header("location:/mobile/login.php?login_attempt=1");
            } else {
                header("location:/login.php?login_attempt=1");
            }
            exit();
        } else {
            // CREATE THEIR SESSIONS AND COOKIES
            $_SESSION['userid'] = $db_id;
            $_SESSION['password'] = $db_pass_str;
            if(isset($_POST['persistent']) && $_POST['persistent'] == 1) {
                setcookie("id", $db_id, strtotime( '+30 days' ), "/", "", "", TRUE);
                setcookie("pass", $db_pass_str, strtotime( '+30 days' ), "/", "", "", TRUE);
            } else if ($d == 'mobile') {
                setcookie("id", $db_id, strtotime( '+30 days' ), "/", "", "", TRUE);
                setcookie("pass", $db_pass_str, strtotime( '+30 days' ), "/", "", "", TRUE);
            }
            // UPDATE THEIR "IP" AND "LASTLOGIN" FIELDS
            $sql = "UPDATE table_users SET ip='$ip', lastlogin=now() WHERE id='$db_id' LIMIT 1";
            $query = mysqli_query($db_conx, $sql);
            if ($d == 'desktop') {
                header("location:/");
            } else if ($d == 'mobile') {
                header("location:/mobile/");
            } else {
                header("location:/");
            }
            exit();
        }
    }
    exit();
}
?>