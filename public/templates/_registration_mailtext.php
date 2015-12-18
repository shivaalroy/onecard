<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>OneCard Message</title>
        <link rel="stylesheet" href="/stylesheets/style.css">
    </head>

    <body>
        <div style="padding:10px; background:#09a360; font-size:24px; color:#fff;">
            <a href="'.$url.'">
                <img src="'.$url.'images/logo.png" height="30" alt="Social Network" style="border:none; float:left; padding-right: 20px;">
            </a>
            Account Activation
        </div>
        <div style="padding:24px; padding-left:100px; font-size:17px;">Hello '.$fn.',<br /><br />Click the link below to activate your account when ready:<br /><br /><a href="'.$url.'activation.php?id='.$uid.'&e='.$e.'&p='.$p_hash.'">Click here to activate your account now</a><br /><br />Login after successful activation using your:<br />* E-mail Address: <b>'.$e.'</b>
        </div>
    </body>
</html>