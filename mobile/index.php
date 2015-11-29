<?php
include_once("../php_includes/home.php");
include_once("../php_includes/check_login_status.php");
// If user is already logged in, header them away
if($profile_ok != true){
    require_once("template/tem_mobile_welcomepage.php");
    exit();
}
include_once("template/tem_mobile_contact_list.php");

$sql = "SELECT * FROM table_userinfo WHERE id='$log_id' AND activated='1' LIMIT 1";
$query = mysqli_query($db_conx, $sql);
$users_arr = mysqli_fetch_assoc($query);
$log_firstname = $users_arr['firstname'];
$log_lastname = $users_arr['lastname'];
$log_gender = $users_arr['gender'];
$log_country = $users_arr['country'];

$sql = "SELECT email FROM table_users WHERE id='$log_id' AND activated='1' LIMIT 1";
$query = mysqli_query($db_conx, $sql);
$row = mysqli_fetch_row($query);
$log_email = $row[0];


$profile = "";
$fn = "";
$ln = "";
$gender = "";
$country = "";
$joindate = "";
$lastsession = "";
// Make sure the _GET id is set, and sanitize it
if(isset($_GET['id'])){
    $profile = preg_replace('#[^0-9]#', '', $_GET['id']);
}
// Select the member from the accounts table
if ($profile != "") {
    $sql = "SELECT * FROM table_userinfo WHERE id='$profile' AND activated='1' LIMIT 1";
    $profile_query = mysqli_query($db_conx, $sql);
    // Now make sure that user exists in the table
    $numrows = mysqli_num_rows($profile_query);
    if($numrows < 1){
        echo "That user does not exist or is not yet activated, press back";
        exit();
    }
    // Check to see if the viewer is the account owner
    $isOwner = false;
    if($profile == $log_id){
        //$isOwner = true;
        header("location: ".$url);
        exit();
    }
    // Fetch the user row from the query above
    while ($row = mysqli_fetch_assoc($profile_query)) {
        $profile_id = $row["id"];
        $fn = $row["firstname"];
        $ln = $row["lastname"];
        $gender = strtolower($row["gender"]);
        $country = $row["country"];
        $avatar = $row["avatar1"];
    }
    if ($avatar == null){
        $avatarsrc = 'img/defaultavatar-'.$gender.'.jpg';
    } else {
        $avatarsrc = 'user/'.$profile_id.'/'.$avatar;
    }

    $sql = "SELECT * FROM table_friends WHERE sharer='$profile' AND sharee='$log_id' AND accepted='1' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    if (mysqli_num_rows($query) == 1) {
        $sharee_arr = mysqli_fetch_assoc($query);
    } else if (mysqli_num_rows($query) < 1) {
        $sharee_arr = $users_arr;
    }

    $sql = "SELECT * FROM table_friends WHERE sharer='$log_id' AND sharee='$profile' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    if (mysqli_num_rows($query) == 1) {
        $sharer_arr = mysqli_fetch_assoc($query);
    } else if (mysqli_num_rows($query) < 1) {
        $sharer_arr = $users_arr;
    }

    $sql = "SELECT * FROM table_notifications WHERE initiator='$log_id' AND target='$profile' AND type='requesting_info' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    if (mysqli_num_rows($query) == 1) {
        $request_arr = mysqli_fetch_assoc($query);
    } else if (mysqli_num_rows($query) < 1) {
        $request_arr = $users_arr;
    }
    // GATHER THE POSTED DATA INTO LOCAL VARIABLES
    foreach ($request_arr as $key => $val) {
        if ($key == "email" || $key == "phone" || $key == "address") {
            $list .= $key."==".$val."&&";
        }
    }

    /*
// THIS FUNCTION REMOVES THE '$' FROM THE VARIABLE NAME AND RETURNS A STRING
function pvn($var) {
    foreach($GLOBALS as $var_name => $value) {
        if ($value === $var) {
            return $var_name;
        }
    }
    return false;
}
*/
    function obj_mkr($keyy, $varr){
        //$vn = pvn($var);
        return $keyy.": ".json_encode($varr).",";
    }
    $infoelems = "";
    foreach ($users_arr as $key => $val) {
        if ((substr($key, 0, 2) == "em" || substr($key, 0, 2) == "ph" || substr($key, 0, 3) == "web" || substr($key, 0, 2) == "ad" || substr($key, 0, 3) == "oun" || $key == "brth") && substr($key, -3) != "lbl") {
            $infoelems .= obj_mkr($key, $val)."\n";
        }
    }
    $infoelems2 = substr($infoelems, 0, -2);
    $infoelems3 = "var info_elems = { \n".$infoelems2."\n};";

    $shareeelems = "";
    $shareeelems .= obj_mkr("profile", $profile)."\n";
    foreach ($sharee_arr as $key => $val) {
        if ((substr($key, 0, 2) == "em" || substr($key, 0, 2) == "ph" || substr($key, 0, 3) == "web" || substr($key, 0, 2) == "ad" || substr($key, 0, 3) == "oun" || $key == "brth") && substr($key, -3) != "lbl") {
            $shareeelems .= obj_mkr($key, $val)."\n";
        }
    }
    $shareeelems2 = substr($shareeelems, 0, -2);
    $shareeelems3 = "var sharee_elems = { \n".$shareeelems2."\n};";

    $sharerelems = "";
    $sharerelems .= obj_mkr("profile", $profile)."\n";
    foreach ($sharer_arr as $key => $val) {
        if (($key == "accepted" || substr($key, 0, 2) == "em" || substr($key, 0, 2) == "ph" || substr($key, 0, 3) == "web" || substr($key, 0, 2) == "ad" || substr($key, 0, 3) == "oun" || $key == "brth") && substr($key, -3) != "lbl") {
            $sharerelems .= obj_mkr($key, $val)."\n";
        }
    }
    $sharerelems2 = substr($sharerelems, 0, -2);
    $sharerelems3 = "var sharer_elems = { \n".$sharerelems2."\n};";

    $requestedinfo = "";
    $requestedinfo .= obj_mkr("profile", $profile)."\n";
    foreach ($request_arr as $key => $val) {
        if ($key == "email" || $key == "phone" || $key == "address") {
            $requestedinfo .= obj_mkr($key, $val)."\n";
        }
    }
    $requestedinfo2 = substr($requestedinfo, 0, -2);
    $requestedinfo3 = "var requested_info = { \n".$requestedinfo2."\n};";
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" charset="UTF-8" content="width=device-width, user-scalable=no">
        <title><?php if ($profile == "") {echo "OneCard";} else {echo $fn." ".$ln;} ?></title>
        <link rel="icon" href="<?php echo $url; ?>img/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="<?php echo $url; ?>mobile/style/style.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="<?php echo $url; ?>js/main.js"></script>
        <script src="<?php echo $url; ?>js/ajax.js"></script>
        <script src="<?php echo $url; ?>js/loggedin.js"></script>
        <script src="<?php echo $url; ?>js/profile.js"></script>
        <script>
            <?php echo $infoelems3."\n"; ?>
            <?php echo $shareeelems3."\n"; ?>
            <?php echo $sharerelems3; ?>
            <?php echo $requestedinfo3; ?>
        </script>
    </head>
    <body>
        <?php include_once("template/tem_mobile_loggedin_menubar.php"); ?>
        <div class="body_background">
            <div id="pageMiddle_centered" class="pageMiddle_centered">
                <div id="contact_view" class="contact_view main_box white_box">
                    <?php if($profile == "") {
    echo "<div id=\"cv_title\" class=\"cv_title\">Select a contact from the list.</div>
                </div>
            </div>
        </div>";
    include_once("template/tem_mobile_loggedout_footer.php");
    echo "
    </body>
</html>";
    exit;
} ?>
                    <img class='contact_photo' src='<?php echo $url.$avatarsrc; ?>'>
                    <div id="contact_name" class="contact_name"><?php echo $fn." ".$ln; ?></div>
                    <div id='sharee_summary' class='summary'>
                        <h3>Contact Info Shared With You</h3>
                        <?php include_once("../template/tem_mobile_profile_shareeelements.php"); ?>
                    </div>
                    <div id='sharer_summary' class='summary'>
                        <h3>Contact Information Shared</h3>
                        <?php include_once("../template/tem_mobile_profile_sharerelements.php"); ?>
                        <div id="changestatus" class="changestatus"></div>
                        <div class="option_btns">
                            <button id="share_btn" class="share_btn sharer_elems_btn" onclick="share_info()">Share Info</button>
                            <button id="unshare_btn" class="unshare_btn sharer_elems_btn" onclick="unshare_info()">Unshare All</button>
                            <button id="discchanges_btn" class="discchanges_btn sharer_elems_btn" onclick="default_all()">Discard Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once("template/tem_mobile_mobile_loggedout_footer.php"); ?>
    </body>
</html>
?>