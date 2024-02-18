<?php
session_start();

include_once './includes/database.php';

if (isset($_SESSION["faculty_role"])) {
	if ($_SESSION["faculty_role"] == "Administrator") {
		header("Location: ./admin/dashboard/dashboard.php");
	} elseif ($_SESSION["faculty_role"] == "Organization") {
		header("Location: ./organization/dashboard/dashboard.php");
	} else {
		header("Location: ./faculty/dashboard/dashboard.php");
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<link rel="stylesheet" type="text/css" href="assets/css/template.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/index.css" />

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

	<title>Center of Continuing Education</title>
	<link rel="icon" type="image/x-icon" href="assets/img/logo/cce-logo.png">
</head>

<body>
	<!-- ====================================================================================
                                           NAVIGATION BAR
         ================================================================================== -->
	<nav class="navbar navbar-expand-lg w-100" id="navbar">
		<div class="container-fluid p-2">
			<div class="logo-div">
				<img src="assets/img/logo/wmsu-logo.png" width="64" alt="WMSU">
				<img src="assets/img/logo/cce-logo.png" width="64" alt="CCE">
			</div>

			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse nav-center" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link active" href="#home">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="#events">Events</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="#personnel">Personnel</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="#about_us">About Us</a>
					</li>
				</ul>
			</div>

			<div class="button-div d-flex flex-row">
				<button type="button" class="btn btn-primary btn-login" data-bs-toggle="modal" data-bs-target="#login-modal">Log in</button>
				<div class="dropdown">
					<button type="button" class="btn btn-primary btn-signup dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Sign up</button>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#register-faculty-modal">Faculty</a></li>
						<li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#register-org-modal">Organization</a></li>
					</ul>
				</div>
			</div>
		</div>
	</nav>

	<!-- ====================================================================================
                                           		HOME
         ================================================================================== -->
	<section class="home" id="home">
		<div class="home-container d-flex flex-column w-100 h-100">
			<div class="header-img w-100">
				<div id="carouselExample" class="carousel slide carousel-fade" data-bs-ride="carousel">
					<div class="carousel-inner">
						<div class="carousel-item active">
							<img src="./assets/img/home/carousel/carousel5.JPG" class="d-block w-100" data-bs-interval="5000">
						</div>
						<div class="carousel-item">
							<img src="./assets/img/home/carousel/carousel2.JPG" class="d-block w-100" data-bs-interval="5000">
						</div>
						<div class="carousel-item">
							<img src="./assets/img/home/carousel/carousel3.JPG" class="d-block w-100" data-bs-interval="5000">
						</div>
						<div class="carousel-item">
							<img src="./assets/img/home/carousel/carousel4.JPG" class="d-block w-100" data-bs-interval="5000">
						</div>
						<div class="carousel-item">
							<img src="./assets/img/home/carousel/carousel1.JPG" class="d-block w-100" data-bs-interval="5000">
						</div>
						<div class="carousel-item">
							<img src="./assets/img/home/carousel/carousel6.JPG" class="d-block w-100" data-bs-interval="5000">
						</div>
						<div class="carousel-item">
							<img src="./assets/img/home/carousel/carousel7.JPG" class="d-block w-100" data-bs-interval="5000">
						</div>
						<div class="carousel-item">
							<img src="./assets/img/home/carousel/carousel8.JPG" class="d-block w-100" data-bs-interval="5000">
						</div>
					</div>
				</div>
				<div class="img-overlay w-100 h-100"></div>
			</div>

			<div class="home-content w-100 d-flex flex-row">
				<div class="home-img">
					<img class="left-pattern" src="assets/img/home/left-pattern.svg" alt="Pattern">
					<img class="right-pattern" src="assets/img/home/right-pattern.svg" alt="Pattern">

					<div class="main-img">
						<div id="carouselExample" class="carousel slide carousel-fade" data-bs-ride="carousel">
							<div class="carousel-inner">
								<div class="carousel-item active">
									<img src="./assets/img/home/carousel/carousel5.JPG" class="d-block w-100" data-bs-interval="5000">
								</div>
								<div class="carousel-item">
									<img src="./assets/img/home/carousel/carousel2.JPG" class="d-block w-100" data-bs-interval="5000">
								</div>
								<div class="carousel-item">
									<img src="./assets/img/home/carousel/carousel3.JPG" class="d-block w-100" data-bs-interval="5000">
								</div>
								<div class="carousel-item">
									<img src="./assets/img/home/carousel/carousel4.JPG" class="d-block w-100" data-bs-interval="5000">
								</div>
								<div class="carousel-item">
									<img src="./assets/img/home/carousel/carousel1.JPG" class="d-block w-100" data-bs-interval="5000">
								</div>
								<div class="carousel-item">
									<img src="./assets/img/home/carousel/carousel6.JPG" class="d-block w-100" data-bs-interval="5000">
								</div>
								<div class="carousel-item">
									<img src="./assets/img/home/carousel/carousel7.JPG" class="d-block w-100" data-bs-interval="5000">
								</div>
								<div class="carousel-item">
									<img src="./assets/img/home/carousel/carousel8.JPG" class="d-block w-100" data-bs-interval="5000">
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="home-text">
					<h1>Center of Continuing Education</h1>
					<p>The center for Continuing Education (CCE) provides training to University clientele and outside customers. The office shall design activities exigent to smooth and effective operation of the University’s training programs.</p>
					<p>Join us in our engaging webinars to earn certificates and enhance your skills while staying updated on the latest trends and developments. Don't miss this opportunity for professional growth and learning with us.</p>
					<button class="btn btn-primary get-started-btn" type="button" data-bs-toggle="modal" data-bs-target="#register-faculty-modal">Get started</button>
				</div>
			</div>
		</div>
	</section>


	<!-- ====================================================================================
                                           		EVENTS
         ================================================================================== -->
	<div class="divider-wrapper" id="events">
		<div class="divider">
			<div class="divider-content">
				<h2>Events</h2>
			</div>
		</div>
	</div>

	<section class="events">
		<div class="events-container h-100 d-flex flex-column m-auto">
			<div class="upcoming-events">
				<h2>Upcoming Events</h2>
				<?php
				foreach ($db->process_db("SELECT COUNT(*) AS event_count FROM tbl_events WHERE day >= ? AND visibility != 3 AND status = 5 ORDER BY day ASC LIMIT 4", "s", true, date("Y-m-d")) as $result) {
					$countTotal = $result["event_count"];
				}
				?>
				<div class="card-wrapper d-flex flex-row flex-wrap" style="<?php echo ($countTotal < 4) ? 'justify-content: start; gap: 20px' : 'justify-content: space-between' ?>">
					<?php
					$upEventCount = 0;
					$sql = "SELECT * FROM tbl_events WHERE day >= ? AND visibility != 3 AND status = 5 ORDER BY day ASC LIMIT 4 ";
					foreach ($db->process_db($sql, "s", true, date("Y-m-d")) as $upcoming_event) {
						$upEventCount++;
					?>
						<div class="card upcoming-card" style="max-width: 300px;">
							<!-- <img src="assets/img/home/event-img-placeholder.svg" class="card-img-top" alt="Event Image" height="202"> -->
							<img <?php echo ($upcoming_event["attachment"] == NULL) ? 'src="./assets/img/home/event-img-placeholder.svg"' : 'src="./assets/attachments/events/' . $upcoming_event["attachment"] . '"' ?> style="object-fit: cover" class="card-img-top" alt="Event Image" height="201">
							<img src="assets/img/home/placeholder-bottom.svg" class="card-img-bottom" alt="Event Image">
							<button class="btn btn-primary join-btn" style="border: 2px white solid !important" data-bs-toggle="modal" data-bs-target="#login-modal">Join Event</button>

							<div class="card-body d-flex flex-column align-items-center">
								<h6 class="card-title"><?php echo $upcoming_event["title"] ?></h6>
								<div class="details d-flex flex-row">
									<i class="fa-solid fa-location-dot"></i>
									<p class="details-text" style="width: 90%; text-align: center; text-overflow:ellipsis; overflow: hidden; white-space: nowrap;"><?php echo $upcoming_event["venue"] ?></p>
								</div>

								<div class="details d-flex flex-row">
									<i class="fa-regular fa-calendar-minus"></i>
									<p class="details-text"><?php echo date_format(date_create($upcoming_event["day"]), "F d, Y") ?></p>
								</div>

								<div class="details d-flex flex-row">
									<i class="fa-regular fa-clock" style="font-size: 13px; margin-top: 2px"></i>
									<p class="details-text"><?php echo date_format(date_create($upcoming_event["startTime"]), "h:i A") ?> - <?php echo date_format(date_create($upcoming_event["endTime"]), "h:i A") ?></p>
								</div>
							</div>

							<div class="card-footer d-flex flex-row justify-content-between">
								<p>View event information here</p>
								<div class="event-link d-flex justify-content-center align-items-center">
									<a class="fa-solid fa-link" data-bs-toggle="modal" data-bs-target="#login-modal"></a>
								</div>
							</div>
						</div>
					<?php
					}
					?>
				</div>
			</div>

			<div class="general-events">
				<h2>General Events</h2>
				<div class="card-wrapper d-flex flex-row flex-wrap justify-content-between">
					<div class="card general-card" style="max-width: 320px;">
						<img src="assets/img/home/general-events/Newly Hired Faculty (Final).jpg" class="card-img-top" alt="Event Image" height="160px">
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
								<h6 class="card-title">Onboarding Seminar for Newly Hired Faculty</h6>
								<div class="event-location d-flex flex-row">
									<i class="fa-solid fa-location-dot"></i>
									<p class="details-text">College of Engineering, AVR</p>
								</div>
							</div>

							<a href="#" data-bs-toggle="modal" data-bs-target="#login-modal">More details...</a>
						</div>
					</div>

					<div class="card general-card" style="max-width: 320px;">
						<img src="assets/img/home/general-events/Tarpaulin 6x8.jpg" class="card-img-top" alt="Event Image" height="160px">
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
								<h6 class="card-title">Onboarding Seminar for Newly Hired Administrative Personnel</h6>
								<div class="event-location d-flex flex-row">
									<i class="fa-solid fa-location-dot"></i>
									<p class="details-text">College of Home Economics, Function Room</p>
								</div>
							</div>

							<a href="#" data-bs-toggle="modal" data-bs-target="#login-modal">More details...</a>
						</div>
					</div>

					<div class="card general-card" style="max-width: 320px;">
						<img src="assets/img/home/general-events/Tarpaulin.png" class="card-img-top" alt="Event Image" height="160px">
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
								<h6 class="card-title">El Primer Ayuda: A First Aid Training for the WMSU Community</h6>
								<div class="event-location d-flex flex-row">
									<i class="fa-solid fa-location-dot"></i>
									<p class="details-text">WMSU Training Center</p>
								</div>
							</div>

							<a href="#" data-bs-toggle="modal" data-bs-target="#login-modal">More details...</a>
						</div>
					</div>

					<div class="card general-card" style="max-width: 320px;">
						<img src="assets/img/home/general-events/PROGRAM VIRTUAL2.png" class="card-img-top" alt="Event Image" height="160px">
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
								<h6 class="card-title">Webinar on Health and Safety Guidelines in Workplace</h6>
								<div class="event-location d-flex flex-row">
									<i class="fa-solid fa-location-dot"></i>
									<p class="details-text">Somewhere, Philippines</p>
								</div>
							</div>

							<a href="#" data-bs-toggle="modal" data-bs-target="#login-modal">More details...</a>
						</div>
					</div>

					<div class="card general-card" style="max-width: 320px;">
						<img src="assets/img/home/general-events/PROGRAM VIRTUAL1.png" class="card-img-top" alt="Event Image" height="160px">
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
								<h6 class="card-title">Webinar on Parenting for Home Learning During the COVID-19 Pandemic</h6>
								<div class="event-location d-flex flex-row">
									<i class="fa-solid fa-location-dot"></i>
									<p class="details-text">Somewhere, Philippines</p>
								</div>
							</div>

							<a href="#" data-bs-toggle="modal" data-bs-target="#login-modal">More details...</a>
						</div>
					</div>

					<div class="card general-card" style="max-width: 320px;">
						<img src="assets/img/home/general-events/Moodle Virtual Layout.png" class="card-img-top" alt="Event Image" height="160px">
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
								<h6 class="card-title">Customized LMS Moodle Platform</h6>
								<div class="event-location d-flex flex-row">
									<i class="fa-solid fa-location-dot"></i>
									<p class="details-text">Somewhere, Philippines</p>
								</div>
							</div>

							<a href="#" data-bs-toggle="modal" data-bs-target="#login-modal">More details...</a>
						</div>
					</div>

					<div class="card general-card" style="max-width: 320px;">
						<img src="assets/img/home/event-img-placeholder.svg" class="card-img-top" alt="Event Image" height="160px">
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

							<a href="#" data-bs-toggle="modal" data-bs-target="#login-modal">More details...</a>
						</div>
					</div>

					<div class="card general-card" style="max-width: 320px;">
						<img src="assets/img/home/event-img-placeholder.svg" class="card-img-top" alt="Event Image" height="160px">
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

							<a href="#" data-bs-toggle="modal" data-bs-target="#login-modal">More details...</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


	<!-- ====================================================================================
                                           		PERSONNEL
         ================================================================================== -->
	<div class="divider-wrapper" id="personnel">
		<div class="divider">
			<div class="divider-content">
				<h2>Management <span>Team</span></h2>
			</div>
		</div>
	</div>

	<section class="personnel">
		<div class="personnel-container d-flex flex-column m-auto">
			<div class="personnel-wrapper w-100 d-flex flex-row flex-wrap justify-content-between">
				<div class="our-team" style="max-width: 320px;">
					<div class="pic">
						<img src="assets/img/home/personnel/Claire.jpg" alt="" />
					</div>
					<div class="team-content">
						<h3 class="name">Dr. Claire A. Madrazo</h3>
						<span class="post">CCE Director</span>
					</div>
					<ul class="social">
						<li><a href="#" class="fa-brands fa-facebook"></a></li>
						<li><a href="#" class="fa-brands fa-twitter"></a></li>
						<li><a href="#" class="fa-brands fa-instagram"></a></li>
						<li><a href="#" class="fa-solid fa-envelope"></a></li>
					</ul>
				</div>

				<div class="our-team" style="max-width: 320px;">
					<div class="pic">
						<img src="assets/img/home/personnel/Mr. Keynard L. Ponce (CCE Assistant to Director).jpeg" alt="" />
					</div>
					<div class="team-content">
						<h3 class="name">Mr. Keynard L. Ponce</h3>
						<span class="post">CCE Assistant to Director</span>
					</div>
					<ul class="social">
						<li><a href="#" class="fa-brands fa-facebook"></a></li>
						<li><a href="#" class="fa-brands fa-twitter"></a></li>
						<li><a href="#" class="fa-brands fa-instagram"></a></li>
						<li><a href="#" class="fa-solid fa-envelope"></a></li>
					</ul>
				</div>

				<div class="our-team" style="max-width: 320px;">
					<div class="pic">
						<img src="assets/img/home/personnel/Ms. Nefretere J. Ingkoh (CCE STAFF).jpg" alt="" />
					</div>
					<div class="team-content">
						<h3 class="name">Ms. Nefretere J. Ingkoh</h3>
						<span class="post">CCE Staff</span>
					</div>
					<ul class="social">
						<li><a href="#" class="fa-brands fa-facebook"></a></li>
						<li><a href="#" class="fa-brands fa-twitter"></a></li>
						<li><a href="#" class="fa-brands fa-instagram"></a></li>
						<li><a href="#" class="fa-solid fa-envelope"></a></li>
					</ul>
				</div>

				<div class="our-team" style="max-width: 320px;">
					<div class="pic">
						<img src="assets/img/home/personnel/Ms. Aicel Joy L. Caberte (CCE STAFF).jpg" alt="" />
					</div>
					<div class="team-content">
						<h3 class="name">Ms. Aicel Joy L. Caberte</h3>
						<span class="post">CCE Staff</span>
					</div>
					<ul class="social">
						<li><a href="#" class="fa-brands fa-facebook"></a></li>
						<li><a href="#" class="fa-brands fa-twitter"></a></li>
						<li><a href="#" class="fa-brands fa-instagram"></a></li>
						<li><a href="#" class="fa-solid fa-envelope"></a></li>
					</ul>
				</div>

				<div class="our-team" style="max-width: 320px;">
					<div class="pic">
						<img src="assets/img/home/personnel/Mr. Marc Luie Fernando (CCE STAFF).jpeg" alt="" />
					</div>
					<div class="team-content">
						<h3 class="name">Mr. Marc Louie Fernando</h3>
						<span class="post">CCE Staff</span>
					</div>
					<ul class="social">
						<li><a href="#" class="fa-brands fa-facebook"></a></li>
						<li><a href="#" class="fa-brands fa-twitter"></a></li>
						<li><a href="#" class="fa-brands fa-instagram"></a></li>
						<li><a href="#" class="fa-solid fa-envelope"></a></li>
					</ul>
				</div>

				<div class="our-team" style="max-width: 320px;">
					<div class="pic">
						<img src="assets/img/home/personnel-img.jpg" alt="" />
					</div>
					<div class="team-content">
						<h3 class="name">Jane Smith</h3>
						<span class="post"> Member</span>
					</div>
					<ul class="social">
						<li><a href="#" class="fa-brands fa-facebook"></a></li>
						<li><a href="#" class="fa-brands fa-twitter"></a></li>
						<li><a href="#" class="fa-brands fa-instagram"></a></li>
						<li><a href="#" class="fa-solid fa-envelope"></a></li>
					</ul>
				</div>

				<div class="our-team" style="max-width: 320px;">
					<div class="pic">
						<img src="assets/img/home/personnel-img.jpg" alt="" />
					</div>
					<div class="team-content">
						<h3 class="name">Jane Smith</h3>
						<span class="post"> Member</span>
					</div>
					<ul class="social">
						<li><a href="#" class="fa-brands fa-facebook"></a></li>
						<li><a href="#" class="fa-brands fa-twitter"></a></li>
						<li><a href="#" class="fa-brands fa-instagram"></a></li>
						<li><a href="#" class="fa-solid fa-envelope"></a></li>
					</ul>
				</div>

				<div class="our-team" style="max-width: 320px;">
					<div class="pic">
						<img src="assets/img/home/personnel-img.jpg" alt="" />
					</div>
					<div class="team-content">
						<h3 class="name">Jane Smith</h3>
						<span class="post"> Member</span>
					</div>
					<ul class="social">
						<li><a href="#" class="fa-brands fa-facebook"></a></li>
						<li><a href="#" class="fa-brands fa-twitter"></a></li>
						<li><a href="#" class="fa-brands fa-instagram"></a></li>
						<li><a href="#" class="fa-solid fa-envelope"></a></li>
					</ul>
				</div>
			</div>
		</div>
	</section>


	<!-- ====================================================================================
                                           		ABOUT US
         ================================================================================== -->
	<div class="divider-wrapper" id="about_us">
		<div class="divider">
			<div class="divider-content">
				<h2>About <span>Us</span></h2>
			</div>
		</div>
	</div>

	<section class="about-us">
		<div class="about-us-container d-flex flex-row justify-content-between m-auto">
			<div class="mission">
				<p>CCE MISSION<br>
					The Center for Continuing Education is a dynamic and sustainable income generating program that
					advances vital human resource and high standard management to develop competent, efficient,
					productive and forward looking individuals.</p>
			</div>
			<div class="vision">
				<p>GOALS<br>
					To enhance the quality of services to clients; To produce knowledgeable and skilled individuals; To
					provide quality training and review/enhancement programs; and To sustain current operations and
					support anticipated expansion of programs and services through linkages with other agencies.</p>
			</div>
		</div>
	</section>


	<!-- ====================================================================================
                                           		MODAL
         ================================================================================== -->
	<div class="modal fade" id="register-faculty-modal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-body">
					<div class="close-div d-flex justify-content-end">
						<a data-bs-dismiss="modal" style="cursor: pointer"><i class="fa-solid fa-xmark"></i></a>
					</div>
					<div class="modal-title-text">
						<h2>Welcome to <span>CCE!</span></h2>
						<label>Please register to continue</label>
					</div>
					<form class="form-div" method="POST" action="./modules/faculty/create_faculty_acc.php" enctype="multipart/form-data">
						<div class="personal-details-wrapper" id="personal-details-field">
							<div class="personal-details-container d-flex flex-column row-gap-2">
								<h6>PERSONAL DETAILS</h6>
								<div class="input-field firstname">
									<input class="form-control" name="firstname" id="firstname" placeholder="Firstname" required>
								</div>
								<div class="input-field middlename">
									<input class="form-control" name="middlename" id="middlename-org" placeholder="Middlename">
								</div>
								<div class="input-field lastname">
									<input class="form-control" name="lastname" id="lastname-org" placeholder="Lastname" required>
								</div>
								<div class="input-field">
									<input class="form-control" id="username" name="username" placeholder="Username" required>
								</div>
								<div class="input-field">
									<input type="email" class="form-control" name="email" id="email" placeholder="Email Address" required>
								</div>
								<div class="input-field d-flex flex-row gap-2 password">
									<input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
									<input type="password" class="form-control" name="confirm_pass" id="confirm_pass" placeholder="Confirm Password" required>
								</div>
							</div>

							<div class="button-container w-100">
								<button type="submit" class="btn next-button w-100" id="next-button">NEXT</button>
							</div>
						</div>

						<div class="faculty-wrapper" id="faculty-details-field" style="display: none;">
							<div class="faculty-container d-flex flex-column row-gap-4">
								<div class="faculty-select" id="faculty-select">
									<h6>WHICH FACULTY ARE YOU ASSOCIATED WITH?</h6>
									<select class="form-select" name="faculty" required>
										<option selected hidden disabled value="" style="color: #5E5A5A !important">Select Option</option>
										<?php
										foreach ($db->process_db("SELECT * FROM  tbl_faculty_list", "", true, "") as $faculty_list) {
											echo "<option value=" . $faculty_list["abbreviation"] . ">" . $faculty_list["faculty_name"] . "</option>";
										}
										?>
									</select>
								</div>

								<div class="faculty-identification">
									<h6>UPLOAD FACULTY IDENTIFICATION</h6>
									<input class="form-control" type="file" id="formFileFac" name="identification" required>
								</div>
							</div>

							<div class="button-container d-flex flex-row justify-content-center gap-2 w-100">
								<button type="button" class="btn back-btn" id="back-button">BACK</button>
								<button type="submit" name="submit" class="btn register-button">REGISTER</button>
							</div>
						</div>
					</form>
					<div class="footer-modal w-100">
						<h6>Already have an account? <a href="#" style="color: var(--red-1);" data-bs-toggle="modal" data-bs-target="#login-modal">Login</a></h6>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="register-org-modal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-body">
					<div class="close-div d-flex justify-content-end">
						<a data-bs-dismiss="modal" style="cursor: pointer"><i class="fa-solid fa-xmark"></i></a>
					</div>
					<div class="modal-title-text">
						<h2>Welcome to <span>CCE!</span></h2>
						<label>Please register to continue</label>
					</div>
					<form class="form-div" method="POST" action="./modules/organization/create_org_acc.php" enctype="multipart/form-data">
						<div class="personal-details-wrapper" id="personal-details-field-org">
							<div class="personal-details-container d-flex flex-column row-gap-2">
								<h6>ON REPRESENTATIVE DETAILS</h6>
								<div class="input-field firstname">
									<input class="form-control" name="firstname" id="firstname-org" placeholder="Firstname" required>
								</div>
								<div class="input-field middlename">
									<input class="form-control" name="middlename" id="middlename-org" placeholder="Middlename">
								</div>
								<div class="input-field lastname">
									<input class="form-control" name="lastname" id="lastname-org" placeholder="Lastname" required>
								</div>
								<div class="input-field">
									<input class="form-control" name="username" id="username-org" placeholder="Username" required>
								</div>
								<div class="input-field">
									<input type="email" class="form-control" name="email" id="email-org" placeholder="Email Address" required>
								</div>
								<div class="input-field d-flex flex-row gap-2 password">
									<input type="password" class="form-control" name="password" id="password-org" placeholder="Password" required>
									<input type="password" class="form-control" name="confirm_pass" id="confirm_pass-org" placeholder="Confirm Password" required>
								</div>
							</div>

							<div class="button-container w-100">
								<button type="button" class="btn next-button w-100" id="org-next-button">NEXT</button>
							</div>
						</div>

						<!-- Organization Details -->
						<div class="wrapper-org-details" style="display: none">
							<div class="org-details-container d-flex flex-column row-gap-2" id="org-details-container">
								<h6 style="margin-bottom: 8px !important">ORGANIZATION DETAILS</h6>
								<div class="input-field d-flex flex-row gap-2 orgname">
									<input class="form-control" name="org-name" placeholder="Name of Organization" required>
								</div>
								<div class="input-field d-flex flex-row gap-2 shortname">
									<input class="form-control" name="org-shortname" placeholder="Short name or acronym of Organization" required>
									<select class="form-select w-25" name="org-suffix">
										<option value="Org." selected>Org.</option>
										<option value="Inc.">Inc.</option>
										<option value="Co.">Co.</option>
										<option value="Co-op">Co-op</option>
										<option value="Ltd.">Ltd.</option>
										<option value="LLC.">LLC.</option>
										<option value="LLP">LLP</option>
										<option value="PLC">PLC</option>
										<option value="LP">LP</option>
									</select>
								</div>

								<div class="mt-2">
									<h6>UPLOAD LOGO</h6>
									<input class="form-control" type="file" id="formFileOrg" name="logo" required>
								</div>

								<div class="button-container d-flex flex-row justify-content-center gap-1 w-100">
									<button type="button" class="btn back-btn" id="back-button2">BACK</button>
									<button type="button" class="btn next-button" style="width: 150px !important;" id="org-next-button2">NEXT</button>
								</div>
							</div>
						</div>


						<!-- Organization Descriptions, Mission, ... -->
						<div class="wrapper-org-descrip" style="display: none">
							<div class="org-descrip-container d-flex flex-column row-gap-1">
								<h6 style="margin-bottom: 8px !important">UPLOAD ORGANIZATION PROOF OF IDENTICATION</h6>
								<div class="">
									<input class="form-control" type="file" id="formFileOrgID" name="identification" required>
								</div>
								<div class="mt-2">
									<h6>DESCRIPTION</h6>
									<textarea class="form-control" name="description" style="height: 100px" required></textarea>
								</div>
								<div class="mt-2">
									<h6>ACTIVITIES</h6>
									<textarea class="form-control" name="activities" style="height: 100px" required></textarea>
								</div>
								<div class="mt-2">
									<h6>MISSION</h6>
									<textarea class="form-control" name="mission" style="height: 100px" required></textarea>
								</div>
								<div class="mt-2">
									<h6>GOAL</h6>
									<textarea class="form-control" name="goal" style="height: 100px" required></textarea>
								</div>
								<div class="button-container d-flex flex-row justify-content-center gap-1 w-100">
									<button type="button" class="btn back-btn" id="back-button3">BACK</button>
									<button type="submit" class="btn next-button" style="width: 150px !important;" name="submit" id="org-submit">REGISTER</button>
								</div>
							</div>
						</div>
					</form>
					<div class="footer-modal w-100">
						<h6>Already have an account? <a href="#" style="color: var(--red-1);" data-bs-toggle="modal" data-bs-target="#login-modal">Login</a></h6>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="login-modal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-body">
					<div class="close-div d-flex justify-content-end">
						<a data-bs-dismiss="modal" style="cursor: pointer"><i class="fa-solid fa-xmark"></i></a>
					</div>
					<div class="modal-title-text">
						<h2>Welcome to <span>CCE!</span></h2>
						<label>Please sign in to continue</label>
					</div>
					<form class="form-div d-flex flex-column gap-2" method="POST" action="./modules/accounts/login.php">
						<div class="input-field d-flex flex-column gap-2">
							<input class="form-control" id="login-username" name="username" placeholder="Username or Email" required>
							<input class="form-control" id="login-password" type="password" name="password" placeholder="Password" required>
						</div>
						<div class="d-flex flex-row justify-content-between">
							<div class="form-check remember-me">
								<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
								<label class="form-check-label" for="flexCheckDefault">
									Remember Me
								</label>
							</div>

							<a>Forgot Password?</a>
						</div>

						<div class="button-container d-flex flex-row justify-content-center w-100">
							<button type="submit" class="btn next-button w-100" name="submit">SIGN IN</button>
						</div>
					</form>
					<div class="footer-modal w-100">
						<h6>Don't have an account? <a href="#" style="color: var(--red-1)" data-bs-toggle="modal" data-bs-target="#register-faculty-modal">Register</a></h6>
					</div>
				</div>
			</div>
		</div>
	</div>

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
<footer class="d-flex flex-column justify-content-center align-items-center">
	<div class="footer-content d-flex flex-row justify-content-between">
		<div class="logo-div">
			<div class="logo-content" style="margin-bottom: 16px">
				<img src="assets/img/logo/wmsu-logo.png" width="64" alt="WMSU">
				<img src="assets/img/logo/cce-logo.png" width="64" alt="CCE">
			</div>
			<a>Center of Continuing Education<br>
				Western Mindanao State University</a>
		</div>

		<div class="about-us-footer d-flex flex-column">
			<h3>About Us</h3>
			<a>About Us</a>
			<a>Our Team</a>
			<a>Contact</a>
		</div>

		<div class="additional-info-footer d-flex flex-column">
			<h3>Additional Information</h3>
			<a>3WMSU Campus B, San Jose Road, Baliwasan, Zamboanga City</a>
			<a>Email: cce@wmsu.edu.ph</a>
			<a>Phone: (062)-991-1040</a>
		</div>

		<div class="recent-photos-footer d-flex flex-column">
			<h3>Recent Photos</h3>
			<div class="photos-div d-flex flex-row flex-wrap">
				<div class="photo-container">
					<img src="assets/img/home/picture-example.png" alt="Previous Photo">
				</div>
				<div class="photo-container">
					<img src="assets/img/home/picture-example.png" alt="Previous Photo">
				</div>
				<div class="photo-container">
					<img src="assets/img/home/picture-example.png" alt="Previous Photo">
				</div>
				<div class="photo-container">
					<img src="assets/img/home/picture-example.png" alt="Previous Photo">
				</div>
				<div class="photo-container">
					<img src="assets/img/home/picture-example.png" alt="Previous Photo">
				</div>
				<div class="photo-container">
					<img src="assets/img/home/picture-example.png" alt="Previous Photo">
				</div>
			</div>
		</div>
	</div>
	<div class="footer-divider"></div>
	<div class="copyright d-flex flex-row justify-content-between">
		<a style="color: white;">Copyright @ 2023 WMSU CCE. All rights reserved.</a>
		<div class="footer-socials d-flex flex-row">
			<a href="#" class="fa-brands fa-facebook"></a>
			<a href="#" class="fa-brands fa-twitter"></a>
			<a href="#" class="fa-brands fa-instagram"></a>
			<a href="#" class="fa-solid fa-envelope"></a>
		</div>
	</div>
</footer>

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script>
	$(document).ready(function() {
		function getUrlParameter(name) {
			name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
			var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
			var results = regex.exec(location.search);
			return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
		}

		function showError(errorMessage) {
			toastLiveExample = document.getElementById('liveToast');
			const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);

			$(".toast-body").text(errorMessage);

			toastBootstrap.show();
		};

		function checkInput(container) {
			errorTrigger = false;
			inputs = $(container);

			inputs.each(function() {
				if ($(this).val() === "") {
					errorTrigger = true;
					$(this).addClass("error");
				} else {
					$(this).removeClass("error");
				}
			});

			return errorTrigger;
		}

		if (getUrlParameter('msg') === 'login') {
			$('#login-modal').modal('show');
		}

		$("#login-modal form").submit(function(event) {
			$.ajax({
				type: "POST",
				url: "./modules/accounts/login.php",
				data: $(this).serialize(),
				success: function(response) {
					if (!(response == "User doesn't exist!" || response == "Incorrect Account Credentials!")) {
						window.location.href = response;
					} else {
						console.log(response);
						showError(response);

						$("#login-username").addClass("error");
						$("#login-password").addClass("error");

					}
				}
			})

			event.preventDefault();
		});


		// Faculty
		$("#next-button").click(function(event) {
			event.preventDefault();
			var errorTrigger = false;
			var emailErrorTrigger = false;
			var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

			errorTrigger = checkInput("#register-faculty-modal .personal-details-container input:not([name='middlename'])");

			if (errorTrigger) {
				showError("Make sure all input fields are not empty!");
			} else {
				if (!(emailPattern.test($("#email").val()))) {
					showError("Please enter a valid email address!");
					$("#email").addClass("error");
				} else if ($("#password").val() != $("#confirm_pass").val()) {
					showError("Password doesn't match!");
					$("#confirm_pass, #password").addClass("error");
				} else {
					$("#personal-details-field").css({
						"display": "none"
					});

					$("#faculty-details-field").css({
						"display": "block"
					});
				}
			}

			return false;
		});
		$("#back-button").click(function(event) {
			$("#personal-details-field").css({
				"display": "block"
			});

			$("#faculty-details-field").css({
				"display": "none"
			});
		});

		$("#register-faculty-modal form").submit(function(event) {
			$.ajax({
				type: "POST",
				url: "./modules/faculty/create_faculty_acc.php",
				data: new FormData(this),
				contentType: false,
				processData: false,
				success: function(response) {
					if (!(response == "User already exist!")) {
						window.location.href = response;
					} else {
						showError("Username/Email already exist!");

						$("#personal-details-field").css({
							"display": "block"
						});
						$("#faculty-details-field").css({
							"display": "none"
						});
						$("#email").addClass("error");
						$("#username").addClass("error");
					}
				}
			})

			event.preventDefault();
		});

		// Organization
		$("#org-next-button").click(function(event) {
			event.preventDefault();
			var errorTrigger = false;
			var emailErrorTrigger = false;
			var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

			errorTrigger = checkInput("#register-org-modal .personal-details-container input:not([name='middlename'])");

			if (errorTrigger) {
				showError("Make sure all input fields are not empty!");
			} else {
				if (!(emailPattern.test($("#email-org").val()))) {
					showError("Please enter a valid email address!");
					$("#email-org").addClass("error");
				} else if ($("#password-org").val() != $("#confirm_pass-org").val()) {
					showError("Password doesn't match!");
					$("#confirm_pass-org, #password-org").addClass("error");
				} else {
					$("#personal-details-field-org").css({
						"display": "none"
					});
					$(".wrapper-org-details").css({
						"display": "block"
					});
				}
			}

			return false;
		});
		$("#back-button2").click(function(event) {
			$("#personal-details-field-org").css({
				"display": "block"
			});
			$(".wrapper-org-details").css({
				"display": "none"
			});
		})

		$("#org-next-button2").click(function(event) {
			event.preventDefault();
			var errorTrigger = false;
			errorTrigger = checkInput("#register-org-modal .org-details-container input");

			if (errorTrigger) {
				showError("Make sure all input fields are not empty!");
			} else {
				$(".wrapper-org-details").css({
					"display": "none",
				});
				$(".wrapper-org-descrip").css({
					"display": "block"
				});
			}

			return false;
		});
		$("#back-button3").click(function(event) {
			$(".wrapper-org-descrip").css({
				"display": "none"
			});
			$(".wrapper-org-details").css({
				"display": "block",
			});
		})

		$("#register-org-modal form").submit(function(event) {
			$.ajax({
				type: "POST",
				url: "./modules/organization/create_org_acc.php",
				data: new FormData(this),
				contentType: false,
				processData: false,
				success: function(response) {
					if (!(response == "User already exist!")) {
						window.location.href = response;
					} else {
						showError("Username/Email already exist!");

						$("#personal-details-field-org").css({
							"display": "block"
						});
						$(".wrapper-org-descrip").css({
							"display": "none"
						});
						$("#email-org").addClass("error");
						$("#username-org").addClass("error");
					}
				}
			})

			event.preventDefault();
		});
	});
</script>

</html>