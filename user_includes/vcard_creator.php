<?php
include_once("../php_includes/home.php");
include_once("../php_includes/check_login_status.php");

$sql = "SELECT sharer FROM table_friends WHERE sharee='$log_id' AND accepted='1'";
$query = mysqli_query($db_conx, $sql);
$num = mysqli_num_rows($query);
$contactIDs = [];
$contacts = [];
while ($row = mysqli_fetch_assoc($query)) {
    $contactIDs[] = $row['sharer'];
}
foreach ($contactIDs as $key => $val) {
    $temp_arr = [];
    $firstandlast = "";
    $sql = "SELECT firstname, lastname FROM table_userinfo WHERE id='$val' AND activated='1' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    while ($row = mysqli_fetch_assoc($query)) {
        $temp_arr['id'] = $val;
        $temp_arr['name'] = $row['firstname']." ".$row['lastname'];
    }
    $firstandlast = $temp_arr['name'];
    $contacts[] = $temp_arr;
}
function array_sort($array, $on, $order=SORT_ASC) {
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
            asort($sortable_array);
            break;
            case SORT_DESC:
            arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[] = $array[$k];//to keep array keys within the master array, make it "$new_array[$k]"
        }
    }

    return $new_array;
}
$contacts = array_sort($contacts, 'name', SORT_ASC);
//print_r($contacts);
$contactsLength = count($contacts);
//echo $contactsLength;
//echo $contacts[1]['name'];

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
function labelType ($type, $label) {
    if ($type == "phone") {
        if (strtoupper($label) == "CELL" || strtoupper($label) == "MOBILE" || strtoupper($label) == "HOME" || strtoupper($label) == "WORK" || strtoupper($label) == "FAX" || strtoupper($label) == "PAGER") {
            return "reg";
        } else {
            return "dif";
        }
    } else if ($type == "email") {
        if (strtoupper($label) == "WORK" || strtoupper($label) == "HOME") {
            return "reg";
        } else {
            return "dif";
        }
    } else if ($type == "address") {
        if (strtoupper($label) == "WORK" || strtoupper($label) == "HOME") {
            return "reg";
        } else {
            return "dif";
        }
    } else if ($type == "website") {
        if (strtoupper($label) == "WORK" || strtoupper($label) == "HOME") {
            return "reg";
        } else {
            return "dif";
        }
    } else {
        return "dif";
    }
}
function labeler($type, $label) {
    if ($type == "phone") {
        if (strtoupper($label) == "CELL" || strtoupper($label) == "MOBILE") {
            return "CELL";
        } else if (strtoupper($label) == "HOME") {
            return strtoupper($label);
        }
    } else if ($type == "email") {
        if (strtoupper($label) == "WORK" || strtoupper($label) == "HOME") {
            return strtoupper($label);
        }
    } else if ($type == "address") {
        if (strtoupper($label) == "WORK" || strtoupper($label) == "HOME") {
            return strtoupper($label);
        }
    } else if ($type == "website") {
        if (strtoupper($label) == "WORK" || strtoupper($label) == "HOME") {
            return strtoupper($label);
        }
    } else {
        return $label;
    }
}

$vcard = "";
foreach ($contacts as $key => $val) {
    $sharee_arr = [];
    $profile = $val['id'];
    $sql = "SELECT * FROM table_friends WHERE sharer=".$profile." AND sharee='$log_id' AND accepted='1' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    if (mysqli_num_rows($query) == 1) {
        $sharee_arr = mysqli_fetch_assoc($query);
    } else if (mysqli_num_rows($query) < 1) {
        //$sharee_arr = $users_arr;
        echo "There was a problem creating the vCard file.";
        exit;
    }

    //print_r($sharee_arr);
    //exit;

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

    $name = "";
    $emailaddresses = "";
    $phonenumbers = "";
    $personalwebsites = "";
    $mailingaddresses = "";
    $onlineusernames = "";
    $otherinfo = "";
    $orig = "";

    $count = 1;

    $name .= "FN:".$val['name']."\n";
    $name .= "N:".getInfo('lastname', $profile, $db_conx).";".getInfo('firstname', $profile, $db_conx).";;;\n";
    //$name .= "N:".getInfo('lastname', $profile, $db_conx).";".getInfo('firstname', $profile, $db_conx).";".getInfo('middlename', $profile, $db_conx).";".getInfo('prefix', $profile, $db_conx).";".getInfo('suffix', $profile, $db_conx)."\n";

    foreach ($sharee_arr as $key => $val) {
        if ((substr($key, 0, 2) == "em" || substr($key, 0, 2) == "ph" || substr($key, 0, 3) == "web" || substr($key, 0, 2) == "ad" || substr($key, 0, 3) == "oun" || $key == "brth") && substr($key, -3) != "lbl") {
            if (substr($key, 0, 2) == "em") {
                if ($val == "1") {
                    if (labelType("email", getLabel($key, $profile, $db_conx)) == "reg") {
                        $emailaddresses .= "EMAIL;TYPE=INTERNET;TYPE=".labeler('email', getLabel($key, $profile, $db_conx)).":".getInfo($key, $profile, $db_conx)."\n";
                    } else if (labelType("email", getLabel($key, $profile, $db_conx)) == "dif") {
                        $emailaddresses .= "item".$count.".EMAIL:".getInfo($key, $profile, $db_conx)."\n";
                        $emailaddresses .= "item".$count.".X-ABLabel:".getLabel($key, $profile, $db_conx)."\n";
                        $count++;
                    }
                }
            } else if (substr($key, 0, 2) == "ph") {
                if ($val == "1") {
                    if (labelType("phone", getLabel($key, $profile, $db_conx)) == "reg") {
                        $phonenumbers .= "TEL;TYPE=".getLabel($key, $profile, $db_conx).":".getInfo($key, $profile, $db_conx)."\n";
                    } else if (labelType("phone", getLabel($key, $profile, $db_conx)) == "dif") {
                        $phonenumbers .= "item".$count.".TEL:".getInfo($key, $profile, $db_conx)."\n";
                        $phonenumbers .= "item".$count.".X-ABLabel:".getLabel($key, $profile, $db_conx)."\n";
                        $count++;
                    }
                }
            } else if (substr($key, 0, 3) == "web") {
                if ($val == "1") {
                    if (labelType("website", getLabel($key, $profile, $db_conx)) == "reg") {
                        $personalwebsites .= "URL;TYPE=".getLabel($key, $profile, $db_conx).":".getInfo($key, $profile, $db_conx)."\n";
                    } else if (labelType("website", getLabel($key, $profile, $db_conx)) == "dif") {
                        $personalwebsites .= "item".$count.".URL:".getInfo($key, $profile, $db_conx)."\n";
                        $personalwebsites .= "item".$count.".X-ABLabel:".getLabel($key, $profile, $db_conx)."\n";
                        $count++;
                    }
                }
            } else if (substr($key, 0, 2) == "ad") {
                if ($val == "1") {
                    if (labelType("address", getLabel($key, $profile, $db_conx)) == "reg") {
                        $mailingaddresses .= "ADR;TYPE=".getLabel($key, $profile, $db_conx).":".getInfo($key, $profile, $db_conx)."\n";
                    } else if (labelType("address", getLabel($key, $profile, $db_conx)) == "dif") {
                        $mailingaddresses .= "item".$count.".ADR:".getInfo($key, $profile, $db_conx)."\n";
                        $mailingaddresses .= "item".$count.".X-ABLabel:".getLabel($key, $profile, $db_conx)."\n";
                        $count++;
                    }
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

    $s_vcard = "BEGIN:VCARD\nVERSION:3.0\n".$name.$emailaddresses.$phonenumbers.$personalwebsites.$mailingaddresses."END:VCARD\n";
    $vcard .= $s_vcard;
}

$myfile = fopen("../user/".$log_id."/contacts.vcf", "w") or die("Unable to create file.");
$vcard_html = preg_replace("#\n#", "<br />", $vcard);
//echo $vcard_html;

fwrite($myfile, $vcard);
fclose($myfile);

//echo "<br />vCard created successfully!"

?>