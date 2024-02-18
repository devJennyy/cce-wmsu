<?php 
session_start();
if(!isset($_SESSION["id"])){
    echo "Please Login!";
    exit();
}

include_once '../../includes/database.php';
if(isset($_POST["submit-del"])){
    $id = $_POST["acc-id"];

    $sql = "DELETE FROM tbl_accounts WHERE id = ?";
    $db->process_db($sql, "s", false, $id);

    header("Location: ../../admin/settings/settings.php");
}