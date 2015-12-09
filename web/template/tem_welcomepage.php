<?php
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Welcome to OneCard</title>
        <link rel="icon" href="/img/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="/style/style.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600">
        <script src="/js/main.js"></script>
        <script src="/js/ajax.js"></script>
        <script src="/js/signup.js"></script>
    </head>
    <body>
        <?php include_once("tem_loggedout_menubar_wloginform.php"); ?>
        <div class="flat_ui_bg">
            <div id="pageMiddle_centered" class="pageMiddle_centered">
                <div id="welcomeInfo" class="welcomeInfo">
                    <div class='head_info'>Sync up-to-date contact info automatically into your address book <span class="company_name">with OneCard.</span></div>
                    <div id="infoText" class="infoText">
                        <div class='info_point'><strong>Share your newest contact details</strong> with the people you know</div>
                        <div class='info_point'><strong>Choose what you share</strong> on a person-to-person basis</div>
                        <div class='info_point'><strong>Store your contacts</strong> in the cloud and access them anywhere</div>
                    </div>
                </div>
                <div id="register" class="register">
                    <h2 class="welcomeTitle" id="welcomeTitle">Sign Up</h2>
                    <?php include_once("tem_signupform.php"); ?>
                </div>
            </div>
        </div>
        <?php include_once("tem_loggedout_footer.php"); ?>
    </body>
</html>