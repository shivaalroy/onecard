window.onload = function() {
    _("sort_order").value = preferences["sort_order"];
    _("disp_order").value = preferences["disp_order"];
};
function restrict(elem){
    var tf = _(elem);
    var rx = new RegExp;
    if (elem.substring(0, 5) == "email") {
        rx = /[^a-z0-9\@\.\!\#\$\%\&\'\*\+\-\/\=\?\^\_\`\{\|\}\~]/gi;
    }
    tf.value = tf.value.replace(rx, "");
}
var reg_email_ok = 0;
function check_new_email1(){
    var emailstatus = _("settings_email1status");
    var settingsform = _("settingsform");
    var e2 = _("email1_account").value;
    var e = e2.replace(/[' "]/gi, "");
    var url2 = document.URL;
    var url = escapeHTML(url2);
    if(e != ""){
        var ajax = ajaxObj("POST", "parsers/check_email.php");
        ajax.send("settings_emailcheck="+e);
        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                if (ajax.responseText === 'available') {
                    emailstatus.style.display = "block";
                    $("#settings_email1status").animate({height:14},40);
                    $("#settings_email1status").animate({opacity:1},100);
                    emailstatus.style.color = "#009900";
                    emailstatus.innerHTML = 'You will have to verify this email';
                    reg_email_ok = 1;
                } else if (ajax.responseText === 'same') {
                    emailstatus.style.display = "block";
                    $("#settings_email1status").animate({height:14},40);
                    $("#settings_email1status").animate({opacity:1},100);
                    emailstatus.style.color = "#f00";
                    emailstatus.innerHTML = 'You are already using this email';
                    reg_email_ok = 2;
                } else if (ajax.responseText === 'taken') {
                    emailstatus.style.display = "block";
                    $("#settings_email1status").animate({height:14},40);
                    $("#settings_email1status").animate({opacity:1},100);
                    emailstatus.style.color = "#F00";
                    emailstatus.innerHTML = e+" is in use by someone else";
                    reg_email_ok = 3;
                } else if (ajax.responseText === 'error') {
                    emailstatus.style.display = "block";
                    $("#settings_email1status").animate({height:14},40);
                    $("#settings_email1status").animate({opacity:1},100);
                    emailstatus.style.color = "#F00";
                    emailstatus.innerHTML = "Error: please try again later";
                }  else {
                    emailstatus.style.display = "block";
                    $("#settings_email1status").animate({height:14},40);
                    $("#settings_email1status").animate({opacity:1},100);
                    emailstatus.style.color = "#F00";
                    emailstatus.innerHTML = ajax.responseText;
                    //_("email").style.borderColor = "#F00";
                }
            }
        };
    } else {
        emailstatus.style.display = "none";
        emailstatus.style.height = "0px";
        emailstatus.style.opacity = "0";
        emailstatus.innerHTML = "";
    }
}
function check_new_email2(){
    var emailstatus = _("settings_email2status");
    var e1 = _("email1_account").value;
    var e2 = _("email2_account").value;
    if (e2 != "") {
        if (e1 == e2) {
            emailstatus.style.display = "none";
            emailstatus.style.color = "#009900";
            emailstatus.innerHTML = "";
        } else if (e1 != e2) {
            emailstatus.style.display = "block";
            $("#settings_email2status").animate({height:14},40);
            $("#settings_email2status").animate({opacity:1},100);
            emailstatus.style.color = "#f00";
            emailstatus.innerHTML = "Emails don't match";
        }
    } else {
        emailstatus.style.display = "none";
        emailstatus.innerHTML = "";
    }
}
function change_email(){
    var e1 = _("email1_account").value;
    var e2 = _("email2_account").value;
    var emailstatus = _("change_emailstatus");
    emailstatus.style.display = "none";
    if (e1 == "" || e2 == "") {
        emailstatus.style.display = "inline-block";
        emailstatus.style.color = "#f00";
        emailstatus.innerHTML = "Emails can't be blank";
        return;
    } else if (e1 != e2) {
        emailstatus.style.display = "inline-block";
        emailstatus.style.color = "#f00";
        emailstatus.innerHTML = "Emails don't match";
        return;
    } else if (reg_email_ok != 1) {
        emailstatus.style.display = "inline-block";
        emailstatus.style.color = "#f00";
        if (reg_email_ok == 2) {
            emailstatus.innerHTML = "You are already using this email";
        } else if (reg_email_ok == 3) {
            emailstatus.innerHTML = e1+" is in use by someone else";
        }
        return;
    }
    emailstatus.style.display = 'inline-block';
    emailstatus.style.color = "#000";
    emailstatus.innerHTML = "Please wait...";
    var ajax = ajaxObj("POST", "parsers/account_info_change.php");
    ajax.send("new_email="+e1);
    /*
    ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
            emailstatus.style.display = "block";
            emailstatus.innerHTML = ajax.responseText;
        }
    }
*/

    ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
            if (ajax.responseText == "email_change_success") {
                emailstatus.style.display = "inline-block";
                emailstatus.style.color = "#000";
                emailstatus.innerHTML = "Check your email: "+e1+" in order to complete the process";
            } else if(ajax.responseText == "you_are_user"){
                emailstatus.style.display = "inline-block";
                emailstatus.style.color = "#f00";
                emailstatus.innerHTML = "You are already using the email address: "+e1;
            } else if(ajax.responseText == "taken"){
                emailstatus.style.display = "inline-block";
                emailstatus.style.color = "#f00";
                emailstatus.innerHTML = "The email address, "+e1+", is already in use by someone else";
            } else {
                emailstatus.style.display = "inline-block";
                emailstatus.style.color = "#f00";
                emailstatus.innerHTML = "There was an error. Changes were not saved";
            }
        }
    };

}
function default_email(){
    _("email1_account").value = "";
    _("email2_account").value = "";
    _("settings_email1status").style.display = "none";
    _("settings_email2status").style.display = "none";
    _("change_emailstatus").style.display = "none";
}
var pass1_ok = false;
function check_new_pass1(){
    var pass1 = _("pass1_new").value;
    var pass2 = _("pass2_new").value;
    var check1 = false;
    var check2 = false;
    var check3 = false;
    var check4 = false;
    //_("newpass1status").innerHTML = '';//checking...
    //_("newpass2status").innerHTML = '';//checking...
    if (pass1 != pass1.toUpperCase()) {
        check1 = true;
    }
    if (pass1 != pass1.toLowerCase()) {
        check2 = true;
    }
    if (pass1 != pass1.replace(/[^a-z]/gi, "")) {
        check3 = true;
    }
    if (pass1 != pass1.replace(/[^0-9]/gi, "")) {
        check4 = true;
    }
    if (check1 == true && check2 == true && check3 == true && check4 == true) {
        pass1_ok = true;
        _("pass1_new").style.borderColor = "#909090";
        _("newpass1status").style.display = 'none';
    } else {
        pass1_ok = false;
        _("pass1_new").style.borderColor = "#F00";
        _("newpass1status").style.display = 'block';
        $("#newpass1status").animate({height:56},50);
        $("#newpass1status").animate({opacity:1},100);
        _("newpass1status").innerHTML = "Password must contain: <div style='color: #000; margin: 0;'>• A lowercase letter</div><div style='color: #000; margin: 0;'>• An uppercase letter</div><div style='color: #000; margin: 0;'>• A number</div>";
    }
    if(pass1 != "" && pass2 != ""){
        if(pass1 === pass2 && pass1_ok == true) {
            _("pass1_new").style.borderColor = "#009900";
            _("pass2_new").style.borderColor = "#009900";
            _("newpass1status").style.display = 'none';
            _("newpass2status").style.display = 'none';
        } else if (pass1 === pass2 && pass1_ok != true) {
            //_("pass1").style.borderColor = "#F00";
            _("pass2_new").style.borderColor = "#F00";
            _("newpass2status").style.display = 'block';
            $("#newpass2status").animate({height:14},50);
            $("#newpass2status").animate({opacity:1},100);
            _("newpass2status").innerHTML = "Password is not acceptable";
        } else if (pass1 !== pass2 && pass1_ok == true) {
            _("pass1_new").style.borderColor = "#909090";
            _("newpass1status").style.display = 'none';
            _("newpass2status").style.display = 'block';
            $("#newpass2status").animate({height:14},50);
            $("#newpass2status").animate({opacity:1},100);
            _("newpass2status").innerHTML = "Passwords don't match";
        } else {
            _("pass1_new").style.borderColor = "#F00";
            _("pass2_new").style.borderColor = "#F00";
            _("newpass2status").style.display = 'block';
            $("#newpass2status").animate({height:14},50);
            $("#newpass2status").animate({opacity:1},100);
            _("newpass2status").innerHTML = "Passwords don't match";
        }
    }
}
function check_new_pass2(){
    var pass1 = _("pass1_new").value;
    var pass2 = _("pass2_new").value;
    //_("pass2status").innerHTML = '';//checking...
    if(pass1 != "" && pass2 != ""){
        if(pass1 === pass2 && pass1_ok == true) {
            _("pass1_new").style.borderColor = "#009900";
            _("pass2_new").style.borderColor = "#009900";
            _("newpass1status").style.display = 'none';
            _("newpass2status").style.display = 'none';
            _("newpass1status").innerHTML = '';
            _("newpass2status").innerHTML = '';
        } else if (pass1 === pass2) {
            _("pass2_new").style.borderColor = "#F00";
            _("newpass2status").style.display = 'block';
            $("#newpass2status").animate({height:14},50);
            $("#newpass2status").animate({opacity:1},100);
            _("newpass2status").innerHTML = "Password is not acceptable";
        } else {
            _("pass1_new").style.borderColor = "#F00";
            _("pass2_new").style.borderColor = "#F00";
            _("newpass2status").style.display = 'block';
            $("#newpass2status").animate({height:14},50);
            $("#newpass2status").animate({opacity:1},100);
            _("newpass2status").innerHTML = "Passwords don't match";
        }
    } else if (pass1 === "" && pass2 === "") {
        _("pass1_new").style.borderColor = "#F00";
        _("pass2_new").style.borderColor = "#F00";
    } else if (pass2 === "") {
        _("pass2_new").style.borderColor = "#F00";
    } else {
        _("pass1_new").style.borderColor = "#F00";
        _("pass2_new").style.borderColor = "#F00";
    }
}
function change_password(){
    var p_old = _("pass_old").value;
    var p1 = _("pass1_new").value;
    var p2 = _("pass2_new").value;
    var passwordstatus = _("change_passwordstatus");
    if(p_old == "" || p1 == "" || p2 == ""){
        passwordstatus.style.display = "inline-block";
        passwordstatus.style.color = "#f00";
        passwordstatus.innerHTML = "Passwords can't be blank";
    } else if (p1 != p2){
        passwordstatus.style.display = "inline-block";
        passwordstatus.style.color = "#f00";
        passwordstatus.innerHTML = "Your new passwords don't match. Please try again";
    } else if (pass1_ok != true){
        passwordstatus.style.display = "inline-block";
        passwordstatus.style.color = "#f00";
        passwordstatus.innerHTML = "Password must contain a lowercase letter, an uppercase letter, and a number";
    } else {
        passwordstatus.style.display = 'none'; //please wait...
        var ajax = ajaxObj("POST", "parsers/account_info_change.php");
        ajax.send("old_password="+p_old+"&new_password="+p1);
        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                if(ajax.responseText == "pass_change_success"){
                    passwordstatus.style.color = "#000";
                    passwordstatus.style.display = "inline-block";
                    var pcm = "Your password has been successfully changed. Redirecting to login page in ";
                    passwordstatus.innerHTML = pcm+"3";
                    setTimeout(function(){
                        passwordstatus.innerHTML = pcm+"2";
                    },1000);
                    setTimeout(function(){
                        passwordstatus.innerHTML = pcm+"1";
                    },2000);
                    setTimeout(function(){
                        window.location.replace("http://onecard.x10.mx/login.php");
                    },3000);
                } else if (ajax.responseText == "wrong_pass"){
                    passwordstatus.style.color = "#f00";
                    passwordstatus.style.display = "inline-block";
                    passwordstatus.innerHTML = "Old password entered is incorrect";
                } else if (ajax.responseText == "below_par"){
                    passwordstatus.style.color = "#f00";
                    passwordstatus.style.display = "inline-block";
                    passwordstatus.innerHTML = "Password doesn't contain a lowercase letter, an uppercase letter, and a number";
                } else {
                    passwordstatus.style.color = "#f00";
                    passwordstatus.style.display = "inline-block";
                    passwordstatus.innerHTML = "There was an error changing your password";
                }
            }
        }
    }
}
function clear_passwords(){
    _("pass_old").value = "";
    _("pass1_new").value = "";
    _("pass2_new").value = "";
    _("newpass1status").style.display = "none";
    _("newpass2status").style.display = "none";
    _("change_passwordstatus").style.display = "none";
}
function change_preferences(){
    var sort_order = _("sort_order").value;
    var disp_order = _("disp_order").value;
    var prefstatus = _("preferencesstatus");
    prefstatus.style.display = 'none'; //please wait...
    var ajax = ajaxObj("POST", "parsers/account_info_change.php");
    ajax.send("sort_order="+sort_order+"&disp_order="+disp_order);
    ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
            if(ajax.responseText == "pref_change_success"){
                prefstatus.style.color = "#000";
                prefstatus.style.display = "inline-block";
                prefstatus.innerHTML = "Your preferences were successfully saved";
            } else {
                prefstatus.style.color = "#f00";
                prefstatus.style.display = "inline-block";
                prefstatus.innerHTML = "There was an error saving your preferences";
            }
        }
    };
}
function clear_preferences(){
    var return_list = "";
    var ajax = ajaxObj("POST", "parsers/account_info_default.php");
    ajax.send("defaultpreferences=yes");
    ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
            return_list = ajax.responseText;
            //_("preferencesstatus").innerHTML += return_list+"<br />";
            for (var prop in preferences) {
                if (prop == "sort_order" || prop == "disp_order") {
                    var len = prop.length;
                    var pos1 = return_list.indexOf("`|[({"+prop+"})]|`") + len + 10 + 2;
                    var pos2 = return_list.lastIndexOf("`|[({"+prop+"})]|`");
                    var ret_val = return_list.slice(pos1, pos2);
/*
                    _("preferencesstatus").style.display = "inline-block";
                    _("preferencesstatus").innerHTML += prop+"<br />";
                    _("preferencesstatus").innerHTML += len+"<br />";
                    _("preferencesstatus").innerHTML += ret_val+"<br />";
*/
                    preferences[prop] = ret_val;
                    _(prop).value = preferences[prop];
                }
            }
        }
    };
/*
    _("preferencesstatus").style.display = "none";
    _("preferencesstatus").innerHTML = "";
*/
}