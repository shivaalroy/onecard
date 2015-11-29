<?php
include_once("php_includes/home.php");
include_once("php_includes/db_conx.php");
?>
<?php
// Ajax calls this REGISTRATION code to execute
if(isset($_POST["fn"])){
    // CONNECT TO THE DATABASE
    include_once("php_includes/db_conx.php");
    // GATHER THE POSTED DATA INTO LOCAL VARIABLES
    //$u = preg_replace('#[^a-z0-9]#i', '', $_POST['u']);
    $fn = preg_replace('#[^a-z]#i', '', $_POST['fn']);
    $ln = preg_replace('#[^a-z]#i', '', $_POST['ln']);
    $e = strtolower(substr($fn, 0, 2).substr($ln, 0, 2)."@oc");
    $p = "welcome";
    $g = "Male";
    $c = "United States of America";
    // GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));

    // FORM DATA ERROR HANDLING
    if($fn == "" || $ln == ""){
        echo "The form submission is missing values.";
        exit();
    } else {
        // END FORM DATA ERROR HANDLING
        // Begin Insertion of data into the database
        // Hash the password and apply your own mysterious unique salt
        /* $cryptpass = crypt($p);
		include_once ("php_includes/randStrGen.php"); change */
        $p_hash = md5($p); //change
        // Add user info into the database table for the main site table
        $sql = "INSERT INTO table_users (email, password, ip, signup, lastlogin, notescheck, activated)
		        VALUES('$e', '$p_hash', '$ip', now(), now(), now(), '1')"; //change
        $query = mysqli_query($db_conx, $sql);
        $uid = mysqli_insert_id($db_conx);
        // Establish their row in the userinfo table
        $sql = "INSERT INTO table_userinfo (id, firstname, lastname, gender, country, activated)
		        VALUES('$uid', '$fn', '$ln', '$g', '$c', '1')";
        $query = mysqli_query($db_conx, $sql);
        // Establish their row in the useroptions table
        $sql = "INSERT INTO table_useroptions (id) VALUES ('$uid')";
        $query = mysqli_query($db_conx, $sql);
        // Create directory(folder) to hold each user's files(pics, MP3s, etc.)
        if (!file_exists("user/$uid")) {
            mkdir("user/$uid", 0755);
        }

        echo $e;
        echo "<br />";
        echo "signup_success";
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Create Accounts</title>
        <link rel="icon" href="<?php echo $url; ?>img/favicon.ico" type="image/x-icon">
    </head>
    <body>
        <form id="account_creatore_form" action="account_creatore.php" method="post">
            <div>
                <label for="fn">Firstname</label>
                <input type="text" id="fn" name="fn">
            </div>
            <div>
                <label for="ln">Lastname</label>
                <input type="text" id="ln" name="ln">
            </div>
            <div class="login_form_row">
                <input type="submit" id="login_btn_big" value="Create Account">
            </div>
        </form>
    </body>
</html>