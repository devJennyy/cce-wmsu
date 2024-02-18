<?php
// Checks if the admin is logged in.
session_start();
if (!isset($_SESSION["id"])) {
    echo "Please Login!";
    exit();
}
include_once '../../includes/database.php';
include_once '../../includes/functions.php';
include_once '../../classes/c_event.php';

$event = new Event();

// Store the event details.
$event->title = $_POST["event-title"];
$event->day = $_POST["day"];
$event->startTime = $_POST["startTime"];
$event->endTime = $_POST["endTime"];
$event->slots = $_POST["slots"];

// If the event venue is get the domain of the link.
if ($_POST["venuetype"] == "Other Platform") {
    $parsedUrl = parse_url($_POST["venue"]);
    // Check if the URL was parsed successfully and has a host component
    if ($parsedUrl && isset($parsedUrl['host'])) {
        $domain = $parsedUrl['host'];
        $event->venue = $domain;
    }
} else {
    $event->venue = $_POST["venue"];
}

// Store event details such as venue type, reminder, description, etc...
$event->venueType = $_POST["venuetype"];
$event->venueLink = $_POST["venuetype"] == "Other Platform" ? $_POST["venue"] : null;
$event->reminder = $_POST["reminder"];
$event->description = $_POST["description"];
$event->agenda = $_POST["agenda"];

// Upload Image
$fileName = $_FILES['image']['name'];
$fileTmpName = $_FILES['image']['tmp_name'];
$fileExt = explode('.', $fileName);
$fileActualExt = strtolower(end($fileExt));
$allowed = array('jpg', 'jpeg', 'png', 'gif');

if (in_array($fileActualExt, $allowed)) {
    $fileNameNew = $fileName;
    $filesDestination = '../../assets/attachments/events/' . $fileNameNew;

    move_uploaded_file($fileTmpName, $filesDestination);
    $event->attachment = "$fileNameNew";
} else {
    echo "File type not allowed!";
}

// Store the event details such as price, gcash info, unique code.
$event->price = $_POST["event-price"];
$event->gcashNumber = $_POST["gcash-number"];
$event->gcashName = $_POST["gcash-name"];
$event->visibility = $_POST["event_visibility"];
$event->unique_code = $_POST["unique-code"];
if (isset($_SESSION["faculty_role"])) {
    if ($_SESSION["faculty_role"] == "Organization") {
        $event->status = "3";
    } else {
        $event->status = "5";
    }
} else {
    $event->status = "5";
}

// Count the Participants
$countParticipants = 0;
foreach ($_POST["id"] as $id) {
    $countParticipants++;
}
$remainingSlots = intval($_POST["slots"]) - $countParticipants; // Get the remaining slots, after inviting participants.
$event->slots_remaining = $remainingSlots;

// Create the Event
$eventId = $event->create_event();

// Add each participant for the event.
foreach ($_POST["id"] as $id) {
    $event->add_event_participants($id, $eventId);
}

// Add the speakers.
foreach ($_POST["speaker-id"] as $speakerId){
    $sql = "INSERT INTO tbl_event_participants (account_id, event_id, role, qr) VALUES (?, ?, ?, ?)";
    $db->process_db($sql, "ssss", false, $speakerId, $eventId, "Speaker", generateRandomString());
}

process_certificate($db, $eventId);
add_assessment($db, $eventId);


// Function to process the certificate template uploaded.
function process_certificate($db, $eventId)
{
    $cert_name = $_POST["event-certificate"];
    $cert_from = $_POST["certificate-from"];

    if (true) {
        // Upload Certificate Image
        $fileName = $_FILES['certificate-file']['name'];
        $fileTmpName = $_FILES['certificate-file']['tmp_name'];
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg', 'jpeg', 'png');

        if (in_array($fileActualExt, $allowed)) {
            $fileNameNew = $fileName;
            $filesDestination = '../../assets/attachments/certificates/' . $fileNameNew;

            move_uploaded_file($fileTmpName, $filesDestination);
            $cert_image = "$fileNameNew";
        } else {
            echo "File type not allowed!";
        }
    }

    // Get the textfield info, x and y axis, width and height, etc...
    $x = $_POST["textfield-x"];
    $y = $_POST["textfield-y"];
    $width = $_POST["textfield-width"];
    $height = $_POST["textfield-height"];
    $fsize = $_POST["textfield-fsize"];
    $fweight = $_POST["textfield-fweight"];

    // Upload Certificate Font Style
    $fileName = $_FILES['textfield-fstyle']['name'] ?? null;
    if ($fileName != null || $fileName != '') {
        $fileTmpName = $_FILES['textfield-fstyle']['tmp_name'];
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('ttf');

        if (in_array($fileActualExt, $allowed)) {
            $fileNameNew = $fileName;
            $filesDestination = '../../assets/attachments/certificates/ttf/' . $fileNameNew;

            move_uploaded_file($fileTmpName, $filesDestination);
            $fstyle = "$fileNameNew";
        } else {
            echo "File type not allowed!";
        }
    } else {
        $fstyle = 'PoppinsSemiBold.ttf';
    }

    $sql = "INSERT INTO tbl_certificates (event_id, certificate_name, certificate_from, source, x_pos, y_pos, width, height, font_style, font_size, font_weight) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $db->process_db($sql, "sssssssssss", false, $eventId, $cert_name, $cert_from, $cert_image, $x, $y, $width, $height, $fstyle, $fsize, $fweight);
}


// Function to create the assesment for the event.
function add_assessment($db, $eventId)
{
    $count = 0;

    // Store each options added by the admin for the assessment.
    $optionA = $_POST["option-A"];
    $optionB = $_POST["option-B"];
    $optionC = $_POST["option-C"];
    $optionD = $_POST["option-D"];
    $answer = $_POST["answer-key"];
    $code = $_POST["event-random-code"];
    foreach ($_POST["question"] as $question) {
        if($count === 4){
            $sql = "INSERT INTO tbl_assessment (question, answer, option_a, option_b, option_c, option_d, event_id, is_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $db->process_db($sql, "ssssssss", false, $question, $code, null, null, null, null, $eventId, 1);
        }
        else {
            $sql = "INSERT INTO tbl_assessment (question, answer, option_a, option_b, option_c, option_d, event_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $db->process_db($sql, "sssssss", false, $question, $answer[$count], $optionA[$count], $optionB[$count], $optionC[$count], $optionD[$count], $eventId);
        }

        $count++;
    }
}

// Send emails to all invited participants and speaker.
include_once 'email_invite.php';

$emails = array();
$qrDatas = array();

$sql = "SELECT tbl_accounts.email, tbl_event_participants.qr FROM tbl_event_participants INNER JOIN tbl_accounts ON tbl_accounts.id = tbl_event_participants.account_id
        WHERE tbl_event_participants.event_id = ? AND tbl_event_participants.status = 'Invited'";
foreach($db->process_db($sql, "s", true, $eventId) as $email) {
    $emails[] = $email["email"];
    $qrDatas[] = $email["qr"];
}

$sql = "SELECT * FROM tbl_events WHERE id = ?";
foreach($db->process_db($sql, "s", true, $eventId) as $event) {

    // Send Email
    sendEmail($emails, 
    $event["title"], 
    "https://wmsu-cce.online/event-join.php", 
    str_replace(' ', '%20', $event["attachment"]), 
    $eventId,
    $_POST["venuetype"] == "Other Platform" ? true : false,
    $_POST["venuetype"] == "Other Platform" ? null : $qrDatas);
}

echo "Done!";
