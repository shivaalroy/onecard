<?php
$master = [
    "em1" => "Home",
    "em2" => "Work",
    "em3" => "Email 3",
    "em4" => "Email 4",
    "em5" => "Email 5",
    "em6" => "Email 6",
    "em7" => "Email 7",
    "em8" => "Email 8",
    "em9" => "Email 9",
    "em10" => "Email 10",
    "ph1" => "Mobile",
    "ph2" => "Work",
    "ph3" => "Home",
    "ph4" => "Main",
    "ph5" => "Work Fax",
    "ph6" => "Home Fax",
    "ph7" => "Phone 7",
    "ph8" => "Phone 8",
    "ph9" => "Phone 9",
    "ph10" => "Phone 10",
    "web1" => "Website 1",
    "web2" => "Website 2",
    "web3" => "Website 3",
    "web4" => "Website 4",
    "web5" => "Website 5",
    "oun_facebook" => "Facebook",
    "oun_linkedin" => "LinkedIn",
    "oun_twitter" => "Twitter",
    "oun_skype" => "Skype",
    "ad1" => "Work",
    "ad2" => "Home",
    "ad3" => "Address 3",
    "ad4" => "Address 4",
    "ad5" => "Address 5",
    "brth" => "Birthday"
];

function getLabel($element, $sharer_id, $conx) {
    $sql = "SELECT ".$element."_lbl FROM table_userinfo WHERE id='$sharer_id' AND activated='1' LIMIT 1";
    $query = mysqli_query($conx, $sql);
    $info = mysqli_fetch_row($query);
    return "$info[0]";
}
function getInfo($element, $sharer_id, $conx) {
    $sql = "SELECT $element FROM table_userinfo WHERE id='$sharer_id' AND activated='1' LIMIT 1";
    $query = mysqli_query($conx, $sql);
    $info = mysqli_fetch_row($query);
    return "$info[0]";
}
function addressFormatted($string) {
    $pieces = explode(";", $string);
    $len = count($pieces);
    $output = "";
    foreach ($pieces as $key => $val) {
        if ($val != "") {
            if ($key == 3) {
                $output .= $val.", ";
            } else if ($key == 4) {
                $output .= $val." ";
            } else {
                $output .= $val."\n";
            }
        }
    }
    return $output;
}

$emailaddresses = "";
$phonenumbers = "";
$personalwebsites = "";
$mailingaddresses = "";
$onlineusernames = "";
$otherinfo = "";
/*
$emcnt = 0;
$phcnt = 0;
$webcnt = 0;
$adcnt = 0;
*/
//$ounamecnt = 0;
$orig = "";
foreach ($sharee_arr as $key => $val) {
    if ((substr($key, 0, 2) == "em" || substr($key, 0, 2) == "ph" || substr($key, 0, 3) == "web" || substr($key, 0, 2) == "ad" || substr($key, 0, 3) == "oun" || $key == "brth") && substr($key, -3) != "lbl") {
        if (substr($key, 0, 2) == "em") {
            if ($val == "1") {
                $emailaddresses .= "
<div id='".$key."_sharee_container' class=\"sharee_element\" style=\"display: block;\">
    <div id='".$key."_sharee_lbl' class=\"sharee_label\">".getLabel($key, $profile, $db_conx)."</div>
    <a id='".$key."_sharee_info' class=\"sharee_item\" href='mailto:".getInfo($key, $profile, $db_conx)."' target='_blank'>".getInfo($key, $profile, $db_conx)."</a>
</div>";
            }
        } else if (substr($key, 0, 2) == "ph") {
            if ($val == "1") {
                $phonenumbers .= "
<div id='".$key."_sharee_container' class=\"sharee_element\" style=\"display: block;\">
    <div id='".$key."_sharee_lbl' class=\"sharee_label\">".getLabel($key, $profile, $db_conx)."</div>
    <div id='".$key."_sharee_info' class=\"sharee_item\">".getInfo($key, $profile, $db_conx)."</div>
</div>";
            }
        } else if (substr($key, 0, 2) == "ad") {
            if ($val == "1") {
                $mailingaddresses .= "
<div id='".$key."_sharee_container' class=\"sharee_element\" style=\"display: block;\">
    <div id='".$key."_sharee_lbl' class=\"sharee_label\">".getLabel($key, $profile, $db_conx)."</div>
    <div id='".$key."_sharee_info' class=\"sharee_item\">".addressFormatted(getInfo($key, $profile, $db_conx))."</div>
</div>";
            }
        } else if (substr($key, 0, 3) == "web") {
            if ($val == "1") {
                $personalwebsites .= "
<div id='".$key."_sharee_container' class=\"sharee_element\" style=\"display: block;\">
    <div id='".$key."_sharee_lbl' class=\"sharee_label\">".getLabel($key, $profile, $db_conx)."</div>
    <div id='".$key."_sharee_info' class=\"sharee_item\">".getInfo($key, $profile, $db_conx)."</div>
</div>";
            }
        } else if (substr($key, 0, 3) == "oun") {
            if ($val == "1") {
                $onlineusernames .= "
<div id='".$key."_sharee_container' class=\"sharee_element\" style=\"display: block;\">
    <div id='".$key."_sharee_lbl' class=\"sharee_label\">".getLabel($key, $profile, $db_conx)."</div>
    <div id='".$key."_sharee_info' class=\"sharee_item\">".getInfo($key, $profile, $db_conx)."</div>
</div>";
            }
        } else {
            $otherinfo .= "
<div id='".$key."_sharee_container' class=\"sharee_element\" style=\"display: block;\">
    <div id='".$key."_sharee_lbl' class=\"sharee_label\">".getLabel($key, $profile, $db_conx)."</div>
    <div id='".$key."_sharee_info' class=\"sharee_item\">".getInfo($key, $profile, $db_conx)."</div>
</div>";
        }
        ${'log_'.$key} = $val;
        $orig .= "<li id=\"log_$key\">".${'log_'.$key}."</li>";
    }
}

$posted_info = 0;
if ($emailaddresses != "") {
    echo "<div id='sharee_emails' class='sharee_element_categories'>$emailaddresses</div>";
    $posted_info = 1;
}
if ($phonenumbers != "") {
    echo "<div id='sharee_phones' class='sharee_element_categories'>$phonenumbers</div>";
    $posted_info = 1;
}
if ($mailingaddresses != "") {
    echo "<div id='sharee_addresses' class='sharee_element_categories'>$mailingaddresses</div>";
    $posted_info = 1;
}
if ($personalwebsites != "") {
    echo "<div id='sharee_websites' class='sharee_element_categories'>$personalwebsites</div>";
    $posted_info = 1;
}
if ($onlineusernames != "") {
    echo "<div id='sharee_usernames' class='sharee_element_categories'>$onlineusernames</div>";
    $posted_info = 1;
}
if ($otherinfo != "") {
    echo "<div id='sharee_otherinfo' class='sharee_element_categories'>$otherinfo</div>";
    $posted_info = 1;
}
if ($posted_info == 0) {
    $genderobject = "him";
    if ($gender == "Male") {
        $genderobject = "him";
    } else if ($gender == "Female") {
        $genderobject = "her";
    }
    $nothingshared = "
<div class='nothing_shared'>
    <div style='margin-top: 10px;'>$fn $ln has not shared any information with you. You can request for $genderobject to share info with you.</div>
    <div id='req_email' class='req_element' style='display: block;'>
        <input type='checkbox' id='req_email_checkbox' class='req_info_checkbox' name='req_email_checkbox'>
        <label for='req_email_checkbox' id='request_email_label' class='req_info_label'>Email</label>
    </div>
    <div id='req_phone' class='req_element' style='display: block;'>
        <input type='checkbox' id='req_phone_checkbox' class='req_info_checkbox' name='req_phone_checkbox'>
        <label for='req_phone_checkbox' id='request_phone_label' class='req_info_label'>Phone</label>
    </div>
    <div id='req_address' class='req_element' style='display: block;'>
        <input type='checkbox' id='req_address_checkbox' class='req_info_checkbox' name='req_address_checkbox'>
        <label for='req_address_checkbox' id='request_address_label' class='req_info_label'>Address</label>
    </div>
    <div id='requeststatus' class='requeststatus'></div>
    <div class='option_btns'>
        <button id='request_info_btn' class='request_info_btn' onclick='request_info()'>Request Info</button>
    </div>
</div>";
    echo $nothingshared;
}
//echo "<ul id='original_info' style='display: none;'>".$orig."</ul>";
?>