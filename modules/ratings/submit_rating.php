<?php

session_start();
if(!isset($_SESSION["id"])){
    echo "Please Login!";
    exit();
}

include_once '../../includes/database.php';

$rating = $_POST["rating"];
$additional = $_POST["additional-feedback"];
$eventID = $_POST["event-id"];
$accountID = $_POST["account-id"];

$labels = ["F1", "F2", "F3A", "F3B", "F3C", "F4A", "F4B", "F4C", "F5", "ADD"];
$count = 0;
foreach($rating as $feedback){
    $sql = "INSERT INTO tbl_ratings(event_id, account_id, rating, label, additional, date) VALUES (?, ?, ?, ?, ?, ?)";
    $db->process_db($sql, "ssssss", false, $eventID, $accountID, $feedback, $labels[$count], null, date("Y-m-d"));
    $count++;
}

$sql = "INSERT INTO tbl_ratings(event_id, account_id, rating, label, additional, date) VALUES (?, ?, ?, ?, ?, ?)";
$db->process_db($sql, "ssssss", false, $eventID, $accountID, 0, $labels[9], $additional, date("Y-m-d"));

$sql = "UPDATE tbl_event_participants SET status = 'Certificate Sent', certificate_sent = '1' WHERE account_id = ? AND event_id = ?";
$db->process_db($sql, "ss", false, $accountID, $eventID);

echo "Done!";