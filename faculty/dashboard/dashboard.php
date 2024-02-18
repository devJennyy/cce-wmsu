<?php
$dashboard = "active";
$css = "<link rel='stylesheet' type='text/css' href='dashboard.css' />";
$top_greet = "Welcome to your personal <span>Dashboard</span>";
$js = "../../assets/js/calendar.js";

include_once '../header.php';
?>


<div class="dashboard-content w-100 h-100 d-flex flex-row">
	<div class="main-content-one h-100 d-flex flex-column">
		<div class="top-head panel d-flex flex-row gap-5 justify-content-center w-100">
			<div class="top-head-text h-100 d-flex flex-column justify-content-evenly">
				<h2 style="text-transform: capitalize;">Hello, <?php echo $_SESSION["firstname"] ?>!</h2>

				<div class="inner-text">
					<?php
					$upcoming_count = 0;
					$sql = 'SELECT tbl_events.*, tbl_event_participants.account_id, tbl_event_participants.status FROM tbl_events INNER JOIN tbl_event_participants ON tbl_event_participants.event_id = tbl_events.id WHERE tbl_events.day >= ? AND tbl_event_participants.account_id = ? AND tbl_event_participants.status = "Invited" AND tbl_events.status = 5';
					foreach ($db->process_db($sql, "ss", true, date("Y-m-d"), $_SESSION["id"]) as $event_details) {
						$upcoming_count++;
					}
					?>
					<h6>You have <?php echo $upcoming_count ?> Upcoming Event<?php echo $upcoming_count > 1 ? "s" : "" ?>!</h6>
					<h6>Join now and be a part of the excitement!</h6>
				</div>
			</div>

			<img src="../../assets/img/faculty/top-head-icon.svg" height="180px">
		</div>
		<div class="recent-events panel d-flex flex-column">
			<h6>Upcoming <span>Events</span></h6>
			<div class="card-wrapper d-flex flex-row pt-2 pb-4 px-2 justify-content-center overflow-auto">
				<?php
				if ($_SESSION["verified"] != 2) {
				?>
					<div class="d-flex flex-column align-items-center">
						<img src="../../assets/img/faculty/upcoming-empty-icon.svg" height="280px">

						<div class="empty-event-text">
							<h5>It's Empty!</h5>
							<h6>Hmm.. looks like you don't have any upcoming events<br>any upcoming events</h6>
						</div>
					</div>
					<?php
				} else {
					$count = 0;
					foreach ($db->process_db("SELECT tbl_events.*, tbl_event_participants.account_id, tbl_event_participants.status FROM tbl_events INNER JOIN tbl_event_participants ON tbl_event_participants.event_id = tbl_events.id WHERE tbl_events.day >= ? AND tbl_event_participants.account_id = ? AND tbl_event_participants.status = 'Invited' AND tbl_events.status = 5 ORDER BY day ASC LIMIT 2", "ss", true, date("Y-m-d"), $_SESSION["id"]) as $event) {
						$count++;
					?>
						<div class="card upcoming-card" style="min-width: 260px;  max-width: 260px;">
							<img <?php echo ($event["attachment"] == NULL) ? 'src="../../assets/img/home/event-img-placeholder.svg"' : 'src="../../assets/attachments/events/' . $event["attachment"] . '"' ?> class="card-img-top" alt="Event Image" height="150">
							<img src="../../assets/img/home/placeholder-bottom.svg" class="card-img-bottom" alt="Event Image">
							<button class="btn btn-primary join-btn" style="border: 2px white solid !important" data-bs-toggle="modal" <?php echo ($event["venue_type"] == "Set Location") ? 'data-bs-target="#set-location-modal' . $event["id"] . '"' : 'data-bs-target="#other-platform-modal' . $event["id"] . '"' ?>>Join Event</button>

							<div class="card-body d-flex flex-column align-items-center">
								<h6 class="card-title"><?php echo $event["title"] ?></h6>
								<div class="details d-flex flex-row">
									<i class="fa-solid fa-location-dot"></i>
									<p class="details-text"><?php echo $event["venue"] ?></p>
								</div>

								<div class="details d-flex flex-row">
									<i class="fa-regular fa-calendar-minus"></i>
									<p class="details-text"><?php echo date_format(date_create($event["day"]), "F d, Y") ?></p>
								</div>

								<div class="details d-flex flex-row">
									<i class="fa-regular fa-clock" style="font-size: 11px; margin-top: 2px"></i>
									<p class="details-text"><?php echo date_format(date_create($event["startTime"]), "h:i A") ?> - <?php echo date_format(date_create($event["endTime"]), "h:i A") ?></p>
								</div>
							</div>

							<div class="card-footer d-flex flex-row justify-content-between">
								<p>View event information here</p>
								<div class="event-link d-flex justify-content-center align-items-center">
									<a data-bs-toggle="modal" data-bs-target="#all-event-modal<?php echo $event["id"] ?>" class="fa-solid fa-link"></a>
								</div>
							</div>
						</div>

						<div class="modal fade all-event-modal" id="all-event-modal<?php echo $event["id"] ?>" tabindex="-1" aria-hidden="true">
							<div class="modal-dialog modal-lg modal-dialog-centered" style="border-radius: 15px !important;">
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
														<h6><?php echo $event["title"] ?></h6>
													</div>
												</div>
												<div class="text-div date-time w-100 d-flex flex-column">
													<div class="when w-100 d-flex flex-row">
														<div class="title-text">
															<h6>When: </h6>
														</div>
														<div class="date-text d-flex flex-column">
															<h6>Date: </h6>
															<h6><?php echo date_format(date_create($event["day"]), "F d, Y") ?></h6>
														</div>
														<div class="time-text d-flex flex-column">
															<h6>Time: </h6>
															<h6><?php echo date_format(date_create($event["startTime"]), "h:i A") ?> - <?php echo date_format(date_create($event["endTime"]), "h:i A") ?></h6>
														</div>
													</div>
												</div>
												<div class="text-div location w-100 d-flex flex-row">
													<div class="title-text">
														<h6>Where: </h6>
													</div>
													<div class="input-text">
														<h6><?php echo $event["venue"] ?></h6>
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
                                                                                                WHERE tep.event_id = ? AND tep.role = 'Speaker'", "s", true, $event["id"]);

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
														foreach ($db->process_db($sql2, "s", true, $event["id"]) as $certs) {
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
														<h6 style="white-space: pre-line; text-align: justify"><?php echo $event["description"] ?></h6>
													</div>
												</div>
												<div class="text-div location w-100 d-flex flex-row">
													<div class="title-text">
														<h6>Agenda: </h6>
													</div>
													<div class="input-text">
														<h6 style="white-space: pre-line; text-align: justify"><?php echo $event["agenda"] ?></h6>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="modal fade all-event-modal" id="other-platform-modal<?php echo $event["id"] ?>" tabindex="-1" aria-hidden="true">
							<div class="modal-dialog modal-lg modal-dialog-centered">
								<div class="modal-content">
									<div class="modal-body">
										<div class="modal-top-img w-100 d-flex flex-row justify-content-center align-items-end">
											<img src="../../assets/img/admin/event-modal-icon.svg" width="40%">
										</div>
										<div class="all-event-wrapper w-100 d-flex flex-column">
											<div class="all-event-content w-100 d-flex flex-row justify-content-center">
												<h6 style="width: 70%; text-align: center; font-size: 1rem">If you click confirm, we will take you to the <span style="color: var(--red-1)"><?php echo $event["venue"] ?></span> where the event is hosted.</h6>
											</div>
										</div>
										<div class="d-flex flex-row justify-content-center gap-2 pb-4">
											<button type="button" class="btn btn-primary cancel-modal-btn" data-bs-dismiss="modal">Cancel</button>
											<form method="POST" action="../events/event-join.php" target="_blank">
												<input hidden name="event-id" value="<?php echo $event["id"] ?>">
												<input hidden name="event-day" value="<?php echo $event["day"] ?>">
												<input hidden name="event-link" value="<?php echo $event["venue_link"] ?>">
												<button type="submit" name="submit" class="btn btn-primary next-modal-btn">Confirm</button>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="modal fade all-event-modal" id="set-location-modal<?php echo $event["id"] ?>" tabindex="-1" aria-hidden="true">
							<div class="modal-dialog modal-lg modal-dialog-centered">
								<div class="modal-content">
									<div class="modal-body">
										<div class="modal-top-img w-100 d-flex flex-row justify-content-center align-items-end">
											<img src="../../assets/img/admin/event-modal-icon.svg" width="40%">
										</div>
										<div class="all-event-wrapper w-100 d-flex flex-column">
											<div class="all-event-content w-100 d-flex flex-row justify-content-center">
												<h6 style="width: 85%; text-align: center; font-size: 1rem">This event will be hosted at <span style="color: var(--red-1)"><?php echo $event["venue"] ?></span>.<br><br>Please arrive to the designated location 15 minutes before the event on <span style="color: var(--red-1)"><?php echo date_format(date_create($event["day"]), "F d, Y") ?></span>, at <span style="color: var(--red-1)"><?php echo date_format(date_create($event["startTime"]), "h:i A") ?></span>.</h6>
											</div>
										</div>
										<div class="d-flex flex-row justify-content-center gap-2 pb-4">

											<button type="button" class="btn btn-primary next-modal-btn" data-bs-dismiss="modal">Ok, Noted!</button>

										</div>
									</div>
								</div>
							</div>
						</div>
					<?php
					}

					if ($count == 0) {
					?>
						<div class="d-flex flex-column align-items-center">
							<img src="../../assets/img/faculty/upcoming-empty-icon.svg" height="280px">

							<div class="empty-event-text">
								<h5>It's Empty!</h5>
								<h6>Hmm.. looks like you don't have any upcoming events<br>any upcoming events</h6>
							</div>
						</div>
				<?php
					}
				}
				?>


			</div>
		</div>
	</div>
	<div class="main-content-two d-flex flex-column" style="flex: 1">
		<div class="calendar-div panel h-100 w-100" style="flex: 1; overflow: auto">
			<div class="calendar-wrapper h-100 w-100">
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

		<div class="today-event panel d-flex flex-column  h-50 w-100" style="flex: 1; overflow: auto">
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
							WHERE tbl_event_participants.account_id = ? AND tbl_events.day = ? AND tbl_events.status = 5";
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
</div>

<?php
include_once '../footer.php';
?>