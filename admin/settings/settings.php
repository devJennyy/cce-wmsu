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
	<link rel="stylesheet" type="text/css" href="settings.css" />
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
					<a class="nav-link active d-flex flex-row justify-content-between" aria-current="page" href="#">
						<div class="icon-div d-flex flex-row">
							<img src="../../assets/img/admin/icon-settings-active.svg" alt="Dashboard Logo" width="20">
							<h6>Settings</h6>
						</div>
						<img src="../../assets/img/admin/icon-right-active.svg" alt="Right" width="11" height="11">
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
			<h6>Good day, Claire! / Welcome to your <span>Settings</span>!</h6>
			<button type="button" class="btn btn-primary topbar-btn" data-bs-toggle="modal" data-bs-target="#modal-createEvent"><i class="fa-solid fa-plus"></i></button>
		</div>
		<div class="main-wrapper h-100 d-flex flex-row">
			
			<div class="main panel h-100 w-100 d-flex flex-column">
				<ul class="nav nav-tabs d-flex flex-row justify-content-center" id="myTab" role="tablist">
					<li class="nav-item" role="presentation">
						<button class="nav-link active" id="manage-users-tab" data-bs-toggle="tab" data-bs-target="#manage-users-tab-pane" type="button" role="tab" aria-controls="manage-users-tab-pane" aria-selected="true">Manage Users</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="account-settings-tab" data-bs-toggle="tab" data-bs-target="#account-settings-tab-pane" type="button" role="tab" aria-controls="account-settings-tab-pane" aria-selected="false">Account Settings</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="content-settings-tab" data-bs-toggle="tab" data-bs-target="#content-settings-tab-pane" type="button" role="tab" aria-controls="content-settings-tab-pane" aria-selected="false">Content Settings</button>
					</li>
				</ul>
				<div class="tab-content w-100 h-100" id="myTabContent">
					<div class="tab-pane fade show active h-100 w-100 manage-users-tab-pane" id="manage-users-tab-pane" role="tabpanel" tabindex="0">
						<div class="h-100 w-100 d-flex flex-row">
							<div class="user-list-container h-100">
								<ul class="nav nav-tabs d-flex flex-row justify-content-between" id="userlist-tab" role="tablist">
									<li class="nav-item" role="presentation">
										<button class="nav-link active" id="allnames-tab" data-bs-toggle="tab" data-bs-target="#allnames-pane" type="button" role="tab" aria-controls="allnames-pane" aria-selected="true">All Users</button>
									</li>
									<!-- <li class="nav-item" role="presentation">
										<button class="nav-link" id="faculty-tab" data-bs-toggle="tab" data-bs-target="#faculty-tab-pane" type="button" role="tab" aria-controls="faculty-tab-pane" aria-selected="false">Faculties</button>
									</li>
									<li class="nav-item" role="presentation">
										<button class="nav-link" id="org-tab" data-bs-toggle="tab" data-bs-target="#org-tab-pane" type="button" role="tab" aria-controls="org-tab-pane" aria-selected="false">Organizations</button>
									</li>
									<li class="nav-item" role="presentation">
										<button class="nav-link" id="cce-tab" data-bs-toggle="tab" data-bs-target="#cce-tab-pane" type="button" role="tab" aria-controls="cce-tab-pane" aria-selected="false">CCE</button>
									</li> -->
								</ul>
								<div class="tab-content" id="userlist-tabContent">
									<div class="tab-pane fade allnames-pane show active " id="allnames-pane" role="tabpanel" aria-labelledby="allnames" tabindex="0">
										<table class="table list-table" id="allname-table">
											<thead style="display: none">
												<tr>
													<th scope="col"></th>
												</tr>
											</thead>
											<tbody>
												<?php
												foreach ($db->process_db("SELECT * FROM tbl_accounts WHERE faculty_role != 'Administrator' AND verified = 2", "", true, "") as $row) {
												?>
													<tr class="member-row">
														<td>
															<button onclick="getUser(<?php echo $row['id'] ?>)" class="d-flex flex-row justify-content-between align-items-center w-100">
																<div class="d-flex flex-row">
																	<div class="picture"></div>
																	<div class="data-info">
																		<h6 class="name"><?php echo $row["firstname"] . " " . $row["lastname"] ?></h6>
																		<h6 class="role"><?php echo $row["faculty_role"] . " Faculty" ?></h6>
																	</div>
																</div>

																<i class="fa-solid fa-chevron-right"></i>
															</button>
														</td>
													</tr>
												<?php
												}
												?>

											</tbody>
										</table>
									</div>
									<div class="tab-pane fade faculty-tab-pane" id="faculty-tab-pane" role="tabpanel" aria-labelledby="faculty-tab" tabindex="0">
										<table class="table list-table w-100" id="faculty-table">
											<thead>
												<tr>
													<th scope="col">
														<button class="add-faculty-btn">Add Faculty Roles +</button>
													</th>
												</tr>
											</thead>

											<tbody>
												<tr class="member-row">
													<td>
														<button class="d-flex flex-row justify-content-between align-items-center w-100">
															<div class="d-flex flex-row">
																<div class="data-info">
																	<h6 class="name">College of Computer Studies - (CCS) Faculty</h6>
																</div>
															</div>

															<i class="fa-solid fa-chevron-right"></i>
														</button>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="tab-pane fade" id="org-tab-pane" role="tabpanel" aria-labelledby="org-tab" tabindex="0">
										Organizations
									</div>
									<div class="tab-pane fade" id="cce-tab-pane" role="tabpanel" aria-labelledby="cce-tab" tabindex="0">
										CCE
									</div>
								</div>

							</div>
							<div class="user-info h-100 d-flex flex-row justify-content-center align-items-center">
								<div id="user-card" class="user-info-card d-flex flex-column w-100 h-100">
									<div class="buttons-top d-flex flex-row justify-content-between">
										<a></a>
										<a data-bs-toggle="modal" data-bs-target="#delete-user-modal"><img src="../../assets/img/admin/user-card-edit.svg"></a>
									</div>
									<div class="avatar-container d-flex flex-column align-items-center">
										<div class="image-wrapper">

										</div>
										<h6 id="user-fullname" class="value" style="font-weight: 600; font-size: 14px; margin-bottom: 4px">Jenny Pieloor</h6>
										<h6 id="user-role" class="value" style="font-size: 14px">CCS - Faculty Member</h6>
									</div>
									<div class="personal-details-container mt-3 d-flex flex-column">
										<h6 class="header-text">PERSONAL DETAILS</h6>
										<div class="info-container d-flex flex-row">
											<img src="../../assets/img/admin/user-card-info-icon.svg">
											<h6 class="label">First name</h6>
											<h6 id="user-firstname" class="value">Jenny</h6>
										</div>
										<div class="info-container d-flex flex-row">
											<img src="../../assets/img/admin/user-card-info-icon.svg">
											<h6 class="label">Last name</h6>
											<h6 id="user-lastname" class="value">Pieloor</h6>
										</div>
									</div>
									<div class="contact-details-container mt-3">
										<h6 class="header-text">CONTACT DETAILS</h6>
										<div class="info-container d-flex flex-row">
											<img src="../../assets/img/admin/usercard-username-icon.svg" width="24" height="24">
											<h6 class="label">Username</h6>
											<h6 id="user-username" class="value">gt201900070@wmsu.com</h6>
										</div>
										<div class="info-container d-flex flex-row">
											<img src="../../assets/img/admin/usercard-email-icon.svg">
											<h6 class="label">Email</h6>
											<h6 id="user-email" class="value">jennypieloor.connect@gmail.com</h6>
										</div>
										<div class="info-container d-flex flex-row">
											<img src="../../assets/img/admin/usercard-email-icon.svg">
											<h6 class="label">Last Online</h6>
											<h6 id="user-lastonline" class="value">December 05, 2023</h6>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade show h-100 w-100 account-settings-tab-pane" id="account-settings-tab-pane" role="tabpanel" tabindex="0">
						<div class="account-settings-container h-100 w-100">
							<ul class="nav nav-tabs pe-3 d-flex flex-row justify-content-center" id="yourAccount" role="tablist">
								<li class="nav-item" role="presentation">
									<button class="nav-link active" id="your-account-tab" data-bs-toggle="tab" data-bs-target="#your-account-tab-pane" type="button" role="tab" aria-selected="true">Your Account</button>
								</li>
								<li class="nav-item" role="presentation">
									<button class="nav-link" id="create-account-tab" data-bs-toggle="tab" data-bs-target="#create-account-tab-pane" type="button" role="tab" aria-selected="false">Create new account</button>
								</li>
							</ul>
							<div class="tab-content w-100 h-100" id="yourAccountContent">
								<div class="tab-pane fade show active h-100 w-100 your-account-tab-pane" id="your-account-tab-pane" role="tabpanel" tabindex="0">
									<form class="h-100 flex-shrink-1 d-flex flex-row pt-4" method="POST" action="../../modules/settings/update_account.php" id="edit-account-form">
										<?php
										$sql = "SELECT * FROM tbl_accounts WHERE id = ?";
										foreach ($db->process_db($sql, "s", true, $_SESSION["id"]) as $user) {
										?>
											<div class="upload-pfp-container d-flex flex-row justify-content-center py-3 w-50 h-100 flex-grow-1">
												<div class="w-75 d-flex justify-content-center">
													<div class="w-75 h-75 d-flex flex-column">
														<h6>Upload Profile Picture</h6>
														<div class="w-100 h-100 py-4 px-4 d-flex justify-content-center flex-grow-1">
															<div class=" w-75 h-100 d-flex align-items-center justify-content-center" style="position: relative;">
																<div style="height: 160px; width: 160px; border-radius: 50%; background-color: red; outline: 8px var(--red-1) solid; outline-offset: 6px">

																</div>
																<label for="fileInput" class="d-flex flex-row align-items-center justify-content-center me-4 mb-4" style="right: 0; bottom: 0; cursor: pointer; position: absolute; width: 36px; height: 36px; border-radius: 50%; background: #F5F5F5; border: 4px white solid;">
																	<i class="fa-solid fa-camera" style="color: rgba(0, 0, 0, .6)"></i>
																	<input type="file" name="user-img" id="fileInput" class="sr-only" style="display: none;">
																</label>
															</div>
														</div>
														<div class="w-100 h-75 d-flex flex-column gap-2	 flex-grow-1">
															<div class="w-100">
																<h6 class="form-label m-0 mb-1">College</h6>
																<input type="text" class="form-control px-3 py-2" placeholder="Role" value="<?php echo $user["faculty_role"] ?>" readonly>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="add-details-container py-3 w-50 flex-grow-1">
												<div class="w-75 d-flex justify-content-center">
													<div class="w-100 h-100 d-flex flex-column">
														<input name="user-id" value="<?php echo $_SESSION["id"] ?>" hidden>
														<h6 class="mb-4">Personal Details</h6>

														<div class="w-100 h-75 d-flex flex-column gap-2	flex-grow-1">
															<div class="w-100">
																<h6 class="form-label m-0 mb-1">First name</h6>
																<input type="text" class="form-control px-3 py-2" name="edit-firstname" value="<?php echo $user["firstname"] ?>" placeholder="Enter first name" required>
															</div>
															<div class="w-100">
																<h6 class="form-label m-0 mb-1">Last name</h6>
																<input type="text" class="form-control px-3 py-2" name="edit-lastname" value="<?php echo $user["lastname"] ?>" placeholder="Enter last name" required>
															</div>
															<div class="w-100">
																<h6 class="form-label m-0 mb-1">Email</h6>
																<input type="email" class="form-control px-3 py-2" name="edit-email" value="<?php echo $user["email"] ?>" placeholder="Enter email" required>
															</div>
															<div class="w-100">
																<h6 class="form-label m-0 mb-1">Username</h6>
																<input type="text" class="form-control px-3 py-2" name="edit-username" value="<?php echo $user["username"] ?>" placeholder="Enter username" required>
															</div>
															<div class="w-100">
																<h6 class="form-label m-0 mb-1">Password</h6>
																<input type="password" class="form-control px-3 py-2" name="edit-password" placeholder="Enter new password">
															</div>
															<div class="w-100">
																<button type="submit" name="submit" class="btn btn-primary w-100" style="border-radius: 2px !important;background: #9C2B23 !important; border: 0 !important">Update your Profile</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										<?php
										}
										?>


									</form>
								</div>
								<div class="tab-pane fade show h-100 w-100 create-account-tab-pane" id="create-account-tab-pane" role="tabpanel" tabindex="0">
									<form class="h-100 flex-shrink-1 d-flex flex-row pt-4" method="POST" action="../../modules/settings/create_account.php" id="create-account-form">
										<div class="upload-pfp-container d-flex flex-row justify-content-center py-3 w-50 h-100 flex-grow-1">
											<div class="w-75 d-flex justify-content-center">
												<div class="w-75 h-75 d-flex flex-column">
													<h6>Upload Profile Picture</h6>
													<div class="w-100 h-100 py-4 px-4 d-flex justify-content-center flex-grow-1">
														<div class="w-75 h-100" style="border: 2px rgba(0, 0, 0, .6) dashed; border-radius: 24px">
															<label for="fileInput" class="w-100 h-100" style="display: flex; flex-direction: column; align-items: center; justify-content: center; cursor: pointer;">
																<i class="fa-regular fa-image" style="font-size: 48px; color: rgba(0, 0, 0, .6)"></i>
																<span class="mt-2">Upload your photo</span>
																<input type="file" id="fileInput" class="sr-only" style="display: none;">
															</label>
														</div>
													</div>
													<div class="w-100 h-75 d-flex flex-column gap-2	 flex-grow-1">
														<div class="w-100">
															<h6 class="form-label m-0 mb-1">Roles</h6>
															<select name="role" class="form-select flex-grow-1 px-3 py-2" id="role-select" required>
																<option value="Admin" selected>Admin</option>
																<option value="Faculty">Faculty</option>
																<option value="Organization Member">Organization Member</option>
															</select>
														</div>
														<div class="w-100" id="college-div" style="display: none">
															<h6 class="form-label m-0 mb-1">College</h6>
															<select name="college" class="form-select flex-grow-1 px-3 py-2" required>

																<?php
																foreach ($db->process_db("SELECT * FROM tbl_faculty_list", "", true, "") as $faculty) {
																?>
																	<option value="<?php echo $faculty["abbreviation"] ?>" selected><?php echo $faculty["faculty_name"] ?></option>
																<?php
																}
																?>
																<option hidden value='No College' selected>Select...</option>
															</select>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="add-details-container py-3 w-50 flex-grow-1">
											<div class="w-75 d-flex justify-content-center">
												<div class="w-100 h-100 d-flex flex-column">
													<h6 class="mb-4">Personal Details</h6>

													<div class="w-100 h-75 d-flex flex-column gap-2	flex-grow-1">
														<div class="w-100">
															<h6 class="form-label m-0 mb-1">First name</h6>
															<input type="text" class="form-control px-3 py-2" name="add-firstname" placeholder="Enter first name" required>
														</div>
														<div class="w-100">
															<h6 class="form-label m-0 mb-1">Last name</h6>
															<input type="text" class="form-control px-3 py-2" name="add-lastname" placeholder="Enter last name" required>
														</div>
														<div class="w-100">
															<h6 class="form-label m-0 mb-1">Email</h6>
															<input type="email" class="form-control px-3 py-2" name="add-email" placeholder="Enter email" required>
														</div>
														<div class="w-100">
															<h6 class="form-label m-0 mb-1">Username</h6>
															<input type="text" class="form-control px-3 py-2" name="add-username" placeholder="Enter username" required>
														</div>
														<div class="w-100">
															<h6 class="form-label m-0 mb-1">Password</h6>
															<input type="password" class="form-control px-3 py-2" name="add-password" placeholder="Enter password" required>
														</div>
														<div class="w-100">
															<button type="submit" class="btn btn-primary w-100" style="border-radius: 2px !important;background: #9C2B23 !important; border: 0 !important">Create new Profile</button>

														</div>
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade show h-100 w-100 content-settings-tab-pane" id="content-settings-tab-pane" role="tabpanel" tabindex="0">
						<div class="under-construction gap-3 h-100 w-100 d-flex flex-column justify-content-center align-items-center">
							<img class="w-50" src="../../assets/img/work_in_progress.png">
							<p style="text-align: center; font-weight: 600; font-size: 20px; margin: 0">We are preparing this for you!</p>
							<p>Stay Tuned!</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		

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
	<?php include_once '../create-event-modal.php' ?>
</body>
<script src="../../assets/js/certificate.js"></script>
<script src="../../assets/js/admin.js"></script>
<script>
	function formatDate(inputDate) {
		const months = [
			"January", "February", "March", "April", "May", "June",
			"July", "August", "September", "October", "November", "December"
		];

		const dateObj = new Date(inputDate);

		const month = months[dateObj.getMonth()];
		const day = dateObj.getDate();
		const year = dateObj.getFullYear();

		return `${month} ${day}, ${year}`;
	}

	function getUser(id) {
		$.ajax({
			type: "POST",
			url: "../../modules/settings/get_user.php",
			data: {
				acc_id: id,
			},
			success: function(response) {
				console.log(response);
				$('#user-fullname').text(response.fullname);
				$('#user-firstname').text(response.firstname);
				$('#user-lastname').text(response.lastname);
				$('#user-role').text(response.role);
				$('#user-username').text(response.username);
				$('#user-email').text(response.email);
				$('#user-id').attr("value", response.id);
				$('#user-lastonline').text(formatDate(response.last_online));
				$('#user-card')[0].style.setProperty("display", "block", "important");
			}
		})
	};

	$(document).ready(function() {
		$('#user-card')[0].style.setProperty("display", "none", "important");

		$('#role-select').on("change", function() {
			if ($('#role-select').val() == 'Faculty') {
				$('#college-div')[0].style.setProperty("display", "block", "important");
			} else {
				$('#college-div')[0].style.setProperty("display", "none", "important");
			}
		});
		if ($('#role-select').val() == 'Faculty') {
			$('#college-div')
		}
		$('#allname-table, #faculty-table').DataTable({
			scrollCollapse: true,
			paging: true,
			bInfo: false,
			sorting: false,
			ordering: false,
			"pageLength": 6,
			"language": {
				"search": "",
				"searchPlaceholder": "Search names or email",
				"paginate": {
					"previous": "<",
					"next": ">"
				}
			}

		});

		$('#create-account-form').submit(function(event) {
			event.preventDefault();
			$.ajax({
				type: "POST",
				url: "../../modules/settings/create_account.php",
				data: $(this).serialize(),
				success: function(response) {
					if (response == "User already exist!") {
						showError("User already exist!", "danger");
					} else {
						showError("User created!", "success");
						$('input[name="add-firstname"]').val('');
						$('input[name="add-lastname"]').val('');
						$('input[name="add-email"]').val('');
						$('input[name="add-username"]').val('');
						$('input[name="add-password"]').val('');
					}
				}
			})
		});
	})
</script>

</html>