<?php
$arr = [
    "em1" => "",
    "em2" => "",
    "em3" => "",
    "em4" => "",
    "em5" => "",
    "em6" => "",
    "em7" => "",
    "em8" => "",
    "em9" => "",
    "em10" => "",
    "ph1" => "",
    "ph2" => "",
    "ph3" => "",
    "ph4" => "",
    "ph5" => "",
    "ph6" => "",
    "ph7" => "",
    "ph8" => "",
    "ph9" => "",
    "ph10" => "",
    "ad1" => "",
    "ad2" => "",
    "ad3" => "",
    "ad4" => "",
    "ad5" => "",
    "web1" => "",
    "web2" => "",
    "web3" => "",
    "web4" => "",
    "web5" => "",
    "oun_facebook" => "",
    "oun_linkedin" => "",
    "oun_twitter" => "",
    "oun_skype" => "",
    "brth" => ""
];
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
    "ad1" => "Home",
    "ad2" => "Work",
    "ad3" => "Address 3",
    "ad4" => "Address 4",
    "ad5" => "Address 5",
    "web1" => "Website 1",
    "web2" => "Website 2",
    "web3" => "Website 3",
    "web4" => "Website 4",
    "web5" => "Website 5",
    "oun_facebook" => "Facebook",
    "oun_linkedin" => "LinkedIn",
    "oun_twitter" => "Twitter",
    "oun_skype" => "Skype",
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
$mailingaddresses = "";
$personalwebsites = "";
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
foreach ($arr as $key => $val) {
    if ((substr($key, 0, 2) == "em" || substr($key, 0, 2) == "ph" || substr($key, 0, 3) == "web" || substr($key, 0, 2) == "ad" || substr($key, 0, 3) == "oun" || $key == "brth") && substr($key, -3) != "lbl" && $key != "email") {
        if (substr($key, 0, 2) == "em") {
            if ($val != "") {
                $emailaddresses .= "
<div id='".$key."_container' class='contact_element' style='display: block;'>
<div class='label_container'>
<input id='".$key."_lbl' class='secondary input_label' type='text' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' maxlength='255' value='".lblTest($master, $arr, $key)."'>
</div>
<input id=".$key." class='newcon_inputtext newcon_input' type='email' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' onkeypress='expand_input(this.id)' onkeyup='expand_input(this.id)' onkeydown='expand_input(this.id)' maxlength='255' value='$val'>
<span id='".$key."_clear' class='field_clear' onclick='clear_field(this.id)'>&times</span>
</div>";
            } else if ($key != "em10") {
                $emailaddresses .= "
<div id='".$key."_container' class='contact_element' style='display: none;'>
<div class='label_container'>
<input id='".$key."_lbl' class='secondary input_label' type='text' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' maxlength='255' value='".keyTest($master, $key)."'>
</div>
<input id=".$key." class='newcon_inputtext newcon_input' type='email' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' onkeypress='expand_input(this.id)' onkeyup='expand_input(this.id)' onkeydown='expand_input(this.id)' maxlength='255' value='$val'>
<span id='".$key."_clear' class='field_clear' onclick='clear_field(this.id)'>&times</span>
</div>";
            } else if ($key == "em10") {
                $emailaddresses .= "
<div id='".$key."_container' class='contact_element' style='display: none;'>
<div class='label_container'>
<input id='".$key."_lbl' class='secondary input_label' type='text' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' maxlength='255' value='".keyTest($master, $key)."'>
</div>
<input id=".$key." class='newcon_inputtext newcon_input' type='email' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' onkeydown='expand_input(this.id)' maxlength='255' value='$val'>
<span id='".$key."_clear' class='field_clear' onclick='clear_field(this.id)'>&times</span>
</div>";
                $emailaddresses .= "
                <button id='add_email' class='add_email add_info' onclick='add_em()'>Add Email</button>";
            }
        } else if (substr($key, 0, 2) == "ph") {
            if ($val != "") {
                $phonenumbers .= "
<div id='".$key."_container' class='contact_element' style='display: block;'>
<div class='label_container'>
<input id='".$key."_lbl' class='secondary input_label' type='text' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' maxlength='255' value='".lblTest($master, $arr, $key)."'>
</div>
<input id=".$key." class='newcon_inputtext newcon_input' type='tel' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' onkeydown='expand_input(this.id)' maxlength='30' value='$val'>
<span id='".$key."_clear' class='field_clear' onclick='clear_field(this.id)'>&times</span>
</div>";
            } else if ($key != "ph10") {
                $phonenumbers .= "
<div id='".$key."_container' class='contact_element' style='display: none;'>
<div class='label_container'>
<input id='".$key."_lbl' class='secondary input_label' type='text' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' maxlength='255' value='".keyTest($master, $key)."'>
</div>
<input id=".$key." class='newcon_inputtext newcon_input' type='tel' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' onkeydown='expand_input(this.id)' maxlength='30' value='$val'>
<span id='".$key."_clear' class='field_clear' onclick='clear_field(this.id)'>&times</span>
</div>";
            } else if ($key == "ph10") {
                $phonenumbers .= "
<div id='".$key."_container' class='contact_element' style='display: none;'>
<div class='label_container'>
<input id='".$key."_lbl' class='secondary input_label' type='text' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' maxlength='255' value='".keyTest($master, $key)."'>
</div>
<input id=".$key." class='newcon_inputtext newcon_input' type='tel' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' onkeydown='expand_input(this.id)' maxlength='30' value='$val'>
<span id='".$key."_clear' class='field_clear' onclick='clear_field(this.id)'>&times</span>
</div>";
                $phonenumbers .= "
                <button id='add_phone' class='add_phone add_info' onclick='add_ph()'>Add Phone</button>";
            }
        } else if (substr($key, 0, 2) == "ad") {
            if ($val != "") {
                $mailingaddresses .= "
<div id='".$key."_container' class='contact_element' style='display: block;'>
<div class='label_container address'>
<input id='".$key."_lbl' class='secondary input_label' type='text' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' maxlength='255' value='".lblTest($master, $arr, $key)."'>
</div>
<textarea id=".$key." class='newcon_inputtext newcon_input large_box' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' maxlength='255' rows='4'>$val</textarea>
<span id='".$key."_clear' class='field_clear address' onclick='clear_field(this.id)'>&times</span>
</div>";
            } else if ($key != "ad5") {
                $mailingaddresses .= "
<div id='".$key."_container' class='contact_element' style='display: none;'>
<div class='label_container address'>
<input id='".$key."_lbl' class='secondary input_label' type='text' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' maxlength='255' value='".keyTest($master, $key)."'>
</div>
<textarea id=".$key." class='newcon_inputtext newcon_input large_box' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' maxlength='255' rows='4'>$val</textarea>
<div id='".$key."_clear' class='field_clear address' onclick='clear_field(this.id)'>&times</div>
</div>";
            }  else if ($key == "ad5") {
                $mailingaddresses .= "
<div id='".$key."_container' class='contact_element' style='display: none;'>
<div class='label_container address'>
<input id='".$key."_lbl' class='secondary input_label' type='text' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' maxlength='255' value='".keyTest($master, $key)."'>
</div>
<textarea id=".$key." class='newcon_inputtext newcon_input large_box' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' maxlength='255' rows='4'>$val</textarea>
<span id='".$key."_clear' class='field_clear address' onclick='clear_field(this.id)'>&times</span>
</div>";
                $mailingaddresses .= "
            <button id='add_address' class='add_address add_info' onclick='add_ad()'>Add Address</button>";
            }
        } else if (substr($key, 0, 3) == "web") {
            if ($val != "") {
                $personalwebsites .= "
<div id='".$key."_container' class='contact_element' style='display: block;'>
<div class='label_container'>
<input id='".$key."_lbl' class='secondary input_label' type='text' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' maxlength='255' value='".lblTest($master, $arr, $key)."'>
</div>
<input id=".$key." class='newcon_inputtext newcon_input' type='url' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' onkeydown='expand_input(this.id)' maxlength='255' value='$val'>
<span id='".$key."_clear' class='field_clear' onclick='clear_field(this.id)'>&times</span>
</div>";
            } else if ($key != "web5") {
                $personalwebsites .= "
<div id='".$key."_container' class='contact_element' style='display: none;'>
<div class='label_container'>
<input id='".$key."_lbl' class='secondary input_label' type='text' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' maxlength='255' value='".keyTest($master, $key)."'>
</div>
<input id=".$key." class='newcon_inputtext newcon_input' type='url' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' onkeydown='expand_input(this.id)' maxlength='255' value='$val'>
<span id='".$key."_clear' class='field_clear' onclick='clear_field(this.id)'>&times</span>
</div>";
            } else if ($key == "web5") {
                $personalwebsites .= "
<div id='".$key."_container' class='contact_element' style='display: none;'>
<div class='label_container'>
<input id='".$key."_lbl' class='secondary input_label' type='text' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' maxlength='255' value='".keyTest($master, $key)."'>
</div>
<input id=".$key." class='newcon_inputtext newcon_input' type='url' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' onkeydown='expand_input(this.id)' maxlength='255' value='$val'>
<span id='".$key."_clear' class='field_clear' onclick='clear_field(this.id)'>&times</span>
</div>";
                $personalwebsites .= "
                <button id='add_website' class='add_website add_info' onclick='add_web()'>Add Website</button>";
            }
        } else if (substr($key, 0, 3) == "oun") {
            if ($val != "") {
                $onlineusernames .= "
<div id='".$key."_container' class='contact_element' style='display: block;'>
<div class='label_container'>
<input id='".$key."_lbl' class='secondary input_label' type='text' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' maxlength='255' value='".keyTest($master, $key)."'>
</div>
<input id=".$key." class='newcon_inputtext newcon_input' type='text' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' onkeydown='expand_input(this.id)' maxlength='30' value='$val'>
<span id='".$key."_clear' class='field_clear' onclick='clear_field(this.id)'>&times</span>
</div>";
            } else if ($key == "oun_facebook") {
                $onlineusernames .= "
<div id='".$key."_container' class='contact_element' style='display: none;'>
<div class='label_container'>
<input id='".$key."_lbl' class='secondary input_label' type='text' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' maxlength='255' value='".keyTest($master, $key)."'>
</div>
<input id=".$key." class='newcon_inputtext newcon_input' type='text' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' onkeydown='expand_input(this.id)' maxlength='30' value='$val'>
<span id='".$key."_clear' class='field_clear' onclick='clear_field(this.id)'>&times</span>
</div>";
                $onlineusernames .= "
                <button id='add_facebook' class='add_facebook add_info' onclick='add_fb()'>Add Facebook Username</button>";
            } else if ($key == "oun_linkedin") {
                $onlineusernames .= "
<div id='".$key."_container' class='contact_element' style='display: none;'>
<div class='label_container'>
<input id='".$key."_lbl' class='secondary input_label' type='text' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' maxlength='255' value='".keyTest($master, $key)."'>
</div>
<input id=".$key." class='newcon_inputtext newcon_input' type='text' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' onkeydown='expand_input(this.id)' maxlength='30' value='$val'>
<span id='".$key."_clear' class='field_clear' onclick='clear_field(this.id)'>&times</span>
</div>";
                $onlineusernames .= "
                <button id='add_linkedin' class='add_linkedin add_info' onclick='add_lnkd()'>Add LinkedIn Username</button>";
            } else if ($key == "oun_twitter") {
                $onlineusernames .= "
<div id='".$key."_container' class='contact_element' style='display: none;'>
<div class='label_container'>
<input id='".$key."_lbl' class='secondary input_label' type='text' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' maxlength='255' value='".keyTest($master, $key)."'>
</div>
<input id=".$key." class='newcon_inputtext newcon_input' type='text' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' onkeydown='expand_input(this.id)' maxlength='30' value='$val'>
<span id='".$key."_clear' class='field_clear' onclick='clear_field(this.id)'>&times</span>
</div>";
                $onlineusernames .= "
                <button id='add_twitter' class='add_twitter add_info' onclick='add_twtr()'>Add Twitter Username</button>";
            } else if ($key == "oun_skype") {
                $onlineusernames .= "
<div id='".$key."_container' class='contact_element' style='display: none;'>
<div class='label_container'>
<input id='".$key."_lbl' class='secondary input_label' type='text' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' maxlength='255' value='".keyTest($master, $key)."'>
</div>
<input id=".$key." class='newcon_inputtext newcon_input' type='text' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' onkeydown='expand_input(this.id)' maxlength='30' value='$val'>
<span id='".$key."_clear' class='field_clear' onclick='clear_field(this.id)'>&times</span>
</div>";
                $onlineusernames .= "
                <button id='add_skype' class='add_skype add_info' onclick='add_skp()'>Add Skype Username</button>";
            }
        } else {
            $otherinfo .= "
<div id='".$key."_container' class='contact_element' style='display: none;'>
<div class='label_container'>
<input id='".$key."_lbl' class='secondary input_label' type='text' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' maxlength='255' value='".keyTest($master, $key)."'>
</div>
<input id=".$key." class='newcon_inputtext newcon_input' type='text' onblur='restrict(this.id)' onfocus='hideElements(\"changestatus\")' onkeydown='expand_input(this.id)' maxlength='30' value='$val'>
<span id='".$key."_clear' class='field_clear' onclick='clear_field(this.id)'>&times</span>
</div>";
            $otherinfo .= "
                <button id='add_birthday' class='add_birthday add_info' onclick='add_brth()'>Add Birthday</button>";
        }
        ${'log_'.$key} = $val;
        $orig .= "<li id='log_$key'>".${'log_'.$key}."</li>";
    }
}

echo $emailaddresses;
echo "<div class='line2'></div>";
echo $phonenumbers;
echo "<div class='line2'></div>";
echo $mailingaddresses;
echo "<div class='line2'></div>";
echo $personalwebsites;
echo "<div class='line2'></div>";
echo $onlineusernames;
echo $otherinfo;
//echo "<ul id='original_info' style='display: none;'>".$orig."</ul>";
?>