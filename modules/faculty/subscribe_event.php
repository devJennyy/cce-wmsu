<?php 
    session_start();
    if(!isset($_SESSION["id"])){
        echo "Please Login!";
        exit();
    }
    
    include_once '../../includes/database.php';

    // Get relevant user infos
    $accId = $_POST["acc-id"];
    $eventId = $_POST["event-id"];
    $firstname = $_POST["firstname"];
    $initialName = $_POST["initial-name"] ?? null;
    $lastname = $_POST["lastname"];
    $gcash = $_POST["gcash-number"];
    $proof = "";

    // Add File Handling for proof image upload
    $fileName = $_FILES['proof-payment']['name'];
    $fileTmpName = $_FILES['proof-payment']['tmp_name'];
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png', 'gif');

    if(in_array($fileActualExt, $allowed)){
        $fileNameNew = $fileName;
        $filesDestination = '../../assets/attachments/faculty/proof/' . $fileNameNew;

        move_uploaded_file($fileTmpName, $filesDestination);
        $proof = $fileNameNew;
    }
    else {
        echo "File type not allowed!";
    }

    $sql = "INSERT INTO tbl_subscriptions (account_id, event_id, firstname, initial_name, lastname, gcash_no, proof) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $db->process_db($sql, "sssssss", false, $accId, $eventId, $firstname, $initialName, $lastname, $gcash, $proof);

    echo "Done!";
    