<?php
$events = "active";
$css = "<link rel='stylesheet' type='text/css' href='events.css' />";
$js = "./events.js";
$top_greet = "Welcome to your <span>Events</span>";

include_once '../header.php';
?>

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
        <div class="card-div d-flex flex-row flex-wrap" style="row-gap: 16px;">
            <?php
            $eventCount = 0;
            $sql = "SELECT * FROM tbl_events WHERE day >= ? AND status = '5' ORDER BY day ASC";
            foreach ($db->process_db($sql, "s", true, date("Y-m-d")) as $upcoming_event) {
                $registered_in_event = false;
                $status = "";

                $checkSQL = "SELECT COUNT(*) as Invited, type FROM tbl_event_participants WHERE account_id = ? AND event_id = ?";
                foreach ($db->process_db($checkSQL, "ss", true, $_SESSION["id"], $upcoming_event["id"]) as $flag) {
                    if ($flag["Invited"] > 0) {
                        $registered_in_event = true;
                        $status = $flag["type"];
                        break;
                    }
                }
                $eventCount++;
            ?>
                <div class="card upcoming-card" style="width: 280px;">
                    <img <?php echo ($upcoming_event["attachment"] == NULL) ? 'src="../../assets/img/home/event-img-placeholder.svg"' : 'src="../../assets/attachments/events/' . $upcoming_event["attachment"] . '"' ?> class="card-img-top" alt="Event Image" height="150" width="258">
                    <img src="../../assets/img/home/placeholder-bottom.svg" class="card-img-bottom" alt="Event Image">
                    <?php
                    if ($upcoming_event["visibility"] != 1 && !$registered_in_event) {
                        echo '<button class="btn btn-primary join-btn" style="border: 2px white solid !important" data-bs-toggle="modal" data-bs-target="#all-event-modal' . $upcoming_event["id"] . '">View Event</button>';
                    } elseif ($registered_in_event) {
                    ?>
                        <button class="btn btn-primary join-btn" style="border: 2px white solid !important" data-bs-toggle="modal" <?php echo ($upcoming_event["venue_type"] == "Set Location") ? 'data-bs-target="#set-location-modal' . $upcoming_event["id"] . '"' : 'data-bs-target="#other-platform-modal' . $upcoming_event["id"] . '"' ?>>Join Event</button>
                    <?php

                    } else {
                        if ($_SESSION["verified"] != 2) {
                            echo '<button class="btn btn-primary join-btn" style="border: 2px white solid !important" data-bs-toggle="modal" data-bs-target="#get-verified-modal">Register</button>';
                        } else {
                            if ($upcoming_event["slots_remaining"] <= 0) {
                                echo '<button class="btn btn-primary join-btn" style="border: 2px white solid !important" data-bs-toggle="modal" data-bs-target="#no-slot-modal">Register</button>';
                            } else {
                                echo '<button class="btn btn-primary join-btn" style="border: 2px white solid !important" data-bs-toggle="modal" data-bs-target="#payment-event-modal' . $upcoming_event["id"] . '">Register</button>';
                            }
                        }
                    }

                    ?>

                    <?php echo ($registered_in_event) || $upcoming_event["visibility"] != 1 ? '<div class="price-div d-flex flex-row justify-content-center align-items-center m-2 px-2" style="background-color: var(--red-1);position: absolute; width: fit-content; height:22px; right: 0; font-size: 12px; color: white; border-radius: 3px">' . $status . '</div>' : '<div class="price-div d-flex flex-row justify-content-center align-items-center m-2" style="background-color: var(--red-1);position: absolute; width: 55px; height:22px; right: 0; font-size: 12px; color: white; border-radius: 3px">&#8369; ' . $upcoming_event["price"] . '</div>' ?>
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

                <div class="modal fade all-event-modal" id="all-event-modal<?php echo $upcoming_event["id"] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" style="border-radius: 15px !important;">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="modal-top-img w-100 d-flex flex-row justify-content-center align-items-end">
                                    <img src="../../assets/img/admin/event-modal-icon.svg" width="40%">
                                </div>
                                <div class="all-event-wrapper w-100 d-flex flex-column">
                                    <h5><span><?php echo ($registered_in_event) ? "Hello! You are invited to an Event!" : "Event Details" ?></span></h5>
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
                                                <div class="title-text" style="width: 180px !important;">
                                                    <h6>When: </h6>
                                                </div>
                                                <div class="date-text d-flex flex-column" style="flex: 1">
                                                    <h6>Date: </h6>
                                                    <h6><?php echo date_format(date_create($upcoming_event["day"]), "F d, Y") ?></h6>
                                                </div>
                                                <div class="time-text d-flex flex-column" style="flex: 1">
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
                                        <!-- <div class="text-div guest w-100 d-flex flex-row">
                                            <div class="title-text">
                                                <h6>Special Guests: </h6>
                                            </div>
                                            <div class="input-text">
                                                <h6>Nezuko Kamado, Muzan Kibutsuji, Zenitsu
                                                    Agatsuma & Tanjiro Kamado.</h6>
                                            </div>
                                        </div> -->
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
                                                    <h6><?php echo $certs["certificate_name"] ?></h6>
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
                                        <div class="text-div location w-100 d-flex flex-row">
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
                                    <img src="../../assets/img/admin/event-modal-icon.svg" width="40%">
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
                                    <img src="../../assets/img/admin/event-modal-icon.svg" width="40%">
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

                <!-- Payment Modal -->
                <div class="modal fade all-event-modal" id="payment-event-modal<?php echo $upcoming_event["id"] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg ">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="modal-top-img w-100 d-flex flex-row justify-content-center align-items-end">
                                    <img src="../../assets/img/admin/event-modal-icon.svg" width="40%">
                                </div>
                                <div class="all-event-wrapper w-100 d-flex flex-column justify-content-center align-items-center">
                                    <h6 style="text-align: center;"><span><?php echo $upcoming_event["gcash_number"] ?></span><br><?php echo $upcoming_event["gcash_name"] ?><br>GCASH ONLY!</h6>

                                    <div class="payment-instructions">
                                        <h6>&#128221;NO RECEIPT - NO PAYMENT.</h6>
                                        <br>
                                        <h6>For payment confirmation, please either take a screenshot or download your receipt in GCASH, ensuring that the reference number is visible. </h6>
                                        <div class="w-100 d-flex justify-content-center pb-2"><a href="../../assets/img/faculty/gcash_preview.jpg" target="_blank" style="color: var(--red-1); text-align: center">View Sample Image.</a></div>
                                        <h6>Fail to do so will require you to make another payment or you may contact the ADMIN onsite.</h6>
                                    </div>

                                    <div class="button-container d-flex flex-row justify-content-center gap-1 w-100">
                                        <button type="button" class="btn cancel-btn" id="cancel-button" data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn register-button" data-bs-toggle="modal" data-bs-target="#payment-proof-modal<?php echo $upcoming_event["id"] ?>">Register</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade payment-proof-modal" id="payment-proof-modal<?php echo $upcoming_event["id"] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <h6 style="font-size: 18px;">Purchase <span><?php echo $upcoming_event["title"] ?></span></h6>
                                <form id="subscribe-form<?php echo $upcoming_event['id'] ?>" method="POST" action="../../modules/faculty/subscribe_event.php" enctype="multipart/form-data">
                                    <input hidden name="acc-id" value="<?php echo $_SESSION["id"] ?>">
                                    <input hidden name="event-id" value="<?php echo $upcoming_event["id"] ?>">
                                    <div class="personal-details-div mt-4">
                                        <h6>PERSONAL DETAILS</h6>
                                        <div class="input-container d-flex flex-row w-100 gap-2">
                                            <input class="form-control w-75" placeholder="First name" name="firstname" value="<?php echo $_SESSION["firstname"] ?>" required>
                                            <input class="form-control w-25" placeholder="Initial name" name="initial-name">
                                        </div>
                                        <div class="input-container d-flex flex-row w-100 gap-2">
                                            <input class="form-control" placeholder="Last name" name="lastname" value="<?php echo $_SESSION["lastname"] ?>" required>
                                        </div>
                                    </div>

                                    <div class="divider" style="margin: 28px 0px;"></div>

                                    <div class="payment-details-div">
                                        <h6>PAYMENT DETAILS</h6>
                                        <div class="input-container d-flex flex-row w-100 gap-2">
                                            <input class="form-control" placeholder="Your GCASH Number" name="gcash-number" required>
                                        </div>
                                    </div>

                                    <div class="proof-div mt-3">
                                        <h6>UPLOAD PROOF OF PAYMENT OR SCREENSHOT</h6>
                                        <div class="input-container d-flex flex-row w-100 gap-2">
                                            <input type="file" class="form-control" name="proof-payment" required>
                                        </div>
                                    </div>

                                    <div class="button-container d-flex flex-row justify-content-center gap-1 w-100" style="margin: 24px 0px;">
                                        <button type="submit" onclick="handleSubscribeForm(<?php echo $upcoming_event['id'] ?>)" class="btn send-button w-100" data-bs-toggle="modal" data-bs-target="#success-event-modal">Send</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade all-event-modal" id="success-event-modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="modal-top-img w-100 d-flex flex-row justify-content-center align-items-end">
                                    <img src="../../assets/img/admin/event-modal-icon.svg" width="40%">
                                </div>
                                <div class="all-event-wrapper w-100 d-flex flex-column justify-content-center align-items-center" style="padding-bottom: 2rem;">
                                    <div class="payment-instructions">
                                        <h6>You have successfully submitted your registration. Kindly wait for the admin to process your payment. Your order will be completed within 5 minutes - 1 hour. Please be patient. We will notify you once you are eligible for the event.</h6>
                                    </div>
                                    <div class="button-container d-flex flex-row justify-content-center gap-1 w-100">
                                        <button type="button" class="btn register-button" data-bs-dismiss="modal" style="width: fit-content !important;">Okay, Thanks!</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php
            }

            if ($eventCount == 0) {
            ?>
                <div class="d-flex flex-column align-items-center" style="margin: auto;">
                    <img src="../../assets/img/faculty/upcoming-empty-icon.svg" height="280px">

                    <div class="empty-event-text" style="text-align: center;">
                        <h5>It's Empty!</h5>
                        <h6>Hmm.. looks like there are no<br>upcoming events.</h6>
                    </div>
                </div>
            <?php
            }
            ?>

            <div class="modal fade all-event-modal" id="get-verified-modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" style="border-radius: 15px !important;">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="modal-top-img w-100 d-flex flex-row justify-content-center align-items-end" style="height: 280px;">
                                <img class="ms-4" src="../../assets/img/faculty/not-registered-pic.svg" width="45%">
                            </div>
                            <div class="all-event-wrapper w-100 mb-5 d-flex flex-column">
                                <h5 style="width: 450px; text-align: center" class="mb-2"><span>Not available!</span></h5>

                                <h6 style="text-align: justify;" class="w-75 m-auto">Oops! It seems that you have not been verified yet. Please wait until you are verified by the administrator.</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade all-event-modal" id="no-slot-modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" style="border-radius: 15px !important;">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="modal-top-img w-100 d-flex flex-row justify-content-center align-items-end" style="height: 280px;">
                                <img class="ms-4" src="../../assets/img/faculty/not-registered-pic.svg" width="45%">
                            </div>
                            <div class="all-event-wrapper w-100 mb-5 d-flex flex-column">
                                <h5 style="width: 450px; text-align: center" class="mb-2"><span>No Slot Available!</span></h5>

                                <h6 style="text-align: justify;" class="w-75 m-auto">Oops! It seems there are no more available slots for this event.</h6>
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
        <div class="general-events d-flex flex-row flex-wrap">
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
                        <h6 class="card-title">International Jazz Festival </h6>
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
                        <h6 class="card-title">International Jazz Festival </h6>
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
                        <h6 class="card-title">International Jazz Festival </h6>
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
                        <h6 class="card-title">International Jazz Festival </h6>
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
                        <h6 class="card-title">International Jazz Festival </h6>
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
                        <h6 class="card-title">International Jazz Festival </h6>
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
                        <h6 class="card-title">International Jazz Festival </h6>
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
                        <h6 class="card-title">International Jazz Festival </h6>
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

    <div class="modal fade certificate-modal" id="certificate-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-top-img w-100 d-flex flex-row justify-content-center align-items-end">
                        <img src="../../assets/img/admin/event-modal-icon.svg" width="40%">
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

    <div class="tab-pane fade d-flex flex-column h-100 w-100" id="history-tab-pane" role="tabpanel" aria-labelledby="history-tab" tabindex="0">
        <div class="search-bar-div w-100">
            <input class="form-control" placeholder="Search title">
        </div>
        <div class="table-wrapper h-100 w-100">
            <div class="h-100 w-100" id="loadHere">
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
                                <p>Time</p>
                            </th>
                            <th>
                                <p>Progress Report</p>
                            </th>
                            <th>
                                <p></p>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT tbl_events.id, tbl_accounts.id AS account_id, tbl_events.title, tbl_events.day, tbl_events.startTime, tbl_events.endTime, tbl_event_participants.status, tbl_event_participants.certificate_sent
                            FROM tbl_events
                            INNER JOIN tbl_event_participants ON tbl_event_participants.event_id = tbl_events.id
                            INNER JOIN tbl_accounts ON tbl_accounts.id = tbl_event_participants.account_id
                            WHERE account_id = ? AND day < ?
                            ORDER BY ABS(day - CURDATE());";
                        foreach ($db->process_db($sql, "ss", true, $_SESSION["id"], date("Y-m-d")) as $pastJoinedEvents) {
                        ?>
                            <tr>
                                <td style="max-width: 200px; white-space:nowrap; text-overflow:ellipsis; overflow:hidden"><?php echo $pastJoinedEvents["title"] ?></td>
                                <td><?php echo date_format(date_create($pastJoinedEvents["day"]), "F d, Y") ?></td>
                                <td><?php echo date_format(date_create($pastJoinedEvents["startTime"]), "h:i A") . " - " . date_format(date_create($pastJoinedEvents["endTime"]), "h:i A") ?></td>
                                <td><?php echo ($pastJoinedEvents["status"] == 'Invited') ? "Step 1 In Progress" : $pastJoinedEvents["status"] ?></td>
                                <td>
                                    <?php
                                    if ($pastJoinedEvents["certificate_sent"] == 1) {
                                    ?>
                                        <a href="../certificates/certificates.php">View Certificate</a>
                                        <?php
                                    } else {
                                        if ($pastJoinedEvents["status"] === "Invited") {
                                        ?>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#assessment-modal<?php echo $pastJoinedEvents["id"] ?>">Take Assessment</a>
                                        <?php
                                        } else if ($pastJoinedEvents["status"] === "Step 2 In Progress") {
                                        ?>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#feedback-modal<?php echo $pastJoinedEvents["id"] ?>">Give Feedback</a>
                                        <?php
                                        }
                                        ?>
                                        <!-- <a href="#">View Details</a> -->
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                            $assessment = array();

                            foreach ($db->process_db("SELECT * FROM tbl_assessment WHERE event_id = ?", "s", true, $pastJoinedEvents["id"]) as $questions) {
                                $assessment[] = $questions;
                            }

                            $assessmentObjects = array_map(function ($result) {
                                return (object)$result;
                            }, $assessment);

                            shuffle($assessmentObjects);
                            ?>
                            <div class="modal fade" id="assessment-modal<?php echo $pastJoinedEvents["id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Assessment Form</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body d-flex flex-column gap-2">
                                            <div class="progress" role="progressbar" aria-label="Example 1px high" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="height: 1px">
                                                <div class="progress-bar" style="width: 20%"></div>
                                            </div>
                                            <form id="assessment-form<?php echo $pastJoinedEvents["id"] ?>" action="../../modules/assessment/check_assessment.php" method="POST">
                                                <input form="assessment-form<?php echo $pastJoinedEvents["id"] ?>" hidden value="<?php echo $_SESSION["id"] ?>" name="user-id">
                                                <input form="assessment-form<?php echo $pastJoinedEvents["id"] ?>" hidden value="<?php echo $pastJoinedEvents["id"] ?>" name="event-id">
                                            </form>
                                            <?php
                                            $questioncount = 1;
                                            $totalQuestions = count($assessmentObjects);
                                            foreach ($assessmentObjects as $object) {
                                                // Shuffle options A to D for each question
                                                $options = array($object->option_a, $object->option_b, $object->option_c, $object->option_d);
                                                shuffle($options);
                                            ?>
                                                <div id="question<?php echo $questioncount; ?>" class="fade-question question-container d-flex flex-column gap-1 mb-3 " <?php if ($questioncount === 1) { ?> style="display: block !important;" <?php } else { ?> style="display: none !important;" <?php } ?>>
                                                    <input form="assessment-form<?php echo $pastJoinedEvents["id"] ?>" hidden value="<?php echo $object->id ?>" name="question_id[]">
                                                    <h6>Question <?php echo $questioncount ?>:</h6>
                                                    <div class="px-4 py-4" style="box-shadow: 0px 2px 6px rgba(18.53, 17.57, 65.87, 0.05); border-radius: 20px; border: 1px #EFF0F6 solid">
                                                        <h6 class="m-0"><?php echo $object->question ?></h6>
                                                    </div>
                                                    <?php

                                                    if ($object->is_code) {
                                                    ?>
                                                        <div class="d-flex flex-column mt-3 gap-4">
                                                            <input form="assessment-form<?php echo $pastJoinedEvents["id"] ?>" type="text" class="form-control" name="question<?php echo $questioncount ?>" placeholder="Please enter code" style="color: #5E5A5A; border: 0; border-radius: 0 !important; border-bottom: 1px rgba(94, 90, 90, .8) solid; margin-left: 6px" required>
                                                        </div>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <div class="d-flex flex-column mt-3 px-3 gap-4">
                                                            <div class="d-flex flex-row align-items-center gap-2">
                                                                <input form="assessment-form<?php echo $pastJoinedEvents["id"] ?>" type="radio" value="<?php echo $options[0] ?>" name="question<?php echo $questioncount ?>" checked>
                                                                <h6 class="m-0" style="color: #5E5A5A;">A. <?php echo $options[0] ?></h6>
                                                            </div>
                                                            <div class="d-flex flex-row align-items-center gap-2">
                                                                <input form="assessment-form<?php echo $pastJoinedEvents["id"] ?>" type="radio" value="<?php echo $options[1] ?>" name="question<?php echo $questioncount ?>">
                                                                <h6 class="m-0" style="color: #5E5A5A;">B. <?php echo $options[1] ?></h6>
                                                            </div>
                                                            <div class="d-flex flex-row align-items-center gap-2">
                                                                <input form="assessment-form<?php echo $pastJoinedEvents["id"] ?>" type="radio" value="<?php echo $options[2] ?>" name="question<?php echo $questioncount ?>">
                                                                <h6 class="m-0" style="color: #5E5A5A;">C. <?php echo $options[2] ?></h6>
                                                            </div>
                                                            <div class="d-flex flex-row align-items-center gap-2">
                                                                <input form="assessment-form<?php echo $pastJoinedEvents["id"] ?>" type="radio" value="<?php echo $options[3] ?>" name="question<?php echo $questioncount ?>">
                                                                <h6 class="m-0" style="color: #5E5A5A;">D. <?php echo $options[3] ?></h6>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                    <div class="navigation-buttons d-flex flex-row justify-content-center mt-3 gap-2">
                                                        <?php if ($questioncount == 1) { ?>
                                                            <button type="button" class="btn btn-primary cancel-modal-btn" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="button" class="btn btn-primary next-modal-btn" onclick="showQuestion(<?php echo $questioncount + 1; ?>, <?php echo $object->is_code ?>, '#assessment-modal<?php echo $pastJoinedEvents['id'] ?>')">Next</button>
                                                        <?php } elseif ($questioncount == $totalQuestions) { ?>
                                                            <button type="button" class="btn btn-primary cancel-modal-btn" onclick="showQuestion(<?php echo $questioncount - 1; ?>, false, '#assessment-modal<?php echo $pastJoinedEvents['id'] ?>')">Previous</button>
                                                            <button form="assessment-form<?php echo $pastJoinedEvents["id"] ?>" data-bs-dismiss="modal" type="submit" onclick="handleSubmit(<?php echo $pastJoinedEvents['id'] ?>)" class="btn btn-primary next-modal-btn">Submit</button>
                                                        <?php } else { ?>
                                                            <button type="button" class="btn btn-primary cancel-modal-btn" onclick="showQuestion(<?php echo $questioncount - 1; ?>, false, '#assessment-modal<?php echo $pastJoinedEvents['id'] ?>')">Previous</button>
                                                            <button type="button" class="btn btn-primary next-modal-btn" onclick="showQuestion(<?php echo $questioncount + 1; ?>, <?php echo $object->is_code ?>, '#assessment-modal<?php echo $pastJoinedEvents['id'] ?>')">Next</button>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            <?php
                                                $questioncount++;
                                            }
                                            ?>


                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade feedback" id="feedback-modal<?php echo $pastJoinedEvents["id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Feedback Form</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body d-flex flex-column px-4">
                                            <form id="feedback-form<?php echo $pastJoinedEvents["id"] ?>" action=""></form>
                                            <input form="feedback-form<?php echo $pastJoinedEvents["id"] ?>" type="number" value="<?php echo $pastJoinedEvents["id"] ?>" name="event-id" hidden>
                                            <input form="feedback-form<?php echo $pastJoinedEvents["id"] ?>" type="number" value="<?php echo $_SESSION["id"] ?>" name="account-id" hidden>

                                            <div class="rating-label w-100 d-flex flex-row justify-content-end py-2 gap-4" style="border-bottom: 1px #E0E4EC solid">
                                                <h6>Poor</h6>
                                                <h6>Fair</h6>
                                                <h6>Good</h6>
                                                <h6>Better</h6>
                                                <h6>Best</h6>
                                            </div>
                                            <div id="feedback-one" class="w-100 d-flex flex-row py-3 justify-content-between align-items-center" style="border-bottom: 1px #E0E4EC solid">
                                                <h6 class="m-0 px-1" style="color: #323232; font-weight: 600; width: 390px">1. OVERALL / GENERAL ASSESSMENT OF TRAINING</h6>
                                                <input form="feedback-form<?php echo $pastJoinedEvents["id"] ?>" type="number" value="1" name="rating[]" hidden>
                                                <div class="rating gap-4">
                                                    <i class='fa-solid fa-star star highlight' style="--i: 0; margin-left: 6.5px; margin-right: 6.5px" data-i="1"></i>
                                                    <i class='fa-solid fa-star star no-highlight' style="--i: 1; margin-left: 6.5px; margin-right: 6.5px" data-i="2"></i>
                                                    <i class='fa-solid fa-star star no-highlight' style="--i: 2; margin-left: 6.5px; margin-right: 6.5px" data-i="3"></i>
                                                    <i class='fa-solid fa-star star no-highlight' style="--i: 3; margin-left: 6.5px; margin-right: 6.5px" data-i="4"></i>
                                                    <i class='fa-solid fa-star star no-highlight' style="--i: 4; margin-left: 6.5px; margin-right: 6.5px" data-i="5"></i>
                                                </div>
                                            </div>
                                            <div id="feedback-two" class="w-100 d-flex flex-row py-3 justify-content-between align-items-center" style="border-bottom: 1px #E0E4EC solid">
                                                <h6 class="m-0 px-1" style="color: #323232; font-weight: 600; width: 390px">2. TIMELINESS, UP-TO-DATE, & CURRENT TRENDS APPLIED</h6>
                                                <input form="feedback-form<?php echo $pastJoinedEvents["id"] ?>" type="number" value="1" name="rating[]" hidden>
                                                <div class="rating gap-4">
                                                    <i class='fa-solid fa-star star highlight' style="--i: 0; margin-left: 6.5px; margin-right: 6.5px" data-i="1"></i>
                                                    <i class='fa-solid fa-star star no-highlight' style="--i: 1; margin-left: 6.5px; margin-right: 6.5px" data-i="2"></i>
                                                    <i class='fa-solid fa-star star no-highlight' style="--i: 2; margin-left: 6.5px; margin-right: 6.5px" data-i="3"></i>
                                                    <i class='fa-solid fa-star star no-highlight' style="--i: 3; margin-left: 6.5px; margin-right: 6.5px" data-i="4"></i>
                                                    <i class='fa-solid fa-star star no-highlight' style="--i: 4; margin-left: 6.5px; margin-right: 6.5px" data-i="5"></i>
                                                </div>
                                            </div>
                                            <div class="w-100 d-flex flex-row py-3 justify-content-between align-items-center" style="border-bottom: 1px #E0E4EC solid">
                                                <div class="m-0 w-100">
                                                    <h6 class="m-0 px-1" style="width: 390px; color: #323232; font-weight: 600;">3. CONTENT</h6>
                                                    <ul>
                                                        <li class="my-3 d-flex flex-row justify-content-between align-items-center" id="feedback-three-a">
                                                            <h6 class="m-0" style="padding-left: 1.2rem; font-weight: 400; width: 390px; ">a. Clarify of the topics presented</h6>
                                                            <input form="feedback-form<?php echo $pastJoinedEvents["id"] ?>" type="number" value="1" name="rating[]" hidden>
                                                            <div class="rating gap-4">
                                                                <i class='fa-solid fa-star star highlight' style="--i: 0; margin-left: 6.5px; margin-right: 6.5px" data-i="1"></i>
                                                                <i class='fa-solid fa-star star no-highlight' style="--i: 1; margin-left: 6.5px; margin-right: 6.5px" data-i="2"></i>
                                                                <i class='fa-solid fa-star star no-highlight' style="--i: 2; margin-left: 6.5px; margin-right: 6.5px" data-i="3"></i>
                                                                <i class='fa-solid fa-star star no-highlight' style="--i: 3; margin-left: 6.5px; margin-right: 6.5px" data-i="4"></i>
                                                                <i class='fa-solid fa-star star no-highlight' style="--i: 4; margin-left: 6.5px; margin-right: 6.5px" data-i="5"></i>
                                                            </div>
                                                        </li>
                                                        <li class="my-3 d-flex flex-row justify-content-between align-items-center" id="feedback-three-b">
                                                            <h6 class="m-0" style="padding-left: 1.2rem; font-weight: 400; width: 390px; ">b. Comprehensiveness of the content</h6>
                                                            <input form="feedback-form<?php echo $pastJoinedEvents["id"] ?>" type="number" value="1" name="rating[]" hidden>
                                                            <div class="rating gap-4">
                                                                <i class='fa-solid fa-star star highlight' style="--i: 0; margin-left: 6.5px; margin-right: 6.5px" data-i="1"></i>
                                                                <i class='fa-solid fa-star star no-highlight' style="--i: 1; margin-left: 6.5px; margin-right: 6.5px" data-i="2"></i>
                                                                <i class='fa-solid fa-star star no-highlight' style="--i: 2; margin-left: 6.5px; margin-right: 6.5px" data-i="3"></i>
                                                                <i class='fa-solid fa-star star no-highlight' style="--i: 3; margin-left: 6.5px; margin-right: 6.5px" data-i="4"></i>
                                                                <i class='fa-solid fa-star star no-highlight' style="--i: 4; margin-left: 6.5px; margin-right: 6.5px" data-i="5"></i>
                                                            </div>
                                                        </li>
                                                        <li class="my-3 d-flex flex-row justify-content-between align-items-center" id="feedback-three-c">
                                                            <h6 class="m-0" style="padding-left: 1.2rem; font-weight: 400; width: 390px; ">c. Applicability and relevance of the content to the needs of the participants</h6>
                                                            <input form="feedback-form<?php echo $pastJoinedEvents["id"] ?>" type="number" value="1" name="rating[]" hidden>
                                                            <div class="rating gap-4">
                                                                <i class='fa-solid fa-star star highlight' style="--i: 0; margin-left: 6.5px; margin-right: 6.5px" data-i="1"></i>
                                                                <i class='fa-solid fa-star star no-highlight' style="--i: 1; margin-left: 6.5px; margin-right: 6.5px" data-i="2"></i>
                                                                <i class='fa-solid fa-star star no-highlight' style="--i: 2; margin-left: 6.5px; margin-right: 6.5px" data-i="3"></i>
                                                                <i class='fa-solid fa-star star no-highlight' style="--i: 3; margin-left: 6.5px; margin-right: 6.5px" data-i="4"></i>
                                                                <i class='fa-solid fa-star star no-highlight' style="--i: 4; margin-left: 6.5px; margin-right: 6.5px" data-i="5"></i>
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
                                                            <input form="feedback-form<?php echo $pastJoinedEvents["id"] ?>" type="number" value="1" name="rating[]" hidden>
                                                            <div class="rating gap-4">
                                                                <i class='fa-solid fa-star star highlight' style="--i: 0; margin-left: 6.5px; margin-right: 6.5px" data-i="1"></i>
                                                                <i class='fa-solid fa-star star no-highlight' style="--i: 1; margin-left: 6.5px; margin-right: 6.5px" data-i="2"></i>
                                                                <i class='fa-solid fa-star star no-highlight' style="--i: 2; margin-left: 6.5px; margin-right: 6.5px" data-i="3"></i>
                                                                <i class='fa-solid fa-star star no-highlight' style="--i: 3; margin-left: 6.5px; margin-right: 6.5px" data-i="4"></i>
                                                                <i class='fa-solid fa-star star no-highlight' style="--i: 4; margin-left: 6.5px; margin-right: 6.5px" data-i="5"></i>
                                                            </div>
                                                        </li>
                                                        <li class="my-3 d-flex flex-row justify-content-between align-items-center" id="feedback-four-b">
                                                            <h6 class="m-0" style="padding-left: 1.2rem; font-weight: 400; width: 390px; ">b. Training Venue</h6>
                                                            <input form="feedback-form<?php echo $pastJoinedEvents["id"] ?>" type="number" value="1" name="rating[]" hidden>
                                                            <div class="rating gap-4">
                                                                <i class='fa-solid fa-star star highlight' style="--i: 0; margin-left: 6.5px; margin-right: 6.5px" data-i="1"></i>
                                                                <i class='fa-solid fa-star star no-highlight' style="--i: 1; margin-left: 6.5px; margin-right: 6.5px" data-i="2"></i>
                                                                <i class='fa-solid fa-star star no-highlight' style="--i: 2; margin-left: 6.5px; margin-right: 6.5px" data-i="3"></i>
                                                                <i class='fa-solid fa-star star no-highlight' style="--i: 3; margin-left: 6.5px; margin-right: 6.5px" data-i="4"></i>
                                                                <i class='fa-solid fa-star star no-highlight' style="--i: 4; margin-left: 6.5px; margin-right: 6.5px" data-i="5"></i>
                                                            </div>
                                                        </li>
                                                        <li class="my-3 d-flex flex-row justify-content-between align-items-center" id="feedback-four-c">
                                                            <h6 class="m-0" style="padding-left: 1.2rem; font-weight: 400; width: 390px; ">c. Effectiveness of the training management</h6>
                                                            <input form="feedback-form<?php echo $pastJoinedEvents["id"] ?>" type="number" value="1" name="rating[]" hidden>
                                                            <div class="rating gap-4">
                                                                <i class='fa-solid fa-star star highlight' style="--i: 0; margin-left: 6.5px; margin-right: 6.5px" data-i="1"></i>
                                                                <i class='fa-solid fa-star star no-highlight' style="--i: 1; margin-left: 6.5px; margin-right: 6.5px" data-i="2"></i>
                                                                <i class='fa-solid fa-star star no-highlight' style="--i: 2; margin-left: 6.5px; margin-right: 6.5px" data-i="3"></i>
                                                                <i class='fa-solid fa-star star no-highlight' style="--i: 3; margin-left: 6.5px; margin-right: 6.5px" data-i="4"></i>
                                                                <i class='fa-solid fa-star star no-highlight' style="--i: 4; margin-left: 6.5px; margin-right: 6.5px" data-i="5"></i>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>

                                            </div>
                                            <div id="feedback-five" class="w-100 d-flex flex-row py-3 justify-content-between align-items-center" style="border-bottom: 1px #E0E4EC solid">
                                                <h6 class="m-0 px-1" style="color: #323232; font-weight: 600; width: 390px">5. RESOURCES SPEAKERS</h6>
                                                <input form="feedback-form<?php echo $pastJoinedEvents["id"] ?>" type="number" value="1" name="rating[]" hidden>
                                                <div class="rating gap-4">
                                                    <i class='fa-solid fa-star star highlight' style="--i: 0; margin-left: 6.5px; margin-right: 6.5px" data-i="1"></i>
                                                    <i class='fa-solid fa-star star no-highlight' style="--i: 1; margin-left: 6.5px; margin-right: 6.5px" data-i="2"></i>
                                                    <i class='fa-solid fa-star star no-highlight' style="--i: 2; margin-left: 6.5px; margin-right: 6.5px" data-i="3"></i>
                                                    <i class='fa-solid fa-star star no-highlight' style="--i: 3; margin-left: 6.5px; margin-right: 6.5px" data-i="4"></i>
                                                    <i class='fa-solid fa-star star no-highlight' style="--i: 4; margin-left: 6.5px; margin-right: 6.5px" data-i="5"></i>
                                                </div>
                                            </div>
                                            <h6 class="mt-3">ADDITIONAL FEEDBACK</h6>
                                            <textarea form="feedback-form<?php echo $pastJoinedEvents["id"] ?>" name="additional-feedback" class="p-3" style="font-size: 14px; color: #535353; outline: none; width: 100%; height: 150px; background: white; box-shadow: 0px 2px 6px rgba(18.53, 17.57, 65.87, 0.07); border-radius: 5px; border: 1px #EFF0F6 solid"></textarea>

                                            <div class="d-flex flex-row justify-content-center mt-4 mb-3 gap-2">
                                                <button data-bs-dismiss="modal" type="button" class="btn btn-primary cancel-modal-btn">Cancel</button>
                                                <button form="feedback-form<?php echo $pastJoinedEvents["id"] ?>" onclick="handleFeedbackSubmit(<?php echo $pastJoinedEvents["id"] ?>)" data-bs-dismiss="modal" type="submit" class="btn btn-primary next-modal-btn">Submit</button>
                                            </div>
                                            <!-- <h6>Your experience rating</h6> -->
                                            <!-- <form id="feedback-form<?php echo $pastJoinedEvents["id"] ?>" action="">
                                                <div class="wrapper">
                                                    
                                                        <div class="rating">
                                                            <input form="feedback-form<?php echo $pastJoinedEvents["id"] ?>" type="number" value="<?php echo $pastJoinedEvents["id"] ?>" name="event-id" hidden>
                                                            <input form="feedback-form<?php echo $pastJoinedEvents["id"] ?>" type="number" value="1" name="rating" hidden>
                                                            <input form="feedback-form<?php echo $pastJoinedEvents["id"] ?>" type="number" value="<?php echo $_SESSION["id"] ?>" name="account-id" hidden>
                                                            <i class='fa-solid fa-star star highlight' style="--i: 0;" data-i="1"></i>
                                                            <i class='fa-solid fa-star star no-highlight' style="--i: 1;" data-i="2"></i>
                                                            <i class='fa-solid fa-star star no-highlight' style="--i: 2;" data-i="3"></i>
                                                            <i class='fa-solid fa-star star no-highlight' style="--i: 3;" data-i="4"></i>
                                                            <i class='fa-solid fa-star star no-highlight' style="--i: 4;" data-i="5"></i>
                                                        </div>
                                                    
                                                </div>
                                                <h6>Additional Feedback</h6>
                                                <textarea form="feedback-form<?php echo $pastJoinedEvents["id"] ?>" name="additional-feedback" class="p-3" style="font-size: 14px; color: #535353; outline: none; width: 100%; height: 150px; background: white; box-shadow: 0px 2px 6px rgba(18.53, 17.57, 65.87, 0.07); border-radius: 5px; border: 1px #EFF0F6 solid"></textarea>
                                                
                                                <div class="d-flex flex-row justify-content-center mt-4 mb-3 gap-2">
                                                    <button data-bs-dismiss="modal" type="button" class="btn btn-primary cancel-modal-btn">Cancel</button>
                                                    <button form="feedback-form<?php echo $pastJoinedEvents["id"] ?>" onclick="handleFeedbackSubmit(<?php echo $pastJoinedEvents["id"] ?>)" data-bs-dismiss="modal" type="submit"class="btn btn-primary next-modal-btn">Submit</button>
                                                </div>
                                            </form> -->
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
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script>
        function showQuestion(questionNumber, isCode, parentContainer) {

            let errorTrigger = false;

            if (isCode) {
                if (checkInput(parentContainer + " .question-container input[type='text']")) {
                    errorTrigger = true;
                }
            }

            if (errorTrigger) {
                showError("Please enter your answer!");
            } else {
                switch (questionNumber) {
                    case 1:
                        $('.progress-bar').css('width', '20%');
                        break;
                    case 2:
                        $('.progress-bar').css('width', '40%');
                        break;
                    case 3:
                        $('.progress-bar').css('width', '60%');
                        break;
                    case 4:
                        $('.progress-bar').css('width', '80%');
                        break;
                    case 5:
                        $('.progress-bar').css('width', '100%');
                        break;
                    default:
                        break;
                }

                $(parentContainer + ' .question-container').each(function() {
                    $(this).fadeOut('slow'); // Use fadeOut for fade effect
                    this.style.setProperty('display', 'none', 'important');
                });

                var questionContainer = $(parentContainer + ' #question' + questionNumber)[0];
                $(questionContainer).fadeIn('fast'); // Use fadeIn for fade effect
                questionContainer.style.setProperty('display', 'block', 'important');
            }

        }

        function handleSubmit(id) {
            $('#assessment-form' + id).submit(function(event) {
                event.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "../../modules/assessment/check_assessment.php",
                    data: $(this).serialize(),
                    success: function(response) {
                        if (!(response == "All Correct")) {
                            showError("Answer(s) incorrect!", "danger");
                        } else {
                            showError("Assessment Complete!", "success");
                        }
                    }
                })

                // Destroy DataTable before loading new content
                $('#loadHere #myTable').DataTable().destroy();

                // Load new content
                $(".table-wrapper.h-100.w-100").load(location.href + " #loadHere", function() {
                    // Reinitialize DataTable after the new content is loaded
                    $('#myTable').DataTable({
                        searching: false,
                        language: {
                            info: 'Showing _START_ - _END_ of list'
                        },
                        scrollCollapse: true,
                        scrollY: '400px',
                        order: [],
                        "language": {
                            "paginate": {
                                "previous": "<",
                                "next": ">"
                            }
                        }
                    });
                });

                initializeFeedback();
                /* $(".table-wrapper.h-100.w-100").load(location.href + " #loadHere");
                 */
            });
        }

        function handleFeedbackSubmit(id) {
            $('#feedback-form' + id).submit(function(event) {
                event.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "../../modules/ratings/submit_rating.php",
                    data: $(this).serialize(),
                    success: function(response) {
                        if (!(response == "Done!")) {
                            showError("Something went wrong!", "danger");
                        } else {
                            showError("Thank you for your feedback!", "success");
                        }
                    }
                })

                // Destroy DataTable before loading new content
                $('#loadHere #myTable').DataTable().destroy();

                // Load new content
                $(".table-wrapper.h-100.w-100").load(location.href + " #loadHere", function() {
                    // Reinitialize DataTable after the new content is loaded
                    $('#myTable').DataTable({
                        searching: false,
                        language: {
                            info: 'Showing _START_ - _END_ of list'
                        },
                        scrollCollapse: true,
                        scrollY: '400px',
                        order: [],
                        "language": {
                            "paginate": {
                                "previous": "<",
                                "next": ">"
                            }
                        }
                    });
                });
                initializeFeedback();
                /* $(".table-wrapper.h-100.w-100").load(location.href + " #loadHere");
                 */
            });
        }
    </script>

</div>
<?php
include_once '../footer.php';
?>