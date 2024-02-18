<?php
function login_user($db, $username, $email, $password){
    $count = 0;
    
    foreach($db->process_db("SELECT * FROM tbl_accounts WHERE username = ? OR email = ?", "ss", true, $username, $email) as $isExisting) {
        $encrypted_pwd = $isExisting["password"];
        
        // Verify if the password matches the encrypted password on the database.
        if(password_verify($password, $encrypted_pwd)){
            // Log the user in and get their infos.
            session_start();
    
            $_SESSION["id"] = $isExisting["id"];
            $_SESSION["firstname"] = $isExisting["firstname"];
            $_SESSION["lastname"] = $isExisting["lastname"];
            $_SESSION["email"] = $isExisting["email"];
            $_SESSION["password"] = $isExisting["password"];
            $_SESSION["mobile"] = $isExisting["mobile"];
            $_SESSION["img"] = $isExisting["img"];
            $_SESSION["faculty_role"] = $isExisting["faculty_role"];
            $_SESSION["identification"] = $isExisting["identification"];
            $_SESSION["verified"] = $isExisting["verified"];

            // If the user is an organization, redirect to Organization Page.
            if($isExisting["faculty_role"] == "Organization"){
                $acc_id = $isExisting["id"];
                foreach($db->process_db("SELECT * FROM tbl_organization WHERE account_id = $acc_id", "", true, "") as $org_details){
                    $_SESSION["org-id"] = $org_details["id"];
                    $_SESSION["acc-id"] = $org_details["account_id"];
                    $_SESSION["org-name"] = $org_details["org_name"];
                    $_SESSION["org-shortname"] = $org_details["org_shortname"];
                    $_SESSION["org-logo"] = $org_details["org_logo"];
                    $_SESSION["org-descrip"] = $org_details["org_descrip"];
                    $_SESSION["org-activities"] = $org_details["org_activities"];
                    $_SESSION["org-mission"] = $org_details["org_mission"];
                    $_SESSION["org-goal"] = $org_details["org_goal"];
                }
    
                return "./organization/dashboard/dashboard.php";
            }
            // If the user is an Admin, redirect to Admin Page.
            elseif ($isExisting["faculty_role"] == "Administrator") {
                return "./admin/dashboard/dashboard.php";
            }
            // If the user is a faculty, redirect to Faculty Page.
            else {
                return "./faculty/dashboard/dashboard.php";
            }
        }
        else {
            echo "Incorrect Account Credentials!";
            exit();
        }
    }

    if($count == 0) {
        echo "User doesn't exist!";
    }
}

function checkAnswer($db, $answer, $event_id, $question_id){
    $sql = "SELECT answer FROM tbl_assessment WHERE event_id = ? AND id = ?";
    foreach($db->process_db($sql, "ss", true, $event_id, $question_id) as $correct_answer){
        return $correct_answer["answer"] === $answer ? true : false;
    }
}

// Generate Random String
function generateRandomString($length = 12) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString;
}

// Generate QR base on user data using an API.
function generateQRCode($data, $size = 200, $margin = 4)
{
    // GoQR.me API URL
    $apiUrl = 'https://api.qrserver.com/v1/create-qr-code/';

    // Build the API request URL
    $url = $apiUrl . '?data=' . urlencode($data) . '&size=' . $size . 'x' . $size . '&margin=' . $margin;

    return $url;
}