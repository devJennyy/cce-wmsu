<?php 
session_start();
if(!isset($_SESSION["id"])){
    echo "Please Login!";
    exit();
}
include_once '../../includes/database.php';

$account_id = $_POST["acc_id"];

foreach($db->process_db("SELECT * FROM tbl_accounts WHERE id = ?", "s", true, $account_id) as $user){
    $response = array(
        'id' => $user['id'],
        'fullname' => $user["firstname"] . " " . $user["lastname"],
        'role' => $user["faculty_role"] . " - Faculty",
        'firstname' => $user["firstname"],
        'lastname' => $user["lastname"],
        'username' => $user["username"],
        'email' => $user["email"],
        'last_online' => $user["last_login"],
    );
}

// Convert the response array to JSON
$jsonResponse = json_encode($response);

// Send the JSON response back to the AJAX request
header('Content-Type: application/json');
echo $jsonResponse;