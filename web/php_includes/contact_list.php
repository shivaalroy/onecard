<?php
//THIS CODE LOADS THE USER'S CONTACT LIST (ONLY SHARED CONTACTS RIGHT NOW)
include_once("php_includes/home.php");
include_once("php_includes/check_login_status.php");
$sql = "SELECT sharer FROM table_friends WHERE sharee='$log_id' AND accepted='1'";
$query = mysqli_query($db_conx, $sql);
$num = mysqli_num_rows($query);
$contacts = [];
while ($cIDs = mysqli_fetch_assoc($query)) {
    $contactID = $cIDs['sharer'];
    $temp_arr = [];
    $name = "";
    $sql = "SELECT firstname, lastname FROM table_userinfo WHERE id='$contactID' AND activated='1' LIMIT 1";
    $contactinfoquery = mysqli_query($db_conx, $sql);
    while ($contactinfo = mysqli_fetch_assoc($contactinfoquery)) {
        $temp_arr['id'] = $contactID;
        $temp_arr['fname'] = $contactinfo['firstname']." ".$contactinfo['lastname'];
        $temp_arr['lname'] = $contactinfo['lastname']." ".$contactinfo['firstname'];
        $temp_arr['fname,name'] = "<strong>".$contactinfo['firstname']."</strong> ".$contactinfo['lastname'];
        $temp_arr['fname,revname'] = $contactinfo['lastname']." <strong>".$contactinfo['firstname']."</strong>";
        $temp_arr['lname,name'] = $contactinfo['lastname']." <strong>".$contactinfo['firstname']."</strong>";
        $temp_arr['lname,revname'] = "<strong>".$contactinfo['lastname']."</strong> ".$contactinfo['firstname'];
    }
    //$name = $temp_arr['fname,name'];
    $contacts[] = $temp_arr;
}

$sql = "SELECT sort_order, disp_order FROM table_useroptions WHERE id='$log_id' LIMIT 1";
$query = mysqli_query($db_conx, $sql);
$row = mysqli_fetch_assoc($query);
$sortcriterion = $row['sort_order'];
$displaycriterion = $row['disp_order'];

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
$contacts = array_sort($contacts, $sortcriterion, SORT_ASC);
//print_r($contacts);
$contactsLength = count($contacts);
//echo $contactsLength;
//echo $contacts[1]['name'];
$contactHTMLList = "";
foreach ($contacts as $key => $val) {
    $contactHTMLList .= "
    <li>
    <a href='".$url."?id=".$val['id']."'>".$val[$sortcriterion.",".$displaycriterion]."</a>
    </li>";
}
?>