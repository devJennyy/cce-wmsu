<?php

session_start();
if(!isset($_SESSION["id"])){
    echo "Please Login!";
    exit();
}

include_once '../../includes/database.php';
include_once '../../classes/c_faculty.php';

$acc = new Faculty_Account();

$encrypted_pwd = password_hash($_POST["add-password"], PASSWORD_DEFAULT);

$acc->firstname = ucfirst($_POST["add-firstname"]);
$acc->middlename = NULL;
$acc->lastname = ucfirst($_POST["add-lastname"]);
$acc->username = $_POST["add-username"];
$acc->email = $_POST["add-email"];
$acc->password = $encrypted_pwd;
$acc->faculty_role = $_POST["role"] == "Faculty" ? $_POST["college"] : $_POST["role"];
$acc->identification = NULL;

if($acc->check_existing()){
    echo "User already exist!";
}
else {
    $acc->create_faculty_acc();
    echo "User created!";
}