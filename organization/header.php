<?php
include_once '../../includes/database.php';


session_start();

if(!isset($_SESSION['id'])){
    echo "Please login first!";
    exit();
}
else {
	if($_SESSION["faculty_role"] != "Organization") {
		echo "Page not found!";
		exit();
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<link rel="stylesheet" type="text/css" href="../../assets/css/template.css" />
	<link rel="stylesheet" type="text/css" href="../../assets/css/faculty.css" />
	<link rel='stylesheet' type='text/css' href='../../assets/css/create-event-modal.css' />
	<?php echo $css ?>

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
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

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
			<?php
				if($_SESSION["verified"] == 2){
					$sql = "SELECT ta.firstname, ta.lastname, tom.role
					FROM tbl_organization_members tom 
					INNER JOIN tbl_accounts ta ON ta.id = tom.account_id 
					WHERE tom.organization_id = ? AND ta.id = ? AND tom.status = 'Active'";
					foreach($db->process_db($sql, "ss", true, $_SESSION["org-id"], $_SESSION["acc-id"]) as $org_member){
						$position = $org_member["role"];
					
			?>
						<h6 class="admin-title"><?php echo $position ?> - <?php echo $_SESSION["org-shortname"] . " Org" ?></h6>
			<?php
					}
				}
				else {
					echo "<h6 class='admin-title'><span style='color: var(--red-1)'>Not Verified</span></h6>";
				}
			?>
		</div>
		<div class="sidebar-links">
			<ul class="nav nav-pills nav-justified d-flex flex-column">
				<li class="nav-item">
					<a class="nav-link <?php echo $dashboard ?> d-flex flex-row justify-content-between" aria-current="page" href="../dashboard/dashboard.php">
						<div class="icon-div d-flex flex-row">
							<img src="../../assets/img/admin/icon-dashboard<?php echo (isset($dashboard)) ? "-active" : "" ?>.svg" alt="Dashboard Logo" width="20">
							<h6>Home</h6>
						</div>
						<img src="../../assets/img/admin/icon-right<?php echo (isset($dashboard)) ? "-active" : "" ?>.svg" alt="Right" width="11" height="11">
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?php echo $events ?> d-flex flex-row justify-content-between" aria-current="page" href="../events/events.php">
						<div class="icon-div d-flex flex-row">
							<img src="../../assets/img/admin/icon-events<?php echo (isset($events)) ? "-active" : "" ?>.svg" alt="Dashboard Logo" width="20">
							<h6>Events</h6>
						</div>
						<img src="../../assets/img/admin/icon-right<?php echo (isset($events)) ? "-active" : "" ?>.svg" alt="Right" width="11" height="11">
					</a>
				</li>
				<?php
				if($_SESSION["verified"] == 2){
				?>
				<li class="nav-item">
					<a class="nav-link <?php echo $notifications ?> d-flex flex-row justify-content-between" aria-current="page" href="../notifications/notifications.php">
						<div class="icon-div d-flex flex-row">
							<img src="../../assets/img/admin/icon-notification<?php echo (isset($notifications)) ? "-active" : "" ?>.svg" alt="Dashboard Logo" width="20">
							<h6>Notifications</h6>
						</div>
						<img src="../../assets/img/admin/icon-right<?php echo (isset($notifications)) ? "-active" : "" ?>.svg" alt="Right" width="11" height="11">
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?php echo $organizations ?> d-flex flex-row justify-content-between" aria-current="page" href="../organizations/organizations.php">
						<div class="icon-div d-flex flex-row">
							<img src="../../assets/img/admin/icon-org<?php echo (isset($organizations)) ? "-active" : "" ?>.svg" alt="Dashboard Logo" width="18">
							<h6>Organizations</h6>
						</div>
						<img src="../../assets/img/admin/icon-right<?php echo (isset($organizations)) ? "-active" : "" ?>.svg" alt="Right" width="11" height="11">
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?php echo $certificates ?> d-flex flex-row justify-content-between" aria-current="page" href="../certificates/certificates.php">
						<div class="icon-div d-flex flex-row">
							<img src="../../assets/img/admin/icon-files<?php echo (isset($certificates)) ? "-active" : "" ?>.svg" alt="Dashboard Logo" width="19">
							<h6>Certificates</h6>
						</div>
						<img src="../../assets/img/admin/icon-right<?php echo (isset($certificates)) ? "-active" : "" ?>.svg" alt="Right" width="11" height="11">
					</a>
				</li>
				<?php
				}
				?>
				<li class="nav-item">
					<a class="nav-link <?php echo $settings ?> d-flex flex-row justify-content-between" aria-current="page" href="../settings/settings.php">
						<div class="icon-div d-flex flex-row">
							<img src="../../assets/img/admin/icon-settings<?php echo (isset($settings)) ? "-active" : "" ?>.svg" alt="Dashboard Logo" width="20">
							<h6>Settings</h6>
						</div>
						<img src="../../assets/img/admin/icon-right<?php echo (isset($settings)) ? "-active" : "" ?>.svg" alt="Right" width="11" height="11">
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
			<h6>Good day, <?php echo $_SESSION["firstname"] ?>! / <?php echo $top_greet ?>!</h6>
			<button type="button" class="btn btn-primary topbar-btn" data-bs-toggle="modal" data-bs-target="#modal-createEvent"><i class="fa-solid fa-plus"></i></button>
		</div>
		<div class="main-wrapper d-flex h-100">
			<div class="main panel d-flex flex-column">
