<?php
// Ajax calls this EMAIL CHECK code to execute
if(isset($_POST["settings_emailcheck"])){
    include_once("../php_includes/check_login_status.php");
    $settings_email = mysqli_real_escape_string($db_conx, $_POST['settings_emailcheck']);
    $sql = "SELECT id FROM table_users WHERE email='$settings_email' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $settings_email_check = mysqli_num_rows($query);
    $row = mysqli_fetch_assoc($query);
    $query_id = $row["id"];
    if ($settings_email_check < 1) {
        echo 'available';
        exit();
    } else if ($query_id == $log_id) {
        echo 'same';
        exit;
    } else if ($settings_email_check > 0)  {
        echo 'taken';
        exit();
    } else {
        echo 'error';
        exit();
    }
}

// Ajax calls this EMAIL CHECK code to execute
if(isset($_POST["reg_emailcheck"])){
    include_once("../php_includes/db_conx.php");
    $reg_email = mysqli_real_escape_string($db_conx, $_POST['reg_emailcheck']);
    $sql = "SELECT id FROM table_users WHERE email='$reg_email' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $reg_email_check = mysqli_num_rows($query);
    if ($reg_email_check < 1) {
        echo 'available';
        exit();
    } else {
        echo 'taken';
        exit();
    }
}
?>