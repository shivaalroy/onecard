window.onload = function() {
    var offset = new Date().getTimezoneOffset();
    var ajax = ajaxObj("POST", "parsers/set_timezone.php");
    ajax.send("offset="+offset);
    /*
    ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
            alert(ajax.responseText);
        }
    };
*/
};