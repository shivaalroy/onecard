<?php
// Ajax calls this account info default code to execute
if(isset($_POST["defaultinfo"])){
    // CONNECT TO THE DATABASE
    include_once("../php_includes/check_login_status.php");
    //initialize the user's contact information into variables
    $sql = "SELECT * FROM table_userinfo WHERE id='$log_id' AND activated='1' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $arr = mysqli_fetch_assoc($query);

    // GATHER THE POSTED DATA INTO LOCAL VARIABLES
    $list = "";
    foreach ($arr as $key => $val) {
        if ($key != "id" && $key != "username" && $key != "gender" && $key != "avatar1" && $key != "avatar2") {
            $list .= "`|[({".$key."})]|`==".$val."`|[({".$key."})]|`&&";
        }
    }
    $list2 = substr($list, 0, -2);
    echo $list2;
    exit;
}

// Ajax calls this account preferences default code to execute
if(isset($_POST["defaultpreferences"])){
    // CONNECT TO THE DATABASE
    include_once("../php_includes/check_login_status.php");
    //initialize the user's contact information into variables
    $sql = "SELECT * FROM table_useroptions WHERE id='$log_id' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $arr = mysqli_fetch_assoc($query);

    // GATHER THE POSTED DATA INTO LOCAL VARIABLES
    $list = "";
    foreach ($arr as $key => $val) {
        if ($key != "id" && $key != "question" && $key != "answer" && $key != "temp_email" && $key != "temp_pass") {
            $list .= "`|[({".$key."})]|`==".$val."`|[({".$key."})]|`&&";
        }
    }
    $list2 = substr($list, 0, -2);
    echo $list2;
    exit;
}
?>