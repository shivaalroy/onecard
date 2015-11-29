function contactReqHandler(action, reqid, sharer, name){
    var elem = "shared_info_details_"+reqid;
    var btns = "request_option_btns_"+reqid;
    //_(elem).innerHTML = "";
    var ajax = ajaxObj("POST", "php_parsers/friend_system.php");
    ajax.send("action="+action+"&reqid="+reqid+"&sharer="+sharer);
    ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
            if(ajax.responseText == "accept_ok"){
                _(elem).innerHTML = "<b>Request Accepted</b>";
                _(btns).style.display = "none";
            } else if(ajax.responseText == "ignore_ok"){
                _(elem).innerHTML = "<b>Request Ignored</b>";
                _(btns).style.display = "none";
            } else if(ajax.responseText == "delete_ok"){
                _(elem).innerHTML = "<b>Request Deleted</b>";
                _(btns).style.display = "none";
            } else {
                _(elem).innerHTML = ajax.responseText;
            }
        }
    }
}