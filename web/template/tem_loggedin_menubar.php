<?php
$current_url = (!empty($_SERVER['HTTPS'])) ? $_SERVER['REQUEST_URI'] : $_SERVER['REQUEST_URI'];
$current_url = substr($current_url, 1);
$sql1 = "SELECT * FROM table_friends WHERE sharee='$log_id' AND new='1' ORDER BY datemade ASC";
$query1 = mysqli_query($db_conx, $sql1);
$cr_badge = mysqli_num_rows($query1);
$cr_badge_style = "";
$cr_icon_style = "";
if ($cr_badge < 1 || $current_url == "contact_requests.php") {
    $cr_badge_style = "style='display: none;'";
}
if ($cr_badge > 0 || $current_url == "contact_requests.php") {
    $cr_icon_style = "style='background-image: url(../img/contact_card_white_w_male_avatar.png); opacity:0.95;'";
}

$sql2 = "SELECT * FROM table_notifications WHERE target='$log_id' AND new='1' ORDER BY date_time ASC";
$query2 = mysqli_query($db_conx, $sql2);
$notes_badge = mysqli_num_rows($query2);
if ($notes_badge < 1 || $current_url == "notifications.php") {
    $notes_badge_style = "style='display: none;'";
}

$sql3 = "SELECT gender, avatar1 FROM table_userinfo WHERE id='$log_id'";
$query3 = mysqli_query($db_conx, $sql3);
$row = mysqli_fetch_row($query3);
$log_gender = strtolower($row[0]);
$log_avatar = $row[1];
if ($log_avatar == null){
    $log_avatarsrc = 'img/defaultavatar-'.$log_gender.'.jpg';
} else {
    $log_avatarsrc = 'user/'.$log_id.'/'.$log_avatar;
}
?>
<div id="loggedin_menubar_container" class="loggedin_menubar_container">
    <div id="loggedin_menubar" class="loggedin_menubar">
        <div id="loggedin_menubar_left" class="loggedin_menubar_left">
            <a href="/" class="home_link">
                <img class="home_img" src="/img/logo_loggedin.png" alt="logo" title="OneCard">
            </a>
            <form name="menubar_search" id="menubar_search" class="menubar_search" onsubmit="return false;">
                <input type="search" id="omni_query" class="search_inputtext omni_query_and_result" onfocus="menubar_user_search()" maxlength="200" placeholder="Search for people">
                <button id="menubar_search_btn" class="menubar_search_btn" onclick="menubar_user_search()">
                    <img class="search_magglass" src="/img/search_magglass.png" alt="Search">
                </button>
                <br />
                <div id="live_results_box" class="live_results_box omni_query_and_result" onmouseover="lrbOver()" onmouseout="lrbOut()">
                    <ul id="live_results" class="live_results"></ul>
                </div>
            </form>
        </div>


        <div id="loggedin_menubar_right" class="loggedin_menubar_right">

            <ul class="navigation_list">
                <li class="menu_item">
                    <a id="log_firstname" class="menubar_container menubar_link" href="myinfo.php">
                        <img class='my_photo' src='<?php echo $log_avatarsrc; ?>'>
                        <span><?php if (isset($log_firstname)) {echo $log_firstname;} ?></span>
                    </a>
                </li>

                <li class="menu_item">
                    <div id="contact_reqs_container" class="popup_badge_container menubar_container no_bg">
                        <a id="contact_reqs_link" class="contact_reqs_link menubar_link" href="contact_requests.php" <?php echo $cr_icon_style; ?>></a>
                        <a id="cr_badge_link" class="popup_badge_link" href="contact_requests.php">
                            <div id="cr_badge" class="popup_badge" <?php echo $cr_badge_style; ?>>
                                <?php echo $cr_badge; ?>
                            </div>
                        </a>
                    </div>
                </li>

                <li class="menu_item">
                    <div id="notifications_container" class="popup_badge_container menubar_container">
                        <a id="notifications_link" class="notifications_link menubar_link" href="notifications.php">Notifications</a>
                        <a id="notes_badge_link" class="popup_badge_link" href="notifications.php"><div id="notes_badge" class="popup_badge" <?php echo $notes_badge_style; ?>>
                            <?php echo $notes_badge; ?>
                            </div>
                        </a>
                    </div>
                </li>

                <div id="more_options" class="more_options non_container" onclick="toggle_more_options()" onmouseover="moreoptionsOver()" onmouseout="moreoptionsOut()">
                    <div id="down_arrow" class="down_arrow" alt="more_options"></div>
                    <ul id="more_options_submenu" class="more_options_submenu" onmouseover="moreoptionsOver()" onmouseout="moreoptionsOut()">
                        <li onclick="location.href='user_includes/download_contacts.php'">
                            <div class="list_text">Download Contacts</div>
                        </li>
                        <li>
                            <a class="list_text" href="settings.php">Settings &amp; Preferences</a>
                        </li>
                        <li onclick="location.href='logout.php'">
                            <div class="list_text">Log Out</div>
                        </li>
                    </ul>
                </div>
            </ul>

        </div>
    </div>
</div>
<div id="loggedin_menubar_placeholder" class="loggedin_menubar_placeholder"></div>