function restrict(elem){
    var tf = _(elem);
    var rx = new RegExp;
    if(elem == "nospaces"){
        rx = /[' "]/gi;
    } else if(elem == "username"){
        rx = /[^a-z0-9\.]/gi;
    } else if(elem == "text") {
        rx = /[^a-z]/gi;
    } else if(elem == "numbers") {
        rx = /[^0-9]/gi;
    } else if(elem == "url") {
        rx = 9000;
    } else if(elem == "address") {
        rx = /[^a-z0-9\,\.\ ]/gi;
    }
    if (rx == 9000) {
        tf.value = escapeHTML(tf.value);
    } else {
        tf.value = tf.value.replace(rx, "");
    }
}
function redirect(){
    var fn = "Shivaal";
    var e = "shivaalroy@gmail.com"
    window.location.replace("http://onecard.x10.mx/message.php?msg=verify_account&fn="+fn+"&e="+e);
}
function addstuff(){
    _("men").style.height = "30px";
    _("men").style.border = "solid 1px black";
    _("men").style.display = "block";
    _("men").innerHTML = "Yo how you doin";
}