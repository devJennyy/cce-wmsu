<?php

session_start();
if(!isset($_SESSION["id"])){
    echo "Please Login!";
    exit();
}

include_once '../../includes/database.php';

if(isset($_POST["submit"])){
    $firstname = $_POST["edit-firstname"];
    $lastname = $_POST["edit-lastname"];
    $email = $_POST["edit-email"];
    $username = $_POST["edit-username"];
    $id = $_POST["user-id"];

    $sql = "UPDATE tbl_accounts SET firstname = ?, lastname = ?, username = ?, email = ? WHERE id = ?";
    $db->process_db($sql, "sssss", false, $firstname, $lastname, $username, $email, $id);

    if (!empty($_POST["edit-password"])) {
        $password = password_hash($_POST["edit-password"], PASSWORD_DEFAULT);
        $db->process_db("UPDATE tbl_accounts SET password = ? WHERE id = ?", "ss", false, $password, $id);
    }

    $_SESSION["firstname"] = $firstname;
    $_SESSION["lastname"] = $lastname;
    $_SESSION["email"] = $email;
    $_SESSION["password"] = $password;

    if($_SESSION["faculty_role"] == "Administrator"){
        header("Location: ../../admin/settings/settings.php");
    }
    else {
        header("Location: ../../faculty/settings/settings.php");
    }
}