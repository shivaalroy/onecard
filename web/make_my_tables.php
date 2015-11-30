<?php
include_once("php_includes/db_conx.php");
$tbl_users = "CREATE TABLE IF NOT EXISTS table_users (
                id INT(11) NOT NULL AUTO_INCREMENT,
                username VARCHAR(16) NOT NULL,
                email VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                userlevel ENUM('a','b','c','d') NOT NULL DEFAULT 'a',
                ip VARCHAR(255) NOT NULL,
                signup DATETIME NOT NULL,
                lastlogin DATETIME NOT NULL,
                timezone INT(3) NOT NULL,
                notescheck DATETIME NOT NULL,
                activated ENUM('0','1') NOT NULL DEFAULT '0',
                PRIMARY KEY (id),
                UNIQUE KEY email (email)
                )";
$query = mysqli_query($db_conx, $tbl_users);
if ($query === true) {
    echo "<h3>table_users table created OK :) </h3>";
} else {
    echo "<h3>table_users table NOT created :( </h3>";
}
////////////////////////////////////
$tbl_userinfo = "CREATE TABLE IF NOT EXISTS table_userinfo (
                id INT(11) NOT NULL,
                activated ENUM('0','1') NOT NULL DEFAULT '0',
                username VARCHAR(16) NOT NULL,
                firstname VARCHAR(30) NOT NULL,
                lastname VARCHAR(30) NOT NULL,
                gender ENUM('Male','Female') NOT NULL,
                city VARCHAR(255) NOT NULL,
                country VARCHAR(255) NOT NULL,
                avatar1 VARCHAR(255) NOT NULL,
                avatar2 VARCHAR(255) NOT NULL,
                em1 VARCHAR(255) NOT NULL,
                em1_lbl VARCHAR(20) NOT NULL,
                em2 VARCHAR(255) NOT NULL,
                em2_lbl VARCHAR(20) NOT NULL,
                em3 VARCHAR(255) NOT NULL,
                em3_lbl VARCHAR(20) NOT NULL,
                em4 VARCHAR(255) NOT NULL,
                em4_lbl VARCHAR(20) NOT NULL,
                em5 VARCHAR(255) NOT NULL,
                em5_lbl VARCHAR(20) NOT NULL,
                em6 VARCHAR(255) NOT NULL,
                em6_lbl VARCHAR(20) NOT NULL,
                em7 VARCHAR(255) NOT NULL,
                em7_lbl VARCHAR(20) NOT NULL,
                em8 VARCHAR(255) NOT NULL,
                em8_lbl VARCHAR(20) NOT NULL,
                em9 VARCHAR(255) NOT NULL,
                em9_lbl VARCHAR(20) NOT NULL,
                em10 VARCHAR(255) NOT NULL,
                em10_lbl VARCHAR(20) NOT NULL,
                ph1 VARCHAR(30) NOT NUll,
                ph1_lbl VARCHAR(20) NOT NULL,
                ph2 VARCHAR(30) NOT NULL,
                ph2_lbl VARCHAR(20) NOT NULL,
                ph3 VARCHAR(30) NOT NULL,
                ph3_lbl VARCHAR(20) NOT NULL,
                ph4 VARCHAR(30) NOT NULL,
                ph4_lbl VARCHAR(20) NOT NULL,
                ph5 VARCHAR(30) NOT NULL,
                ph5_lbl VARCHAR(20) NOT NULL,
                ph6 VARCHAR(30) NOT NULL,
                ph6_lbl VARCHAR(20) NOT NULL,
                ph7 VARCHAR(30) NOT NULL,
                ph7_lbl VARCHAR(20) NOT NULL,
                ph8 VARCHAR(30) NOT NULL,
                ph8_lbl VARCHAR(20) NOT NULL,
                ph9 VARCHAR(30) NOT NULL,
                ph9_lbl VARCHAR(20) NOT NULL,
                ph10 VARCHAR(30) NOT NULL,
                ph10_lbl VARCHAR(20) NOT NULL,
                ad1 VARCHAR(255) NOT NULL,
                ad1_lbl VARCHAR(20) NOT NULL,
                ad2 VARCHAR(255) NOT NULL,
                ad2_lbl VARCHAR(20) NOT NULL,
                ad3 VARCHAR(255) NOT NULL,
                ad3_lbl VARCHAR(20) NOT NULL,
                ad4 VARCHAR(255) NOT NULL,
                ad4_lbl VARCHAR(20) NOT NULL,
                ad5 VARCHAR(255) NOT NULL,
                ad5_lbl VARCHAR(20) NOT NULL,
                web1 VARCHAR(255) NOT NULL,
                web1_lbl VARCHAR(20) NOT NULL,
                web2 VARCHAR(255) NOT NULL,
                web2_lbl VARCHAR(20) NOT NULL,
                web3 VARCHAR(255) NOT NULL,
                web3_lbl VARCHAR(20) NOT NULL,
                web4 VARCHAR(255) NOT NULL,
                web4_lbl VARCHAR(20) NOT NULL,
                web5 VARCHAR(255) NOT NULL,
                web5_lbl VARCHAR(20) NOT NULL,
                oun_facebook VARCHAR(255) NOT NULL,
                oun_linkedin VARCHAR(255) NOT NULL,
                oun_twitter VARCHAR(255) NOT NULL,
                oun_skype VARCHAR(255) NOT NULL,
                PRIMARY KEY (id)
                )";
$query = mysqli_query($db_conx, $tbl_userinfo);
if ($query === true) {
    echo "<h3>table_userinfo table created OK :) </h3>";
} else {
    echo "<h3>table_userinfo table NOT created :( </h3>";
}
////////////////////////////////////
$tbl_useroptions = "CREATE TABLE IF NOT EXISTS table_useroptions (
                        id INT(11) NOT NULL,
                        question VARCHAR(255) NULL,
                        answer VARCHAR(255) NULL,
                        temp_email VARCHAR(255) NOT NULL,
                        temp_pass VARCHAR(255) NOT NULL,
                        sort_order VARCHAR(20) NOT NULL DEFAULT 'fname',
                        disp_order VARCHAR(20) NOT NULL DEFAULT 'name',
                        PRIMARY KEY (id)
                        )";
$query = mysqli_query($db_conx, $tbl_useroptions);
if ($query === TRUE) {
    echo "<h3>table_useroptions table created OK :) </h3>";
} else {
    echo "<h3>table_useroptions table NOT created :( </h3>";
}
////////////////////////////////////
$tbl_friends = "CREATE TABLE IF NOT EXISTS table_friends (
                    id INT(11) NOT NULL AUTO_INCREMENT,
                    sharer INT(11) NOT NULL,
                    sharee INT(11) NOT NULL,
                    new ENUM('0','1') NOT NULL DEFAULT '1',
                    accepted ENUM('0','1') NOT NULL DEFAULT '0',
                    ignored ENUM('0','1') NOT NULL DEFAULT '0',
                    datemade DATETIME NOT NULL,
                    em1 ENUM('0','1') NOT NULL DEFAULT '0',
                    em2 ENUM('0','1') NOT NULL DEFAULT '0',
                    em3 ENUM('0','1') NOT NULL DEFAULT '0',
                    em4 ENUM('0','1') NOT NULL DEFAULT '0',
                    em5 ENUM('0','1') NOT NULL DEFAULT '0',
                    em6 ENUM('0','1') NOT NULL DEFAULT '0',
                    em7 ENUM('0','1') NOT NULL DEFAULT '0',
                    em8 ENUM('0','1') NOT NULL DEFAULT '0',
                    em9 ENUM('0','1') NOT NULL DEFAULT '0',
                    em10 ENUM('0','1') NOT NULL DEFAULT '0',
                    ph1 ENUM('0','1') NOT NULL DEFAULT '0',
                    ph2 ENUM('0','1') NOT NULL DEFAULT '0',
                    ph3 ENUM('0','1') NOT NULL DEFAULT '0',
                    ph4 ENUM('0','1') NOT NULL DEFAULT '0',
                    ph5 ENUM('0','1') NOT NULL DEFAULT '0',
                    ph6 ENUM('0','1') NOT NULL DEFAULT '0',
                    ph7 ENUM('0','1') NOT NULL DEFAULT '0',
                    ph8 ENUM('0','1') NOT NULL DEFAULT '0',
                    ph9 ENUM('0','1') NOT NULL DEFAULT '0',
                    ph10 ENUM('0','1') NOT NULL DEFAULT '0',
                    web1 ENUM('0','1') NOT NULL DEFAULT '0',
                    web2 ENUM('0','1') NOT NULL DEFAULT '0',
                    web3 ENUM('0','1') NOT NULL DEFAULT '0',
                    web4 ENUM('0','1') NOT NULL DEFAULT '0',
                    web5 ENUM('0','1') NOT NULL DEFAULT '0',
                    ad1 ENUM('0','1') NOT NULL DEFAULT '0',
                    ad2 ENUM('0','1') NOT NULL DEFAULT '0',
                    ad3 ENUM('0','1') NOT NULL DEFAULT '0',
                    ad4 ENUM('0','1') NOT NULL DEFAULT '0',
                    ad5 ENUM('0','1') NOT NULL DEFAULT '0',
                    oun_facebook ENUM('0','1') NOT NULL DEFAULT '0',
                    oun_linkedin ENUM('0','1') NOT NULL DEFAULT '0',
                    oun_twitter ENUM('0','1') NOT NULL DEFAULT '0',
                    oun_skype ENUM('0','1') NOT NULL DEFAULT '0',
                    PRIMARY KEY (id)
                    )";
$query = mysqli_query($db_conx, $tbl_friends);
if ($query === TRUE) {
    echo "<h3>table_friends table created OK :) </h3>";
} else {
    echo "<h3>table_friends table NOT created :( </h3>";
}
////////////////////////////////////
$tbl_blockedusers = "CREATE TABLE IF NOT EXISTS table_blockedusers (
                        id INT(11) NOT NULL AUTO_INCREMENT,
                        blocker VARCHAR(16) NOT NULL,
                        blockee VARCHAR(16) NOT NULL,
                        blockdate DATETIME NOT NULL,
                        PRIMARY KEY (id)
                        )";
$query = mysqli_query($db_conx, $tbl_blockedusers);
if ($query === TRUE) {
    echo "<h3>table_blockedusers table created OK :) </h3>";
} else {
    echo "<h3>table_blockedusers table NOT created :( </h3>";
}
////////////////////////////////////
$tbl_status = "CREATE TABLE IF NOT EXISTS table_status (
                id INT(11) NOT NULL AUTO_INCREMENT,
                osid INT(11) NOT NULL,
                account_name VARCHAR(16) NOT NULL,
                author VARCHAR(16) NOT NULL,
                type ENUM('a','b','c') NOT NULL,
                data TEXT NOT NULL,
                postdate DATETIME NOT NULL,
                PRIMARY KEY (id)
                )";
$query = mysqli_query($db_conx, $tbl_status);
if ($query === TRUE) {
    echo "<h3>table_status table created OK :) </h3>";
} else {
    echo "<h3>table_status table NOT created :( </h3>";
}
////////////////////////////////////
$tbl_photos = "CREATE TABLE IF NOT EXISTS table_photos (
                id INT(11) NOT NULL AUTO_INCREMENT,
                user VARCHAR(16) NOT NULL,
                gallery VARCHAR(16) NOT NULL,
                filename VARCHAR(255) NOT NULL,
                description VARCHAR(255) NULL,
                uploaddate DATETIME NOT NULL,
                PRIMARY KEY (id)
                )";
$query = mysqli_query($db_conx, $tbl_photos);
if ($query === TRUE) {
    echo "<h3>table_photos table created OK :) </h3>";
} else {
    echo "<h3>table_photos table NOT created :( </h3>";
}
////////////////////////////////////
$tbl_notifications = "CREATE TABLE IF NOT EXISTS table_notifications (
                        id INT(11) NOT NULL AUTO_INCREMENT,
                        target INT(11) NOT NULL,
                        initiator INT(11) NOT NULL,
                        new ENUM('0','1') NOT NULL DEFAULT '1',
                        did_read ENUM('0','1') NOT NULL DEFAULT '0',
                        date_time DATETIME NOT NULL,
                        type VARCHAR(255) NOT NULL,
                        email ENUM('0','1') NOT NULL DEFAULT '0',
                        phone ENUM('0','1') NOT NULL DEFAULT '0',
                        address ENUM('0','1') NOT NULL DEFAULT '0',
                        additional VARCHAR(255) NOT NULL,
                        PRIMARY KEY (id)
                        )";
$query = mysqli_query($db_conx, $tbl_notifications);
if ($query === TRUE) {
    echo "<h3>table_notifications table created OK :) </h3>";
} else {
    echo "<h3>table_notifications table NOT created :( </h3>";
}
?>
