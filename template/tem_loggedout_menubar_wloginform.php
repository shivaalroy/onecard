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
            <!-- LOGIN FORM -->
            <form id="login_form_header" class="login_form_header" onsubmit="disable_btn('login_btn_header');" action="php_parsers/logincode.php" method="post">
                <table style="padding:0;">
                    <tbody>
                        <tr>
                            <td>
                                <label for="email" class="login_form_hlabel">Email Address</label>
                            </td>
                            <td>
                                <label for="password" class="login_form_hlabel">Password</label>
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="email" class="login_form_hinputtext" name="email" id="email" value="" tabindex="1" onfocus="emptyElement('loginstatus')" maxlength="88" autofocus>
                            </td>
                            <td>
                                <input type="password" class="login_form_hinputtext" name="password" id="password" tabindex="2" onfocus="emptyElement('loginstatus')" maxlength="100">
                            </td>
                            <td>
                                <input type="submit" id="login_btn_header" class="login_btn_header" tabindex="4" value="Log In">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="persistent_container">
                                    <div>
                                        <input id="persistent_box" class="persistent_box" type="checkbox" name="persistent" value="1" tabindex="3">
                                        <label for="persistent_box" class="persistent_label">Keep me logged in</label>
                                    </div>
                                    <input type="hidden" name="default_persistent" value="0">
                                    <input type="hidden" name="device" value="desktop">
                                </div>
                            </td>
                            <td>
                                <a href="<?php echo $url; ?>forgot_pass.php">Forgot your password?</a>
                            </td>
                            <td>
                                <span id="loginstatus" class="loginstatus"></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <!-- LOGIN FORM -->
        </div>
    </div>
</div>