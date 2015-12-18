<?php
session_start();
include_once("db_conx.php");
// Files that include this file at the very top would NOT require 
// connection to database or session_start(), be careful.
// Initialize some vars
$profile_ok = false;
$att_id = "";
$att_password = "";
$log_id = "";
// User Verify function
function evalLoggedUser($conx, $id, $p){
    $sql = "SELECT ip FROM table_users WHERE id='$id' AND password='$p' AND activated='1' LIMIT 1";
    $query = mysqli_query($conx, $sql);
    $numrows = mysqli_num_rows($query);
    if($numrows > 0){
        return true;
    }
}
if(isset($_SESSION["userid"]) && isset($_SESSION["password"])) {
    $att_id = preg_replace('#[^0-9]#', '', $_SESSION['userid']);
    $att_password = preg_replace('#[^a-z0-9]#i', '', $_SESSION['password']);
    // Verify the user
    $profile_ok = evalLoggedUser($db_conx, $att_id, $att_password);
    if ($profile_ok == true) {
        $log_id = $att_id;
    }
} else if(isset($_COOKIE["id"]) && isset($_COOKIE["pass"])){
    $_SESSION['userid'] = preg_replace('#[^0-9]#', '', $_COOKIE['id']);
    $_SESSION['password'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['pass']);
    $att_id = $_SESSION['userid'];
    $att_password = $_SESSION['password'];
    // Verify the user
    $profile_ok = evalLoggedUser($db_conx, $att_id, $att_password);
    if($profile_ok == true){
        $log_id = $att_id;
        // Update their lastlogin datetime field
        $sql = "UPDATE table_users SET lastlogin=now() WHERE id='$att_id' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
    }
}
?>