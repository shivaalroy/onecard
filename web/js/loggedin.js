var mousePosition = "";
$(function() {
    //calls ajax function to set timezone in database
    var offset = new Date().getTimezoneOffset();
    var ajax = ajaxObj("POST", "http://onecard.x10.mx/php_parsers/set_timezone.php");
    ajax.send("offset="+offset);
    //alert(offset);
    /*
    ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
            alert(ajax.responseText);
        }
    };
*/

    //performs added contacts search
    $('#contacts_query').fastLiveFilter('#contact_list');

    //hide more options box
    $('body').mouseup(function(){
        if (mousePosition != "moreoptionsOver") {
            $('#more_options_submenu').css("display","none");
            $("#down_arrow").css("background-image","url(../img/down_arrow_black.png)");
            $("#down_arrow").css("opacity","0.4");
        }
    });
    $("#more_options").hover(function(){
        if ($('#more_options_submenu').css("display") == "none") {
            $("#down_arrow").css("opacity","0.6");
        }
    },function(){
        if ($('#more_options_submenu').css("display") == "none") {
            $("#down_arrow").css("opacity","0.4");
        }
    });

    //hide search results box
    $('#omni_query').blur(function(){
        if (mousePosition != "lrbOver") {
            $('#live_results_box').css("display","none");
        }
    });

    //use keys to navigate search options
    var liSelected;
    $(window).keydown(function(e){
        if ($('#live_results_box').css("display") == "block") {
            var li = $('#live_results_box .live_result_list_itm');
            if(e.which === 40){
                if(liSelected){
                    liSelected.removeClass('selected');
                    next = liSelected.next();
                    if(next.length > 0){
                        liSelected = next.addClass('selected');
                    } else {
                        liSelected = li.eq(0).addClass('selected');
                    }
                } else {
                    liSelected = li.eq(0).addClass('selected');
                }
            } else if(e.which === 38){
                if(liSelected){
                    liSelected.removeClass('selected');
                    next = liSelected.prev();
                    if(next.length > 0){
                        liSelected = next.addClass('selected');
                    }else{
                        liSelected = li.last().addClass('selected');
                    }
                } else {
                    liSelected = li.last().addClass('selected');
                }
            } else if(e.which === 13){
                var href = $('#live_results_box .selected a').attr('href');
                window.location.replace(href);
            } else {
                setTimeout(function(){menubar_user_search()}, 10);
            }
        }
    });
});
function menubar_user_search(){
    //var start = new Date().getTime();
    var oq2 = _("omni_query").value;
    var oq = oq2.replace(/[^a-z ]/gi, "");
    var url2 = document.URL;
    var url = escapeHTML(url2);
    if(oq != ""){
        var ajax = ajaxObj("POST", "php_parsers/ajax_livesearch.php");
        ajax.send("&oq="+oq);
        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                _("live_results_box").style.display = "block";
                _("live_results").innerHTML = ajax.responseText;
                //var end = new Date().getTime();
                //var time = end - start;
                //_("cv_title").innerHTML = 'Execution time: '+time;
            }
        }
    } else {
        _("live_results_box").style.display = "block";
        _("live_results").innerHTML = "<li class='no_users_found'>no users found</li>";
    }
}
jQuery.fn.fastLiveFilter = function(list, options) {
    // Options: input, list, timeout, callback
    options = options || {};
    list = jQuery(list);
    var input = this;
    var lastFilter = '';
    var timeout = options.timeout || 0;
    var callback = options.callback || function() {};

    var keyTimeout;

    // NOTE: because we cache lis & len here, users would need to re-init the plugin
    // if they modify the list in the DOM later.  This doesn't give us that much speed
    // boost, so perhaps it's not worth putting it here.
    var lis = list.children();
    var len = lis.length;
    var oldDisplay = len > 0 ? lis[0].style.display : "block";
    callback(len); // do a one-time callback on initialization to make sure everything's in sync

    input.change(function() {
        // var startTime = new Date().getTime();
        var filter = input.val().toLowerCase();
        var li, innerText;
        var numShown = 0;
        for (var i = 0; i < len; i++) {
            li = lis[i];
            innerText = !options.selector ?
                (li.textContent || li.innerText || "") :
            $(li).find(options.selector).text();

            if (innerText.toLowerCase().indexOf(filter) >= 0) {
                if (li.style.display == "none") {
                    li.style.display = oldDisplay;
                }
                numShown++;
            } else {
                if (li.style.display != "none") {
                    li.style.display = "none";
                }
            }
        }
        callback(numShown);
        // var endTime = new Date().getTime();
        // console.log('Search for ' + filter + ' took: ' + (endTime - startTime) + ' (' + numShown + ' results)');
        return false;
    }).keydown(function() {
        clearTimeout(keyTimeout);
        keyTimeout = setTimeout(function() {
            if( input.val() === lastFilter ) return;
            lastFilter = input.val();
            input.change();
        }, timeout);
    });
    return this; // maintain jQuery chainability
}
function moreoptionsOver() {
    mousePosition = "moreoptionsOver";
}
function moreoptionsOut() {
    mousePosition = "moreoptionsOut";
}
function lrbOver() {
    mousePosition = "lrbOver";
}
function lrbOut() {
    mousePosition = "lrbOut";
}
function toggle_more_options(){
    var submenu = _("more_options_submenu");
    var currentdisplay = "";
    currentdisplay = $('#more_options_submenu').css("display");
    if (currentdisplay == "none") {
        submenu.style.display = "block";
        $("#down_arrow").css("background-image","url(../img/down_arrow_white.png)");
        $("#down_arrow").css("opacity","1");
    } else if (currentdisplay == "block") {
        submenu.style.display = "none";
        $("#down_arrow").css("background-image","url(../img/down_arrow_black.png)");
        $("#down_arrow").css("opacity","0.4");
    }
}
/* function addEvents(){
	_("elemID").addEventListener("click", func, false);
}
window.onload = addEvents; */