<?php
include_once("includes/home.php");
include_once("includes/check_login_status.php");
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
    $log_gender = $users_arr['gender'];
    $log_country = $users_arr['country'];
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
    if ($key != "id" && $key != "password" && $key != "userlevel" && $key != "ip" && $key != "signup" && $key != "lastlogin" && $key != "activated" && $key != "notescheck") {
        $jsobj2 .= obj_mkr($key, $val)."\n";
    }
}
$jsobj2 = substr($jsobj2, 0, -2);
$jsobj = "var elem_obj = { \n".$jsobj2."\n};";

/*
INCLUDE_ONCE CODE HERE
*/
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>New Contact</title>
        <link rel="icon" href="/img/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="/stylesheets/style.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="/js/main.js"></script>
        <script src="/js/ajax.js"></script>
        <script src="/js/loggedin.js"></script>
        <script src="/js/new_contact.js"></script>
        <script>
            <?php echo $jsobj; ?>
        </script>
    </head>
    <body>
        <?php include_once("templates/_loggedin_menubar.php"); ?>
        <div class="body_background" style="height: auto;">
            <div id="pageMiddle_centered" class="pageMiddle_centered">
                <form id="newconform" class="newconform white_box" onsubmit="return false;">

                    <div id="option_btns1" class="option_btns">
                        <button id="savechanges_btn1" class="savechanges_btn newcon_btn" onclick="change_info()">Save All</button>
                        <button id="discchanges_btn1" class="discchanges_btn newcon_btn" onclick="default_all()">Discard Changes</button>
                    </div>
                    <div id="changestatus1" class="changestatus"></div>

                    <div id="firstname_container" class="contact_element">
                        <div class="label_container">
                            <span class="main">First Name</span>
                        </div>
                        <input id="firstname" class="newcon_inputtext2 newcon_input" type="text" onblur="restrict(this.id);" onfocus="hideElement('changestatus1'); hideElement('changestatus2')" maxlength="30" placeholder="">
                    </div>

                    <div id="lastname_container" class="contact_element">
                        <div class="label_container">
                            <span class="main">Last Name</span>
                        </div>
                        <input id="lastname" class="newcon_inputtext2 newcon_input" type="text" onblur="restrict(this.id);" onfocus="hideElement('changestatus1'); hideElement('changestatus2')" maxlength="30" placeholder="">
                    </div>

                    <div class="line1"></div>

                    <?php include_once("templates/_new_contact_contactelements.php") ?>

                    <div id="changestatus2" class="changestatus"></div>
                    <div id="option_btns2" class="option_btns">
                        <button id="savechanges_btn2" class="savechanges_btn newcon_btn" onclick="change_info()">Save All</button>
                        <button id="discchanges_btn2" class="discchanges_btn newcon_btn" onclick="default_all()">Discard Changes</button>
                    </div>
                </form>
            </div>
        </div>
        <?php include_once("templates/_loggedout_footer.php"); ?>
    </body>
</html>