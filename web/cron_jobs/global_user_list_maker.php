<?php
require_once("../php_includes/home.php");
require_once("../php_includes/db_conx.php");
$xml = new SimpleXMLElement('<xml/>');
$sql = "SELECT MAX(id) FROM table_userinfo";
$query = mysqli_query($db_conx, $sql);
$row = mysqli_fetch_row($query);
$max_id = $row[0];
for ($id = 1; $id <= $max_id; $id++) {
    $sql = "SELECT firstname, lastname, city, country, gender, avatar1 FROM table_userinfo WHERE id='$id' AND activated='1' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $numrows = mysqli_num_rows($query);
    if($numrows > 0){
        $row = mysqli_fetch_row($query);
        $fn = $row[0];
        $ln = $row[1];
        $city = $row[2];
        $country = $row[3];
        $gender = strtolower($row[4]);
        $avatar = $row[5];
        if ($city == "") {
            $location = $country;
        } else {
            $location = $city.", ".$country;
        }
        if($avatar == NULL){
            $avatarsrc = 'img/defaultavatar-'.$gender.'.jpg';
        } else {
            $avatarsrc = 'user/'.$id.'/'.$avatar;
        }
        $listelement = "
<li class='live_result_list_itm'>
    <a class='user_search_summary' href='".$url."?id=".$id."'>
        <img src='$url$avatarsrc' class='user_search_avatar'>
        <div class='user_search_info'>
            <div class='user_search_name'>".$fn." ".$ln."</div>
            <div class='user_search_location'>".$location."</div>
        </div>
    </a>
</li>";
        $user = $xml->addChild('link');
        $user->addChild('firstname', $fn);
        $user->addChild('lastname', $ln);
        $user->addChild('location', $location);
        $user->addChild('url', $url."?id=".$id);
        $user->addChild('avatarsrc', $avatarsrc);
        $user->addChild('listelement', $listelement);
    }
}

Header('Content-type: text/xml');
print($xml->asXML());
$fp = @fopen('../user_includes/global_user_list.xml', 'w');
if(!$fp) {
    die('Error cannot create XML file');
}
fwrite($fp, $xml->asXML());
fclose($fp);
?>