<form name="signupform" id="signupform" class="signupform" onsubmit="return false;">
    <div style="height: 40px; margin-top: 0;">
        <input id="firstname" class="reg_inputtext2" type="text" onblur="checkfirstname(); restrict('firstname');" onfocus="hideElement('signupstatus')" maxlength="30" placeholder="First Name">

        <input id="lastname" class="reg_inputtext2" type="text" onblur="checklastname(); restrict('lastname');" onfocus="hideElement('signupstatus')" maxlength="30" placeholder="Last Name">
    </div>

    <input id="reg_email" class="reg_inputtext" type="email" autocomplete="off" value="" onblur="checkreg_email(); restrict('reg_email');" onfocus="hideElement('signupstatus')" maxlength="88" placeholder="Email">
    <div id="reg_emailstatus" class="reg_emailstatus reg_status"></div>

    <input id="pass1" class="reg_inputtext" type="password" autocomplete="off" value="" onblur="checkpass1()" onfocus="hideElement('signupstatus')" maxlength="30" placeholder="Password">
    <div id="pass1status" class="pass1status reg_status"></div>

    <input id="pass2" class="reg_inputtext" type="password" onblur="checkpass2()" onfocus="hideElement('signupstatus')" maxlength="30" placeholder="Re-enter Password">
    <div id="pass2status" class="pass2status reg_status"></div>

    <input type="radio" id="gender_f" class="gender" name="gender" value="Female" onfocus="hideElement('signupstatus')"><label for="gender_f" class="gender_text">Female</label>
    <input type="radio" id="gender_m" class="gender" name="gender" value="Male" onfocus="hideElement('signupstatus')"><label for="gender_m" class="gender_text">Male</label>

    <div class="country">Country</div>
    <select id="country" class="country_select" onfocus="hideElement('signupstatus')">
        <?php include_once("tem_mobile_country_list.php"); ?>
    </select>
    <div class="viewTerms">
        By clicking Sign Up, you agree to our <a href="img/terms.php" target="_blank">Terms</a>, <a href="#" target="_blank" onclick="">Data Use Policy</a> <br />
        and our <a href="#" target="_blank" onclick="">Cookie Policy</a>.
    </div>
    <button id="signup_btn" class="signup_btn" onclick="signup()">Sign Up</button>
    <div id="signupstatus" class="signupstatus"></div>
</form>