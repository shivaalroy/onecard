function _(x) {
    return document.getElementById(x);
}
function _name(x) {
    return document.getElementsByName(x); //need to be followed by "[n]" where 'n' is an integer
}
function _class(x) {
    return document.getElementsByClassName(x); //need to be followed by "[n]" where 'n' is an integer
}
function _tag(x) {
    return document.getElementsByTagName(x); //need to be followed by "[n]" where 'n' is an integer
}
function emptyElement(x) {
    document.getElementById(x).innerHTML = "";
}
function hideElement(x) {
    document.getElementById(x).style.display = "none";
}
function hideElements(x) {
    var elems = document.getElementsByClassName(x);
    var i = elems.length;

    while(i--) {
        elems[i].style.display = "none";
    }
}
function escapeHTML(x) {
    return x
    //.replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}
function disable_btn(x) {
    _(x).disabled = true;
    _(x).style.background = "#ccc";
}
function toggleElement(x){
	var x = _(x);
	if(x.style.display == 'block'){
		x.style.display = 'none';
	}else{
		x.style.display = 'block';
	}
}
/* function addEvents(){
	_("elemID").addEventListener("click", func, false);
}
window.onload = addEvents; */