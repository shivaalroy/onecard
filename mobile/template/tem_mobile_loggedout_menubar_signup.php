<?php
?>
<div id="loggedout_menubar_container" class="loggedout_menubar_container">
    <div id="loggedout_menubar" class="loggedout_menubar">
        <div id="loggedout_menubar_left" class="loggedout_menubar_left">
            <a href="<?php echo $url; ?>">
                <img src="<?php echo $url; ?>img/logo.png" alt="logo" title="OneCard">
            </a>
        </div>
        <div id="loggedout_menubar_login_container" class="loggedout_menubar_login_container">
            <button id="signup_btn_header" class="signup_btn_header" onclick="location.href='<?php echo $url; ?>signup.php'">Sign Up</button>
        </div>
    </div>
</div>