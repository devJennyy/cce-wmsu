<?php
session_start();
if (!isset($_SESSION["id"])) {
    echo "Please Login!";
    exit();
}
include_once '../../includes/database.php';

if(isset($_POST["submit"])){
    $eventId = $_POST["event-id"];

    $reason = $_POST["resched-reason"];
    $additional = $_POST["resched-additional"];

    $day = $_POST["resched-day"];
    $startTime = $_POST["resched-startTime"];
    $endTime = $_POST["resched-endTime"];
    $slots = $_POST["resched-slots"];

    if ($_POST["resched-venuetype"] == "Other Platform") {
        $parsedUrl = parse_url($_POST["resched-venue"]);
        // Check if the URL was parsed successfully and has a host component
        if ($parsedUrl && isset($parsedUrl['host'])) {
            $domain = $parsedUrl['host'];
            $venue = $domain;
        }
    } else {
        $venue = $_POST["resched-venue"];
    }
    $venueType = $_POST["resched-venuetype"];
    $venueLink = $_POST["resched-venuetype"] == "Other Platform" ? $_POST["resched-venue"] : null;
    $reminder = $_POST["resched-reminder"];

    foreach($db->process_db("SELECT slots, slots_remaining FROM tbl_events WHERE id = ?", "s", true, $eventId) as $slotBefore) {
        $slotRemaining = $slotBefore["slots_remaining"] + ($slots - $slotBefore["slots"]);
        echo $slotRemaining;
    }

    $sql = "UPDATE tbl_events SET day = ?, startTime = ?, endTime = ?, slots = ?, slots_remaining = ?, venue = ?, venue_type = ?, venue_link = ?, reminder = ? WHERE id = ?";
    $db->process_db($sql, "ssssssssss", false, $day, $startTime, $endTime, $slots, $slotRemaining, $venue, $venueType, $venueLink, $reminder, $eventId);

    $db->process_db("INSERT INTO tbl_reschedule_reason(event_id, reason, additional) VALUES (?, ?, ?)", "sss", false, $eventId, $reason, $additional);

    header("Location: ../../admin/events/events.php");
}