<?php
if (isset($_POST['type']) && isset($_POST['profile'])){
    //connect to the databse
    include_once("../php_includes/check_login_status.php");
    //get the sharee's profile id and make sure the sharee exists
    $profile = preg_replace('#[^0-9]#i', '', $_POST['profile']);
    $sql = "SELECT COUNT(id) FROM table_userinfo WHERE id='$profile' AND activated='1' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $exist_count = mysqli_fetch_row($query);
    if($exist_count[0] < 1){
        mysqli_close($db_conx);
        echo "A user with id:$profile does not exist.";
        exit();
    } else {
        $sql = "SELECT * FROM table_userinfo WHERE id='$profile' AND activated='1' LIMIT 1";
        $profile_query = mysqli_query($db_conx, $sql);
        $row = mysqli_fetch_assoc($profile_query);
        $fn = $row["firstname"];
        $ln = $row["lastname"];
        $name = $fn." ".$ln;
    }
    //get sharer's info and initialize array
    $sql = "SELECT * FROM table_userinfo WHERE id='$log_id' AND activated='1' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $users_arr = mysqli_fetch_assoc($query);
    $log_firstname = $arr['firstname'];
    $log_lastname = $arr['lastname'];


    if($_POST['type'] == "friend"){
        //This query determines if the sharer has been blocked with the sharee
        $sql = "SELECT COUNT(id) FROM table_blockedusers WHERE blocker='$profile' AND blockee='$log_id' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $is_blockee = mysqli_fetch_row($query);

        //This query determines if the sharer has blocked with the sharee
        $sql = "SELECT COUNT(id) FROM table_blockedusers WHERE blocker='$log_id' AND blockee='$profile' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $is_blocker = mysqli_fetch_row($query);

        //This query determines if the sharer has already shared info with the sharee
        $sql = "SELECT COUNT(id) FROM table_friends WHERE sharer='$log_id' AND sharee='$profile' AND accepted='1' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $sharer_exists = mysqli_fetch_row($query);

        //This query determines if the SHAREE has already shared info with the sharer
        //we don't need this information
        /*
$sql = "SELECT COUNT(id) FROM table_friends WHERE sharer='$profile' AND sharee='$log_id' AND accepted='1' LIMIT 1";
$query = mysqli_query($db_conx, $sql);
$sharee_exists = mysqli_fetch_row($query);
*/

        //This query determines if the sharer has PENDING shared info with the sharee
        //this is important because it prevents spam
        $sql = "SELECT COUNT(id) FROM table_friends WHERE sharer='$log_id' AND sharee='$profile' AND accepted='0' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $sharer_pending = mysqli_fetch_row($query);

        //This query determines if the SHAREE has PENDING shared info with the sharer
        //we don't need this information
        /*
$sql = "SELECT COUNT(id) FROM table_friends WHERE sharer='$profile' AND sharee='$log_id' AND accepted='0' LIMIT 1";
$query = mysqli_query($db_conx, $sql);
$sharee_pending = mysqli_fetch_row($query);
*/
        if ($is_blockee[0] > 0){
            mysqli_close($db_conx);
            echo "$name has blocked you, we cannot proceed.";
            exit();
        } else if ($is_blocker[0] > 0){
            mysqli_close($db_conx);
            echo "You must first unblock $name in order to friend with them.";
            exit();
        } else if ($sharer_pending[0] > 0) {
            mysqli_close($db_conx);
            echo "You have a pending contact request already sent to $name.";
            exit();
        } else {
            if ($sharer_exists[0] > 0) {
                //get current info shared between sharer and sharee
                $sql = "SELECT * FROM table_friends WHERE sharer='$log_id' AND sharee='$profile' AND accepted='1' LIMIT 1";
                $query = mysqli_query($db_conx, $sql);
                $sharer_arr = mysqli_fetch_assoc($query);
                // GATHER THE POSTED DATA INTO LOCAL VARIABLES
                foreach ($sharer_arr as $key => $val) {
                    if (isset($_POST[$key])) {
                        $$key = preg_replace('#[^0-9]#i', '', $_POST[$key]);
                        //if ($$key != $val) {
                        $sql_set1 .= $key."='".$$key."', ";
                        //}
                    }
                }
            } else {
                $sql = "INSERT INTO table_friends (sharer, sharee, datemade)
VALUES('$log_id', '$profile', now())";
                $query = mysqli_query($db_conx, $sql);
                $default_sharer = [
                    "em1" => "0",
                    "em2" => "0",
                    "em3" => "0",
                    "em4" => "0",
                    "em5" => "0",
                    "em6" => "0",
                    "em7" => "0",
                    "em8" => "0",
                    "em9" => "0",
                    "em10" => "0",
                    "ph1" => "0",
                    "ph2" => "0",
                    "ph3" => "0",
                    "ph4" => "0",
                    "ph5" => "0",
                    "ph6" => "0",
                    "ph7" => "0",
                    "ph8" => "0",
                    "ph9" => "0",
                    "ph10" => "0",
                    "web1" => "0",
                    "web2" => "0",
                    "web3" => "0",
                    "web4" => "0",
                    "web5" => "0",
                    "oun_facebook" => "0",
                    "oun_linkedin" => "0",
                    "oun_twitter" => "0",
                    "oun_skype" => "0",
                    "ad1" => "0",
                    "ad2" => "0",
                    "ad3" => "0",
                    "ad4" => "0",
                    "ad5" => "0",
                    "brth" => "0"
                ];
                $sharer_arr = $default_sharer;
                foreach ($sharer_arr as $key => $val) {
                    if (isset($_POST[$key])) {
                        $$key = preg_replace('#[^0-9]#i', '', $_POST[$key]);
                        $sql_set1 .= $key."='".$$key."', ";
                    }
                }
            }
            $sql_set2 = $sql_set1;
            $sql_set3 = substr($sql_set2, 0, -2);
            $sql = "UPDATE table_friends SET $sql_set3 WHERE sharer='$log_id' AND sharee='$profile' LIMIT 1";
            /*
echo $sql;
exit();
*/
            $query = mysqli_query($db_conx, $sql);
            if ($query === true) {
                echo "friend_request_sent";
            } else {
                echo "error";
            }
            exit();
        }
    } else if($_POST['type'] == "unfriend"){
        $sql = "SELECT COUNT(id) FROM table_friends WHERE user1='$log_id' AND user2='$profile' AND accepted='1' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $row_count1 = mysqli_fetch_row($query);
        $sql = "SELECT COUNT(id) FROM table_friends WHERE user1='$profile' AND user2='$log_id' AND accepted='1' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $row_count2 = mysqli_fetch_row($query);
        if ($row_count1[0] > 0) {
            $sql = "DELETE FROM table_friends WHERE user1='$log_id' AND user2='$profile' AND accepted='1' LIMIT 1";
            $query = mysqli_query($db_conx, $sql);
            mysqli_close($db_conx);
            echo "unfriend_ok";
            exit();
        } else if ($row_count2[0] > 0) {
            $sql = "DELETE FROM table_friends WHERE user1='$profile' AND user2='$log_id' AND accepted='1' LIMIT 1";
            $query = mysqli_query($db_conx, $sql);
            if ($query === true) {
                echo "unfriend_ok";
            } else {
                echo "error";
            }
            mysqli_close($db_conx);
            exit();
        } else {
            mysqli_close($db_conx);
            echo "No friendship could be found between your account and $profile, therefore we cannot unfriend you.";
            exit();
        }
    }
}
if (isset($_POST['action']) && isset($_POST['reqid']) && isset($_POST['sharer'])){
    //connect to the databse
    include_once("../php_includes/check_login_status.php");
    //get sharer's info and initialize array
    $sql = "SELECT * FROM table_userinfo WHERE id='$log_id' AND activated='1' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $users_arr = mysqli_fetch_assoc($query);
    $log_firstname = $arr['firstname'];
    $log_lastname = $arr['lastname'];

    $reqid = preg_replace('#[^0-9]#', '', $_POST['reqid']);
    $sharer = preg_replace('#[^0-9]#', '', $_POST['sharer']);
    $sql = "SELECT COUNT(id) FROM table_userinfo WHERE id='$sharer' AND activated='1' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $exist_count = mysqli_fetch_row($query);
    if($exist_count[0] < 1){
        mysqli_close($db_conx);
        echo "A user with id:$sharer does not exist.";
        exit();
    }

    if($_POST['action'] == "accept"){
        $sql = "SELECT COUNT(id) FROM table_friends WHERE sharer='$sharer' AND sharee='$log_id' AND accepted='1' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $row_count1 = mysqli_fetch_row($query);
        /*
        $sql = "SELECT COUNT(id) FROM table_friends WHERE sharer='$log_id' AND sharee='$sharer' AND accepted='1' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $row_count2 = mysqli_fetch_row($query);
        MAKE SURE TO CHANGE THE FOLLOWING LINE TO "if ($row_count1[0] > 0 || $row_count2[0] > 0) {"
        */
        if ($row_count1[0] > 0) {
            mysqli_close($db_conx);
            echo "You are already friends with $sharer.";
            exit();
        } else {
            $sql1 = "UPDATE table_friends SET accepted='1', ignored='0' WHERE id='$reqid' AND sharer='$sharer' AND sharee='$log_id' and accepted='0' LIMIT 1";
            $query1 = mysqli_query($db_conx, $sql1);
            $sql2 = "INSERT INTO table_notifications (target, initiator, date_time, type)
                VALUES('$sharer', '$log_id', now(), 'cr_accepted')";
            $query2 = mysqli_query($db_conx, $sql2);
            if ($query1 === true && $query2 === true) {
                echo "accept_ok";
            } else {
                echo "error";
            }
            mysqli_close($db_conx);
            exit();
        }
    } else if($_POST['action'] == "ignore"){
        $sql = "UPDATE table_friends SET ignored='1' WHERE id='$reqid' AND sharer='$sharer' AND sharee='$log_id' AND accepted='0' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        if ($query === true) {
            echo "ignore_ok";
        } else {
            echo "error";
        }
        mysqli_close($db_conx);
        exit();
    } else if($_POST['action'] == "delete"){
        $sql = "DELETE FROM table_friends WHERE id='$reqid' AND sharer='$sharer' AND sharee='$log_id' AND ignored='1' AND accepted='0' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        if ($query === true) {
            echo "delete_ok";
        } else {
            echo "error";
        }
        mysqli_close($db_conx);
        exit();
    }
}
if (isset($_POST['request'])){
    //connect to the databse
    include_once("../php_includes/check_login_status.php");
    //get the sharee's profile id and make sure the sharee exists
    $profile = preg_replace('#[^0-9]#i', '', $_POST['request']);
    $sql = "SELECT COUNT(id) FROM table_userinfo WHERE id='$profile' AND activated='1' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $exist_count = mysqli_fetch_row($query);
    if($exist_count[0] < 1){
        mysqli_close($db_conx);
        echo "A user with id:$profile does not exist.";
        exit();
    } else {
        $sql = "SELECT * FROM table_userinfo WHERE id='$profile' AND activated='1' LIMIT 1";
        $profile_query = mysqli_query($db_conx, $sql);
        $row = mysqli_fetch_assoc($profile_query);
        $fn = $row["firstname"];
        $ln = $row["lastname"];
        $name = $fn." ".$ln;
    }
    //get sharer's info and initialize array
    $sql = "SELECT * FROM table_userinfo WHERE id='$log_id' AND activated='1' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $users_arr = mysqli_fetch_assoc($query);
    $log_firstname = $arr['firstname'];
    $log_lastname = $arr['lastname'];


    //This query determines if the sharer has been blocked with the sharee
    $sql = "SELECT COUNT(id) FROM table_blockedusers WHERE blocker='$profile' AND blockee='$log_id' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $is_blockee = mysqli_fetch_row($query);

    //This query determines if the sharer has blocked with the sharee
    $sql = "SELECT COUNT(id) FROM table_blockedusers WHERE blocker='$log_id' AND blockee='$profile' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $is_blocker = mysqli_fetch_row($query);

    //This query determines if the sharer has already shared info with the sharee
    //we don't need this information
    /*
    $sql = "SELECT COUNT(id) FROM table_friends WHERE sharer='$log_id' AND sharee='$profile' AND accepted='1' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $sharer_exists = mysqli_fetch_row($query);
*/

    //This query determines if the SHAREE has already shared info with the sharer
    //we don't need this information
    /*
$sql = "SELECT COUNT(id) FROM table_friends WHERE sharer='$profile' AND sharee='$log_id' AND accepted='1' LIMIT 1";
$query = mysqli_query($db_conx, $sql);
$sharee_exists = mysqli_fetch_row($query);
*/

    //This query determines if the sharer has PENDING requested info with the sharee
    //this is important because it prevents spam
    $sql = "SELECT COUNT(id) FROM table_notifications WHERE initiator='$log_id' AND target='$profile' AND type='requesting_info' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $sharer_pending = mysqli_fetch_row($query);

    //This query determines if the SHAREE has PENDING shared info with the sharer
    $sql = "SELECT COUNT(id) FROM table_friends WHERE sharer='$profile' AND sharee='$log_id' AND accepted='0' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $sharee_pending = mysqli_fetch_row($query);

    if ($is_blockee[0] > 0){
        mysqli_close($db_conx);
        echo "$name has blocked you, we cannot proceed.";
        exit();
    } else if ($is_blocker[0] > 0){
        mysqli_close($db_conx);
        echo "You must first unblock $name in order to friend with them.";
        exit();
    } else if ($sharer_pending[0] > 0) {
        mysqli_close($db_conx);
        echo "You have already requested contact information from $name.";
        exit();
    } else if ($sharee_pending[0] > 0) {
        mysqli_close($db_conx);
        echo "$name has already shared information with you.";
        exit();
    } else {
        $email_req = preg_replace('#[^0-9]#i', '', $_POST["email"]);
        $phone_req = preg_replace('#[^0-9]#i', '', $_POST["phone"]);
        $address_req = preg_replace('#[^0-9]#i', '', $_POST["address"]);
        $sql = "INSERT INTO table_notifications (target, initiator, date_time, type, email, phone, address)
                    VALUES('$profile', '$log_id', now(), 'requesting_info', '$email_req', '$phone_req', '$address_req')";
        //echo $sql;
        //exit;
        $query = mysqli_query($db_conx, $sql);
        if ($query === true) {
            echo "info_requested";
        } else {
            echo "error";
        }
        exit();
    }
}
?>