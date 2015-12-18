<?php
include_once("../includes/home.php");
include_once("../includes/check_login_status.php");
// Initialize any variables that the page might echo
if ($profile_ok == false) {
    header("location: ".$url);
    exit();
}

if($profile_ok) {
    $sql = "SELECT * FROM table_userinfo WHERE id='$log_id' AND activated='1' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $users_arr = mysqli_fetch_assoc($query);
    $log_firstname = $users_arr['firstname'];
    $log_lastname = $users_arr['lastname'];
    //$log_email = $users_arr['email'];
    $log_gender = $users_arr['gender'];
    $log_city = $users_arr['city'];
    $log_country = $users_arr['country'];
    $log_avatar1 = $users_arr['avatar1'];
    $avatar_form  = '
<form id="avatar_form" enctype="multipart/form-data" method="post" action="../parsers/photo_system.php">
    <h4>Change your avatar</h4>
    <input type="file" name="avatar" required>
    <div>
        <input type="submit" class="upload_avatar" value="Upload">
    </div>
</form>';
    if ($log_avatar1 == NULL) {
        $profile_pic = '<img src="'.$url.'img/defaultavatar-'.strtolower($log_gender).'.jpg" alt="'.$user1.'">';
    } else {
        $profile_pic = '<img src="'.$url.'user/'.$log_id.'/'.$log_avatar1.'" alt="'.$log_firstname." ".$log_lastname.'">';
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
$jsobj = "";
$jsobj2 = "";
foreach ($users_arr as $key => $val) {
    if ($key == "firstname" || $key == "lastname" || $key == "country" || $key == "city" || (substr($key, 0, 2) == "em" || substr($key, 0, 2) == "ph" || substr($key, 0, 3) == "web" || substr($key, 0, 2) == "ad" || substr($key, 0, 3) == "oun" || $key == "brth")) {
        $jsobj2 .= obj_mkr($key, $val)."\n";
    }
}
$jsobj2 = substr($jsobj2, 0, -2);
$jsobj = "var elem_obj = { \n".$jsobj2."\n};";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" charset="UTF-8" content="width=device-width, user-scalable=no">
        <title>My Info</title>
        <link rel="icon" href="/img/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="img/mobile/stylesheets/style.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="/javascripts/main.js"></script>
        <script src="/javascripts/ajax.js"></script>
        <script src="/javascripts/loggedin.js"></script>
        <script src="/javascripts/myinfo.js"></script>
        <script>
            <?php echo $jsobj; ?>
        </script>
    </head>
    <body>
        <?php include_once("templates/_mobile_loggedin_menubar.php"); ?>
        <div class="body_background" style="height: auto;">
            <div id="pageMiddle_centered" class="pageMiddle_centered">
                <div id="myinfoform" class="myinfoform main_box white_box">
                    <div style='width:inherit'>
                        <div class="account_name"><?php echo $log_firstname." ".$log_lastname; ?></div>

                        <div class="option_btns">
                            <button id="savechanges_btn1" class="savechanges_btn myinfo_btn" onclick="change_info()">Save All</button>
                            <button id="discchanges_btn1" class="discchanges_btn myinfo_btn" onclick="default_all()">Discard Changes</button>
                        </div>
                        <div id="changestatus1" class="changestatus"></div>

                        <div id="profile_pic_box">
                            <form id="avatar_form" name="avatar_form" enctype="multipart/form-data" method="post" action="../parsers/photo_system.php" onmouseup='trigger_upload();'>
                                <h4>Update Contact Photo</h4>
                                <div id='upfile_text'>Upload a Photo</div>
                                <input type="file" id='upfile' name="avatar" onchange="avatar_form.submit(); avatar_form_submitted();" required>
                            </form>
                            <?php echo $profile_pic; ?>
                        </div>

                        <div class="main_info_container">
                            <div id="firstname_container" class="contact_element">
                                <span class="main">First Name</span>
                                <input id="firstname" class="myinfo_input myinfo_inputtext2" type="text" onblur="restrict(this.id);" onfocus="hideElement('changestatus1'); hideElement('changestatus2')" maxlength="30" value="<?php echo $log_firstname; ?>">
                            </div>

                            <div id="lastname_container" class="contact_element">
                                <span class="main">Last Name</span>
                                <input id="lastname" class="myinfo_input myinfo_inputtext2" type="text" onblur="restrict(this.id);" onfocus="hideElement('changestatus1'); hideElement('changestatus2')" maxlength="30" value="<?php echo $log_lastname; ?>">
                            </div>

                            <div id="city_container" class="contact_element">
                                <span class="main">City</span>
                                <input id="city" class="myinfo_input myinfo_inputtext2" type="text" onblur="restrict(this.id);" onfocus="hideElement('changestatus1'); hideElement('changestatus2')" maxlength="30" value="<?php echo $log_city; ?>">
                            </div>

                            <div id="country_container" class="contact_element">
                                <span class="main">Country</span>
                                <select id="country" class="myinfo_country_select" onfocus="hideElement('changestatus1'); hideElement('changestatus2')">
                                    <?php include_once("templates/_mobile_country_list.php") ?>
                                </select>
                            </div>
                        </div>

                        <div class="line1"></div>

                        <div class="secondary_info_container">
                            <?php include_once("templates/_mobile_myinfo_contactelements.php") ?>
                        </div>

                        <div id="changestatus2" class="changestatus"></div>
                        <div class="option_btns">
                            <button id="savechanges_btn2" class="savechanges_btn myinfo_btn" onclick="change_info()">Save All</button>
                            <button id="discchanges_btn2" class="discchanges_btn myinfo_btn" onclick="default_all()">Discard Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once("templates/_mobile_loggedout_footer.php"); ?>
    </body>
</html>