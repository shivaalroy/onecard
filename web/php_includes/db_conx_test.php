<?php
$db_conx = mysqli_connect("localhost", "onecardx_maker", "hellO1", "onecardx_social");
// Evaluate the connection
if (mysqli_connect_errno()) {
    echo mysqli_connect_error();
    exit();
} else {
	echo "Successful database connection, happy coding!!!";
}
?>