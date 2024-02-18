<?php
session_start();
if (isset($_SESSION["faculty_role"])) {
    if ($_SESSION["faculty_role"] != "Administrator") {
        echo "Page not found!";
        exit();
    }
} else {
    echo "Page not found!";
    exit();
}
include_once '../../includes/database.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="../../assets/css/template.css" />
    <link rel="stylesheet" type="text/css" href="events.css" />
    <link rel="stylesheet" type="text/css" href="../dashboard/dashboard-modal.css" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <!-- Datatables -->
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <title>Center of Continuing Education</title>
    <link rel="icon" type="image/x-icon" href="../../assets/img/logo/cce-logo.png">
</head>

<body>
    <div class="sidebar panel h-100">
        <div class="admin-profile d-flex flex-column align-items-center justify-content-center">
            <div class="admin-pic">
                <img src="../../assets/img/home/personnel-img.jpg" alt="Admin Picture">
            </div>
            <h5><?php echo $_SESSION["firstname"] . " " . $_SESSION["lastname"] ?></h5>
            <h6 class="admin-title">Administrator</h6>
        </div>
        <div class="sidebar-links">
            <ul class="nav nav-pills nav-justified d-flex flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex flex-row justify-content-between" aria-current="page" href="../dashboard/dashboard.php">
                        <div class="icon-div d-flex flex-row">
                            <img src="../../assets/img/admin/icon-dashboard.svg" alt="Dashboard Logo" width="20">
                            <h6>Home</h6>
                        </div>
                        <img src="../../assets/img/admin/icon-right.svg" alt="Right" width="11" height="11">
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active d-flex flex-row justify-content-between" aria-current="page" href="#">
                        <div class="icon-div d-flex flex-row">
                            <img src="../../assets/img/admin/icon-events-active.svg" alt="Dashboard Logo" width="20">
                            <h6>Events</h6>
                        </div>
                        <img src="../../assets/img/admin/icon-right-active.svg" alt="Right" width="11" height="11">
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex flex-row justify-content-between" aria-current="page" href="../notifications/notifications.php">
                        <div class="icon-div d-flex flex-row">
                            <img src="../../assets/img/admin/icon-notification.svg" alt="Dashboard Logo" width="20">
                            <h6>Notifications</h6>
                            <?php
                            $getBadge = "SELECT COUNT(*) as TotalCount
							FROM (
								SELECT tbl_events.id
								FROM tbl_subscriptions
								INNER JOIN tbl_events ON tbl_events.id = tbl_subscriptions.event_id
								WHERE tbl_subscriptions.status = 3
								GROUP BY tbl_events.id
						
								UNION
						
								SELECT tbl_accounts.id
								FROM tbl_accounts
								INNER JOIN tbl_faculty_list ON tbl_faculty_list.abbreviation = tbl_accounts.faculty_role
								WHERE verified = 1 AND (faculty_role <> 'Organization' AND faculty_role <> 'Administrator')
							) AS combined_result;";
                            $badgeResult = $db->process_db($getBadge, "", true, "");
                            $badge = $badgeResult[0]['TotalCount'] ?? 0;

                            if ($badge != 0) {
                            ?>
                                <span class="badge ms-2 d-flex flex-row justify-content-center align-items-center" style="background-color: var(--red-1); color: white; margin-top: 12px; padding-top: 4px; border-radius: 3px; height:fit-content; font-size: 10px">
                                    <?php echo $badge;  ?>
                                </span>
                            <?php
                            }
                            ?>
                        </div>
                        <img src="../../assets/img/admin/icon-right.svg" alt="Right" width="11" height="11">
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex flex-row justify-content-between" aria-current="page" href="../organizations/organizations.php">
                        <div class="icon-div d-flex flex-row">
                            <img src="../../assets/img/admin/icon-org.svg" alt="Dashboard Logo" width="18">
                            <h6>Organizations</h6>
                        </div>
                        <img src="../../assets/img/admin/icon-right.svg" alt="Right" width="11" height="11">
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex flex-row justify-content-between" aria-current="page" href="../certificates/certificates.php">
                        <div class="icon-div d-flex flex-row">
                            <img src="../../assets/img/admin/icon-files.svg" alt="Dashboard Logo" width="19">
                            <h6>Certificates</h6>
                        </div>
                        <img src="../../assets/img/admin/icon-right.svg" alt="Right" width="11" height="11">
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex flex-row justify-content-between" aria-current="page" href="../settings/settings.php">
                        <div class="icon-div d-flex flex-row">
                            <img src="../../assets/img/admin/icon-settings.svg" alt="Dashboard Logo" width="20">
                            <h6>Settings</h6>
                        </div>
                        <img src="../../assets/img/admin/icon-right.svg" alt="Right" width="11" height="11">
                    </a>
                </li>
            </ul>
        </div>
        <a href="../../modules/accounts/logout.php" class="btn position-absolute bottom-0 start-0 ms-2 mb-2" style="width: fit-content;">
            <img src="../../assets/img/admin/logout.svg">
        </a>
    </div>
    <div class="content d-flex flex-column h-100 w-100">
        <div class="top-bar panel d-flex flex-row align-items-center justify-content-between">
            <h6>Good day, Claire! / Welcome to your personal <span>Events</span>!</h6>
            <button type="button" class="btn btn-primary topbar-btn" data-bs-toggle="modal" data-bs-target="#modal-createEvent"><i class="fa-solid fa-plus"></i></button>
        </div>
        <div class="main-wrapper d-flex h-100">
            <div class="main panel d-flex flex-column">
                <ul class="nav nav-tabs d-flex flex-row justify-content-center" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="events-tab" data-bs-toggle="tab" data-bs-target="#events-tab-pane" type="button" role="tab" aria-controls="events-tab-pane" aria-selected="true">All events</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history-tab-pane" type="button" role="tab" aria-controls="history-tab-pane" aria-selected="false">History</button>
                    </li>
                </ul>
                <div class="tab-content w-100 h-100" id="myTabContent">
                    <div class="tab-pane fade show active h-100 w-100" id="events-tab-pane" role="tabpanel" aria-labelledby="events-tab" tabindex="0">
                        <div class="label-div w-100 d-flex flex-row justify-content-between">
                            <label class="form-label">Upcoming <span>Events</span></label>
                        </div>
                        <div class="card-div d-flex flex-row flex-wrap" style="row-gap: 16px">
                            <?php
                            $upEventCount = 0;
                            $sql = "SELECT * FROM tbl_events WHERE day >= ? AND CONCAT(?, ' ', ?) <= CONCAT(day, ' ', endTime) AND status = '5' ORDER BY day ASC";
                            foreach ($db->process_db($sql, "sss", true, date("Y-m-d"), date("Y-m-d"), date('H:i:s')) as $upcoming_event) {
                                $upEventCount++;
                            ?>
                                <div class="card upcoming-card" style="width: 280px;">
                                    <div class="dropdown" style="position: absolute; right: 0;">
                                        <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-image: none !important;">
                                            <i style="color: white" class="fa-solid fa-gear"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" style="max-width: auto !important;">
                                            <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#historyModal<?php echo $upcoming_event["id"] ?>" style="font-size: 13px !important;">View Participants</a></li>
                                            <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#manage-option<?php echo $upcoming_event["id"] ?>" style="font-size: 13px !important;">Manage Event</a></li>
                                            <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#reason-resched-modal<?php echo $upcoming_event["id"] ?>" style="font-size: 13px !important;">Reschedule Event</a></li>
                                            <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#confirm-delete-modal<?php echo $upcoming_event["id"] ?>" style="font-size: 13px !important;">Delete Event</a></li>
                                        </ul>
                                    </div>
                                    <img <?php echo ($upcoming_event["attachment"] == NULL) ? 'src="../../assets/img/home/event-img-placeholder.svg"' : 'src="../../assets/attachments/events/' . $upcoming_event["attachment"] . '"' ?> class="card-img-top" alt="Event Image" height="150" width="258">
                                    <img src="../../assets/img/home/placeholder-bottom.svg" class="card-img-bottom" alt="Event Image">
                                    <button class="btn btn-primary join-btn" data-bs-toggle="modal" <?php echo ($upcoming_event["venue_type"] == "Set Location") ? 'data-bs-target="#set-location-modal' . $upcoming_event["id"] . '"' : 'data-bs-target="#other-platform-modal' . $upcoming_event["id"] . '"' ?>>Join Event</button>

                                    <div class="card-body d-flex flex-column align-items-center">
                                        <h6 class="card-title"><?php echo $upcoming_event["title"] ?></h6>
                                        <div class="details d-flex flex-row">
                                            <i class="fa-solid fa-location-dot"></i>
                                            <p class="details-text"><?php echo $upcoming_event["venue"] ?></p>
                                        </div>

                                        <div class="details d-flex flex-row">
                                            <i class="fa-regular fa-calendar-minus"></i>
                                            <p class="details-text"><?php echo date_format(date_create($upcoming_event["day"]), "F d, Y") ?></p>
                                        </div>

                                        <div class="details d-flex flex-row">
                                            <i class="fa-regular fa-clock" style="font-size: 11px; margin-top: 2px"></i>
                                            <p class="details-text"><?php echo date_format(date_create($upcoming_event["startTime"]), "h:i A") ?> - <?php echo date_format(date_create($upcoming_event["endTime"]), "h:i A") ?></p>
                                        </div>
                                    </div>

                                    <div class="card-footer d-flex flex-row justify-content-between">
                                        <p>View event information here</p>
                                        <div class="event-link d-flex justify-content-center align-items-center">
                                            <a class="fa-solid fa-link" data-bs-toggle="modal" data-bs-target="#all-event-modal<?php echo $upcoming_event["id"] ?>"></a>
                                        </div>
                                    </div>
                                </div>

                                <!-- All Events Modals -->
                                <div class="modal fade all-event-modal view" id="all-event-modal<?php echo $upcoming_event["id"] ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="modal-top-img w-100 d-flex flex-row justify-content-center align-items-end">
                                                    <img src="../../assets/img/admin/event-modal-icon.svg" width="40%">
                                                </div>
                                                <div class="all-event-wrapper w-100 d-flex flex-column">
                                                    <h5><span>Hello! You are invited to an Event!</span></h5>
                                                    <div class="all-event-content w-100 d-flex flex-column">
                                                        <div class="text-div event-title w-100 d-flex flex-row">
                                                            <div class="title-text">
                                                                <h6>Event Title: </h6>
                                                            </div>
                                                            <div class="input-text">
                                                                <h6><?php echo $upcoming_event["title"] ?></h6>
                                                            </div>
                                                        </div>
                                                        <div class="text-div date-time w-100 d-flex flex-column">
                                                            <div class="when w-100 d-flex flex-row">
                                                                <div class="title-text">
                                                                    <h6>When: </h6>
                                                                </div>
                                                                <div class="date-text d-flex flex-column" style="margin-left: 2px;">
                                                                    <h6>Date: </h6>
                                                                    <h6><?php echo date_format(date_create($upcoming_event["day"]), "F d, Y") ?></h6>
                                                                </div>
                                                                <div class="time-text d-flex flex-column">
                                                                    <h6>Time: </h6>
                                                                    <h6><?php echo date_format(date_create($upcoming_event["startTime"]), "h:i A") ?> - <?php echo date_format(date_create($upcoming_event["endTime"]), "h:i A") ?></h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-div location w-100 d-flex flex-row">
                                                            <div class="title-text">
                                                                <h6>Where: </h6>
                                                            </div>
                                                            <div class="input-text">
                                                                <h6><?php echo $upcoming_event["venue"] ?></h6>
                                                            </div>
                                                        </div>
                                                        <div class="text-div guest w-100 d-flex flex-row">
                                                            <div class="title-text">
                                                                <h6>Speakers: </h6>
                                                            </div>
                                                            <div class="input-text">
                                                                <h6>
                                                                    <?php
                                                                    $speakers = $db->process_db("SELECT ta.firstname, ta.lastname, tep.role 
                                                                                                FROM tbl_event_participants tep 
                                                                                                INNER JOIN tbl_accounts ta ON ta.id = tep.account_id
                                                                                                WHERE tep.event_id = ? AND tep.role = 'Speaker'", "s", true, $upcoming_event["id"]);

                                                                    $numberOfSpeakers = count($speakers);
                                                                    if ($numberOfSpeakers > 0) {
                                                                        foreach ($speakers as $key => $speaker) {
                                                                            echo $speaker["firstname"] . " " . $speaker["lastname"];

                                                                            // Add a comma if it's not the last iteration
                                                                            if ($key < $numberOfSpeakers - 1) {
                                                                                echo ", ";
                                                                            } else {
                                                                                // Add a period if it's the last iteration
                                                                                echo ".";
                                                                            }
                                                                        }
                                                                    } else {
                                                                        echo "None.";
                                                                    }


                                                                    ?>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                        <div class="text-div certificates w-100 d-flex flex-row">
                                                            <div class="title-text">
                                                                <h6>Certificates: </h6>
                                                                <a data-bs-toggle="modal" data-bs-target="#certificate-modal" href="#">Conditions required</a>
                                                            </div>
                                                            <div class="input-text">
                                                                <?php
                                                                $certcount = 0;
                                                                $sql2 = "SELECT * FROM tbl_certificates WHERE event_id = ?";
                                                                foreach ($db->process_db($sql2, "s", true, $upcoming_event["id"]) as $certs) {
                                                                    $certcount++;
                                                                ?>
                                                                    <h6><?php echo $certs["certificate_name"] ?></h6><br>
                                                                <?php
                                                                }

                                                                if ($certcount == 0) {
                                                                    echo "<h6>None</h6>";
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="text-div location w-100 d-flex flex-row">
                                                            <div class="title-text">
                                                                <h6>Description: </h6>
                                                            </div>
                                                            <div class="input-text">
                                                                <h6 style="white-space: pre-line; text-align: justify"><?php echo $upcoming_event["description"] ?></h6>
                                                            </div>
                                                        </div>
                                                        <div class="text-div agenda w-100 d-flex flex-row">
                                                            <div class="title-text">
                                                                <h6>Agenda: </h6>
                                                            </div>
                                                            <div class="input-text">
                                                                <h6 style="white-space: pre-line; text-align: justify"><?php echo $upcoming_event["agenda"] ?></h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade all-event-modal" id="other-platform-modal<?php echo $upcoming_event["id"] ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="modal-top-img w-100 d-flex flex-row justify-content-center align-items-end">
                                                    <img src="../../assets/img/admin/event-modal-icon.svg" width="45%">
                                                </div>
                                                <div class="all-event-wrapper w-100 d-flex flex-column">
                                                    <div class="all-event-content w-100 d-flex flex-row justify-content-center">
                                                        <h6 style="width: 70%; text-align: center; font-size: 1rem">If you click confirm, we will take you to the <span style="color: var(--red-1)"><?php echo $upcoming_event["venue"] ?></span> where the event is hosted.</h6>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-row justify-content-center gap-2 pb-4">
                                                    <button type="button" class="btn btn-primary cancel-modal-btn" data-bs-dismiss="modal">Cancel</button>
                                                    <form method="POST" action="../events/event-join.php" target="_blank">
                                                        <input hidden name="event-id" value="<?php echo $upcoming_event["id"] ?>">
                                                        <input hidden name="event-day" value="<?php echo $upcoming_event["day"] ?>">
                                                        <input hidden name="event-link" value="<?php echo $upcoming_event["venue_link"] ?>">
                                                        <button type="submit" name="submit" class="btn btn-primary next-modal-btn">Confirm</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade all-event-modal" id="set-location-modal<?php echo $upcoming_event["id"] ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="modal-top-img w-100 d-flex flex-row justify-content-center align-items-end">
                                                    <img src="../../assets/img/admin/event-modal-icon.svg" width="45%">
                                                </div>
                                                <div class="all-event-wrapper w-100 d-flex flex-column">
                                                    <div class="all-event-content w-100 d-flex flex-row justify-content-center">
                                                        <h6 style="width: 85%; text-align: center; font-size: 1rem">This event will be hosted at <span style="color: var(--red-1)"><?php echo $upcoming_event["venue"] ?></span>.<br><br>Please arrive to the designated location 15 minutes before the event on <span style="color: var(--red-1)"><?php echo date_format(date_create($upcoming_event["day"]), "F d, Y") ?></span>, at <span style="color: var(--red-1)"><?php echo date_format(date_create($upcoming_event["startTime"]), "h:i A") ?></span>.</h6>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-row justify-content-center gap-2 pb-4">

                                                    <button type="button" class="btn btn-primary next-modal-btn" data-bs-dismiss="modal">Ok, Noted!</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade all-event-modal" id="confirm-delete-modal<?php echo $upcoming_event["id"] ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="modal-top-img w-100 d-flex flex-row justify-content-center align-items-end">
                                                    <img src="../../assets/img/admin/event-modal-icon.svg" width="45%">
                                                </div>
                                                <div class="all-event-wrapper w-100 d-flex flex-column">
                                                    <div class="all-event-content w-100 d-flex flex-row justify-content-center">
                                                        <h6 style="width: 70%; text-align: center; font-size: 1rem">Are you sure you want to delete?</h6>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-row justify-content-center gap-2 pb-4">
                                                    <button type="button" class="btn btn-primary cancel-modal-btn" data-bs-dismiss="modal">Cancel</button>
                                                    <form method="POST" action="../../modules/events/delete_event.php">
                                                        <input hidden name="event-id" value="<?php echo $upcoming_event["id"] ?>">
                                                        <button type="submit" name="submit" class="btn btn-primary next-modal-btn">Confirm</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade all-event-modal" id="add-slots-modal<?php echo $upcoming_event["id"] ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 400px !important;">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <form method="POST" action="../../modules/events/add_slots.php" id="add-slots-form<?php echo $upcoming_event["id"] ?>">
                                                    <div class="all-event-wrapper w-100 d-flex flex-column">
                                                        <div class="all-event-content w-100 d-flex flex-column align-items-center justify-content-center">
                                                            <h6 style="width: 70%; text-align: center; font-size: 1rem">Add More Slots</h6>

                                                            <div class="d-flex flex-row justify-content-between w-100 mt-3">
                                                                <h6>Remaining Slots: <?php echo $upcoming_event["slots_remaining"] ?></h6>
                                                                <h6>Total Slots: <?php echo $upcoming_event["slots"] ?></h6>
                                                            </div>
                                                            <div class="input w-100 mt-2">
                                                                <input type="number" min="1" name="slots" class="form-control" placeholder="Slots to Add" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-row justify-content-center gap-2 pb-3">
                                                        <button type="button" class="btn btn-primary cancel-modal-btn" data-bs-target="#historyModal<?php echo $upcoming_event["id"] ?>" data-bs-toggle="modal">Cancel</button>

                                                        <input hidden name="event-id" value="<?php echo $upcoming_event["id"] ?>">
                                                        <button type="submit" name="submit" class="btn btn-primary next-modal-btn">Confirm</button>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade historyModal" id="historyModal<?php echo $upcoming_event["id"] ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">People who joined the <span>“<?php echo $upcoming_event["title"] ?>”</span></h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body d-flex flex-column" style="position: relative;">
                                                <div class="search-bar-div w-100">
                                                    <i class="fa-solid fa-magnifying-glass"></i>
                                                    <input class="form-control" placeholder="Search people">
                                                </div>
                                                <div class="w-100 d-flex justify-content-end">
                                                    <h6>Remaining Slots: <?php echo $upcoming_event["slots_remaining"] ?></h6>
                                                </div>
                                                <div class="table-wrapper">
                                                    <table id="participant-invited-table" class="table" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <p>Name</p>
                                                                </th>
                                                                <th>
                                                                    <p>Type</p>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $sql2 = "SELECT tbl_event_participants.*, tbl_accounts.firstname, tbl_accounts.lastname FROM tbl_event_participants INNER JOIN tbl_accounts ON tbl_accounts.id = tbl_event_participants.account_id WHERE tbl_event_participants.event_id = ? AND tbl_event_participants.role = 'Participant'";
                                                            foreach ($db->process_db($sql2, "s", true, $upcoming_event["id"]) as $participant) {
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $participant["firstname"] . " " . $participant["lastname"] ?></td>
                                                                    <td><?php echo $participant["type"] ?></td>
                                                                </tr>
                                                            <?php
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="w-100 d-flex flex-row justify-content-end">
                                                    <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#add-slots-modal<?php echo $upcoming_event["id"] ?>" style="border-radius: 2px; font-size: 14px; color:#5E5A5A; background-color: transparent !important; border: 1px #BFBFBF solid !important;">Add More Slots</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade all-event-modal reason-resched" id="reason-resched-modal<?php echo $upcoming_event["id"] ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="modal-top-img w-100 d-flex flex-row justify-content-center align-items-end">
                                                    <img src="../../assets/img/admin/event-modal-icon.svg" width="45%">
                                                </div>
                                                <div class="content-wrapper">
                                                    <h6><span>Why are you rejecting this<br>application?</span></h6>
                                                    <select class="form-select reason-select" name="resched-reason" form="resched-form<?php echo $upcoming_event["id"] ?>" required>
                                                        <option selected value="Current date is not available">Current date is not available</option>
                                                        <option value="Venue is not available">Venue is not available</option>
                                                        <option value="Weather condition">Weather condition</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                    <div class="explain-div">
                                                        <label for="exampleFormControlTextarea1" class="form-label">(Optional)</label>
                                                        <textarea class="form-control" name="resched-additional" id="exampleFormControlTextarea1" rows="3" form="resched-form<?php echo $upcoming_event["id"] ?>"></textarea>
                                                    </div>
                                                </div>
                                                <div class="btn-div d-flex flex-row justify-content-center">
                                                    <button class="btn btn-primary back-btn" data-bs-dismiss="modal">Back</button>
                                                    <button class="btn btn-primary submit-btn" data-bs-toggle="modal" data-bs-target="#resched-modal<?php echo $upcoming_event["id"] ?>" style="color: white; font-weight: 400">Next</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade create-event-one" id="resched-modal<?php echo $upcoming_event["id"] ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title" id="exampleModalLabel">RESCHEDULE EVENT</h1>
                                            </div>
                                            <div class="modal-body">
                                                <form action="../../modules/events/reschedule_event.php" method="POST" id="resched-form<?php echo $upcoming_event["id"] ?>">
                                                    <input name="event-id" value="<?php echo $upcoming_event["id"] ?>" hidden>
                                                    <div class="more-info-div d-flex flex-row justify-content-between">
                                                        <div class="input day">
                                                            <label class="form-label">DAY</label>
                                                            <input type="date" class="form-control" name="resched-day" min="<?php echo date('Y-m-d', strtotime('+1 day')) ?>" value="<?php echo $upcoming_event["day"] ?>" required>
                                                        </div>
                                                        <div class="input hour">
                                                            <label class="form-label">START TIME</label>
                                                            <input type="time" class="form-control" name="resched-startTime" value="<?php echo $upcoming_event["startTime"] ?>" required>
                                                        </div>
                                                        <div class="input minute">
                                                            <label class="form-label">END TIME</label>
                                                            <input type="time" class="form-control" name="resched-endTime" value="<?php echo $upcoming_event["endTime"] ?>" required>
                                                        </div>
                                                        <div class="input slots">
                                                            <label class="form-label">SLOTS</label>
                                                            <input type="number" class="form-control" name="resched-slots" value="<?php echo $upcoming_event["slots"] ?>" min="<?php echo $upcoming_event["slots"] ?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="venue-reminder-wrapper mt-3 d-flex flex-row w-100 gap-4">
                                                        <div class="venue" style="width: 97%;">
                                                            <label class="form-label">VENUE</label>
                                                            <div class="d-flex flex-row">
                                                                <div class="input input-group d-flex flex-row">
                                                                    <input class="form-control flex-grow-1" list="datalistOptions" id="resched-set-location-select<?php echo $upcoming_event["id"] ?>" value="<?php echo $upcoming_event["venue_type"] === "Other Platform" ? $upcoming_event["venue_link"] : $upcoming_event["venue"] ?>" name="resched-venue" style="width: 31%; border-top-right-radius: 0 !important; border-bottom-right-radius: 0 !important" placeholder="Enter Location" required>
                                                                    <datalist id="datalistOptions">
                                                                        <option value="WMSU Gymnasium">
                                                                        <option value="WMSU Covered Court">
                                                                        <option value="CCE Building">
                                                                    </datalist>
                                                                    <input type="text" class="form-control flex-grow-1" name="resched-venue" id="resched-other-platform-select<?php echo $upcoming_event["id"] ?>" placeholder="Enter Link" style="width: 31%; border-top-right-radius: 0 !important; border-bottom-right-radius: 0 !important" required hidden disabled>
                                                                    <select class="form-select flex-grow-1" id="venue-select<?php echo $upcoming_event['id'] ?>" onchange="setLocation(<?php echo $upcoming_event['id'] ?>)" name="resched-venuetype" style="border-top-left-radius: 0 !important; border-bottom-left-radius: 0 !important" required>
                                                                        <option value="Set Location" <?php echo $upcoming_event["venue_type"] === "Set Location" ? "selected" : "" ?>>Physical</option>
                                                                        <option value="Other Platform" <?php echo $upcoming_event["venue_type"] === "Other Platform" ? "selected" : "" ?>>Virtual</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="reminder" style="width: 78%;">
                                                            <label class="form-label">REMINDER</label>
                                                            <select class="form-select" name="resched-reminder">
                                                                <option value="15mins" <?php echo $upcoming_event["reminder"] === "15mins" ? "selected" : "" ?>>15 minutes
                                                                    before
                                                                    the event</option>
                                                                <option value="30mins" <?php echo $upcoming_event["reminder"] === "30mins" ? "selected" : "" ?>>30 minutes
                                                                    before
                                                                    the event</option>
                                                                <option value="1hour" <?php echo $upcoming_event["reminder"] === "1hour" ? "selected" : "" ?>>1 hour before
                                                                    the
                                                                    event</option>
                                                                <option value="2hours" <?php echo $upcoming_event["reminder"] === "2hours" ? "selected" : "" ?>>2 hours before
                                                                    the
                                                                    event</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-row justify-content-center  gap-2 step-4-footer">
                                                        <button type="button" class="btn btn-primary back-modal-btn" data-bs-toggle="modal" data-bs-target="#reason-resched-modal<?php echo $upcoming_event["id"] ?>">Back</button>
                                                        <button type="submit" name="submit" class="btn btn-primary create-modal-btn">Confirm</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php include('../manage-event-modal.php') ?>

                                <!-- <script>
									$(document).ready(function() {
										var agendaContent = <?php echo json_encode($upcoming_event["agenda"]); ?>;
										var quillEdit<?php echo $upcoming_event["id"] ?> = new Quill('#edit-editor<?php echo $upcoming_event["id"] ?>', {
											theme: 'snow'
										});

										var delta = quillEdit<?php echo $upcoming_event["id"] ?>.clipboard.convert(agendaContent);
										quillEdit<?php echo $upcoming_event["id"] ?>.setContents(delta);
									});
								</script> -->


                            <?php
                            }

                            if ($upEventCount <= 0) {
                            ?>
                                <div class="w-100 d-flex flex-column justify-content-center align-items-center">
                                    <img src="../../assets/img/faculty/upcoming-empty-icon.svg" height="245px">

                                    <div class="empty-event-text">
                                        <h5>It's Empty!</h5>
                                        <h6>Hmm.. looks like you don't have<br>any upcoming events</h6>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="modal fade certificate-modal" id="certificate-modal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="modal-top-img w-100 d-flex flex-row justify-content-center align-items-end">
                                            <img src="../../assets/img/admin/event-modal-icon.svg" width="45%">
                                        </div>
                                        <div class="certificate-wrapper w-100 d-flex flex-column align-items-center">
                                            <h5><span>Certificate Conditions</span></h5>
                                            <div class="input-text instructions">
                                                <h6>To be able to receive your certificate you are<br>required to finish this steps:</h6>
                                            </div>
                                            <div class="certificate-content w-100 d-flex flex-column">
                                                <h6><span>STEP 1:</span></h6>
                                                <div class="text-div step-1 w-100 d-flex flex-row">
                                                    <div class="title-text">
                                                        <h6>Join the Event </h6>
                                                    </div>
                                                    <div class="input-text">
                                                        <h6>Upon joining the event, you will be registered successfully.</h6>
                                                    </div>
                                                </div>
                                                <h6><span>STEP 2:</span></h6>
                                                <div class="text-div step-2 w-100 d-flex flex-row">
                                                    <div class="title-text">
                                                        <h6>Finish the Assessment </h6>
                                                    </div>
                                                    <div class="input-text">
                                                        <h6>Please note that completing all the given questions is mandatory for this assessment. Failure to do so will require you to rewatch the video. You are allowed to take the assessment multiple times.</h6>
                                                    </div>
                                                </div>
                                                <h6><span>STEP 3:</span></h6>
                                                <div class="text-div step-3 w-100 d-flex flex-row">
                                                    <div class="title-text">
                                                        <h6>Give Feedback </h6>
                                                    </div>
                                                    <div class="input-text">
                                                        <h6>After providing feedback, you are now eligible to receive the certificate. </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-nav-div w-100">

                        </div>

                        <div class="label-div w-100 d-flex flex-row justify-content-between">
                            <label class="form-label">General <span>Events</span></label>

                        </div>
                        <div class="general-events d-flex flex-row flex-wrap mb-4">
                            <div class="card general-card" style="max-width: 280px;">
                                <img src="../../assets/img/home/general-events/Newly Hired Faculty (Final).jpg" class="card-img-top" alt="Event Image" height="160px">
                                <div class="card-body">
                                    <div class="event-date-time d-flex flex-row">
                                        <div class="event-date d-flex flex-row">
                                            <i class="fa-regular fa-calendar-minus"></i>
                                            <p class="details-text">30th August, 2023</p>
                                        </div>
                                        <div class="date-time-divider"></div>
                                        <div class="event-time d-flex flex-row">
                                            <i class="fa-regular fa-clock"></i>
                                            <p class="details-text">08:00 am - 05:30 pm</p>
                                        </div>
                                    </div>

                                    <div class="title-location d-flex flex-column">
                                        <h6 class="card-title" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">Onboarding Seminar for Newly Hired Faculty</h6>
                                        <div class="event-location d-flex flex-row">
                                            <i class="fa-solid fa-location-dot"></i>
                                            <p class="details-text">College of Engineering, AVR</p>
                                        </div>
                                    </div>

                                    <a href="#">More details...</a>
                                </div>
                            </div>
                            <div class="card general-card" style="max-width: 280px;">
                                <img src="../../assets/img/home/general-events/Tarpaulin 6x8.jpg" class="card-img-top" alt="Event Image" height="160px">
                                <div class="card-body">
                                    <div class="event-date-time d-flex flex-row">
                                        <div class="event-date d-flex flex-row">
                                            <i class="fa-regular fa-calendar-minus"></i>
                                            <p class="details-text">15th September, 2023</p>
                                        </div>
                                        <div class="date-time-divider"></div>
                                        <div class="event-time d-flex flex-row">
                                            <i class="fa-regular fa-clock"></i>
                                            <p class="details-text">08:00 am - 12:00 pm</p>
                                        </div>
                                    </div>

                                    <div class="title-location d-flex flex-column">
                                        <h6 class="card-title" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">Onboarding Seminar for Newly Hired Administrative Personnel</h6>
                                        <div class="event-location d-flex flex-row">
                                            <i class="fa-solid fa-location-dot"></i>
                                            <p class="details-text">College of Home Economics, Function Room</p>
                                        </div>
                                    </div>

                                    <a href="#">More details...</a>
                                </div>
                            </div>
                            <div class="card general-card" style="max-width: 280px;">
                                <img src="../../assets/img/home/general-events/Tarpaulin.png" class="card-img-top" alt="Event Image" height="160px">
                                <div class="card-body">
                                    <div class="event-date-time d-flex flex-row">
                                        <div class="event-date d-flex flex-row">
                                            <i class="fa-regular fa-calendar-minus"></i>
                                            <p class="details-text">18th July, 2023</p>
                                        </div>
                                        <div class="date-time-divider"></div>
                                        <div class="event-time d-flex flex-row">
                                            <i class="fa-regular fa-clock"></i>
                                            <p class="details-text">08:00 am - 05:00 pm</p>
                                        </div>
                                    </div>

                                    <div class="title-location d-flex flex-column">
                                        <h6 class="card-title" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">El Primer Ayuda: A First Aid Training for the WMSU Community</h6>
                                        <div class="event-location d-flex flex-row">
                                            <i class="fa-solid fa-location-dot"></i>
                                            <p class="details-text">WMSU Training Center</p>
                                        </div>
                                    </div>

                                    <a href="#">More details...</a>
                                </div>
                            </div>
                            <div class="card general-card" style="max-width: 280px;">
                                <img src="../../assets/img/home/general-events/PROGRAM VIRTUAL2.png" class="card-img-top" alt="Event Image" height="160px">
                                <div class="card-body">
                                    <div class="event-date-time d-flex flex-row">
                                        <div class="event-date d-flex flex-row">
                                            <i class="fa-regular fa-calendar-minus"></i>
                                            <p class="details-text">29th June, 2021</p>
                                        </div>
                                        <div class="date-time-divider"></div>
                                        <div class="event-time d-flex flex-row">
                                            <i class="fa-regular fa-clock"></i>
                                            <p class="details-text">08:00 am - 12:00 pm</p>
                                        </div>
                                    </div>

                                    <div class="title-location d-flex flex-column">
                                        <h6 class="card-title" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">Webinar on Health and Safety Guidelines in Workplace</h6>
                                        <div class="event-location d-flex flex-row">
                                            <i class="fa-solid fa-location-dot"></i>
                                            <p class="details-text">Somewhere, Philippines</p>
                                        </div>
                                    </div>

                                    <a href="#">More details...</a>
                                </div>
                            </div>
                            <div class="card general-card" style="max-width: 280px;">
                                <img src="../../assets/img/home/general-events/PROGRAM VIRTUAL1.png" class="card-img-top" alt="Event Image" height="160px">
                                <div class="card-body">
                                    <div class="event-date-time d-flex flex-row">
                                        <div class="event-date d-flex flex-row">
                                            <i class="fa-regular fa-calendar-minus"></i>
                                            <p class="details-text">24th April, 2021</p>
                                        </div>
                                        <div class="date-time-divider"></div>
                                        <div class="event-time d-flex flex-row">
                                            <i class="fa-regular fa-clock"></i>
                                            <p class="details-text">08:00 am - 05:00 pm</p>
                                        </div>
                                    </div>

                                    <div class="title-location d-flex flex-column">
                                        <h6 class="card-title" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">Webinar on Parenting for Home Learning During the COVID-19 Pandemic</h6>
                                        <div class="event-location d-flex flex-row">
                                            <i class="fa-solid fa-location-dot"></i>
                                            <p class="details-text">Somewhere, Philippines</p>
                                        </div>
                                    </div>

                                    <a href="#">More details...</a>
                                </div>
                            </div>
                            <div class="card general-card" style="max-width: 280px;">
                                <img src="../../assets/img/home/general-events/Moodle Virtual Layout.png" class="card-img-top" alt="Event Image" height="160px">
                                <div class="card-body">
                                    <div class="event-date-time d-flex flex-row">
                                        <div class="event-date d-flex flex-row">
                                            <i class="fa-regular fa-calendar-minus"></i>
                                            <p class="details-text">13th March, 2023</p>
                                        </div>
                                        <div class="date-time-divider"></div>
                                        <div class="event-time d-flex flex-row">
                                            <i class="fa-regular fa-clock"></i>
                                            <p class="details-text">08:00 am - 12:30 pm</p>
                                        </div>
                                    </div>

                                    <div class="title-location d-flex flex-column">
                                        <h6 class="card-title" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">Customized LMS Moodle Platform</h6>
                                        <div class="event-location d-flex flex-row">
                                            <i class="fa-solid fa-location-dot"></i>
                                            <p class="details-text">Somewhere, Philippines</p>
                                        </div>
                                    </div>

                                    <a href="#">More details...</a>
                                </div>
                            </div>
                            <div class="card general-card" style="max-width: 280px;">
                                <img src="../../assets/img/home/event-img-placeholder.svg" class="card-img-top" alt="Event Image" height="160px">
                                <div class="card-body">
                                    <div class="event-date-time d-flex flex-row">
                                        <div class="event-date d-flex flex-row">
                                            <i class="fa-regular fa-calendar-minus"></i>
                                            <p class="details-text">17th July, 2023</p>
                                        </div>
                                        <div class="date-time-divider"></div>
                                        <div class="event-time d-flex flex-row">
                                            <i class="fa-regular fa-clock"></i>
                                            <p class="details-text">10:00 - 11:30 am</p>
                                        </div>
                                    </div>

                                    <div class="title-location d-flex flex-column">
                                        <h6 class="card-title" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">International Jazz Festival </h6>
                                        <div class="event-location d-flex flex-row">
                                            <i class="fa-solid fa-location-dot"></i>
                                            <p class="details-text">Somewhere, Philippines</p>
                                        </div>
                                    </div>

                                    <a href="#">More details...</a>
                                </div>
                            </div>
                            <div class="card general-card" style="max-width: 280px;">
                                <img src="../../assets/img/home/event-img-placeholder.svg" class="card-img-top" alt="Event Image" height="160px">
                                <div class="card-body">
                                    <div class="event-date-time d-flex flex-row">
                                        <div class="event-date d-flex flex-row">
                                            <i class="fa-regular fa-calendar-minus"></i>
                                            <p class="details-text">17th July, 2023</p>
                                        </div>
                                        <div class="date-time-divider"></div>
                                        <div class="event-time d-flex flex-row">
                                            <i class="fa-regular fa-clock"></i>
                                            <p class="details-text">10:00 - 11:30 am</p>
                                        </div>
                                    </div>

                                    <div class="title-location d-flex flex-column">
                                        <h6 class="card-title" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">International Jazz Festival </h6>
                                        <div class="event-location d-flex flex-row">
                                            <i class="fa-solid fa-location-dot"></i>
                                            <p class="details-text">Somewhere, Philippines</p>
                                        </div>
                                    </div>

                                    <a href="#">More details...</a>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="tab-pane fade d-flex flex-column h-100 w-100" id="history-tab-pane" role="tabpanel" aria-labelledby="history-tab" tabindex="0">
                        <div class="search-bar-div w-100">
                            <input class="form-control" placeholder="Search title">
                        </div>
                        <div class="table-wrapper h-100 w-100">
                            <table id="myTable" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <p>Title</p>
                                        </th>
                                        <th>
                                            <p>Date</p>
                                        </th>
                                        <th>
                                            <p>People Subscribed</p>
                                        </th>
                                        <th>
                                            <p>Certificate Sent</p>
                                        </th>
                                        <th>
                                            <p></p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT 
									tbl_events.*,
									COALESCE(SUM(CASE WHEN tbl_event_participants.certificate_sent = 1 THEN 1 ELSE 0 END), 0) AS certificate_sent,
									COALESCE(SUM(CASE WHEN tbl_event_participants.certificate_sent = 0 THEN 1 ELSE 0 END), 0) AS pending,
									COALESCE(SUM(CASE WHEN tbl_event_participants.type = 'Invited' THEN 1 ELSE 0 END), 0) AS invited_count,
									COALESCE(SUM(CASE WHEN tbl_event_participants.type = 'Subscribed' THEN 1 ELSE 0 END), 0) AS subscribed_count
									FROM tbl_events
									LEFT JOIN tbl_event_participants ON tbl_event_participants.event_id = tbl_events.id
									WHERE tbl_events.status = 5 AND day < ?
									GROUP BY tbl_events.id
									ORDER BY day ASC;";
                                    foreach ($db->process_db($sql, "s", true, date("Y-m-d")) as $past_event) {
                                    ?>
                                        <tr>
                                            <td style="max-width: 240px; white-space:nowrap; text-overflow:ellipsis; overflow:hidden"><?php echo $past_event["title"] ?></td>
                                            <td><?php echo date_format(date_create($past_event["day"]), "F d, Y") ?></td>
                                            <td>
                                                <i class="fa-solid fa-user"></i>
                                                <?php echo $past_event["subscribed_count"] ?>
                                            </td>
                                            <td>
                                                <i class="fa-solid fa-user"></i>
                                                <?php echo $past_event["certificate_sent"] ?>
                                            </td>
                                            <td>
                                                <button data-bs-toggle="modal" data-bs-target="#feedback-modal<?php echo $past_event["id"] ?>" class="btn primary-btn view-assessment-btn">
                                                    <i class="fa-solid fa-eye"></i>
                                                    View Feedback Reports
                                                </button>
                                                <a data-bs-toggle="modal" data-bs-target="#historyModal<?php echo $past_event["id"] ?>"><i class="fa-solid fa-users-line"></i></a>
                                            </td>
                                        </tr>



                                        <div class="modal fade feedback" id="feedback-modal<?php echo $past_event["id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" style="border-radius: 2px !important;">
                                                <div class="modal-content" style="border-radius: 2px !important;">
                                                    <div class="modal-header px-4" style="background-color: #F1F1F1;">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel" style="font-weight: 700; color: #5E5A5A;">Feedback Reports</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body d-flex flex-column px-4 py-4 pb-4 gap-2">
                                                        <h4 style="font-weight: 600;"><?php echo $past_event["title"] ?></h4>

                                                        <?php
                                                        $F1_total = 0;
                                                        $F2_total = 0;
                                                        $F3A_total = 0;
                                                        $F3B_total = 0;
                                                        $F3C_total = 0;
                                                        $F4A_total = 0;
                                                        $F4B_total = 0;
                                                        $F4C_total = 0;
                                                        $F5_total = 0;
                                                        $totalRating = 0.0;
                                                        $commentCount = 0;

                                                        $sql = "SELECT 
                                                                    event_id,
                                                                    label,
                                                                    SUM(CASE WHEN rating = 1 THEN 1 ELSE 0 END) as 1star_count,
                                                                    SUM(CASE WHEN rating = 2 THEN 1 ELSE 0 END) as 2star_count,
                                                                    SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) as 3star_count,
                                                                    SUM(CASE WHEN rating = 4 THEN 1 ELSE 0 END) as 4star_count,
                                                                    SUM(CASE WHEN rating = 5 THEN 1 ELSE 0 END) as 5star_count,
                                                                    SUM(CASE WHEN additional IS NOT NULL THEN 1 ELSE 0 END) as comment_count,
                                                                    COUNT(*) as total_count
                                                                FROM
                                                                    tbl_ratings
                                                                WHERE
                                                                    event_id = ?
                                                                GROUP BY label";

                                                        foreach ($db->process_db($sql, "s", true, $past_event["id"]) as $ratings) {
                                                            $label = $ratings["label"];
                                                            $total_count = $ratings["total_count"];

                                                            // Calculate the average rating for each label
                                                            $average_rating = round(($ratings["1star_count"] * 1 + $ratings["2star_count"] * 2 + $ratings["3star_count"] * 3 + $ratings["4star_count"] * 4 + $ratings["5star_count"] * 5) / $total_count, 1);

                                                            switch ($label) {
                                                                case "ADD":
                                                                    $commentCount = $ratings["comment_count"];
                                                                    break;
                                                                case "F1":
                                                                    $F1_total = $average_rating;
                                                                    break;
                                                                case "F2":
                                                                    $F2_total = $average_rating;
                                                                    break;
                                                                case "F3A":
                                                                    $F3A_total = $average_rating;
                                                                    break;
                                                                case "F3B":
                                                                    $F3B_total = $average_rating;
                                                                    break;
                                                                case "F3C":
                                                                    $F3C_total = $average_rating;
                                                                    break;
                                                                case "F4A":
                                                                    $F4A_total = $average_rating;
                                                                    break;
                                                                case "F4B":
                                                                    $F4B_total = $average_rating;
                                                                    break;
                                                                case "F4C":
                                                                    $F4C_total = $average_rating;
                                                                    break;
                                                                case "F5":
                                                                    $F5_total = $average_rating;
                                                                    break;
                                                            }
                                                        }
                                                        ?>

                                                        <div class="total-rating-container align-items-center d-flex flex-column px-2">
                                                            <div class="rating-label w-100 d-flex flex-row justify-content-end py-2 gap-4" style="border-bottom: 1px #E0E4EC solid">
                                                                <h6>Poor</h6>
                                                                <h6>Fair</h6>
                                                                <h6>Good</h6>
                                                                <h6>Better</h6>
                                                                <h6>Best</h6>
                                                            </div>
                                                            <div id="feedback-one" class="w-100 d-flex flex-row py-3 justify-content-between align-items-center" style="border-bottom: 1px #E0E4EC solid">
                                                                <h6 class="m-0 px-1" style="color: #323232; font-weight: 600; width: 390px">1. OVERALL / GENERAL ASSESSMENT OF TRAINING</h6>
                                                                <div class="rating gap-4">
                                                                    <?php
                                                                    for ($i = 1; $i <= 5; $i++) {
                                                                        if ($i <= intval($F1_total)) {
                                                                    ?>
                                                                            <i class='fa-solid fa-star star highlight' style="--i: 0; margin-left: 6.5px; margin-right: 6.5px" data-i="1"></i>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <i class='fa-solid fa-star star no-highlight' style="--i: 1; margin-left: 6.5px; margin-right: 6.5px" data-i="2"></i>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <div id="feedback-two" class="w-100 d-flex flex-row py-3 justify-content-between align-items-center" style="border-bottom: 1px #E0E4EC solid">
                                                                <h6 class="m-0 px-1" style="color: #323232; font-weight: 600; width: 390px">2. TIMELINESS, UP-TO-DATE, & CURRENT TRENDS APPLIED</h6>
                                                                <div class="rating gap-4">
                                                                    <?php
                                                                    for ($i = 1; $i <= 5; $i++) {
                                                                        if ($i <= intval($F2_total)) {
                                                                    ?>
                                                                            <i class='fa-solid fa-star star highlight' style="--i: 0; margin-left: 6.5px; margin-right: 6.5px" data-i="1"></i>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <i class='fa-solid fa-star star no-highlight' style="--i: 1; margin-left: 6.5px; margin-right: 6.5px" data-i="2"></i>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <div class="w-100 d-flex flex-row py-3 justify-content-between align-items-center" style="border-bottom: 1px #E0E4EC solid">
                                                                <div class="m-0 w-100">
                                                                    <h6 class="m-0 px-1" style="width: 390px; color: #323232; font-weight: 600;">3. CONTENT</h6>
                                                                    <ul>
                                                                        <li class="my-3 d-flex flex-row justify-content-between align-items-center" id="feedback-three-a">
                                                                            <h6 class="m-0" style="padding-left: 1.2rem; font-weight: 400; width: 390px; ">a. Clarify of the topics presented</h6>
                                                                            <div class="rating gap-4">
                                                                                <?php
                                                                                for ($i = 1; $i <= 5; $i++) {
                                                                                    if ($i <= intval($F3A_total)) {
                                                                                ?>
                                                                                        <i class='fa-solid fa-star star highlight' style="--i: 0; margin-left: 6.5px; margin-right: 6.5px" data-i="1"></i>
                                                                                    <?php
                                                                                    } else {
                                                                                    ?>
                                                                                        <i class='fa-solid fa-star star no-highlight' style="--i: 1; margin-left: 6.5px; margin-right: 6.5px" data-i="2"></i>
                                                                                <?php
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </li>
                                                                        <li class="my-3 d-flex flex-row justify-content-between align-items-center" id="feedback-three-b">
                                                                            <h6 class="m-0" style="padding-left: 1.2rem; font-weight: 400; width: 390px; ">b. Comprehensiveness of the content</h6>
                                                                            <div class="rating gap-4">
                                                                                <?php
                                                                                for ($i = 1; $i <= 5; $i++) {
                                                                                    if ($i <= intval($F3B_total)) {
                                                                                ?>
                                                                                        <i class='fa-solid fa-star star highlight' style="--i: 0; margin-left: 6.5px; margin-right: 6.5px" data-i="1"></i>
                                                                                    <?php
                                                                                    } else {
                                                                                    ?>
                                                                                        <i class='fa-solid fa-star star no-highlight' style="--i: 1; margin-left: 6.5px; margin-right: 6.5px" data-i="2"></i>
                                                                                <?php
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </li>
                                                                        <li class="my-3 d-flex flex-row justify-content-between align-items-center" id="feedback-three-c">
                                                                            <h6 class="m-0" style="padding-left: 1.2rem; font-weight: 400; width: 390px; ">c. Applicability and relevance of the content to the needs of the participants</h6>
                                                                            <div class="rating gap-4">
                                                                                <?php
                                                                                for ($i = 1; $i <= 5; $i++) {
                                                                                    if ($i <= intval($F3C_total)) {
                                                                                ?>
                                                                                        <i class='fa-solid fa-star star highlight' style="--i: 0; margin-left: 6.5px; margin-right: 6.5px" data-i="1"></i>
                                                                                    <?php
                                                                                    } else {
                                                                                    ?>
                                                                                        <i class='fa-solid fa-star star no-highlight' style="--i: 1; margin-left: 6.5px; margin-right: 6.5px" data-i="2"></i>
                                                                                <?php
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                </div>

                                                            </div>
                                                            <div class="w-100 d-flex flex-row py-3 justify-content-between align-items-center" style="border-bottom: 1px #E0E4EC solid">
                                                                <div class="m-0 w-100">
                                                                    <h6 class="m-0 px-1" style="width: 390px; color: #323232; font-weight: 600;">4. MANAGEMENT TEAM</h6>
                                                                    <ul>
                                                                        <li class="my-3 d-flex flex-row justify-content-between align-items-center" id="feedback-four-a">
                                                                            <h6 class="m-0" style="padding-left: 1.2rem; font-weight: 400; width: 390px; ">a. Secretariat Support</h6>
                                                                            <div class="rating gap-4">
                                                                                <?php
                                                                                for ($i = 1; $i <= 5; $i++) {
                                                                                    if ($i <= intval($F4A_total)) {
                                                                                ?>
                                                                                        <i class='fa-solid fa-star star highlight' style="--i: 0; margin-left: 6.5px; margin-right: 6.5px" data-i="1"></i>
                                                                                    <?php
                                                                                    } else {
                                                                                    ?>
                                                                                        <i class='fa-solid fa-star star no-highlight' style="--i: 1; margin-left: 6.5px; margin-right: 6.5px" data-i="2"></i>
                                                                                <?php
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </li>
                                                                        <li class="my-3 d-flex flex-row justify-content-between align-items-center" id="feedback-four-b">
                                                                            <h6 class="m-0" style="padding-left: 1.2rem; font-weight: 400; width: 390px; ">b. Training Venue</h6>
                                                                            <div class="rating gap-4">
                                                                                <?php
                                                                                for ($i = 1; $i <= 5; $i++) {
                                                                                    if ($i <= intval($F4B_total)) {
                                                                                ?>
                                                                                        <i class='fa-solid fa-star star highlight' style="--i: 0; margin-left: 6.5px; margin-right: 6.5px" data-i="1"></i>
                                                                                    <?php
                                                                                    } else {
                                                                                    ?>
                                                                                        <i class='fa-solid fa-star star no-highlight' style="--i: 1; margin-left: 6.5px; margin-right: 6.5px" data-i="2"></i>
                                                                                <?php
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </li>
                                                                        <li class="my-3 d-flex flex-row justify-content-between align-items-center" id="feedback-four-c">
                                                                            <h6 class="m-0" style="padding-left: 1.2rem; font-weight: 400; width: 390px; ">c. Effectiveness of the training management</h6>
                                                                            <div class="rating gap-4">
                                                                                <?php
                                                                                for ($i = 1; $i <= 5; $i++) {
                                                                                    if ($i <= intval($F4C_total)) {
                                                                                ?>
                                                                                        <i class='fa-solid fa-star star highlight' style="--i: 0; margin-left: 6.5px; margin-right: 6.5px" data-i="1"></i>
                                                                                    <?php
                                                                                    } else {
                                                                                    ?>
                                                                                        <i class='fa-solid fa-star star no-highlight' style="--i: 1; margin-left: 6.5px; margin-right: 6.5px" data-i="2"></i>
                                                                                <?php
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                </div>

                                                            </div>
                                                            <div id="feedback-five" class="w-100 d-flex flex-row py-3 justify-content-between align-items-center" style="border-bottom: 1px #E0E4EC solid">
                                                                <h6 class="m-0 px-1" style="color: #323232; font-weight: 600; width: 390px">5. RESOURCES SPEAKERS</h6>
                                                                <input form="feedback-form<?php echo $pastJoinedEvents["id"] ?>" type="number" value="1" name="rating[]" hidden>
                                                                <div class="rating gap-4">
                                                                    <?php
                                                                    for ($i = 1; $i <= 5; $i++) {
                                                                        if ($i <= intval($F5_total)) {
                                                                    ?>
                                                                            <i class='fa-solid fa-star star highlight' style="--i: 0; margin-left: 6.5px; margin-right: 6.5px" data-i="1"></i>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <i class='fa-solid fa-star star no-highlight' style="--i: 1; margin-left: 6.5px; margin-right: 6.5px" data-i="2"></i>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="d-flex flex-column px-2 gap-2">
                                                            <?php
                                                            if (intval($commentCount) !== 0) {
                                                            ?>
                                                                <h6 class="m-0 my-2">Comments (<?php echo $commentCount ?>)</h6>
                                                            <?php
                                                            }
                                                            $sql = "SELECT
                                                                        tbl_accounts.firstname,
                                                                        tbl_accounts.lastname,
                                                                        tbl_ratings.additional,
                                                                        tbl_ratings.date
                                                                    FROM
                                                                        tbl_ratings
                                                                    INNER JOIN tbl_accounts ON tbl_accounts.id = tbl_ratings.account_id
                                                                    WHERE
                                                                        tbl_ratings.event_id = ? AND tbl_ratings.label = 'ADD' AND tbl_ratings.additional IS NOT NULL";
                                                            foreach ($db->process_db($sql, "s", true, $past_event["id"]) as $comment) {
                                                            ?>
                                                                <div class="d-flex flex-row ps-2">
                                                                    <div class="avatar-div d-flex flex-row flex-grow-1 h-100">
                                                                        <div class="avatar-wrapper">
                                                                            <img src="../../assets/img/admin/participant-img.png" alt="Avatar" width="36">
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex-grow-1 w-100 d-flex flex-column pt-1 gap-1 ms-2">
                                                                        <h6 class="m-0" style="font-weight: 600;"><?php echo $comment["firstname"] . " " . $comment["lastname"] ?></h6>
                                                                        <div class="d-flex flex-row gap-3">
                                                                            <h6 class="m-0" style="font-size: 12px;"><?php echo date("m/d/Y", strtotime($comment["date"])) ?></h6>
                                                                        </div>
                                                                        <h6 class="m-0" style="text-align: justify; font-size: 13px; font-weight: 400; line-height: 1.5rem"><?php echo $comment["additional"] ?></h6>
                                                                    </div>
                                                                </div>
                                                            <?php
                                                            }
                                                            ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <?php
                    $sql = "SELECT * FROM tbl_events WHERE day < ?";
                    foreach ($db->process_db($sql, "s", true, date("Y-m-d")) as $past_event) {
                    ?>
                        <div class="modal fade historyModal" id="historyModal<?php echo $past_event["id"] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Event Participants</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body d-flex flex-column">
                                        <div class="search-bar-div w-100">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                            <input class="form-control" placeholder="Search Participants">
                                        </div>
                                        <div class="table-wrapper">
                                            <table class="table" style="width:100%; margin-bottom: 1px !important">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <p class="my-1">Name</p>
                                                        </th>
                                                        <th>
                                                            <p class="my-1">Progress Report</p>
                                                        </th>
                                                        <th>
                                                            <p class="my-1">Type</p>
                                                        </th>
                                                        <th>
                                                            <p class="my-1">Details</p>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sql2 = "SELECT tbl_event_participants.*, tbl_accounts.firstname, tbl_accounts.lastname FROM tbl_event_participants INNER JOIN tbl_accounts ON tbl_accounts.id = tbl_event_participants.account_id WHERE event_id = ? AND role = 'Participant'";
                                                    foreach ($db->process_db($sql2, "s", true, $past_event["id"]) as $participant) {
                                                    ?>
                                                        <tr>
                                                            <td style="text-transform: capitalize;"><?php echo $participant["firstname"] . " " . $participant["lastname"] ?></td>
                                                            <td><?php echo $participant["status"] == 'Invited' ? "Step 1 In Progress" : $participant["status"] ?></td>
                                                            <td><?php echo $participant["type"] == 'Subscribed' ? "<span>Subscribed</span>" : $participant["type"] ?></td>
                                                            <td>
                                                                <?php echo $participant["attended"] == 1 ? '<i class="ms-4 fa-solid fa-user-check"></i>' : '<i class="ms-4 fa-solid fa-user-xmark"></i>' ?>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <?php include_once '../create-event-modal.php' ?>

        <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3">
            <div id="liveToast" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">

                <div class="d-flex">
                    <div class="toast-body" style="color: white;">

                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>

            </div>
        </div>
    </div>

    <script>
        function setLocation(id) {
            if ($('#venue-select' + id).val() == 'Other Platform') {
                $('#resched-set-location-select' + id).attr("disabled", "disabled");
                $('#resched-set-location-select' + id).attr("hidden", true);

                $("#resched-other-platform-select" + id).removeAttr("hidden");
                $("#resched-other-platform-select" + id).removeAttr("disabled");
            } else {
                $("#resched-other-platform-select" + id).attr("disabled", "disabled");
                $("#resched-other-platform-select" + id).attr("hidden", true);

                $('#resched-set-location-select' + id).removeAttr("hidden");
                $('#resched-set-location-select' + id).removeAttr("disabled");
            }
        }

        $(document).ready(function() {

            $('#myTable').DataTable({
                searching: false,
                language: {
                    info: 'Showing _START_ - _END_ of list'
                },
                scrollCollapse: true,
                scrollY: '400px',
                "language": {
                    "paginate": {
                        "previous": "<",
                        "next": ">"
                    }
                }
            });

            $('#history-modal-table').DataTable({
                searching: false,
                scrollCollapse: true,
                scrollY: '442px',
                paging: false,
                bInfo: false,
                sorting: false,
                bAutoWidth: false,
                columns: [{
                        width: '150px'
                    },
                    {
                        width: '190px'
                    },
                    null
                ]
            });
        });
    </script>
</body>
<script src="../../assets/js/admin.js"></script>
<script src="../../assets/js/certificate.js"></script>

</html>