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

	<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
	<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="../../assets/css/template.css" />
	<link rel="stylesheet" type="text/css" href="notifications.css" />
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
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">

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
					<a class="nav-link d-flex flex-row justify-content-between" aria-current="page" href="../events/events.php">
						<div class="icon-div d-flex flex-row">
							<img src="../../assets/img/admin/icon-events.svg" alt="Dashboard Logo" width="20">
							<h6>Events</h6>
						</div>
						<img src="../../assets/img/admin/icon-right.svg" alt="Right" width="11" height="11">
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active d-flex flex-row justify-content-between" aria-current="page" href="#">
						<div class="icon-div d-flex flex-row">
							<img src="../../assets/img/admin/icon-notification-active.svg" alt="Dashboard Logo" width="20">
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
							<span class="badge ms-2 d-flex flex-row justify-content-center align-items-center" style="background-color: white; color: var(--red-1); margin-top: 12px; padding-top: 4px; border-radius: 3px; height:fit-content; font-size: 10px">
							<?php echo $badge;  ?>
							</span>
							<?php 
							}
							?>
						</div>
						<img src="../../assets/img/admin/icon-right-active.svg" alt="Right" width="11" height="11">
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
			<h6>Good day, Claire! / Welcome to your <span>Notifications</span>!</h6>
			<button type="button" class="btn btn-primary topbar-btn" data-bs-toggle="modal" data-bs-target="#modal-createEvent"><i class="fa-solid fa-plus"></i></button>
		</div>
		<div class="main-wrapper h-100 d-flex flex-row">
			<div class="main panel d-flex flex-column h-100" style="padding: 0 !important;">
				<ul class="nav nav-tabs d-flex flex-row justify-content-evenly" id="myTab" role="tablist">
					<li class="nav-item" role="presentation">
						<button class="nav-link active" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications-tab-pane" type="button" role="tab" aria-controls="notifications-tab-pane" aria-selected="true">Notifications</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment-tab-pane" type="button" role="tab" aria-controls="payment-tab-pane" aria-selected="false">Event Subscriptions</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="faculty-request-tab" data-bs-toggle="tab" data-bs-target="#faculty-request-tab-pane" type="button" role="tab" aria-controls="faculty-request-tab-pane" aria-selected="false">Faculty Membership</button>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade active show" id="notifications-tab-pane" role="tabpanel" aria-labelledby="notifications-tab" tabindex="0">
						<div class="notif-header d-flex flex-row align-items-center w-100">
							<h6 class="top-text">Notifications</h6>
						</div>
						<div class="label-div d-flex flex-row w-100">
							<h6>Time</h6>
							<h6 style="margin-left: 55px">Events</h6>
						</div>
						<div class="notif-wrapper w-100 d-flex flex-column" style="flex: 1">
							<?php
							$notifCount = 0;
							$sql = "SELECT * FROM tbl_events WHERE status = 5 and day >= ? ORDER BY day";
							foreach ($db->process_db($sql, "s", true, date("Y-m-d")) as $notif) {
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
												<button class="btn btn-primary join-event-btn">Join Event</button>
												<button class="btn btn-primary view-btn">View Details</button>
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
					<div class="tab-pane fade" id="payment-tab-pane" role="tabpanel" aria-labelledby="payment-tab" tabindex="0">
						<div class="notif-header d-flex flex-row align-items-center w-100">
							<h6 class="top-text">Event Subscriptions</h6>
						</div>
						<div class="label-div d-flex flex-row w-100">
							<h6>Time</h6>
							<h6 style="margin-left: 50px">Subscriptions</h6>
						</div>
						<div id="sub-div">
							<div class="subscription-wrapper w-100 d-flex flex-column" style="flex: 1">
								<?php
								$eventCount = 0;
								$sql = "SELECT COUNT(*) as SubCount, tbl_subscriptions.*, tbl_events.id as event_id, tbl_events.title, tbl_events.day, tbl_events.title, tbl_events.startTime, tbl_events.endTime, tbl_events.venue, tbl_events.timestamp AS event_timestamp FROM tbl_subscriptions INNER JOIN tbl_events ON tbl_events.id = tbl_subscriptions.event_id WHERE tbl_subscriptions.status = 3 GROUP BY tbl_events.id";
								foreach ($db->process_db($sql, "", true, "") as $subscriptions) {
									$eventCount++;
								?>
									<div class="notification-div d-flex flex-row active w-100">
										<div class="date-time-div d-flex flex-column h-100">
											<h6 class="date"><?php echo date_format(date_create($subscriptions["timestamp"]), "M d, Y") ?></h6>
											<h6 class="time"><?php echo date_format(date_create($subscriptions["timestamp"]), "h:i A") ?></h6>
										</div>
										<div class="notification d-flex flex-column h-100 gap-3">
											<h6 class="invite-text"><b><?php echo $subscriptions["title"] ?></b></h6>
											<div class="info-div d-flex flex-row w-100">
												<div class="notif-date d-flex flex-column gap-1">
													<h6 class="label">Date:</h6>
													<h6 class="input"><?php echo date_format(date_create($subscriptions["day"]), "F d, Y") ?></h6>
												</div>
												<div class="notif-time d-flex flex-column gap-1">
													<h6 class="label">Time:</h6>
													<h6 class="input"><?php echo date_format(date_create($subscriptions["startTime"]), "h:i A") ?> - <?php echo date_format(date_create($subscriptions["endTime"]), "h:i A") ?></h6>
												</div>
												<div class="notif-duration d-flex flex-column gap-1" style="flex: 1;">
													<h6 class="label">Location:</h6>
													<h6 class="input"><?php echo $subscriptions["venue"] ?></h6>
												</div>
											</div>
											<div class="d-flex flex-row gap-2">
												<p style="font-weight: 500; font-size: 15px">Subscription:</p>
												<a href="#" style="color: var(--red-1)" data-bs-toggle="modal" data-bs-target="#sub-list-modal<?php echo $subscriptions["event_id"] ?>"><?php echo $subscriptions["SubCount"] ?> request<?php echo ($subscriptions["SubCount"] > 1) ? "s" : "" ?></a>
											</div>
										</div>
									</div>

									<div class="modal fade historyModal" id="sub-list-modal<?php echo $subscriptions["event_id"] ?>" tabindex="-1" aria-hidden="true">
										<div class="modal-dialog modal-lg">
											<div class="modal-content">
												<div class="modal-header">
													<h1 class="modal-title fs-5" id="exampleModalLabel"><span>“<?php echo $subscriptions["title"] ?>”</span></h1>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<div class="modal-body d-flex flex-column">
													<div class="search-bar-div w-100">
														<i class="fa-solid fa-magnifying-glass"></i>
														<input class="form-control" placeholder="Search title">
													</div>
													<div class="table-wrapper">
														<table id="history-modal-table" class="table" style="width:100%">
															<thead>
																<tr>
																	<th>
																		<p>Name</p>
																	</th>
																	<th>
																		<p>Gcash Number</p>
																	</th>
																	<th>
																		<p>Proof</p>
																	</th>
																</tr>
															</thead>
															<tbody>
																<?php
																$sql2 = "SELECT * FROM tbl_subscriptions WHERE status = 3 AND event_id = ?";
																foreach ($db->process_db($sql2, "s", true, $subscriptions["event_id"]) as $user_sub) {
																?>
																	<tr>
																		<td><?php echo $user_sub["firstname"] . " " . $user_sub["lastname"] ?></td>
																		<td><?php echo $user_sub["gcash_no"] ?></td>
																		<td class="d-flex flex-row">
																			<a data-bs-toggle="modal" data-bs-target="#proof-modal<?php echo $user_sub["id"] ?>" class="btn primary-btn view-assessment-btn">
																				<i class="fa-solid fa-eye"></i>
																				View
																			</a>
																			<button data-bs-dismiss="modal" type="submit" class="btn primary-btn sub-approve-btn" onclick="handleSubscriptions(<?php echo $user_sub['id'] ?>)" form="manage-sub<?php echo $user_sub["id"] ?>">
																				Approve
																			</button>
																			<button type="button" class="btn primary-btn sub-reject-btn">
																				Reject
																			</button>
																		</td>
																	</tr>


																<?php
																}
																?>

															</tbody>
														</table>

														<?php
														$sql2 = "SELECT * FROM tbl_subscriptions WHERE status = 3";
														foreach ($db->process_db($sql2, "", true, "") as $user_sub) {
														?>
															<form method="POST" action="../../modules/faculty/approve_subscription.php" id="manage-sub<?php echo $user_sub["id"] ?>">
																<input hidden name="sub-id" value="<?php echo $user_sub["id"] ?>">
																<input hidden name="acc-id" value="<?php echo $user_sub["account_id"] ?>">
																<input hidden name="event-id" value="<?php echo $user_sub["event_id"] ?>">
															</form>
														<?php
														}
														?>
													</div>
												</div>

											</div>
										</div>
									</div>
								
								    <?php
									$sql2 = "SELECT * FROM tbl_subscriptions WHERE status = 3 AND event_id = ?";
									foreach ($db->process_db($sql2, "s", true, $subscriptions["event_id"]) as $user_sub) {
									?>
										<div class="modal fade view-modal" data-bs-backdrop="static" id="proof-modal<?php echo $user_sub["id"] ?>" tabindex="-1" aria-hidden="true">
											<div class="modal-dialog modal-lg modal-dialog-centered" style="width: fit-content !important; height: fit-content !important; max-width: 900px !important; max-height: 800px !important">
												<div class="modal-content">
													<button type="button" class="btn-close me-2 mt-2" data-bs-toggle="modal" data-bs-target="#sub-list-modal<?php echo $subscriptions["event_id"] ?>" aria-label="Close" style="position: absolute; right: 0; z-index: 50"></button>
													<div class="modal-body py-3">
														<div class="content-wrapper d-flex justify-content-center w-100" style="width: fit-content !important; height: fit-content !important; max-width: 900px !important; max-height: 800px !important">
															<img style="object-fit: cover;" height="650" src="../../assets/attachments/faculty/proof/<?php echo $user_sub["proof"] ?>">
														</div>
													</div>
												</div>
											</div>
										</div>
									<?php
									}
									?>
								<?php
								}

								if ($eventCount == 0) {
								?>
									<div class="d-flex flex-column align-items-center mt-5">
										<img src="../../assets/img/faculty/upcoming-empty-icon.svg" height="280px">

										<div class="empty-event-text" style="text-align: center;">
											<h5>It's Empty!</h5>
											<h6>Hmm.. looks like there are no<br>event subscriptions.</h6>
										</div>
									</div>
								<?php
								}
								?>
							</div>
						</div>

					</div>
					<div class="tab-pane fade" id="faculty-request-tab-pane" role="tabpanel" aria-labelledby="faculty-request-tab" tabindex="0">
						<div class="notif-header d-flex flex-row align-items-center w-100">
							<h6 class="top-text">Membership Request</h6>
						</div>
						<div class="faculty-request label-div d-flex flex-row w-100">
							<h6>Time</h6>
							<h6 style="margin-left: 70px">Request</h6>
						</div>

						<div id="fac-wrap" class="w-100">
							<div class="faculty-wrapper w-100 d-flex flex-column" style="flex: 1">
								<?php
								$membershipCount = 0;
								$sql = "SELECT tbl_accounts.id, tbl_accounts.firstname, tbl_accounts.lastname, tbl_accounts.email, tbl_accounts.identification, tbl_accounts.faculty_role, tbl_accounts.timestamp, tbl_faculty_list.faculty_name FROM tbl_accounts INNER JOIN tbl_faculty_list ON tbl_faculty_list.abbreviation = tbl_accounts.faculty_role WHERE verified = 1 AND (faculty_role <> 'Organization' AND faculty_role <> 'Administrator') ORDER BY timestamp DESC";
								foreach ($db->process_db($sql, "", true, "") as $non_verified_faculty) {
									$membershipCount++;
								?>
									<div class="request-div d-flex flex-row w-100">
										<div class="time-div h-100 mt-2 me-3">
											<h6 class="date"><?php echo date_format(date_create($non_verified_faculty["timestamp"]), "M d, Y") ?></h6>
											<h6 class="time"><?php echo date_format(date_create($non_verified_faculty["timestamp"]), "h:i A") ?></h6>
										</div>

										<div class="main-req-content d-flex flex-row w-100 h-100">
											<div class="avatar-div d-flex flex-row h-100">
												<div class="red-thingy"></div>
												<div class="avatar-wrapper">
													<img src="../../assets/img/admin/participant-img.png" alt="Avatar" width="32">
												</div>
											</div>
											<div class="info-div d-flex flex-column w-100 h-100">
												<div class="header-text-div w-100">
													<h6><b><?php echo $non_verified_faculty["firstname"] . " " . $non_verified_faculty["lastname"] ?></b> has requested an approval for Faculty membership.</b></h6>
												</div>
												<div class="org-details-div d-flex flex-column w-100 gap-2">
													<div class="d-flex flex-row">
														<h6 class="label">Faculty Role: </h6>
														<h6 class="label-value"><?php echo $non_verified_faculty["faculty_name"] ?></h6>
													</div>
												</div>
												<div class="btn-div d-flex flex-row justify-content-end h-100 w-100">
													<form style="height: fit-content !important" id="approve-faculty-form" method="POST" action="" onsubmit="handleSubmit(<?php echo $non_verified_faculty['id'] ?>)">
														<input hidden name="account-id" value="<?php echo $non_verified_faculty["id"] ?>">
														<button type="submit" class="btn btn-primary approve-btn approve-member-btn" data-bs-toggle="modal" data-bs-target="#approve-modal">Approve</button>
													</form>

													<button class="btn btn-primary reject-btn" data-bs-toggle="modal" data-bs-target="#decline-modal<?php echo $non_verified_faculty["id"] ?>">Reject</button>
													<button class="btn btn-primary view-btn" data-bs-toggle="modal" data-bs-target="#view-modal<?php echo $non_verified_faculty["id"] ?>">View Details</button>
												</div>
											</div>
										</div>
									</div>

									<div class="modal fade decline-modal" id="decline-modal<?php echo $non_verified_faculty["id"] ?>" tabindex="-1" aria-hidden="true">
										<div class="modal-dialog modal-lg modal-dialog-centered">
											<div class="modal-content">
												<div class="modal-body">
													<div class="modal-top-img w-100 d-flex flex-row justify-content-center align-items-end">
														<img src="../../assets/img/admin/event-modal-icon.svg" width="40%">
													</div>
													<div class="content-wrapper">
														<h6><span>Why are you rejecting this<br>application?</span></h6>
														<select class="form-select reason-select">
															<option selected disabled hidden>Select a reason</option>
															<option value="Identification is invalid">Identification is invalid</option>
															<option value="Not a member of any faculties at WMSU">Not a member of any faculties at WMSU</option>
															<option value="Others">Others</option>
														</select>
														<div class="explain-div">
															<label for="exampleFormControlTextarea1" class="form-label">(Optional)</label>
															<textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
														</div>
													</div>
													<div class="btn-div d-flex flex-row justify-content-center">
														<button class="btn btn-primary back-btn" data-bs-dismiss="modal">Back</button>
														<button class="btn btn-primary submit-btn" style="color: white; font-weight: 400">Submit</button>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="modal fade view-modal" id="view-modal<?php echo $non_verified_faculty["id"] ?>" tabindex="-1" aria-hidden="true">
										<div class="modal-dialog modal-lg modal-dialog-centered">
											<div class="modal-content">
												<div class="modal-body">
													<div class="modal-top-img w-100 d-flex flex-row justify-content-center align-items-end">
														<img src="../../assets/img/admin/event-modal-icon.svg" width="40%">
													</div>
													<div class="content-wrapper w-100">
														<h6><span>REQUESTING FOR MEMBERSHIP</span></h6>

														<div class="info-div w-100 d-flex flex-column">
															<div class="fullname d-flex flex-row">
																<label class="main-label">Full name:</label>
																<label class="info-label"><?php echo $non_verified_faculty["firstname"] . " " . $non_verified_faculty["lastname"] ?></label>
															</div>
															<div class="email d-flex flex-row">
																<label class="main-label">Email:</label>
																<label class="info-label"><?php echo $non_verified_faculty["email"] ?></label>
															</div>
															<div class="fullname d-flex flex-row">
																<label class="main-label">Faculty Role:</label>
																<label class="info-label"><?php echo $non_verified_faculty["faculty_name"] ?></label>
															</div>
															<div class="fullname d-flex flex-row">
																<label class="main-label">Faculty Identification:</label>
																<label class="info-label"><a style="color: var(--red-1)" href="#" data-bs-toggle="modal" data-bs-target="#id-modal<?php echo $non_verified_faculty["id"] ?>">See attachment</a></h6></label>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="modal fade view-modal" data-bs-backdrop="static" id="id-modal<?php echo $non_verified_faculty["id"] ?>" tabindex="-1" aria-hidden="true">
										<div class="modal-dialog modal-lg modal-dialog-centered" style="width: fit-content !important; height: fit-content !important; max-width: 900px !important; max-height: 800px !important">
											<div class="modal-content">
												<button type="button" class="btn-close me-2 mt-2" data-bs-toggle="modal" data-bs-target="#view-modal<?php echo $non_verified_faculty["id"] ?>" aria-label="Close" style="position: absolute; right: 0; z-index: 50"></button>
												<div class="modal-body py-3">
													<div class="content-wrapper d-flex justify-content-center w-100" style="width: fit-content !important; height: fit-content !important; max-width: 900px !important; max-height: 800px !important">
														<img style="object-fit: cover;" height="650" src="../../assets/attachments/faculty/<?php echo $non_verified_faculty['identification'] ?>">
													</div>
												</div>
											</div>
										</div>
									</div>


								<?php
								}

								if ($membershipCount == 0) {
								?>
									<div class="d-flex flex-column align-items-center mt-5">
										<img src="../../assets/img/faculty/upcoming-empty-icon.svg" height="280px">

										<div class="empty-event-text" style="text-align: center;">
											<h5>It's Empty!</h5>
											<h6>Hmm.. looks like there are no<br>faculty membership request.</h6>
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
			
			<div class="content-two h-100 w-100 d-flex flex-column gap-3">
				<div class="calendar-div panel flex-grow-1 w-100" style="overflow: hidden">
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
				<div class="today-event panel flex-shrink-1  d-flex flex-column w-100">
					<h6>Today's Event</h6>
					<div class="today-event-wrapper d-flex flex-column h-100 w-100">

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


</body>
<script src="../../assets/js/calendar.js"></script>
<script src="../../assets/js/admin.js"></script>
<script src="../../assets/js/certificate.js"></script>
<script>
	function handleSubmit(id) {
		event.preventDefault();

		$.ajax({
			type: "POST",
			url: "../../modules/faculty/approve_membership.php",
			data: {
				'account-id': id
			},
			success: function(response) {
				if (!(response == "Done!")) {
					console.log("Something went wrong!");
				} else {
					showError("Request Approved!", "success");
				}
			}
		})

		$("#fac-wrap").load(location.href + " .faculty-wrapper.w-100.d-flex.flex-column");
	}

	function handleSubscriptions(id) {

		$('#manage-sub' + id).submit(function(event) {
			event.preventDefault();
			$.ajax({
				type: "POST",
				url: "../../modules/faculty/approve_subscription.php",
				data: $(this).serialize(),
				success: function(response) {
					if (!(response == "[Done!")) {
						console.log("Something went wrong!");
					} else {
						showError("Request Approved!", "success");
					}
				}
			})

			$("#sub-div").load(location.href + " .subscription-wrapper.w-100.d-flex.flex-column");
		});



	}
</script>

</html>