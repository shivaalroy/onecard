var master = {
    em1_lbl: "Home",
    em2_lbl: "Work",
    em3_lbl: "Email 3",
    em4_lbl: "Email 4",
    em5_lbl: "Email 5",
    em6_lbl: "Email 6",
    em7_lbl: "Email 7",
    em8_lbl: "Email 8",
    em9_lbl: "Email 9",
    em10_lbl: "Email 10",
    ph1_lbl: "Mobile",
    ph2_lbl: "Work",
    ph3_lbl: "Home",
    ph4_lbl: "Main",
    ph5_lbl: "Work Fax",
    ph6_lbl: "Home Fax",
    ph7_lbl: "Phone 7",
    ph8_lbl: "Phone 8",
    ph9_lbl: "Phone 9",
    ph10_lbl: "Phone 10",
    web1_lbl: "Website 1",
    web2_lbl: "Website 2",
    web3_lbl: "Website 3",
    web4_lbl: "Website 4",
    web5_lbl: "Website 5",
    oun_facebook: "Facebook",
    oun_linkedin: "LinkedIn",
    oun_twitter: "Twitter",
    oun_skype: "Skype",
    ad1_lbl: "Work",
    ad2_lbl: "Home",
    ad3_lbl: "Address 3",
    ad4_lbl: "Address 4",
    ad5_lbl: "Address 5",
    brth: "Birthday"
};
function restrict(elem){
    var tf = _(elem);
    var rx = new RegExp;
    if (elem.slice(-3) == "lbl") {
        rx = /[^a-z0-9\ ]/gi;
    } else if(elem.substring(0, 2) == "em") {
        rx = /[^a-z0-9\@\.\!\#\$\%\&\'\*\+\-\/\=\?\^\_\`\{\|\}\~]/gi;
    } else if(elem == "username" || elem.substring(0, 3) == "oun"){
        rx = /[^a-z0-9\.]/gi;
    } else if(elem == "firstname" || elem == "lastname") {
        rx = /[^a-z]/gi;
    } else if(elem.substring(0, 2) == "ph") {
        rx = /[^0-9]/gi;
    } else if(elem.substring(0, 3) == "web") {
        rx = 9000;
    } else if(elem.substring(0, 2) == "ad") {
        rx = /[^a-z0-9\,\.\n\ ]/gi;
    }
    if (rx == 9000) {
        tf.value = tf.value.replace(/[^a-z0-9\-\.\_\~\:\/\?\#\[\]\@\!\$\&\'\(\)\*\+\,\;\=\%]/gi, "");
        tf.value = escapeHTML(tf.value);
    } else {
        tf.value = tf.value.replace(rx, "");
    }
}
function change_info(){
    var e = "";
    var changestatus1 = _("changestatus1");
    var changestatus2 = _("changestatus2");
    var list = "";
    changestatus1.innerHTML = "";
    changestatus2.innerHTML = "";
    for (var prop in elem_obj) {
        if (_(prop) != null && prop.slice(-3) != "lbl") {
            if (_(prop+"_container") != null && _(prop+"_container").style.display != 'none') {
                var propval = _(prop).value;
                if (prop == "firstname" || prop == "lastname" || prop == "country") {
                    if (propval == "") {
                        changestatus1.style.display = "block";
                        changestatus1.innerHTML += "Firstname, Lastname and Country cannot be blank";
                        changestatus2.style.display = "block";
                        changestatus2.innerHTML += "Firstname, Lastname and Country cannot be blank";
                        return;
                    } else {
                        list += prop+"="+propval+"&";
                    }
                } else if (prop == "email") {
                    if (propval == "") {
                        changestatus1.style.display = "block";
                        changestatus1.innerHTML += "Primary Email cannot be blank";
                        changestatus2.style.display = "block";
                        changestatus2.innerHTML += "Primary Email cannot be blank";
                        return;
                    } else {
                        var e = propval;
                        list += prop+"="+propval+"&";
                    }
                } else if (prop.slice(0, 2) == "ad") {
                    if (propval == "") {
                        changestatus1.style.display = "block";
                        changestatus1.innerHTML += "All fields must be filled";
                        changestatus2.style.display = "block";
                        changestatus2.innerHTML += "All fields must be filled";
                        return;
                    } else {
                        propval = propval.replace(/\n/g, '\\n');
                        list += prop+"="+propval+"&";
                    }
                } else {
                    if (propval == "") {
                        changestatus1.style.display = "block";
                        changestatus1.innerHTML += "All fields must be filled";
                        changestatus2.style.display = "block";
                        changestatus2.innerHTML += "All fields must be filled";
                        return;
                    } else {
                        list += prop+"="+propval+"&";
                    }
                }
            } else if (_(prop+"_container") != null && _(prop+"_container").style.display == 'none') {
                var propval = _(prop).value;
                //if (propval != elem_obj[prop]) {
                list += prop+"="+"`|[({eWIf5S0PhgzHmUtITl7I})]|`"+"&"; //`|[({eWIf5S0PhgzHmUtITl7I})]|`
                list += prop+"_lbl="+"`|[({eWIf5S0PhgzHmUtITl7I})]|`"+"&"; //`|[({eWIf5S0PhgzHmUtITl7I})]|`
                //}
            }
        } else if (_(prop) != null && prop.slice(-3) == "lbl") {
            if (_(prop.slice(0, -3)+"container").style.display != 'none') {
                var propval = _(prop).value;
                if (propval == "") {
                    changestatus1.style.display = "block";
                    changestatus1.innerHTML += "All labels must be filled";
                    changestatus2.style.display = "block";
                    changestatus2.innerHTML += "All labels must be filled";
                    return;
                } else {
                    list += prop+"="+propval+"&";
                }
            }
        }
    }
    changestatus1.style.display = 'block';
    changestatus1.innerHTML = "Please wait...";
    changestatus2.style.display = 'block';
    changestatus2.innerHTML = "Please wait...";
    var ajax = ajaxObj("POST", "parsers/account_info_change.php");
    var list2 = list.slice(0, -1);
    //changestatus1.innerHTML = list2;
    ajax.send(list2);
    /*
    ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
            changestatus1.style.display = "block";
            changestatus1.innerHTML = ajax.responseText;
        }
    }
*/

    ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
            if (ajax.responseText == "info_change_success") {
                changestatus1.style.display = "block";
                changestatus1.innerHTML = "All Changes Saved Successfully";
                changestatus2.style.display = "block";
                changestatus2.innerHTML = "All Changes Saved Successfully";
            } else if (ajax.responseText == "info_change_success_and_email") {
                changestatus1.style.display = "block";
                changestatus1.innerHTML = "All changes successfully saved. You must now check your inbox for "+e+" to verify your new primary email address. This must be done within 48 hours for this change to take effect.";
                changestatus2.style.display = "block";
                changestatus2.innerHTML = "All changes successfully saved. You must now check your inbox for "+e+" to verify your new primary email address. This must be done within 48 hours for this change to take effect.";
            } else if (ajax.responseText == "info_change_success_but_no_email") {
                changestatus1.style.display = "block";
                changestatus1.innerHTML = "All changes were saved successfully except your new primary email address, "+e+". It is already in use.";
                changestatus2.style.display = "block";
                changestatus2.innerHTML = "All changes were saved successfully except your new primary email address, "+e+". It is already in use.";
            } else if(ajax.responseText == "info_change_fail"){
                changestatus1.style.display = "block";
                changestatus1.innerHTML = ajax.responseText;
                changestatus2.style.display = "block";
                changestatus2.innerHTML = ajax.responseText;
            } else {
                changestatus1.style.display = "block";
                changestatus1.innerHTML = "Changes were not saved.";
                changestatus2.style.display = "block";
                changestatus2.innerHTML = "Changes were not saved.";
            }
        }
    };

}
function default_all(){
    if(confirm("Are you sure you want to revert all changes to the last save?")) {
        //_("changestatus1").innerHTML = list2;
        var return_list = "";
        var ajax = ajaxObj("POST", "parsers/account_info_default.php");
        ajax.send("defaultinfo=yes");
        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                return_list = ajax.responseText;
                //_("changestatus1").innerHTML += return_list+"<br />";
                for (var prop in elem_obj) {
                    if (prop != "id" && prop != "username" && prop != "email" && prop != "email_lbl" && prop != "password" && prop != "gender" && prop != "userlevel" && prop != "avatar" && prop != "ip" && prop != "signup" && prop != "lastlogin" && prop != "notescheck" && prop != "activated") {
                        var len = prop.length;
                        var pos1 = return_list.indexOf("`|[({"+prop+"})]|`") + len + 10 + 2;
                        var pos2 = return_list.lastIndexOf("`|[({"+prop+"})]|`");
                        var ret_val = return_list.slice(pos1, pos2);
                        //_("changestatus1").innerHTML += prop+"<br />";
                        //_("changestatus1").innerHTML += len+"<br />";
                        //_("changestatus1").innerHTML += ret_val+"<br />";
                        elem_obj[prop] = ret_val;
                        if (_(prop) != null && prop.slice(-3) != "lbl") {
                            if (_(prop+"_container") != null && _(prop).value != elem_obj[prop]) {
                                _(prop).value = elem_obj[prop];
                                if (elem_obj[prop] == "") {
                                    _(prop+"_container").style.display = 'none';
                                } else if (elem_obj[prop] != "") {
                                    _(prop+"_container").style.display = 'block';
                                }
                            } else if (_(prop+"_container") != null && _(prop).value == "") {
                                //_(prop).value = elem_obj[prop];
                                _(prop+"_container").style.display = 'none';
                            }
                        } else if (_(prop) != null && prop.slice(-3) == "lbl") {
                            if (_(prop.slice(0, -3)+"container") != null) {
                                if (elem_obj[prop] != "" && _(prop).value != elem_obj[prop]) {
                                    _(prop).value = elem_obj[prop];
                                    _(prop.slice(0, -3)+"container").style.display = 'block';
                                } else if (elem_obj[prop] == "" && _(prop).value != master[prop]) {
                                    _(prop).value = master[prop];
                                    _(prop.slice(0, -3)+"container").style.display = 'block';
                                }
                            }
                        }
                    }
                }
            }
        };

        _("changestatus1").innerHTML = "";
        _("changestatus2").innerHTML = "";
        _("myacc_emailstatus").innerHTML = "";

    }
}
function expand_input(elem) {
    //var box = _(elem);
    //box.style.fontSize = fontSize;
    //var height = (box.clientHeight + 1) + "px";
    //var wid = box.scrollWidth+"px";
    //box.style.width = wid;
    //var wid = box.value.length;
    //box.setAttribute("size", wid);
    //box.setAttribute("style", "width:auto");
    var input = _(elem);
    setTimeout(function(){
        var tmp = document.createElement('div');
        if(getComputedStyle)
            tmp.style.cssText = getComputedStyle(input, null).cssText;
        if(input.currentStyle)
            tmp.style = input.currentStyle;
        tmp.style.padding = '0';
        tmp.style.width = '';
        tmp.style.position = 'absolute';
        tmp.innerHTML = input.value.replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;")
        .replace(/ /g, '&nbsp;');
        input.parentNode.appendChild(tmp);
        var width = tmp.clientWidth+1;
        tmp.parentNode.removeChild(tmp);
        input.style.width = width+'px';
    }, 1);
}
function clear_field(elem){
    var container_id = elem.slice(0, -5)+"container";
    var label_id = elem.slice(0, -5)+"lbl";
    var input_id = elem.slice(0, -6);
    _(container_id).style.display = 'none';
    _(label_id).value = master[elem.slice(0, -5)+"lbl"];
    _(input_id).value = "";
    if (elem.slice(0,2) == "em") {
        var count = false;
        for (var i = 1; i <= 10; i++) {
            if (_("em"+i+"_container").style.display == 'none') {
                count = true;
            }
        }
        if (count) {
            _("add_email").style.display = 'block';
        }
    } else if (elem.slice(0,2) == "ph") {
        for (var i = 1; i <= 10; i++) {
            if (_("ph"+i+"_container").style.display == 'none') {
                count = true;
            }
        }
        if (count) {
            _("add_phone").style.display = 'block';
        }
    } else if (elem.slice(0,3) == "web") {
        for (var i = 1; i <= 5; i++) {
            if (_("web"+i+"_container").style.display == 'none') {
                count = true;
            }
        }
        if (count) {
            _("add_website").style.display = 'block';
        }
    } else if (elem.slice(0,2) == "ad") {
        for (var i = 1; i <= 5; i++) {
            if (_("ad"+i+"_container").style.display == 'none') {
                count = true;
            }
        }
        if (count) {
            _("add_address").style.display = 'block';
        }
    }
}
function add_em(){
    var count = 0;
    var changed = false;
    for (var i = 1; i <= 10 && !changed; i++) {
        if (_("em"+i+"_container").style.display == 'none') {
            _("em"+i+"_container").style.display = 'block';
            changed = true;
        }
    }
    for (var i = 1; i <= 10 && count < 10; i++) {
        if (_("em"+i+"_container").style.display == 'block') {
            count++;
        }
    }
    if (count == 10) {
        _("add_email").style.display = 'none';
    }
    if (changed) {
        return;
    }
}
function add_ph(){
    var count = 0;
    var changed = false;
    for (var i = 1; i <= 10 && !changed; i++) {
        if (_("ph"+i+"_container").style.display == 'none') {
            _("ph"+i+"_container").style.display = 'block';
            changed = true;
        }
    }
    for (var i = 1; i <= 10 && count < 10; i++) {
        if (_("ph"+i+"_container").style.display == 'block') {
            count++;
        }
    }
    if (count == 10) {
        _("add_phone").style.display = 'none';
    }
    if (changed) {
        return;
    }
}
function add_web(){
    var count = 0;
    var changed = false;
    for (var i = 1; i <= 5 && !changed; i++) {
        if (_("web"+i+"_container").style.display == 'none') {
            _("web"+i+"_container").style.display = 'block';
            changed = true;
        }
    }
    for (var i = 1; i <= 5 && count < 5; i++) {
        if (_("web"+i+"_container").style.display == 'block') {
            count++;
        }
    }
    if (count == 5) {
        _("add_website").style.display = 'none';
    }
    if (changed) {
        return;
    }
}
function add_ad(){
    var count = 0;
    var changed = false;
    for (var i = 1; i <= 5 && !changed; i++) {
        if (_("ad"+i+"_container").style.display == 'none') {
            _("ad"+i+"_container").style.display = 'block';
            changed = true;
        }
    }
    for (var i = 1; i <= 5 && count < 5; i++) {
        if (_("ad"+i+"_container").style.display == 'block') {
            count++;
        }
    }
    if (count == 5) {
        _("add_address").style.display = 'none';
    }
    if (changed) {
        return;
    }
}