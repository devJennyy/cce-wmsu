<?php

session_start();
if (!isset($_SESSION["id"])) {
    echo "Please Login!";
    exit();
}

include_once '../../includes/database.php';

$eventID = $_POST["event-id"];

$sql = "UPDATE tbl_events SET status = 7 WHERE id = ?";
$db->process_db($sql, "s", false, $eventID);

header("Location: ../../admin/events/events.php");