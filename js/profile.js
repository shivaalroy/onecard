window.onload = function() {
    for (var prop in requested_info) {
        if(requested_info[prop] == 1) {
            var propbox = "req_"+prop+"_checkbox";
            if (_(propbox) != null) {
                _(propbox).checked = true;
            }
        }
    }
    for (var prop in sharer_elems) {
        if(sharer_elems[prop] == 1 && prop != "profile") {
            if (_(prop) != null) {
                if (sharer_elems["accepted"] == 1) {
                    _(prop).checked = true;
                    toggle_highlight(true, prop+"_label", true);
                } else if (sharer_elems["accepted"] == 0) {
                    _(prop).checked = true;
                    toggle_highlight(true, prop+"_label", false);
                }
            }
        }
    }
};
function request_info(){
    if(confirm("Are you sure you want to request the selected info?")) {
        var requeststatus = _("requeststatus");
        requeststatus.innerHTML = "";
        var list = "";
        list = "request="+sharer_elems["profile"]+"&";
        if (_("req_email_checkbox").checked == true) {
            list += "email=1&";
        } else {
            list += "email=0&";
        }
        if (_("req_phone_checkbox").checked == true) {
            list += "phone=1&";
        } else {
            list += "phone=0&";
        }
        if (_("req_address_checkbox").checked == true) {
            list += "address=1";
        } else {
            list += "address=0";
        }
        requeststatus.style.display = 'block';
        requeststatus.innerHTML = "Please wait...";
        var ajax = ajaxObj("POST", "php_parsers/friend_system.php");
        //requeststatus.innerHTML = list;
        ajax.send(list);
        /*
        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                requeststatus.style.display = "block";
                requeststatus.innerHTML = ajax.responseText;
            }
        }
*/

        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                if (ajax.responseText == "info_requested") {
                    requeststatus.style.display = "block";
                    requeststatus.innerHTML = "Information requested";
                } else {
                    requeststatus.style.display = "block";
                    requeststatus.innerHTML = ajax.responseText;
                }
            }
        };

    }
}
function toggle_highlight(checked, id, accepted) {
    if (accepted) {
        if (checked) {
            _(id).style.color = "#fff";
            _(id).style.background = "linear-gradient(to bottom, #6BC8A0, #22AC70)";
        } else {
            _(id).style.color = "#000";
            _(id).style.background = "transparent";
        }
    } else {
        if (checked) {
            _(id).style.background = "linear-gradient(to bottom, #eee, #ddd)";
        } else {
            _(id).style.background = "transparent";
        }
    }
}
function highlight(elem) {
    var chk = _(elem).checked;
    var elem_label = _(elem+"_label");
    if (sharer_elems["accepted"] == 1) {
        toggle_highlight(chk, elem+"_label", true);
    } else if (sharer_elems["accepted"] == 0) {
        toggle_highlight(chk, elem+"_label", false);
    }
}
function share_info(){
    if(confirm("Are you sure you want to share the info you have selected?")) {
        var changestatus = _("changestatus");
        var list = "";
        changestatus.innerHTML = "";
        list = "type=friend&"
        for (var prop in sharer_elems) {
            var propbox = prop;
            var proplabel = prop+"_label";
            if (_(propbox) != null) {
                if (_(propbox).checked == true) {
                    list += prop+"=1&";
                } else {
                    list += prop+"=0&";
                }
            } else if (prop == "profile") {
                list += prop+"="+sharer_elems[prop]+"&";
            }
        }
        changestatus.style.display = 'block';
        changestatus.innerHTML = "Please wait...";
        var ajax = ajaxObj("POST", "php_parsers/friend_system.php");
        var list2 = list.slice(0, -1);
        //changestatus.innerHTML = list2;
        ajax.send(list2);
        /*
        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                changestatus.style.display = "block";
                changestatus.innerHTML = ajax.responseText;
            }
        }
*/

        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                if (ajax.responseText == "friend_request_sent") {
                    changestatus.style.display = "block";
                    changestatus.innerHTML = "Information successfully shared";
                } else if (ajax.responseText == "info_change_success_but_no_email") {
                    changestatus.style.display = "block";
                    changestatus.innerHTML = "All changes were saved successfully except your new primary email address, "+e+". It is already in use.";
                } else if(ajax.responseText == "info_change_fail"){
                    changestatus.style.display = "block";
                    changestatus.innerHTML = ajax.responseText;
                } else {
                    changestatus.style.display = "block";
                    changestatus.innerHTML = ajax.responseText;
                }
            }
        };

    }
}
function unshare_info(){
    if(confirm("Are you sure you want to unshare all info?")) {
        var changestatus = _("changestatus");
        var list = "";
        changestatus.innerHTML = "";
        list = "type=friend&"
        for (var prop in sharer_elems) {
            var propbox = prop;
            var proplabel = prop+"_label";
            if (_(propbox) != null) {
                list += prop+"=0&";
            } else if (prop == "profile") {
                list += prop+"="+sharer_elems[prop]+"&";
            }
        }
        changestatus.style.display = 'block';
        changestatus.innerHTML = "Please wait...";
        var ajax = ajaxObj("POST", "php_parsers/friend_system.php");
        var list2 = list.slice(0, -1);
        //changestatus.innerHTML = list2;
        ajax.send(list2);
        /*
        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                changestatus.style.display = "block";
                changestatus.innerHTML = ajax.responseText;
            }
        }
*/

        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                if (ajax.responseText == "friend_request_sent") {
                    changestatus.style.display = "block";
                    changestatus.innerHTML = "All information unshared";
                    for (var prop in sharer_elems) {
                        if(_(prop) != null && prop != "profile") {
                            _(prop).checked = false;
                            _(prop+"_label").style.background = "transparent";
                        }
                    }
                } else if (ajax.responseText == "info_change_success_but_no_email") {
                    changestatus.style.display = "block";
                    changestatus.innerHTML = "All changes were saved successfully except your new primary email address, "+e+". It is already in use.";
                } else if(ajax.responseText == "info_change_fail"){
                    changestatus.style.display = "block";
                    changestatus.innerHTML = ajax.responseText;
                } else {
                    changestatus.style.display = "block";
                    changestatus.innerHTML = ajax.responseText;
                }
            }
        };

    }
}
function default_all(){
    if(confirm("Are you sure you want to revert all changes to the last save?")) {
        _("changestatus").innerHTML = "";
        var return_list = "";
        var ajax = ajaxObj("POST", "php_parsers/friend_shared_info.php");
        ajax.send("profile="+sharer_elems['profile']);
        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                return_list = ajax.responseText;
                //_("changestatus").innerHTML += return_list+"<br />";
                for (var prop in sharer_elems) {
                    if (prop != "profile") {
                        var len = prop.length;
                        var pos = return_list.indexOf(prop) + len + 2;
                        var ret_val = return_list.slice(pos, pos+1);
                        //_("changestatus").innerHTML += prop+"<br />";
                        //_("changestatus").innerHTML += len+"<br />";
                        //_("changestatus").innerHTML += ret_val+"<br />";
                        sharer_elems[prop] = ret_val;
                        var propbox = prop;
                        var proplabel = prop+"_label";
                        var propinit = sharer_elems[prop];
                        if (propinit == 1) {
                            propinit = true;
                        } else {
                            propinit = false;
                        }
                        if (_(propbox) != null) {
                            if (_(propbox).checked != propinit) {
                                _(propbox).checked = propinit;
                                if (propinit) {
                                    _(proplabel).style.background = "#68ff68";
                                } else if (!propinit) {
                                    _(proplabel).style.background = "transparent";
                                }
                            }
                        }
                    }
                }
            }
        };
        _("changestatus").innerHTML = "";

    }
}
/*
function friendToggle(type,user,elem){
    var conf = confirm("Press OK to confirm the '"+type+"' action for user <?php echo $u; ?>.");
    if(conf != true){
        return false;
    }
    _(elem).innerHTML = 'please wait ...';
    var ajax = ajaxObj("POST", "php_parsers/friend_system.php");
    ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
            if(ajax.responseText == "friend_request_sent"){
                _(elem).innerHTML = 'OK Friend Request Sent';
            } else if(ajax.responseText == "unfriend_ok"){
                _(elem).innerHTML = '<button onclick="friendToggle(\'friend\',\'<?php echo $u; ?>\',\'friendBtn\')">Request As Friend</button>';
            } else {
                alert(ajax.responseText);
                _(elem).innerHTML = 'Try again later';
            }
        }
    }
    ajax.send("type="+type+"&user="+user);
}
function blockToggle(type,blockee,elem){
    var conf = confirm("Press OK to confirm the '"+type+"' action on user <?php echo $u; ?>.");
    if(conf != true){
        return false;
    }
    var elem = document.getElementById(elem);
    elem.innerHTML = 'please wait ...';
    var ajax = ajaxObj("POST", "php_parsers/block_system.php");
    ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
            if(ajax.responseText == "blocked_ok"){
                elem.innerHTML = '<button onclick="blockToggle(\'unblock\',\'<?php echo $u; ?>\',\'blockBtn\')">Unblock User</button>';
            } else if(ajax.responseText == "unblocked_ok"){
                elem.innerHTML = '<button onclick="blockToggle(\'block\',\'<?php echo $u; ?>\',\'blockBtn\')">Block User</button>';
            } else {
                alert(ajax.responseText);
                elem.innerHTML = 'Try again later';
            }
        }
    }
    ajax.send("type="+type+"&blockee="+blockee);
}
*/