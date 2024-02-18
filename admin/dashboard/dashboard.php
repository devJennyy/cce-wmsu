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
date_default_timezone_set('Asia/Singapore');
include_once '../../includes/database.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<link rel="stylesheet" type="text/css" href="../../assets/css/template.css" />
	<link rel="stylesheet" type="text/css" href="dashboard.css" />
	<link rel="stylesheet" type="text/css" href="dashboard-modal.css" />

	<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
	<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">

	<title>Center of Continuing Education</title>
	<link rel="icon" type="image/x-icon" href="../../assets/img/logo/cce-logo.png">
	<style>
		/* Custom font face */
		@font-face {
			font-family: 'CustomFont';
			src: url('');
			/* Leave the URL empty for now */
		}

		/* Apply the custom font */
		#textField.custom-font {
			font-family: 'CustomFont', 'Poppins', sans-serif;
		}
	</style>
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
		<div class="sidebar-links position-relative">
			<ul class="nav nav-pills nav-justified d-flex flex-column">
				<li class="nav-item">
					<a class="nav-link active d-flex flex-row justify-content-between" aria-current="page" href="#">
						<div class="icon-div d-flex flex-row">
							<img src="../../assets/img/admin/icon-dashboard-active.svg" alt="Dashboard Logo" width="20">
							<h6>Home</h6>
						</div>
						<img src="../../assets/img/admin/icon-right-active.svg" alt="Right" width="11" height="11">
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link d-flex flex-row justify-content-between" aria-current="page" href="../events/events.php">
						<div class="icon-div d-flex flex-row">
							<img src="../../assets/img/admin/icon-events.svg" alt="Dashboard Logo" width="20">
							<h6>Events</h6>
						</div>
						<img src="../../assets/img/admin/icon-right.svg" alt="Right" width="11" height="11">
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

							if($badge != 0){
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
	<div class="content d-flex flex-column h-100 w-100" style="flex: 1">
		<div class="top-bar panel d-flex flex-row align-items-center justify-content-between">
			<h6>Good day, Claire! / Welcome to your personal <span>Dashboard</span>!</h6>
			<button type="button" class="btn btn-primary topbar-btn" data-bs-toggle="modal" data-bs-target="#modal-createEvent"><i class="fa-solid fa-plus"></i></button>
		</div>
		<div class="dashboard-content w-100 d-flex flex-row" style="height: 1% !important;flex: 1 1 auto;">
			<div class="main-content-one h-100 d-flex flex-column flex-1">
				<div class="analytics panel w-100">
					<h6>Analytics</h6>
					<div class="card-div w-100 d-flex flex-row justify-content-center">
						<div class="analytics-card d-flex flex-column justify-content-center align-items-center">
							<?php
							$sql = "SELECT COUNT(*) AS Created_Events FROM tbl_events WHERE status = '5'";
							$createdEvents = $db->process_db($sql, "", true, "");
							?>
							<h4><?php echo $createdEvents[0]["Created_Events"] ?></h4>
							<h6>Created Events</h6>
						</div>
						<div class="analytics-card d-flex flex-column justify-content-center align-items-center">
							<?php
							$sql = "SELECT COUNT(*) AS Registered_Org FROM tbl_organization INNER JOIN tbl_accounts ON tbl_accounts.id = tbl_organization.account_id WHERE tbl_accounts.verified = '2'";
							$registeredOrg = $db->process_db($sql, "", true, "");
							?>
							<h4><?php echo $registeredOrg[0]["Registered_Org"] ?></h4>
							<h6>Registered Organizations</h6>
						</div>
						<div class="analytics-card d-flex flex-column justify-content-center align-items-center">
							<?php
							$sql = "SELECT COUNT(*) AS Faculty_Members FROM tbl_accounts WHERE verified = 2 AND faculty_role <> 'Organization'";
							$facultyMembers = $db->process_db($sql, "", true, "");
							?>
							<h4><?php echo $facultyMembers[0]["Faculty_Members"] ?></h4>
							<h6>Faculty Members</h6>
						</div>
					</div>
				</div>
				<div class="recent-events panel d-flex flex-column">
					<h6 style="margin-bottom: 0 !important;">Recently Created <span>Events</span></h6>

					<div class="card-wrapper d-flex flex-row flex-nowrap justify-content-center py-4 overflow-auto" style="width: 100%;">
						<?php
						$currentDateTime = new DateTime();
						$current = $currentDateTime->format('Y-m-d H:i:s');

						$oneWeekAgoDateTime = $currentDateTime->modify('-1 week')->format('Y-m-d H:i:s');
						$upcomingCount = 0;
						foreach ($db->process_db("SELECT * FROM tbl_events WHERE status = '5' AND (timestamp >= ? AND timestamp <= ?) ORDER BY timestamp DESC LIMIT 2", "ss", true, $oneWeekAgoDateTime, $current) as $event) {
							$upcomingCount++;
						?>
							<div class="card upcoming-card" style="min-width: 250px; max-width: 250px;">
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
								<div class="modal-dialog modal-lg modal-dialog-centered">
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
                                                                                                WHERE tep.event_id = ? AND tep.role = 'Speaker'", "s", true,$event["id"]);

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
													<div class="text-div agenda w-100 d-flex flex-row">
														<div class="title-text">
															<h6>Agenda: </h6>
														</div>
														<div class="input-text">
															<h6 class="ql-editor"><?php echo $event["agenda"] ?></h6>
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
												<form method="POST" action="../events/event-join.php">
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

						if ($upcomingCount <= 0) {
						?>
							<div class="w-100 d-flex flex-column justify-content-center align-items-center">
								<img src="../../assets/img/faculty/upcoming-empty-icon.svg" height="275px">

								<div class="empty-event-text">
									<h5>It's Empty!</h5>
									<h6>Hmm.. looks like there are no<br> recently created events</h6>
								</div>
							</div>
						<?php
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

				<div class="today-event panel d-flex flex-column  h-50 w-100">
					<h6>Today's <span>Event</span></h6>
					<div class="today-event-wrapper d-flex flex-column h-100 w-100">
						<div class="column-text d-flex flex-row pb-2">
							<p class="time-txt">Time</p>
							<p class="event-txt">Events</p>
						</div>
						<div id="today-wrap">
							<div class="today-event-content h-100 w-100 d-flex flex-column">
								<?php
								if (isset($_GET["date"])) {
									$currentCalDate = $_GET["date"];
								} else {
									$currentCalDate = date("Y-m-d");
								}

								$todayCount = 0;
								$sql = "SELECT * FROM tbl_events WHERE day = ? AND status = 5";
								foreach ($db->process_db($sql, "s", true, $currentCalDate) as $todayEvent) {
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
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php include_once '../create-event-modal.php' ?>


	<div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3">
		<div id="liveToast" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">

			<div class="d-flex">
				<div class="toast-body" style="color: white;">

				</div>
				<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>

		</div>
	</div>

</body>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>

<script src="../../assets/js/admin.js"></script>
<script src="../../assets/js/calendar.js"></script>
<script src="../../assets/js/certificate.js"></script>

</html>