<?php
include_once("../php_includes/home.php");
include_once("../php_includes/check_login_status.php");
// If the page requestor is not logged in, usher them away
if($profile_ok != true){
    header("location: ".$url);
    exit();
}
include_once("templates/_mobile_contact_list.php");
include_once("../php_includes/get_timezone.php");

$sql = "SELECT firstname FROM table_userinfo WHERE id='$log_id' AND activated='1' LIMIT 1";
$query = mysqli_query($db_conx, $sql);
$row = mysqli_fetch_row($query);
$log_firstname = $row[0];

function messageSelector ($conx, $row_id, $msgtype) {
    $msg= "";
    if ($msgtype == "cr_accepted") {
        $msg = "accepted your contact information.";
    } else if ($msgtype == "requesting_info") {
        $sql = "SELECT email, phone, address FROM table_notifications WHERE id='$row_id' LIMIT 1";
        $query = mysqli_query($conx, $sql);
        $info_array = mysqli_fetch_assoc($query);
        $emailcount = $info_array["email"];
        $phonecount = $info_array["phone"];
        $addresscount = $info_array["address"];
        $afteremails = false;
        $afterphones = false;
        if ($phonecount > 0 || $addresscount > 0) {
            $afteremails = true;
        }
        if ($addresscount > 0) {
            $afterphones = true;
        }
        $emails = "";
        $phones = "";
        $addresses = "";
        if ($emailcount < 1) {
            $emails = "";
        } else if ($emailcount == 1) {
            if ($afteremails) {
                $emails = "<strong>email address</strong>, ";
            } else {
                $emails = "<strong>email address</strong>";
            }
        }
        if ($phonecount < 1) {
            $phones = "";
        } else if ($phonecount == 1) {
            if ($afterphones) {
                $phones = "<strong>phone number</strong>, ";
            } else {
                $phones = "<strong>phone number</strong>";
            }
        }
        if ($addresscount < 1) {
            $addresses = "";
        } else if ($addresscount == 1) {
            $addresses = "<strong>mailing address</strong>";
        }
        $req_elements = $emails.$phones.$addresses;
        $msg = "requested your ".$req_elements;
    }
    return $msg;
}

$notification_list = "";
$sql = "SELECT * FROM table_notifications WHERE target='$log_id' ORDER BY date_time DESC";
$query = mysqli_query($db_conx, $sql);
$numrows = mysqli_num_rows($query);
if($numrows < 1){
    $notification_list = '<p id="no_new_notes" class="no_notes">You do not have any notifications</p>';
} else {
    while ($row = mysqli_fetch_assoc($query)) {
        $noteid = $row["id"];
        $initiator = $row["initiator"];
        $type = $row["type"];
        $note = $row["note"];
        $date_time = strtotime($row["date_time"]);
        if ($date_time >= (strtotime("today") + $timezoneOffset)) {
            $date_time = "Today at ".strftime("%l:%M%P", $date_time + $timezoneOffset);
        } else if ($date_time >= (strtotime("yesterday") + $timezoneOffset)) {
            $date_time = "Yesterday at ".strftime("%l:%M%P", $date_time + $timezoneOffset);
        } else {
            $date_time = strftime("%B %e at %l:%M%P", $date_time);
        }
        $initiatorquery = mysqli_query($db_conx, "SELECT firstname, lastname, gender, avatar1 FROM table_userinfo WHERE id='$initiator' LIMIT 1");
        $initiatorrow = mysqli_fetch_assoc($initiatorquery);
        $initiatorfn = $initiatorrow['firstname'];
        $initiatorln = $initiatorrow['lastname'];
        $initiatorgender = strtolower($initiatorrow['gender']);
        $initiatoravatar = $initiatorrow['avatar1'];
        $initiatorname = $initiatorfn." ".$initiatorln;
        if($initiatoravatar == NULL){
            $initiatorpic = '<img src="'.$url.'img/defaultavatar-'.$initiatorgender.'.jpg" alt="'.$initiatorname.'" class="initiator_pic">';
        } else {
            $initiatorpic = '<img src="'.$url.'user/'.$initiator.'/'.$initiatoravatar.'" alt="'.$initiatorname.'" class="initiator_pic">';
        }
        $message = "";
        $message = messageSelector($db_conx, $noteid, $type);
        $notification_list .= '
<div id="notes_'.$noteid.'" class="notes">
    <a href="'.$url.'?id='.$initiator.'">'.$initiatorpic.'</a>
    <div class="initiator_info" id="initiator_info_'.$noteid.'">
        <a href="'.$url.'?id='.$initiator.'" class="initiator_name">'.$initiatorname.'</a>
        <div id="shared_info_details_'.$noteid.'" class="shared_info">'.$message.'</div>
        <div class="notes_date">'.$date_time.'</div>
    </div>
</div>';
        $sql_loop = "UPDATE table_notifications SET new='0' WHERE id='$noteid' LIMIT 1";
        $query_loop = mysqli_query($db_conx, $sql_loop);
    }
}
$sql = "UPDATE table_users SET notescheck=now() WHERE id='$log_id' LIMIT 1";
$query = mysqli_query($db_conx, $sql);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" charset="UTF-8" content="width=device-width, user-scalable=no">
        <title>Notifications</title>
        <link rel="icon" href="/img/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="img/mobile/stylesheets/style.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="/js/main.js"></script>
        <script src="/js/ajax.js"></script>
        <script src="/js/loggedin.js"></script>
    </head>
    <body>
        <?php include_once("templates/_mobile_loggedin_menubar.php"); ?>
        <div class="body_background">
            <div id="pageMiddle_centered" class="pageMiddle_centered">
                <div id="notes_box" class="notes_box main_box white_box">
                    <div id="notes_header" class="notes_header">
                        <h2>Notifications</h2>
                    </div>
                    <div id="notes_margin" class="notes_margin">
                        <?php echo $notification_list; ?>
                    </div>
                </div>
                <div style="clear:left;"></div>
            </div>
        </div>
        <?php include_once("templates/_mobile_loggedout_footer.php"); ?>
    </body>
</html>
