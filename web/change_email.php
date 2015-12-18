<?php
if (isset($_GET['id']) && isset($_GET['ref'])) {
    // Connect to database and sanitize incoming $_GET variables
    include_once("includes/db_conx.php");
    $id = preg_replace('#[^0-9]#i', '', $_GET['id']);
    $hashRef = preg_replace('#[^0-9a-z]#i', '', $_GET['ref']);
    // Evaluate the lengths of the incoming $_GET variable
    if($id == "" || strlen($hashRef) != 32){
        // Log this issue into a text file and email details to yourself
        header("location: message.php?msg=activation_string_length_issues");
        exit();
    }
    // Check their credentials against the database
    $sql = "SELECT * FROM table_useroptions WHERE id='$id' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $numrows = mysqli_num_rows($query);
    // Evaluate for a match in the system (0 = no match, 1 = match)
    if($numrows == 0){
        // Log this potential hack attempt to text file and email details to yourself
        header("location: message.php?msg=Your credentials are not matching anything in our system");
        exit();
    } else {
        $array = mysqli_fetch_assoc($query);
        $long_email = $array['temp_email'];
        $long_emailHash = md5($long_email);
        if ($hashRef != $long_emailHash) {
            header("location: message.php?msg=Your credentials are not matching anything in our system");
            exit();
        }
        $new_email = substr($long_email, 0, -3);
    }
    // Match was found, you can change their email, BUT FIRST check whether someone has recently taken that email
    $sql_e_check = "SELECT id FROM table_users WHERE email='$email' LIMIT 1";
    $query = mysqli_query($db_conx, $sql_e_check);
    $e_check = mysqli_num_rows($query);

    // FORM DATA ERROR HANDLING
    if ($e_check > 0){
        echo "The email address, ".$email.", has recently been taken by someone else";
        exit();
    } else {
        $sql1 = "UPDATE table_users SET email='$new_email' WHERE id='$id' LIMIT 1";
        $query1 = mysqli_query($db_conx, $sql1);

        $sql2 = "UPDATE table_useroptions SET temp_email='' WHERE id='$id' LIMIT 1";
        $query2 = mysqli_query($db_conx, $sql2);

        if ($query1 != true || $query2 != true) {
            header("location: message.php?msg=There was an error changing your login email");
            exit();
        } else {
            header("location: logout.php");
            exit();
        }
    }

} else {
    // Log this issue of missing initial $_GET variables
    header("location: message.php?msg=missing_GET_variables");
    exit();
}
?>
