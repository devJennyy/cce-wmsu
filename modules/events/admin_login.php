<?php
include_once '../../includes/database.php';

$email = $_POST["username"];
$username = $_POST["username"];
$password = $_POST["password"];

$admin = $db->process_db("SELECT * FROM tbl_accounts WHERE faculty_role = 'Administrator' LIMIT 1", "", true, "")[0];

$response = array(
    'status' => false,  // Set default status to false
);

if ($admin && ($admin["email"] == $email || $admin["username"] == $username) && password_verify($password, $admin["password"])) {
    $response['status'] = true;  // Update status only if credentials match
}

$jsonResponse = json_encode($response);

// Send the JSON response back to the AJAX request
header('Content-Type: application/json');
echo $jsonResponse;
