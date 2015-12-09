function restrict(elem){
    var tf = _(elem);
    var rx = new RegExp;
    if(elem == "reg_email"){
        rx = /[' "]/gi;
    } else if(elem == "username"){
        rx = /[^a-z0-9]/gi;
    } else if(elem == "firstname" || elem == "lastname" || elem == "fnq" || elem == "lnq") {
        rx = /[^a-z]/gi;
    }
    tf.value = tf.value.replace(rx, "");
}
var reg_email_ok = false;
function checkreg_email(){
    var e2 = _("reg_email").value;
    var e = e2.replace(/[' "]/gi, "");
    if(e != ""){
        var ajax = ajaxObj("POST", "php_parsers/check_email.php");
        ajax.send("reg_emailcheck="+e);
        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                if (ajax.responseText === 'available') {
                    _("reg_email").style.borderColor = "#009900";
                    _("reg_emailstatus").style.paddingTop = "0px";
                    _("reg_emailstatus").innerHTML = '';//checking...
                    reg_email_ok = true;
                } else {
                    _("reg_emailstatus").style.color = "#F00";
                    _("reg_emailstatus").style.paddingTop = "4px";
                    _("reg_emailstatus").innerHTML = e+" is already in use";
                    _("reg_email").style.borderColor = "#F00";
                }
            }
        }
    } else {
        _("reg_emailstatus").innerHTML = "";
        _("reg_email").style.borderColor = "#F00";
    }
}
function checkfirstname(){
    var name = _("firstname").value;
    if(name == ""){
        _("firstname").style.borderColor = "#F00";
    } else {
        _("firstname").style.borderColor = "#009900";
    }
}
function checklastname(){
    var name = _("lastname").value;
    if(name == ""){
        _("lastname").style.borderColor = "#F00";
    } else {
        _("lastname").style.borderColor = "#009900";
    }
}
var pass1_ok = false;
function checkpass1(){
    var pass1 = _("pass1").value;
    var pass2 = _("pass2").value;
    var check1 = false;
    var check2 = false;
    var check3 = false;
    var check4 = false;
    //_("pass1status").innerHTML = '';//checking...
    //_("pass2status").innerHTML = '';//checking...
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
        _("pass1").style.borderColor = "#909090";
        _("pass1status").style.display = 'none';
    } else {
        pass1_ok = false;
        _("pass1").style.borderColor = "#F00";
        _("pass1status").style.display = 'block';
        _("pass1status").innerHTML = "Password must contain: <div class='pass_bullet_point'>• A lowercase letter</div><div class='pass_bullet_point'>• An uppercase letter</div><div class='pass_bullet_point'>• A number</div>";
    }
    if(pass1 != "" && pass2 != ""){
        if(pass1 === pass2 && pass1_ok == true) {
            _("pass1").style.borderColor = "#009900";
            _("pass2").style.borderColor = "#009900";
            _("pass1status").style.display = 'none';
            _("pass2status").style.display = 'none';
        } else if (pass1 === pass2 && pass1_ok != true) {
            //_("pass1").style.borderColor = "#F00";
            _("pass2").style.borderColor = "#F00";
            _("pass2status").style.display = 'block';
            _("pass2status").innerHTML = "Password is not acceptable";
        } else if (pass1 !== pass2 && pass1_ok == true) {
            _("pass1").style.borderColor = "#909090";
            _("pass1status").style.display = 'none';
            _("pass2status").style.display = 'block';
            _("pass2status").innerHTML = "Passwords don't match";
        } else {
            _("pass1").style.borderColor = "#F00";
            _("pass2").style.borderColor = "#F00";
            _("pass2status").style.display = 'block';
            _("pass2status").innerHTML = "Passwords don't match";
        }
    }
}
function checkpass2(){
    var pass1 = _("pass1").value;
    var pass2 = _("pass2").value;
    //_("pass2status").innerHTML = '';//checking...
    if(pass1 != "" && pass2 != ""){
        if(pass1 === pass2 && pass1_ok == true) {
            _("pass1").style.borderColor = "#009900";
            _("pass2").style.borderColor = "#009900";
            _("pass1status").style.display = 'none';
            _("pass2status").style.display = 'none';
        } else if (pass1 === pass2) {
            //_("pass1").style.borderColor = "#F00";
            _("pass2").style.borderColor = "#F00";
            _("pass2status").style.display = 'block';
            _("pass2status").innerHTML = "Password is not acceptable";
        } else {
            _("pass1").style.borderColor = "#F00";
            _("pass2").style.borderColor = "#F00";
            _("pass2status").style.display = 'block';
            _("pass2status").innerHTML = "Passwords don't match";
        }
    } else if (pass1 === "" && pass2 === "") {
        _("pass1").style.borderColor = "#F00";
        _("pass2").style.borderColor = "#F00";
    } else if (pass2 === "") {
        _("pass2").style.borderColor = "#F00";
    } else {
        _("pass1").style.borderColor = "#F00";
        _("pass2").style.borderColor = "#F00";
    }
}
function signup(){
    //var u = _("username").value;
    var fn = _("firstname").value;
    var ln = _("lastname").value;
    var e = _("reg_email").value;
    var p1 = _("pass1").value;
    var p2 = _("pass2").value;
    var c = _("country").value;
    var g_m = _("gender_m").checked;
    var g_f = _("gender_f").checked;
    if (g_m) {
        var g = "Male";
    } else if (g_f) {
        var g = "Female";
    } else {
        var g = "";
    }
    var signupstatus = _("signupstatus");
    if(fn == "" || ln == "" || e == "" || p1 == "" || p2 == "" || c == "" || g == ""){
        signupstatus.style.display = "block";
        signupstatus.innerHTML = "Form is incomplete";
    } else if (reg_email_ok != true){
        signupstatus.style.display = "block";
        signupstatus.innerHTML = e+" is already in use";
    } else if (p1 != p2){
        signupstatus.style.display = "block";
        signupstatus.innerHTML = "Passwords don't match";
    } else if (pass1_ok != true){
        signupstatus.style.display = "block";
        signupstatus.innerHTML = "Password must contain a lowercase letter, an uppercase letter, and a number";
    } else {
        signupstatus.style.display = 'none'; //please wait...
        disable_btn("signup_btn"); //please wait...
        var ajax = ajaxObj("POST", "php_parsers/registration.php");
        ajax.send("fn="+fn+"&ln="+ln+"&e="+e+"&p="+p1+"&c="+c+"&g="+g);
        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                if(ajax.responseText != "signup_success"){
                    signupstatus.style.display = "block";
                    signupstatus.innerHTML = ajax.responseText;
                } else {
                    window.location.replace("message.php?msg=verify_account&fn="+fn+"&e="+e);
                }
            }
        }
    }
}