<?php
// AJAX CALLS THIS LIVESEARCH CODE TO EXECUTE
if(isset($_POST["oq"])){
    // GATHER THE POSTED OMNIQUERY
    $oq = preg_replace('#[^a-z ]#i', '', $_POST['oq']);
    // LOAD THE GLOBAL XML USER LIST
    $xmlDoc=new DOMDocument();
    $xmlDoc->load("../user_includes/global_user_list.xml");

    $xmllink=$xmlDoc->getElementsByTagName('link');

    // lookup all links from the xml file if length of oq>0
    if (strlen($oq)>0) {
        $hint="";
        function startsWith($str1, $str2) {
            $strlow1 = strtolower($str1);
            $strlow2 = strtolower($str2);
            return $str2 === "" || strpos($strlow1, $strlow2) === 0;
        }
        function listLength($lst) {
            return substr_count($lst, "<li");
        }
        function contList($currentListLength, $maxLength) {
            if ($currentListLength < $maxLength) {// the value $maxLength will be the length of the actual list displayed
                return true;
            } else {
                return false;
            }
        }
        function listElem($firstname, $lastname, $location, $url) {
            $listelement = "
<li class='live_result_list_itm'>
    <a class='user_search_summary' href='".$url."'>
        <div class='user_search_name'>".$firstname." ".$lastname."</div>
        <div class='user_search_location'>".$location."</div>
    </a>
</li>";
            return $listelement;
        }
        for($i=0; $i<($xmllink->length); $i++) {
            $xmlfirstname=$xmllink->item($i)->getElementsByTagName('firstname');
            $xmllastname=$xmllink->item($i)->getElementsByTagName('lastname');
            $xmllistelement=$xmllink->item($i)->getElementsByTagName('listelement');
            if ($xmlfirstname->item(0)->nodeType==1) {
                //find a link matching the search text
                $xmlfirstname2 = $xmlfirstname->item(0)->childNodes->item(0)->nodeValue;
                $xmllastname2 = $xmllastname->item(0)->childNodes->item(0)->nodeValue;
                $xmllistelement2 = $xmllistelement->item(0)->childNodes->item(0)->nodeValue;
                if (startsWith($xmlfirstname2." ".$xmllastname2, $oq)) {
                    if ($hint == "") {
                        $hint = $xmllistelement2;
                    } else if (contList(listLength($hint), 6)) {
                        $hint .= $xmllistelement2;
                    }
                } else if (startsWith($xmllastname2, $oq)) {
                    if ($hint == "") {
                        $hint = $xmllistelement2;
                    } else if (contList(listLength($hint), 6)) {
                        $hint .= $xmllistelement2;
                    }
                } else if (startsWith($xmlfirstname2, $oq)) {
                    if ($hint == "") {
                        $hint = $xmllistelement2;
                    } else if (contList(listLength($hint), 6)) {
                        $hint .= $xmllistelement2;
                    }
                }
            }
        }
    }
    $nul_hint = "<li class='no_users_found'>no users found</li>";
    // Set output to "no suggestion" if no hint were found
    // or to the correct values
    if ($hint == "") {
        $response = $nul_hint;
    } else {
        $response = $hint;
    }

    //output the response
    echo $response;
    exit();
}
?>