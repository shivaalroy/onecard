<?php
include_once("includes/home.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Display Tables</title>
        <link rel="icon" href="/img/favicon.ico" type="image/x-icon">
        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
                table-layout: fixed;
                width: auto;
                white-space: pre;
                text-align: left;
                padding: 3px;
                margin: 5px 0px 20px 5px;
            }
            th {
                color: #ffffff;
                background-color: #555555;
                border: 1px solid #000;
                text-align: center;
            }
            table tr:nth-child(even) {
                background-color: #ffffff;
            }
            table tr:nth-child(odd) {
                background-color: #f1f1f1;
            }
            td{
                padding: 0px 10px;
            }
        </style>
    </head>
    <body>
        <?php
include_once("includes/db_conx.php");

$sql = "SELECT MAX(id) FROM table_users";
$query = mysqli_query($db_conx, $sql);
$row = mysqli_fetch_row($query);
$num = $row[0];

$sql2 = "SELECT * FROM table_users WHERE id='1' LIMIT 1";
$query2 = mysqli_query($db_conx, $sql2);
$arr = mysqli_fetch_assoc($query2);
$header = "";
$data = "";
echo "<table border='1'>";
foreach ($arr as $key => $val) {
    $header .= "<th>".$key."</th>";
}
echo "<tr>$header</tr>";
for ($i = 1; $i <= $num; $i++) {
    $sql3 = "SELECT * FROM table_users WHERE id='$i' LIMIT 1";
    $query3 = mysqli_query($db_conx, $sql3);
    if (mysqli_num_rows($query3) == 0) {
        continue;
    }
    $arr = mysqli_fetch_assoc($query3);
    $data = "";
    foreach ($arr as $key => $val) {
        $data .= "<td>".$val."</td>";
    }
    echo "<tr>".$data."</tr>";
}
echo "</table>";

$sql = "SELECT MAX(id) FROM table_userinfo";
$query = mysqli_query($db_conx, $sql);
$row = mysqli_fetch_row($query);
$num = $row[0];

$sql2 = "SELECT * FROM table_userinfo WHERE id='1' LIMIT 1";
$query2 = mysqli_query($db_conx, $sql2);
$arr = mysqli_fetch_assoc($query2);
$header = "";
$data = "";
echo "<table border='1'>";
foreach ($arr as $key => $val) {
    $header .= "<th>".$key."</th>";
}
echo "<tr>$header</tr>";
for ($i = 1; $i <= $num; $i++) {
    $sql3 = "SELECT * FROM table_userinfo WHERE id='$i' LIMIT 1";
    $query3 = mysqli_query($db_conx, $sql3);
    if (mysqli_num_rows($query3) == 0) {
        continue;
    }
    $arr = mysqli_fetch_assoc($query3);
    $data = "";
    foreach ($arr as $key => $val) {
        $data .= "<td>".$val."</td>";
    }
    echo "<tr>".$data."</tr>";
}
echo "</table>";

$sql = "SELECT MAX(id) FROM table_useroptions";
$query = mysqli_query($db_conx, $sql);
$row = mysqli_fetch_row($query);
$num = $row[0];

$sql2 = "SELECT * FROM table_useroptions WHERE id='1' LIMIT 1";
$query2 = mysqli_query($db_conx, $sql2);
$arr = mysqli_fetch_assoc($query2);
$header = "";
$data = "";
echo "<table border='1'>";
foreach ($arr as $key => $val) {
    $header .= "<th>".$key."</th>";
}
echo "<tr>$header</tr>";
for ($i = 1; $i <= $num; $i++) {
    $sql3 = "SELECT * FROM table_useroptions WHERE id='$i' LIMIT 1";
    $query3 = mysqli_query($db_conx, $sql3);
    if (mysqli_num_rows($query3) == 0) {
        continue;
    }
    $arr = mysqli_fetch_assoc($query3);
    $data = "";
    foreach ($arr as $key => $val) {
        $data .= "<td>".$val."</td>";
    }
    echo "<tr>".$data."</tr>";
}
echo "</table>";

$sql = "SELECT MAX(id) FROM table_friends";
$query = mysqli_query($db_conx, $sql);
$row = mysqli_fetch_row($query);
$num = $row[0];

$sql2 = "SELECT * FROM table_friends WHERE id='1' LIMIT 1";
$query2 = mysqli_query($db_conx, $sql2);
$arr = mysqli_fetch_assoc($query2);
$header = "";
$data = "";
echo "<table border='1'>";
foreach ($arr as $key => $val) {
    $header .= "<th>".$key."</th>";
}
echo "<tr>$header</tr>";
for ($i = 1; $i <= $num; $i++) {
    $sql3 = "SELECT * FROM table_friends WHERE id='$i' LIMIT 1";
    $query3 = mysqli_query($db_conx, $sql3);
    if (mysqli_num_rows($query3) == 0) {
        continue;
    }
    $arr = mysqli_fetch_assoc($query3);
    $data = "";
    foreach ($arr as $key => $val) {
        $data .= "<td>".$val."</td>";
    }
    echo "<tr>".$data."</tr>";
}
echo "</table>";

$sql = "SELECT MAX(id) FROM table_notifications";
$query = mysqli_query($db_conx, $sql);
$row = mysqli_fetch_row($query);
$num = $row[0];

$sql2 = "SELECT * FROM table_notifications WHERE id='1' LIMIT 1";
$query2 = mysqli_query($db_conx, $sql2);
$arr = mysqli_fetch_assoc($query2);
$header = "";
$data = "";
echo "<table border='1'>";
foreach ($arr as $key => $val) {
    $header .= "<th>".$key."</th>";
}
echo "<tr>$header</tr>";
for ($i = 1; $i <= $num; $i++) {
    $sql3 = "SELECT * FROM table_notifications WHERE id='$i' LIMIT 1";
    $query3 = mysqli_query($db_conx, $sql3);
    if (mysqli_num_rows($query3) == 0) {
        continue;
    }
    $arr = mysqli_fetch_assoc($query3);
    $data = "";
    foreach ($arr as $key => $val) {
        $data .= "<td>".$val."</td>";
    }
    echo "<tr>".$data."</tr>";
}
echo "</table>";
        ?>
    </body>
</html>