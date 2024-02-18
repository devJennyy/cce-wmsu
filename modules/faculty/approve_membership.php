<?php
    session_start();
    if(!isset($_SESSION["id"])){
        echo "Please Login!";
        exit();
    }
    include_once '../../includes/database.php';

    $accId = $_POST["account-id"];

    $sql = "UPDATE tbl_accounts SET verified = 2 WHERE id = ?";
    $db->process_db($sql, "s", false, $accId);

    echo "Done!";