<?php
include_once("../php_includes/home.php");
include_once("../php_includes/check_login_status.php");
// Initialize any variables that the page might echo
if ($profile_ok == false) {
    header("location: ".$url);
    exit();
}

if($profile_ok) {
    $sql = "SELECT * FROM table_users WHERE id='$log_id' AND activated='1' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $users_arr = mysqli_fetch_assoc($query);
    $log_email = $users_arr['email'];
    $log_password = $users_arr['password'];

    $sql = "SELECT * FROM table_userinfo WHERE id='$log_id' AND activated='1' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $row = mysqli_fetch_assoc($query);
    $log_firstname = $row['firstname'];
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
$sql = "SELECT sort_order, disp_order FROM table_useroptions WHERE id='$log_id' LIMIT 1";
$query = mysqli_query($db_conx, $sql);
$pref_array = mysqli_fetch_assoc($query);
foreach ($pref_array as $key => $val) {
    if ($key == "sort_order" || $key == "disp_order") {
        $jsobj2 .= obj_mkr($key, $val)."\n";
    }
}
$jsobj2 = substr($jsobj2, 0, -2);
$jsobj = "var preferences = { \n".$jsobj2."\n};";

/*
INCLUDE ONCE CODE HERE
*/
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" charset="UTF-8" content="width=device-width, user-scalable=no">
        <title>Settings &amp; Preferences</title>
        <link rel="icon" href="/img/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="img/mobile/stylesheets/style.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="/js/main.js"></script>
        <script src="/js/ajax.js"></script>
        <script src="/js/loggedin.js"></script>
        <script src="/js/settings.js"></script>
        <script>
            <?php echo $jsobj; ?>
        </script>
    </head>
    <body>
        <?php include_once("templates/_mobile_loggedin_menubar.php"); ?>
        <div class="body_background" style="height: auto;">
            <div id="pageMiddle_centered" class="pageMiddle_centered">
                <form id="settingsform" class="settingsform main_box white_box" onsubmit="return false;">
                    <div style='width:inherit'>
                        <div class="settings_header">Settings</div>

                        <div id="email_change" class="settings_subheader">Change Login Email Address</div>

                        <div id="email1_container" class="account_element">
                            <div class="settings_type_container">
                                <span class="settings_type">New Email</span>
                            </div>
                            <input id="email1_account" class="settings_input" type="text" autocomplete="off" onblur="check_new_email1(); restrict(this.id);" onfocus="hideElement('change_emailstatus');" maxlength="88" value="">
                            <div id="settings_email1status" class="settings_formstatus"></div>
                        </div>

                        <div id="email2_container" class="account_element">
                            <div class="settings_type_container">
                                <span class="settings_type">Re-enter Email</span>
                            </div>
                            <input id="email2_account" class="settings_input" type="text" autocomplete="off" onblur="check_new_email2(); restrict(this.id);" onfocus="hideElement('change_emailstatus');" maxlength="88" value="">
                            <div id="settings_email2status" class="settings_formstatus"></div>
                        </div>

                        <div style='text-align: center;'>
                            <div id="change_emailstatus" class="changestatus"></div>
                        </div>

                        <div class="option_btns">
                            <button id="save_email_btn" class="savechanges_btn settings_btn" onclick="change_email()">Save</button>
                            <button id="discard_email_btn" class="discchanges_btn settings_btn" onclick="default_email()">Cancel</button>
                        </div>


                        <div id="password_change" class="settings_subheader">Change Password</div>

                        <div id="oldpass_container" class="account_element">
                            <div class="settings_type_container">
                                <span class="settings_type">Current Password</span>
                            </div>
                            <input id="pass_old" class="settings_input" type="password" autocomplete="off" onblur="" onfocus="hideElement('change_passwordstatus');" maxlength="88" value="">
                            <div id="oldpassstatus" class="settings_formstatus"></div>
                        </div>

                        <div id="pass1_container" class="account_element">
                            <div class="settings_type_container">
                                <span class="settings_type">New Password</span>
                            </div>
                            <input id="pass1_new" class="settings_input" type="password" autocomplete="off" onblur="check_new_pass1()" onfocus="hideElement('change_passwordstatus');" maxlength="88">
                            <div id="newpass1status" class="settings_formstatus"></div>
                        </div>

                        <div id="pass2_container" class="account_element">
                            <div class="settings_type_container">
                                <span class="settings_type">Re-enter Password</span>
                            </div>
                            <input id="pass2_new" class="settings_input" type="password" autocomplete="off" onblur="check_new_pass2()" onfocus="hideElement('change_passwordstatus');" maxlength="88">
                            <div id="newpass2status" class="settings_formstatus"></div>
                        </div>

                        <div style='text-align: center;'>
                            <div id="change_passwordstatus" class="changestatus"></div>
                        </div>

                        <div class="option_btns">
                            <button id="save_password_btn" class="savechanges_btn settings_btn" onclick="change_password()">Save</button>
                            <button id="clear_password_btn" class="discchanges_btn settings_btn" onclick="clear_passwords()">Cancel</button>
                        </div>

                        <div class="settings_header">Preferences</div>

                        <div id="sort_order_container" class="account_element">
                            <div class="settings_type_container">
                                <span class="settings_type">Contact Sort Order</span>
                            </div>
                            <select id="sort_order" class="preferences_select" onfocus="hideElement('preferencesstatus')">
                                <option value='fname'>First, Last</option>
                                <option value='lname'>Last, First</option>
                            </select>
                        </div>

                        <div id="disp_order_container" class="account_element">
                            <div class="settings_type_container">
                                <span class="settings_type">Contact Display Order</span>
                            </div>
                            <select id="disp_order" class="preferences_select" onfocus="hideElement('preferencesstatus')">
                                <option value='name'>First, Last</option>
                                <option value='revname'>Last, First</option>
                            </select>
                        </div>

                        <div style='text-align: center;'>
                            <div id="preferencesstatus" class="changestatus"></div>
                        </div>

                        <div class="option_btns">
                            <button id="save_preferences_btn" class="savechanges_btn settings_btn" onclick="change_preferences()">Save</button>
                            <button id="clear_preferences_btn" class="discchanges_btn settings_btn" onclick="clear_preferences()">Cancel</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <?php include_once("templates/_mobile_loggedout_footer.php"); ?>
    </body>
</html>