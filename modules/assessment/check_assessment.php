<?php
session_start();
if(!isset($_SESSION["id"])){
    echo "Please Login!";
    exit();
}

include_once '../../includes/database.php';
include_once '../../includes/functions.php';

$question_id = $_POST["question_id"];
$answersArray = array(
    $_POST["question1"],
    $_POST["question2"],
    $_POST["question3"],
    $_POST["question4"],
    $_POST["question5"]
);

$countAns = 0;
$allCorrect = true;
foreach($question_id as $id){
    // Check if the submitted answers are correct.
    if(!checkAnswer($db, $answersArray[$countAns], $_POST["event-id"], $id)){
        $allCorrect = false; // Stop the loop when theres an answer that is wrong.
        break;
    }
    $countAns++;
}

if($allCorrect){
    $sql = "UPDATE tbl_event_participants SET status = 'Step 2 In Progress' WHERE account_id = ? AND event_id = ?";
    $db->process_db($sql, "ss", false, $_POST["user-id"], $_POST["event-id"]);
}

echo $allCorrect ? "All Correct" : "Not all correct";


