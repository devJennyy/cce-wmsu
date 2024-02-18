<?php
session_start();
if(!isset($_SESSION["id"])){
    echo "Please Login!";
    exit();
}
include_once '../../includes/database.php';

// Function to retrieve events for a specific date
function getEvents($db) {
    if($_SESSION["faculty_role"] == "Administrator"){
        $sql = "SELECT * FROM tbl_events WHERE status = 5";

        $events = $db->process_db($sql, "", true, "");
    }
    elseif($_SESSION["faculty_role"] != "Administrator"){
        $sql = "SELECT tbl_events.*, tbl_event_participants.status AS participant_status FROM tbl_events
        INNER JOIN tbl_event_participants ON tbl_events.id = tbl_event_participants.event_id
        WHERE tbl_event_participants.account_id = ? AND tbl_events.day > ? AND tbl_events.status = 5;";

        $events = $db->process_db($sql, "ss", true, $_SESSION["id"], date("Y-m-d"));
    }
    
    return $events;
    
    /* $result = mysqli_query($db, $query);
    
    if ($result) {
        $events = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $events[] = $row;
        }
        mysqli_free_result($result);
        return $events;
    } else {
        return [];
    } */
}

// Get the date from the client-side JavaScript request
// Modify as needed (e.g., use POST for security)

// Call the getEvents function to retrieve events for the specified date
$events = getEvents($db);

// Return events data as JSON
header('Content-Type: application/json');
echo json_encode($events);
