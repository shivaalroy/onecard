<?php
require '../vendor/autoload.php';
include_once 'php_includes/home.php';
$username = getenv('SENDGRID_USERNAME');
$password = getenv('SENDGRID_PASSWORD');
$sendgrid = new SendGrid($username, $password);

$to = "shivaalroy@gmail.com";
$from = "no-reply".$hosuff;
$subject = 'OneCard Account Activation';
$text = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>OneCard Message</title>
        <link rel="stylesheet" href="'.$url.'style/style.css">
    </head>

    <body>
        <div style="padding:10px; background:#09a360; font-size:24px; color:#fff;">
            <a href="'.$url.'" style="border:none; float:left; padding-right: 20px; color:#fff; text-decoration:none;">
                OneCard
            </a>
            Account Activation
        </div>
        <div style="padding:24px; padding-left:100px; font-size:17px;">Hello '.$fn.',<br /><br />Click the link below to activate your account when ready:<br /><br /><a href="'.$url.'activation.php?id='.$uid.'&e='.$e.'&p='.$p_hash.'">Click here to activate your account now</a><br /><br />Login after successful activation using your:<br />* E-mail Address: <b>'.$e.'</b>
        </div>
    </body>
</html>';

$message = new SendGrid\Email();
$message->addTo($to)->
          setFrom($from)->
          setSubject($subject)->
          setHtml($text);
$response = $sendgrid->send($message);
if ($response) {
    echo "email_success";
} else {
    echo "email_failure";
}
?>