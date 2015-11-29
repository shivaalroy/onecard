<?php
?>
<div id="loggedout_menubar_container" class="loggedout_menubar_container">
    <div id="loggedout_menubar" class="loggedout_menubar">
        <div id="loggedout_menubar_left" class="loggedout_menubar_left">
            <a id="home_link" href="<?php echo $url; ?>">
                <img src="<?php echo $url; ?>img/logo.png" alt="logo" title="OneCard">
            </a>
        </div>
        <div id="loggedout_menubar_login_container" class="loggedout_menubar_login_container">
            <button id="login_btn_link" class="login_btn_link" onclick="location.href='<?php echo $url; ?>login.php'">Log In</button>
        </div>
    </div>
</div>