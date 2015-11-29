<div id="loginstatus" class="loginstatus" <?php if($attempt) {echo "style='display:block;'";} ?>>
    <p><b>Login Error</b></p>
    <br />
    <p>Either the email or password given was incorrect.</p>
</div>
<div id="login_centerbox" class="login_centerbox">
    <form id="login_form" action="<?php echo $url; ?>php_parsers/logincode.php" onsubmit="disable_btn('login_btn_big')" method="post">
        <input type="email" id="email" name="email" class="login_form_inputtext form_fields" maxlength="88" placeholder="Email">
        <input type="password" id="password" name="password" class="login_form_inputtext form_fields" maxlength="100" placeholder="Password">
        <input type="hidden" name="device" value="mobile">
        <div class='form_fields'>
            <input type="submit" id="login_btn_big" class="login_btn_big" value="Log In">
        </div>
    </form>
</div>
<a class='link' href="<?php echo $mobile_url; ?>forgot_pass.php">Forgot Password?</a>