<?php
// Ajax calls this shared info default code to execute
if(isset($_POST["profile"])){
    // CONNECT TO THE DATABASE
    include_once("../php_includes/check_login_status.php");
    //initialize the user's contact information into variables
    $profile = preg_replace('#[^0-9]#i', '', $_POST["profile"]);
    $sql = "SELECT * FROM table_friends WHERE sharer='$log_id' AND sharee='$profile' AND accepted='1' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $arr = mysqli_fetch_assoc($query);
    //echo $sql;
    //exit;

    // GATHER THE POSTED DATA INTO LOCAL VARIABLES
    $list = "";
    foreach ($arr as $key => $val) {
        if (substr($key, 0, 2) == "em" || substr($key, 0, 2) == "ph" || substr($key, 0, 3) == "web" || substr($key, 0, 2) == "ad" || substr($key, 0, 3) == "oun" || $key == "brth") {
            $list .= $key."==".$val."&&";
        }
    }
    $list2 = substr($list, 0, -2);
    echo $list2;
}
if(isset($_POST["requested_info"])){
    // CONNECT TO THE DATABASE
    include_once("../php_includes/check_login_status.php");
    //initialize the user's contact information into variables
    $profile = preg_replace('#[^0-9]#i', '', $_POST["requested_info"]);
    $sql = "SELECT * FROM table_notifications WHERE initiator='$log_id' AND target='$profile' AND type='requesting_info' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $arr = mysqli_fetch_assoc($query);
    //echo $sql;
    //exit;

    // GATHER THE POSTED DATA INTO LOCAL VARIABLES
    $list = "";
    foreach ($arr as $key => $val) {
        if ($key == "email" || $key == "phone" || $key == "address") {
            $list .= $key."==".$val."&&";
        }
    }
    $list2 = substr($list, 0, -2);
    echo $list2;
}
?>