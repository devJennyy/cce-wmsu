<?php 
    session_start();
    if(!isset($_SESSION["id"])){
        echo "Please Login!";
        exit();
    }
    
    include_once '../../includes/database.php';

    $org_id = $_POST["account-id"];
    
    $db->process_db("UPDATE tbl_accounts SET verified = 2 WHERE id = ?", "s", false, $org_id);

    echo "Verified!";