[<?php
    session_start();
    if(!isset($_SESSION["id"])){
        echo "Please Login!";
        exit();
    }
    include_once '../../includes/database.php';
    include_once '../../includes/functions.php';
    include_once '../events/email_invite.php';

    // Get the Event Id and Account Id for the user who want to subscribe.
    $subId = $_POST["sub-id"];
    $accId = $_POST["acc-id"];
    $eventId = $_POST["event-id"];

    $handleSubTable = "UPDATE tbl_subscriptions SET status = 5 WHERE id = ?";
    $db->process_db($handleSubTable, "s", false, $subId);

    // Add subscription to participants.
    $sql = "INSERT INTO tbl_event_participants (account_id, event_id, type, qr) VALUES (?, ?, 'Subscribed', ?)";
    $db->process_db($sql, "sss", false, $accId, $eventId, generateRandomString());

    // Update the slot accordingly.
    $updateSlot = "UPDATE tbl_events SET slots_remaining = slots_remaining - 1 WHERE id = ?";
    $db->process_db($updateSlot, "s", false, $eventId);

    $emails = array();
    $qrDatas = array();

    $event = $db->process_db("SELECT * FROM tbl_events WHERE id = ?", "s", true, $eventId);
    foreach($db->process_db("SELECT * FROM tbl_accounts WHERE id = ?" , "s", true, $accId) as $account){
        $emails[] = $account["email"];
    }
    foreach($db->process_db("SELECT * FROM tbl_event_participants WHERE account_id = ? AND event_id = ?", "ss", true, $accId, $eventId) as $qr){
        $qrDatas[] = $qr["qr"];
    }

    // Send email invite to subscribed participant.
    sendEmail($emails, $event["title"], "https://wmsu-cce.online/event-join.php",
                str_replace(' ', '%20', $event["attachment"]), $eventId,
                $event["venue_type"] == "Other Platform" ? true : false, 
                $event["venue_type"] == "Other Platform" ? null : $qrDatas);

    echo "Done!";
    /* header("location: ../../admin/notifications/notifications.php"); */