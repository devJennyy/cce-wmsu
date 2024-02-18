<?php
    date_default_timezone_set('Asia/Singapore');
    include_once '../../includes/database.php';
    
    if(!isset($_SESSION["id"])){
        header("Location: https://wmsu-cce.online/?msg=login");
    }


    $flag = false;
    $event_day = "";
    $event_link = "";

    $sql = "SELECT day, startTime, venue_link from tbl_events WHERE id = ?";
    foreach ($db->process_db($sql, "s", true, $event_id) as $event) {
        $eventTime = $event["startTime"];
        $event_link = $event["venue_link"];
        $event_day = $event["day"];
    }

    if(isset($_GET["id"])){
        $event_id = $_GET["id"];

        $eventDate = new DateTime($eventTime[0]["day"]);
        $currentDate = new DateTime(date("Y-m-d"));

        if($eventDate != $currentDate) {
            $flag = true;
        } 
    }

    if($flag){
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error 404</title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    </head>
    <style>
        html, body {
            height: 100%; 
            width: 100%; 
            overflow: hidden; 
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        .div-main {
            overflow: hidden; 
            height: 100%; 
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
    </style>
    <body>
        <div class="div-main">
            <img src="../../assets/img/error-join.svg">
            <h3 style="color: #323232; font-size: 24px; margin:0; margin-bottom: 10px">Oops, Sorry!</h3>
            <h6 style="margin: 0; font-size: 16px; text-align: center; font-weight: 500">This event is only available on <span style="color:#9C2B23"><?php echo date_format(date_create($event_day), "F d, Y") ?></span>,<br>starting 20 minutes before the event.</h6>
        </div>
    </body>
    </html>
<?php
    }
    else {
        $canJoin = false;
        $sql = "SELECT * FROM tbl_event_participants WHERE event_id = ? AND account_id = ?";
        foreach($db->process_db($sql,"ss", true, $event_id, $_SESSION["id"]) as $isParticipant){
            $canJoin = true;
        }

        $event_link = trim($event_link);
        if (strpos($event_link, 'http://') !== 0 && strpos($event_link, 'https://') !== 0) {
            $event_link = 'http://' . $event_link;
        }

        if($canJoin){
            echo "<script>window.location.href = '$event_link';</script>";
        }
        else {
?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Error 404</title>
                <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
            </head>
            <style>
                html, body {
                    height: 100%; 
                    width: 100%; 
                    overflow: hidden; 
                    margin: 0;
                    font-family: 'Poppins', sans-serif;
                }

                .div-main {
                    overflow: hidden; 
                    height: 100%; 
                    width: 100%;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                }
            </style>
            <body>
                <div class="div-main">
                    <img src="../../assets/img/error-join.svg">
                    <h3 style="color: #323232; font-size: 24px; margin:0; margin-bottom: 10px">Oops, Sorry!</h3>
                    <h6 style="margin: 0; font-size: 16px; text-align: center; font-weight: 500">You are not invited to this event.</h6>
                </div>
            </body>
            </html>
<?php
        }
    }
?>