<?php
session_start();
if(isset($_SESSION["faculty_role"])){
	if($_SESSION["faculty_role"] != "Administrator") {
		echo "Page not found!";
		exit();
	}
}
else {
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
	<link rel="stylesheet" type="text/css" href="organizations.css" />
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
					<a class="nav-link active d-flex flex-row justify-content-between" aria-current="page" href="#">
						<div class="icon-div d-flex flex-row">
							<img src="../../assets/img/admin/icon-org-active.svg" alt="Dashboard Logo" width="18">
							<h6>Organizations</h6>
						</div>
						<img src="../../assets/img/admin/icon-right-active.svg" alt="Right" width="11" height="11">
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
			<h6>Good day, Claire! / Welcome to your <span>Organizations</span>!</h6>
			<button type="button" class="btn btn-primary topbar-btn" data-bs-toggle="modal" data-bs-target="#modal-createEvent"><i class="fa-solid fa-plus"></i></button>
		</div>
		<div class="main-wrapper h-100 d-flex flex-row">
			<div class="main panel h-100 w-100 d-flex flex-column">
				<ul class="nav nav-tabs d-flex flex-row justify-content-center" id="myTab" role="tablist">
					<li class="nav-item" role="presentation">
						<button class="nav-link active" id="approval-tab" data-bs-toggle="tab" data-bs-target="#approval-tab-pane" type="button" role="tab" aria-controls="approval-tab-pane" aria-selected="true">Requesting for Approval</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="events-tab" data-bs-toggle="tab" data-bs-target="#events-tab-pane" type="button" role="tab" aria-controls="events-tab-pane" aria-selected="false">Requested Events</button>
					</li>
				</ul>
				<div class="tab-content w-100 h-100" id="myTabContent">
					<div class="tab-pane fade show active h-100 w-100" id="approval-tab-pane" role="tabpanel" aria-labelledby="approval-tab" tabindex="0">
						<div class="req-header d-flex flex-row align-items-center w-100">
							<h6 class="top-text">Requests</h6>
							<select class="form-select" aria-label="Default select example">
								<option selected value="All">All</option>
								<option value="Unread">One</option>
								<option value="Read">Two</option>
							</select>
						</div>
						<div class="label-div d-flex flex-row">
							<label class="time-txt">Time</label>
							<label class="org-txt">Organizations</label>
						</div>
						<div class="content-wrapper d-flex flex-column">
							<?php
							$count = 0;
							$sql = "SELECT tbl_organization.*, tbl_accounts.id AS account_id, tbl_accounts.firstname, tbl_accounts.lastname, tbl_accounts.email, tbl_accounts.verified, tbl_accounts.timestamp, tbl_organization_members.role
							FROM tbl_organization
							INNER JOIN tbl_accounts ON tbl_accounts.id = tbl_organization.account_id
							INNER JOIN tbl_organization_members ON tbl_organization_members.account_id = tbl_accounts.id
							WHERE tbl_accounts.verified = 1";
							foreach ($db->process_db($sql, "", true, "") as $non_verified_org) {
								$count++;
							?>
								<div class="request-div d-flex flex-row w-100">
									<div class="time-div h-100">
										<h6 class="date" style="max-width: 80px"><?php echo date_format(date_create($non_verified_org["timestamp"]), "M d, Y") ?></h6>
										<h6 class="time"><?php echo date_format(date_create($non_verified_org["timestamp"]), "h:i A") ?></h6>
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
												<h6><b><?php echo $non_verified_org["firstname"] . " " . $non_verified_org["lastname"] ?></b> requested an approval for the verification of the <b><?php echo $non_verified_org["org_name"] ?> Organization to access all its features.</b></h6>
											</div>
											<div class="org-details-div w-100">
												<h6>"<?php echo $non_verified_org["org_goal"] ?>"</h6>
											</div>
											<div class="btn-div d-flex flex-row justify-content-end h-100 w-100">
												<form id="approve-org-form" method="POST" action="../../modules/organization/verify_org.php" onsubmit="handleSubmit(<?php echo $non_verified_org['account_id'] ?>)">
													<input hidden name="account-id" value="">
													<button type="submit" class="btn btn-primary approve-btn" data-bs-toggle="modal" data-bs-target="#approve-modal<?php echo $non_verified_org["id"] ?>">Approve</button>
												</form>

												<button class="btn btn-primary reject-btn" data-bs-toggle="modal" data-bs-target="#decline-modal">Reject</button>
												<button class="btn btn-primary view-btn" data-bs-toggle="modal" data-bs-target="#view-modal<?php echo $non_verified_org["id"] ?>">View Details</button>
											</div>
										</div>
									</div>
								</div>

								<div class="modal fade view-modal" id="view-modal<?php echo $non_verified_org["id"] ?>" tabindex="-1" aria-hidden="true">
									<div class="modal-dialog modal-lg modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-body">
												<div class="modal-top-img w-100 d-flex flex-row justify-content-center align-items-end">
													<img src="../../assets/img/admin/event-modal-icon.svg" width="40%">
												</div>
												<div class="content-wrapper-modal">
													<h6><span>REQUESTING FOR APPROVAL</span></h6>
													<div class="representative-details w-100">
														<h6 class="header-text">REPRESENTATIVE DETAILS</h6>
														<div class="info-wrapper w-100 d-flex flex-row">
															<label class="label-text">Full name:</label>
															<label class="info-text"><?php echo $non_verified_org["firstname"] . " " . $non_verified_org["lastname"] ?></label>
														</div>
														<div class="info-wrapper w-100 d-flex flex-row">
															<label class="label-text">Email:</label>
															<label class="info-text"><?php echo $non_verified_org["email"] ?></label>
														</div>
													</div>
													<div class="organization-details w-100">
														<h6 class="header-text">ORGANIZATION DETAIlS</h6>
														<div class="info-wrapper w-100 d-flex flex-row">
															<label class="label-text">Name:</label>
															<label class="info-text"><?php echo $non_verified_org["org_name"] ?></label>
														</div>
														<div class="info-wrapper w-100 d-flex flex-row">
															<label class="label-text">Acronym:</label>
															<label class="info-text"><?php echo $non_verified_org["org_shortname"] ?></label>
														</div>
														<div class="info-wrapper w-100 d-flex flex-row">
															<label class="label-text">Attachment:</label>
															<label class="info-text"><a href="#">No attachments</a></label>
														</div>
														<div class="info-wrapper w-100 d-flex flex-row">
															<label class="label-text">Details:</label>
															<label class="info-text" style="white-space: pre-line;">Description: <br><?php echo $non_verified_org["org_descrip"] ?><br>
																													Activities: <br><?php echo $non_verified_org["org_activities"] ?><br>
																													Mission: <br><?php echo $non_verified_org["org_mission"] ?><br>
																													Goal: <br><?php echo $non_verified_org["org_goal"] ?><br></label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="modal fade approve-modal" id="approve-modal<?php echo $non_verified_org["id"] ?>" tabindex="-1" aria-hidden="true">
									<div class="modal-dialog modal-lg modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-body">
												<div class="modal-top-img w-100 d-flex flex-row justify-content-center align-items-end">
													<img src="../../assets/img/admin/approval-placeholder.svg" width="135px">
												</div>
												<div class="content-wrapper-modal">
													<h6><span>Approval Confirmed!</span></h6>
													<div class="info-wrapper w-100 d-flex flex-row justify-content-center">
														<label class="info-text w-100">
															<p style="text-align: center;"><?php echo $non_verified_org["org_name"] ?> also known as <?php echo $non_verified_org["org_shortname"] ?> has been approved as a verified Organization.</p>
														</label>
													</div>
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

									<div class="empty-event-text" style="text-align: center;">
										<h5>It's Empty!</h5>
										<h6>Hmm.. looks like there are no<br>organization approval requests.</h6>
									</div>
								</div>
							<?php
							}
							?>
						</div>
					</div>

					<div class="tab-pane fade d-flex flex-column h-100 w-100" id="events-tab-pane" role="tabpanel" aria-labelledby="events-tab" tabindex="0">
						<div class="under-construction gap-3 h-100 w-100 d-flex flex-column justify-content-center align-items-center">
							<img class="w-50" src="../../assets/img/work_in_progress.png">
							<p style="text-align: center; font-weight: 600; font-size: 20px; margin: 0">We are preparing this for you!</p>
							<p>Stay Tuned!</p>
						</div>
						<!-- <div class="requested-main d-flex flex-column h-100">
							<div class="label-div d-flex flex-row w-100">
								<h6>Time</h6>
								<h6 style="margin-left: 40px">Events</h6>
							</div>
							<div class="requested-wrapper w-100 d-flex flex-column">
								<div class="requested-div d-flex flex-row active w-100">
									<div class="stepper-container d-flex flex-column align-items-center h-100">
										<div class="stepper-circle"></div>
										<div class="stepper-line h-100"></div>
									</div>
									<div class="date-time-div d-flex flex-column h-100">
										<h6 class="date">Today</h6>
										<h6 class="time">10:00</h6>
									</div>
									<div class="requested d-flex flex-column h-100">
										<h6 class="invite-text">Figma Organization requested an "<b>International Jazz Festival</b>" event.</h6>
										<div class="purpose-div d-flex flex-column">
											<h6 class="label purpose">Purpose:</h6>
											<h6 class="label">This event aims to celebrate the rich heritage and diversity of jazz music while providing a platform for talented musicians from around the world to showcase their artistry</h6>
										</div>
										<div class="info-div d-flex flex-row w-100">
											<div class="notif-date d-flex flex-column">
												<h6 class="label">Date:</h6>
												<h6 class="input">17th, July 2023</h6>
											</div>
											<div class="notif-time d-flex flex-column">
												<h6 class="label">Time:</h6>
												<h6 class="input">10:00 - 11:30 am</h6>
											</div>
											<div class="notif-duration d-flex flex-column">
												<h6 class="label">Duration:</h6>
												<h6 class="input">2 hours and 45 minutes</h6>
											</div>
										</div>
										<div class="button-div d-flex flex-row justify-content-end">
											<button class="btn btn-primary manage-btn">Manage</button>
											<button class="btn btn-primary decline-btn">Decline</button>
											<button class="btn btn-primary view-btn">View Details</button>
										</div>
									</div>
								</div>

								<div class="requested-div d-flex flex-row active w-100">
									<div class="stepper-container d-flex flex-column align-items-center h-100">
										<div class="stepper-circle"></div>
										<div class="stepper-line h-100"></div>
									</div>
									<div class="date-time-div d-flex flex-column h-100">
										<h6 class="date">Today</h6>
										<h6 class="time">10:00</h6>
									</div>
									<div class="requested d-flex flex-column h-100">
										<h6 class="invite-text">Figma Organization requested an "<b>International Jazz Festival</b>" event.</h6>
										<div class="purpose-div d-flex flex-column">
											<h6 class="label purpose">Purpose:</h6>
											<h6 class="label">This event aims to celebrate the rich heritage and diversity of jazz music while providing a platform for talented musicians from around the world to showcase their artistry</h6>
										</div>
										<div class="info-div d-flex flex-row w-100">
											<div class="notif-date d-flex flex-column">
												<h6 class="label">Date:</h6>
												<h6 class="input">17th, July 2023</h6>
											</div>
											<div class="notif-time d-flex flex-column">
												<h6 class="label">Time:</h6>
												<h6 class="input">10:00 - 11:30 am</h6>
											</div>
											<div class="notif-duration d-flex flex-column">
												<h6 class="label">Duration:</h6>
												<h6 class="input">2 hours and 45 minutes</h6>
											</div>
										</div>
										<div class="button-div d-flex flex-row justify-content-end">
											<button class="btn btn-primary manage-btn">Manage</button>
											<button class="btn btn-primary decline-btn">Decline</button>
											<button class="btn btn-primary view-btn">View Details</button>
										</div>
									</div>
								</div>

							</div>
						</div> -->
					</div>



					<div class="modal fade decline-modal" id="decline-modal" tabindex="-1" aria-hidden="true">
						<div class="modal-dialog modal-lg modal-dialog-centered">
							<div class="modal-content">
								<div class="modal-body">
									<div class="modal-top-img w-100 d-flex flex-row justify-content-center align-items-end">
										<img src="../../assets/img/admin/event-modal-icon.svg" width="40%">
									</div>
									<div class="content-wrapper-modal">
										<h6><span>Why are you rejecting this<br>application?</span></h6>
										<select class="form-select reason-select">
											<option selected disabled hidden>Select a reason</option>
											<option value="1">One</option>
											<option value="2">Two</option>
											<option value="3">Three</option>
										</select>
										<div class="explain-div">
											<label for="exampleFormControlTextarea1" class="form-label">(Optional)</label>
											<textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
										</div>
									</div>
									<div class="btn-div d-flex flex-row justify-content-center">
										<button class="btn btn-primary back-btn">Back</button>
										<button class="btn btn-primary submit-btn">Submit</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include_once '../create-event-modal.php' ?>
</body>
<script src="../../assets/js/certificate.js"></script>
<script src="../../assets/js/admin.js"></script>
<script>
	function handleSubmit(id){
		$.ajax({
			type: "POST",
			url: "../../modules/organization/verify_org.php",
			data: {'account-id': id},
			success: function(response) {
				if (response == "Verified!") {
					setTimeout(function() {
						// Reload the page after 1 second
						window.location.reload();
					}, 1500)
				} else {
					console.log("SOMETHING WRONG");
				}
			}
		})

		event.preventDefault();
	}
</script>

</html>