<?php
$db_conx = mysqli_connect("localhost", "onecardx_maker", "hellO1", "onecardx_social");
//                          hostname        user        pass        database
// Evaluate the connection
if (mysqli_connect_errno()) {
    echo mysqli_connect_error();
    exit();
}
?>