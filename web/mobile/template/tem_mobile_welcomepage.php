<?php
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" charset="UTF-8" content="width=device-width, user-scalable=no">
        <title>Welcome to OneCard</title>
        <link rel="icon" href="/img/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="img/mobile/stylesheets/style.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="/js/main.js"></script>
        <script src="/js/ajax.js"></script>
        <script src="/js/signup.js"></script>
    </head>
    <body>
        <div id='viewport'>
            <?php include_once("tem_mobile_loggedout_menubar.php"); ?>
            <div class="body_background">
                <div id="pageMiddle_centered" class="pageMiddle_centered">
                    <?php include_once("tem_mobile_loginform.php"); ?>
                </div>
            </div>
            <?php include_once("tem_mobile_loggedout_footer.php"); ?>
        </div>
    </body>
</html>