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
function keyTest($array, $keyvalue) {
    if ($array[$keyvalue] != "") {
        return $array[$keyvalue];
    } else {
        return $keyvalue;
    }
}
function lblTest($presetlabels, $userlabels, $keyvalue) {
    $label = $keyvalue."_lbl";
    if ($userlabels[$label] != "") {
        return $userlabels[$label];
    } else {
        return $presetlabels[$kevalue];
    }
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
foreach ($users_arr as $key => $val) {
    if ((substr($key, 0, 2) == "em" || substr($key, 0, 2) == "ph" || substr($key, 0, 3) == "web" || substr($key, 0, 2) == "ad" || substr($key, 0, 3) == "oun" || $key == "brth") && substr($key, -3) != "lbl") {
        if (substr($key, 0, 2) == "em") {
            if ($val != "") {
                $emailaddresses .= "
<div id='".$key."_container' class=\"sharer_element\" style=\"display: block;\">
    <input type=\"checkbox\" id='".$key."' class=\"share_info_checkbox\" name='".$key."' onchange='highlight(this.id)'>
    <label for='".$key."' id='".$key."_label' class=\"share_info_text\">
            <div id='".$key."_lbl' class=\"sharer_label\">".lblTest($master, $users_arr, $key)."</div>
            <div id='".$key."_info' class=\"sharer_item\">$val</div>
    </label>
</div>";
            }
        } else if (substr($key, 0, 2) == "ph") {
            if ($val != "") {
                $phonenumbers .= "
<div id='".$key."_container' class=\"sharer_element\" style=\"display: block;\">
    <input type=\"checkbox\" id='".$key."' class=\"share_info_checkbox\" name='".$key."' onchange='highlight(this.id)'>
    <label for='".$key."' id='".$key."_label' class=\"share_info_text\">
        <div id='".$key."_lbl' class=\"sharer_label\">".lblTest($master, $users_arr, $key)."</div>
        <div id='".$key."_info' class=\"sharer_item\">$val</div>
    </label>
</div>";
            }
        } else if (substr($key, 0, 2) == "ad") {
            if ($val != "") {
                $mailingaddresses .= "
<div id='".$key."_container' class=\"sharer_element\" style=\"display: block;\">
    <input type=\"checkbox\" id='".$key."' class=\"share_info_checkbox\" name='".$key."' onchange='highlight(this.id)'>
    <label for='".$key."' id='".$key."_label' class=\"share_info_text\">
        <div id='".$key."_lbl' class=\"sharer_label\">".lblTest($master, $users_arr, $key)."</div>
        <div id='".$key."_info' class=\"sharer_item\">".addressFormatted($val)."</div>
    </label>
</div>";
            }
        } else if (substr($key, 0, 3) == "web") {
            if ($val != "") {
                $personalwebsites .= "
<div id='".$key."_container' class=\"sharer_element\" style=\"display: block;\">
    <input type=\"checkbox\" id='".$key."' class=\"share_info_checkbox\" name='".$key."' onchange='highlight(this.id)'>
    <label for='".$key."' id='".$key."_label' class=\"share_info_text\">
        <div id='".$key."_lbl' class=\"sharer_label\">".lblTest($master, $users_arr, $key)."</div>
        <div id='".$key."_info' class=\"sharer_item\">$val</div>
    </label>
</div>";
            }
        } else if (substr($key, 0, 3) == "oun") {
            if ($val != "") {
                $onlineusernames .= "
<div id='".$key."_container' class=\"sharer_element\" style=\"display: block;\">
    <input type=\"checkbox\" id='".$key."' class=\"share_info_checkbox\" name='".$key."' onchange='highlight(this.id)'>
    <label for='".$key."' id='".$key."_label' class=\"share_info_text\">
        <div id='".$key."_lbl' class=\"sharer_label\">".lblTest($master, $users_arr, $key)."</div>
        <div id='".$key."_info' class=\"sharer_item\">$val</div>
    </label>
</div>";
            }
        } else {
            $otherinfo .= "
<div id='".$key."_container' class=\"sharer_element\" style=\"display: block;\">
    <input type=\"checkbox\" id='".$key."' class=\"share_info_checkbox\" name='".$key."' onchange='highlight(this.id)'>
    <label for='".$key."' id='".$key."_label' class=\"share_info_text\">
        <div id='".$key."_lbl' class=\"sharer_label\">".lblTest($master, $users_arr, $key)."</div>
        <div id='".$key."_info' class=\"sharer_item\">$val</div>
    </label>
</div>";
        }
        ${'log_'.$key} = $val;
        $orig .= "<li id=\"log_$key\">".${'log_'.$key}."</li>";
    }
}
$posted_info = 0;
if ($emailaddresses != "") {
    echo "<div id='emails' class='element_categories'>$emailaddresses</div>";
    $posted_info = 1;
}
if ($phonenumbers != "") {
    echo "<div id='phones' class='element_categories'>$phonenumbers</div>";
    $posted_info = 1;
}
if ($mailingaddresses != "") {
    echo "<div id='addresses' class='element_categories'>$mailingaddresses</div>";
    $posted_info = 1;
}
if ($personalwebsites != "") {
    echo "<div id='websites' class='element_categories'>$personalwebsites</div>";
    $posted_info = 1;
}
if ($onlineusernames != "") {
    echo "<div id='usernames' class='element_categories'>$onlineusernames</div>";
    $posted_info = 1;
}
if ($otherinfo != "") {
    echo "<div id='otherinfo' class='element_categories'>$otherinfo</div>";
    $posted_info = 1;
}
if ($posted_info == 0) {
    echo "<p style='margin: 5px 0px;'>You have no information to share. <a href='".$url."myinfo.php' style='text-decoration: none; color: blue;'>Click here</a> or click on your name in the header bar to add and edit your contact info.</p>";
}
//echo "<ul id='original_info' style='display: none;'>".$orig."</ul>";
?>