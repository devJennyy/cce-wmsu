<?php

    include_once '../../includes/database.php';
    include_once '../../includes/functions.php';

        $email = $_POST["username"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        $message = login_user($db, $username, $email, $password);

        if (!($message == "User doesn't exist!" || $message == "Incorrect Account Credentials!")) {
            $db->process_db("UPDATE tbl_accounts SET last_login = ? WHERE email = ? OR username = ?", "sss", false, date("Y-m-d H:i:s"), $email, $username);
        }
        
        echo $message;
        