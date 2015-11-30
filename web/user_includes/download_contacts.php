<?php
include_once("../php_includes/home.php");
include_once("../php_includes/check_login_status.php");
include_once("vcard_creator.php");


header('Content-type: text/vcf');
header('Content-Disposition: attachment; filename="contacts_'.date("Y.m.d_H.i.s").'.vcf"');
readfile("../user/".$log_id."/contacts.vcf");


//header("location:".$url."user/".$log_id."/contacts.vcf");
//echo "<br />vCard created successfully!"

?>