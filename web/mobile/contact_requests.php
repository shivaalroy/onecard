<?php
include_once("../includes/home.php");
include_once("../includes/check_login_status.php");
// If the page requestor is not logged in, usher them away
if($profile_ok != true){
    header("location: ".$url);
    exit();
}
include_once("templates/_mobile_contact_list.php");

$sql = "SELECT firstname FROM table_userinfo WHERE id='$log_id' AND activated='1' LIMIT 1";
$query = mysqli_query($db_conx, $sql);
$row = mysqli_fetch_row($query);
$log_firstname = $row[0];

function sharedContactReqs($array, $conx, $old) {
    $reqID = $array["id"];
    $sharer = $array["sharer"];
    $datemade = $array["datemade"];
    $datemade = strftime("%B %d", strtotime($datemade));
    $sharerquery = mysqli_query($conx, "SELECT firstname, lastname, gender, city, country, avatar1 FROM table_userinfo WHERE id='$sharer' LIMIT 1");
    $sharerrow = mysqli_fetch_assoc($sharerquery);
    $sharerfn = $sharerrow['firstname'];
    $sharerln = $sharerrow['lastname'];
    $sharergender = strtolower($sharerrow['gender']);
    $sharercity = $sharerrow['city'];
    $sharercountry = $sharerrow['country'];
    $shareravatar = $sharerrow['avatar1'];
    $sharername = $sharerfn." ".$sharerln;
    if ($sharercity != "") {
        $sharercity .= ", ";
    }
    $sharerlocation = $sharercity.$sharercountry;
    if($shareravatar == NULL){
        $sharerpic = '<img src="'.$url.'img/defaultavatar-'.$sharergender.'.jpg" alt="'.$sharername.'" class="sharer_pic">';
    } else {
        $sharerpic = '<img src="'.$url.'user/'.$sharer.'/'.$shareravatar.'" alt="'.$sharername.'" class="sharer_pic">';
    }
    $emailcount = 0;
    $phonecount = 0;
    $addresscount = 0;
    $websitecount = 0;
    foreach ($array as $key => $val) {
        if ((substr($key, 0, 2) == "em" || substr($key, 0, 2) == "ph" || substr($key, 0, 2) == "ad" || substr($key, 0, 3) == "web") && substr($key, -3) != "lbl" && $val == 1) {
            if (substr($key, 0, 2) == "em") {
                $emailcount++;
            } else if (substr($key, 0, 2) == "ph") {
                $phonecount++;
            } else if (substr($key, 0, 2) == "ad") {
                $addresscount++;
            } else if (substr($key, 0, 3) == "web") {
                $websitecount++;
            }
        }
    }
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
            $emails = "<strong>1 email address</strong>, ";
        } else {
            $emails = "<strong>1 email address</strong> ";
        }
    } else if ($emailcount > 1) {
        if ($afteremails) {
            $emails = "<strong>".$emailcount." email addresses</strong>, ";
        } else {
            $emails = "<strong>".$emailcount." email addresses</strong> ";
        }
    }
    if ($phonecount < 1) {
        $phones = "";
    } else if ($phonecount == 1) {
        if ($afterphones) {
            $phones = "<strong>1 phone number</strong>, ";
        } else {
            $phones = "<strong>1 phone number</strong> ";
        }
    } else if ($phonecount > 1) {
        if ($afterphones) {
            $phones = "<strong>".$phonecount." phone numbers</strong>, ";
        } else {
            $phones = "<strong>".$phonecount." phone numbers</strong> ";
        }
    }
    if ($addresscount < 1) {
        $addresses = "";
    } else if ($addresscount == 1) {
        $addresses = "<strong>1 mailing address</strong> ";
    } else if ($addresscount > 1) {
        $addresses = "<strong>".$addresscount." mailing addresses</strong> ";
    }
    if (!$old) {
        $tempVar .= '
<div id="contactreq_'.$reqID.'" class="contactrequests">
    <a href="'.$url.'?id='.$sharer.'">'.$sharerpic.'</a>
    <div class="sharer_info" id="sharer_info_'.$reqID.'">
        <a href="'.$url.'?id='.$sharer.'" class="sharer_name">'.$sharername.'</a>
        <div class="sharer_location">'.$sharerlocation.'</div>
        <div id="shared_info_details_'.$reqID.'" class="shared_info">'.$emails.$phones.$addresses.'shared with you</div>
    </div>
    <div id="request_option_btns_'.$reqID.'" class="request_option_btns">
        <button class="accept_req" onclick="contactReqHandler(\'accept\', \''.$reqID.'\', \''.$sharer.'\', \''.$sharername.'\')">Accept</button>
        <button class="decline_req" onclick="contactReqHandler(\'ignore\', \''.$reqID.'\', \''.$sharer.'\', \''.$sharername.'\')">Not Now</button>
    </div>
</div>';
    } else if ($old) {
        $tempVar .= '
<div id="contactreq_'.$reqID.'" class="contactrequests">
    <a href="'.$url.'?id='.$sharer.'">'.$sharerpic.'</a>
    <div class="sharer_info" id="sharer_info_'.$reqID.'">
        <a href="'.$url.'?id='.$sharer.'" class="sharer_name">'.$sharername.'</a>
        <div class="sharer_location">'.$sharerlocation.'</div>
        <div id="shared_info_details_'.$reqID.'" class="shared_info">'.$emails.$phones.$addresses.'shared with you</div>
    </div>
    <div id="request_option_btns_'.$reqID.'" class="request_option_btns">
        <button class="accept_req" onclick="contactReqHandler(\'accept\', \''.$reqID.'\', \''.$sharer.'\', \''.$sharername.'\')">Accept</button>
        <button class="decline_req" onclick="contactReqHandler(\'delete\', \''.$reqID.'\', \''.$sharer.'\', \''.$sharername.'\')">Decline</button>
    </div>
</div>';
    }
    return $tempVar;
}

//NEW CONTACT REQUESTS
$contact_requests = "";
$sql = "SELECT * FROM table_friends WHERE sharee='$log_id' AND accepted='0' AND ignored='0' ORDER BY datemade ASC";
$query = mysqli_query($db_conx, $sql);
$numrows = mysqli_num_rows($query);
if($numrows < 1){
    $contact_requests = '<p id="no_new_requests" class="no_requests">No new contact requests</p>';
} else {
    while ($row = mysqli_fetch_assoc($query)) {
        $reqID = $row["id"];
        $contact_requests .= sharedContactReqs($row, $db_conx, false);
        $sql_loop = "UPDATE table_friends SET new='0' WHERE id='$reqID' LIMIT 1";
        $query_loop = mysqli_query($db_conx, $sql_loop);
    }
}

//OLD CONTACT REQUESTS
$old_contact_requests = "";
$sql = "SELECT * FROM table_friends WHERE sharee='$log_id' AND accepted='0' AND ignored='1' ORDER BY datemade ASC";
$query = mysqli_query($db_conx, $sql);
$numrows = mysqli_num_rows($query);
if($numrows < 1){
    $old_contact_requests = 'none';
} else {
    while ($row = mysqli_fetch_assoc($query)) {
        $old_contact_requests .= sharedContactReqs($row, $db_conx, true);
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" charset="UTF-8" content="width=device-width, user-scalable=no">
        <title>Contact Requests</title>
        <link rel="icon" href="/img/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="img/mobile/stylesheets/style.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="/js/main.js"></script>
        <script src="/js/ajax.js"></script>
        <script src="/js/loggedin.js"></script>
        <script src="/js/contact_requests.js"></script>
    </head>
    <body>
        <?php include_once("templates/_mobile_loggedin_menubar.php"); ?>
        <div class="body_background">
            <div id="pageMiddle_centered" class="pageMiddle_centered">
                <div id="contact_request_box" class="contact_request_box main_box white_box">
                    <div class="requests_header">
                        <h2>New Contact Requests</h2>
                    </div>
                    <div class="requests_margin">
                        <?php echo $contact_requests; ?>
                    </div>
                    <?php
if ($old_contact_requests == "none") {
    echo "";
} else {
    echo "<div id='old_requests_header' class='requests_header'>";
    echo "<h2>Previous Contact Requests</h2>";
    echo "</div>";
    echo "<div class='requests_margin'>";
    echo $old_contact_requests;
    echo "</div>";
}
                    ?>
                </div>
            </div>
        </div>
        <?php include_once("templates/_mobile_loggedout_footer.php"); ?>
    </body>
</html>
