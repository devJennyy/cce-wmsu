<?php
include_once '../../includes/database.php';


$sql = "SELECT tbl_accounts.id, tbl_accounts.firstname, tbl_accounts.lastname, tbl_event_participants.attended FROM tbl_event_participants 
        INNER JOIN tbl_accounts ON tbl_accounts.id = tbl_event_participants.account_id
        WHERE tbl_event_participants.qr = ? AND tbl_event_participants.event_id = ?";
$count = 0;

foreach($db->process_db($sql, "ss", true, $_POST["qr_str"], $_POST["event_id"]) as $participant){
    // Check if participant has already been recorded.
    if($participant["attended"] == 1){
        $response[] = array(
            'message' => "Participant's attendance is already recorded!",
        );
    }
    else {
        // Record participant's attendance.
        $db->process_db("UPDATE tbl_event_participants SET attended = 1 
                    WHERE account_id = ? AND event_id = ?", "ss", false, $participant["id"], $_POST["event_id"]);

        $isRecorded = true;

        $response[] = array(
            'message' => "Participant's attendance is successfully recorded!",
        );
    }

    $count++;
}

if($count == 0){
    // update status from response to 'This participant's attendance is already recorded!'
    $response[] = array(
        'message' => "Invalid QR Code!",
    );
}

// Convert the response array to JSON
$jsonResponse = json_encode($response);

// Send the JSON response back to the AJAX request
header('Content-Type: application/json');
echo $jsonResponse;