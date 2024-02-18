<?php
require_once('../../includes/database.php');
require_once('../../includes/functions.php');

class Event {
    public $title;
    public $day;
    public $startTime;
    public $endTime;
    public $slots;
    public $slots_remaining;
    public $venue;
    public $venueType;
    public $venueLink;
    public $reminder;
    public $description;
    public $agenda;
    public $attachment;
    public $price;
    public $gcashName;
    public $gcashNumber;
    public $unique_code;
    public $visibility;
    public $status; 

    public function create_event(){
        global $db;

        $sql = "INSERT INTO tbl_events (title, day, startTime, endTime, slots, slots_remaining, venue, venue_type, venue_link, reminder, description, agenda, attachment, price, gcash_number, gcash_name, unique_code, visibility, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $db->process_db($sql, "sssssssssssssssssss", false, $this->title, $this->day, $this->startTime, $this->endTime, $this->slots, $this->slots_remaining, $this->venue, $this->venueType, $this->venueLink, $this->reminder, $this->description, $this->agenda, $this->attachment, $this->price, $this->gcashNumber, $this->gcashName, $this->unique_code, $this->visibility, $this->status);
    
        return $db->insert_id();
    }

    public function add_event_participants($accId, $eventId){
        global $db;

        $sql = "INSERT INTO tbl_event_participants (account_id, event_id, qr) VALUES (?, ?, ?)";
        $db->process_db($sql, "sss", false, $accId, $eventId, generateRandomString());
    }
}