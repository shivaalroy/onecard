<?php
// Ajax calls this timezone code to execute
if(isset($_POST["offset"])){
    $serverOffset = -4;
    $tempOffset = preg_replace('#[^0-9]#i', '', $_POST["offset"]);
    $timezoneSet = -1*($tempOffset/60 + $serverOffset);

    include_once("../includes/check_login_status.php");
    $sql = "UPDATE table_users SET timezone='$timezoneSet' WHERE id='$log_id' AND activated='1' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    //echo $timezoneSet;
    exit;
}
?>