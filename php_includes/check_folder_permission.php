<?php
include_once("home.php");
include_once("check_login_status.php");
$folder_permission = false;
$current_url = (!empty($_SERVER['HTTPS'])) ? $_SERVER['REQUEST_URI'] : $_SERVER['REQUEST_URI'];
$current_url2 = preg_replace('#/user/#', '', $current_url);
$pos = strpos($current_url2, "/");
$current_id = substr($current_url2, 0, $pos);
/*
echo $current_url;
echo "<br />";
echo $current_url2;
echo "<br />";
echo $pos;
echo "<br />";
echo "folder id = $current_id";
echo "<br />";
echo "login id = $log_id";
echo "<br />";
echo "are the two equal?";
echo "<br />";
*/
if ($current_id == $log_id) {
    echo "You have permission to access this folder.";
    $folder_permission = true;
} else {
    echo "You should not be here.";
    $folder_permission = false;
}
?>