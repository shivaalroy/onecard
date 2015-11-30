<?php
include_once("check_login_status.php");
$sql = "SELECT timezone FROM table_users WHERE id='$log_id' AND activated='1' LIMIT 1";
$query = mysqli_query($db_conx, $sql);
$row = mysqli_fetch_row($query);
$timezoneOffset = $row[0]*3600;
?>