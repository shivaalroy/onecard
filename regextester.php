<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Regex Tester</title>
        <link rel="icon" href="<?php echo $url; ?>img/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="<?php echo $url; ?>style/style.css">
        <style type="text/css">
            #test_img {
                border-radius: 10px;
                margin: 20px;
                height: 200px;
                width: 200px;
            }

        </style>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="<?php echo $url; ?>js/main.js"></script>
        <script src="<?php echo $url; ?>js/regex.js"></script>
    </head>
    <body>
        <div id="pageMiddle_centered" class="pageMiddle_centered body_background">

            <img id='test_img' src="http://onecard.x10.mx/user/1/172408378962.jpg">

            <form id="myinfoform" onsubmit="return false;">

                <div class="contact_element">
                    <span class="main">Text</span>
                    <input id="text" type="text" onblur="restrict('text');" maxlength="30">
                </div>


                <div class="contact_element">
                    <span class="main">Numbers</span>
                    <input id="numbers" type="text" onblur="restrict('numbers');" maxlength="30">
                </div>


                <div class="contact_element">
                    <span class="main">No Spaces</span>
                    <input id="nospaces" type="text" onblur="restrict('nospaces');" maxlength="88">
                </div>


                <div class="contact_element">
                    <span class="main">Username</span>
                    <input id="username" type="text" onblur="restrict('username');" maxlength="88">
                </div>


                <div class="contact_element">
                    <span class="main">URL</span>
                    <input id="url" type="text" onblur="restrict('url');" maxlength="88">
                </div>


                <div class="contact_element">
                    <span class="main">Address</span>
                    <input id="address" type="textarea" onblur="restrict('address');" maxlength="88">
                </div>

                <div class="white_box" style='width:200px; height:auto; padding:10px; margin: 20px;'>
                    <span class="main">Address</span>
                    <input id="testing" type="text" onblur="addstuff()">
                    <div id="men" style='display: none;'></div>
                </div>

            </form>
            <button onclick="redirect()">Take Me Away</button>
        </div>
    </body>
</html>