<?php
    session_start();
    if(!isset($_SESSION["id"])){
        echo "Please Login!";
        exit();
    }
    include_once '../../includes/database.php';

    $slots = $_POST["slots"];
    $eventId = $_POST["event-id"];

    $updateSlot = "UPDATE tbl_events SET slots_remaining = slots_remaining + ?, slots = slots + ? WHERE id = ?";
    $db->process_db($updateSlot, "sss", false, $slots, $slots, $eventId);

    header("location: ../../admin/events/events.php");