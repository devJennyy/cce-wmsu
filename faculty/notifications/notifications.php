<?php
$notifications = "active";
$css = "<link rel='stylesheet' type='text/css' href='notifications.css' />";
$top_greet = "Welcome to your <span>Notifications</span>";
$js = "../../assets/js/calendar.js";

include_once '../header.php';
?>

<div class="notification-main panel d-flex flex-column h-100">
    <div class="notif-header d-flex flex-row align-items-center w-100">
        <h6 class="top-text">Notifications</h6>
    </div>
    <div class="label-div d-flex flex-row w-100">
        <h6>Time</h6>
        <h6 style="margin-left: 55px">Events</h6>
    </div>
    <div class="notif-wrapper w-100 d-flex flex-column">
        <?php
        $notifCount = 0;
        $sql = "SELECT tbl_events.*, tbl_event_participants.account_id, tbl_event_participants.status FROM tbl_events INNER JOIN tbl_event_participants ON tbl_event_participants.event_id = tbl_events.id WHERE tbl_events.day >= ? AND tbl_event_participants.account_id = ? AND tbl_event_participants.status = 'Invited' AND tbl_events.status = 5 ORDER BY day";
        foreach ($db->process_db($sql, "ss", true, date("Y-m-d"), $_SESSION["id"]) as $notif) {
            $startTime = strtotime($notif["day"] . " " . $notif["startTime"]);
            $endTime = strtotime($notif["day"] . " " . $notif["endTime"]);
            $reminder = $notif["reminder"];

            $currentTime = strtotime('+' . $reminder, time());
            $timeDifference = $startTime - $currentTime;

            if ($timeDifference <= 0 && time() <= $startTime) {
                $notifCount++;
        ?>
                <div class="notification-div d-flex flex-row active w-100 ms-4">
                    <div class="date-time-div d-flex flex-column h-100">
                        <h6 class="date"><?php echo date_format(date_create($notif["day"]), "M d, Y") ?></h6>
                        <h6 class="time"><?php echo date_format(date_create($notif["startTime"]), "h:i A") ?></h6>
                    </div>
                    <div class="notification d-flex flex-column justify-content-between h-100">
                        <h6 class="invite-text">Hello! "<b><?php echo $notif["title"] ?></b>" event is starting soon. Please join us 5 minutes before the event.</h6>
                        <div class="info-div d-flex flex-row w-100 gap-4">
                            <div class="notif-date d-flex flex-column">
                                <h6 class="label">Date:</h6>
                                <h6 class="input"><?php echo date_format(date_create($notif["day"]), "M d, Y") ?></h6>
                            </div>
                            <div class="notif-time d-flex flex-column">
                                <h6 class="label">Time:</h6>
                                <h6 class="input"><?php echo date_format(date_create($notif["startTime"]), "h:i A") ?> - <?php echo date_format(date_create($notif["endTime"]), "h:i A") ?></h6>
                            </div>
                            <div class="notif-duration d-flex flex-column">
                                <h6 class="label">Duration:</h6>
                                <?php
                                // Calculate the duration in seconds
                                $duration = strtotime($notif["endTime"]) - strtotime($notif["startTime"]);

                                // Calculate the hours and minutes
                                $hours = floor($duration / 3600);
                                $minutes = floor(($duration % 3600) / 60);

                                // Build the formatted duration string
                                $durationString = '';
                                if ($hours > 0) {
                                    $durationString .= $hours . ' hour' . ($hours > 1 ? 's' : '');
                                }
                                if ($minutes > 0) {
                                    if ($durationString !== '') {
                                        $durationString .= ' and ';
                                    }
                                    $durationString .= $minutes . ' minute' . ($minutes > 1 ? 's' : '');
                                }
                                ?>
                                <h6 class="input"><?php echo $durationString ?></h6>
                            </div>
                        </div>
                        <div class="notif-location w-100 d-flex flex-row">
                            <h6 class="label">Location:</h6>
                            <h6 class="input" style="max-width: 100%; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;"><?php echo $notif["venue"] ?></h6>
                        </div>
                        <div class="notif-note w-100 d-flex flex-row">
                            <h6 class="label">Note:</h6>
                            <h6 class="input">Please join 5 minutes before the event begins.</h6>
                        </div>
                        <div class="button-div d-flex flex-row justify-content-end">
                            <button class="btn btn-primary join-event-btn me-1">Join Event</button>
                            <button class="btn btn-primary view-btn ms-1">View Details</button>
                        </div>
                    </div>
                </div>
            <?php
            }
        }

        if ($notifCount == 0) {
            ?>
            <div class="d-flex flex-column align-items-center mt-5">
                <img src="../../assets/img/faculty/upcoming-empty-icon.svg" height="280px">

                <div class="empty-event-text" style="text-align: center;">
                    <h5>It's Empty!</h5>
                    <h6>Hmm.. looks like there are no<br>notifications.</h6>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>
<div class="content-two h-100 w-100 d-flex flex-column">
    <div class="calendar-div panel w-100 pt-4" style="flex: 1; padding: 22px 24px">
        <div class="calendar-wrapper w-100">
            <header>
                <div class="icons w-100 d-flex flex-row justify-content-between align-items-center">
                    <span id="prev" class="material-symbols-rounded d-flex flex-row align-items-center justify-content-center">chevron_left</span>
                    <p class="current-date"></p>
                    <span id="next" class="material-symbols-rounded d-flex flex-row align-items-center justify-content-center" style="margin-right: 2px">chevron_right</span>
                </div>
            </header>
            <div class="calendar">
                <ul class="weeks">
                    <li>Sun</li>
                    <li>Mon</li>
                    <li>Tue</li>
                    <li>Wed</li>
                    <li>Thu</li>
                    <li>Fri</li>
                    <li>Sat</li>
                </ul>
                <ul class="days"></ul>
            </div>
        </div>
    </div>

    <div class="today-event d-flex flex-column panel w-100" style="flex: 1; padding: 22px 24px">
        <h6>Today's Event</h6>
        <div class="today-event-wrapper d-flex flex-column h-100 w-100">
				<?php
				if ($_SESSION["verified"] != 2) {
				?>
					<div class="d-flex flex-column align-items-center gap-2">
						<img src="../../assets/img/faculty/empty-todays-event-icon.svg" height="160px">

						<div class="empty-event-text">
							<h5>No events today!</h5>
							<h6>When you get invited to an event, <br>they’ll show up here</h6>
						</div>
					</div>
				<?php
				} else {
				?>
					<div class="column-text d-flex flex-row pb-2">
						<p class="time-txt">Time</p>
						<p class="event-txt">Events</p>
					</div>
					<div id="today-wrap" style="flex: 1">
						<div class="today-event-content h-100 w-100 d-flex flex-column">
							<?php
							if (isset($_GET["date"])) {
								$currentCalDate = $_GET["date"];
							} else {
								$currentCalDate = date("Y-m-d");
							}

							$todayCount = 0;
							$sql = "SELECT tbl_events.*, tbl_event_participants.status FROM tbl_events
							INNER JOIN tbl_event_participants ON tbl_events.id = tbl_event_participants.event_id
							WHERE tbl_event_participants.account_id = ? AND tbl_events.day = ? AND tbl_events.status = 5;";
							foreach ($db->process_db($sql, "ss", true, $_SESSION["id"], $currentCalDate) as $todayEvent) {
								$todayCount++;
							?>
								<div class="today-event-group d-flex flex-row w-100">

									<div class="time-wrapper d-flex flex-column align-items-center h-100">
										<h6 class="start-time"><?php echo date_format(date_create($todayEvent["startTime"]), "H:i") ?></h6>
										<h6 class="end-time"><?php echo date_format(date_create($todayEvent["endTime"]), "H:i") ?></h6>
									</div>
									<div class="event-card-wrapper h-100" style="margin-left: 6px;">
										<div class="today-event-card first d-flex flex-column h-100">
											<div class="event-title-location">
												<h6 style="font-weight: bold"><?php echo $todayEvent["title"] ?></h6>
												<div class="details d-flex flex-row">
													<i class="fa-solid fa-location-dot"></i>
													<p class="details-text"><?php echo $todayEvent["venue"] ?></p>
												</div>
											</div>
											<div class="d-flex flex-row align-items-end justify-content-end h-100">
												<div class="d-flex flex-column" style="width: 70%;">
													<div class="details d-flex flex-row" style="margin-top: 12%;">
														<i class="fa-regular fa-calendar-minus"></i>
														<p class="details-text"><?php echo date_format(date_create($todayEvent["day"]), "F d, Y") ?></p>
													</div>
													<div class="details d-flex flex-row">
														<i class="fa-regular fa-clock" style="font-size: 13px; margin-top: 2px"></i>
														<p class="details-text"><?php echo date_format(date_create($todayEvent["startTime"]), "h:i A") . " - " . date_format(date_create($todayEvent["endTime"]), "h:i A") ?></p>
													</div>
												</div>
												<a href="../events/events.php"><button class="btn btn-primary join-event-btn">View Event</button></a>
											</div>
										</div>
									</div>
								</div>
							<?php
							}

							if ($todayCount <= 0) {
							?>
								<div class="d-flex flex-column align-items-center gap-2">
									<img src="../../assets/img/faculty/empty-todays-event-icon.svg" height="140px">

									<div class="empty-event-text">
										<h5>No events today!</h5>
										<h6>When you get invited to an event, <br>they’ll show up here</h6>
									</div>
								</div>
							<?php
							}
							?>

						</div>
					</div>
				<?php
				}
				?>
			</div>
    </div>


</div>

<?php
include_once '../footer.php';
?>