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
    <link rel="stylesheet" type="text/css" href="certificates.css" />
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
                    <a class="nav-link d-flex flex-row justify-content-between" aria-current="page" href="../organizations/organizations.php">
                        <div class="icon-div d-flex flex-row">
                            <img src="../../assets/img/admin/icon-org.svg" alt="Dashboard Logo" width="18">
                            <h6>Organizations</h6>
                        </div>
                        <img src="../../assets/img/admin/icon-right.svg" alt="Right" width="11" height="11">
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active d-flex flex-row justify-content-between" aria-current="page" href="#">
                        <div class="icon-div d-flex flex-row">
                            <img src="../../assets/img/admin/icon-files-active.svg" alt="Dashboard Logo" width="19">
                            <h6>Certificates</h6>
                        </div>
                        <img src="../../assets/img/admin/icon-right-active.svg" alt="Right" width="11" height="11">
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
            <h6>Good day, Claire! / Welcome to you <span>Certificates</span>!</h6>
            <button type="button" class="btn btn-primary topbar-btn" data-bs-toggle="modal" data-bs-target="#modal-createEvent"><i class="fa-solid fa-plus"></i></button>
        </div>
        <div class="main-wrapper d-flex h-100">
            <div class="main panel d-flex flex-column">
                <div class="search-bar-div w-100">
                    <input class="form-control" placeholder="Search Past Events">
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
                                    <p>People Invited</p>
                                </th>
                                <th>
                                    <p>People Subcribed</p>
                                </th>
                                <th>
                                    <p>Certificate Sent</p>
                                </th>
                                <th>
                                    <p>Pending</p>
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
                                        COALESCE(SUM(CASE WHEN tbl_event_participants.certificate_sent = 1 AND tbl_event_participants.role = 'Participant' THEN 1 ELSE 0 END), 0) AS certificate_sent,
                                        COALESCE(SUM(CASE WHEN tbl_event_participants.certificate_sent = 0 AND tbl_event_participants.role = 'Participant' THEN 1 ELSE 0 END), 0) AS pending,
                                        COALESCE(SUM(CASE WHEN tbl_event_participants.type = 'Invited' AND tbl_event_participants.role = 'Participant' THEN 1 ELSE 0 END), 0) AS invited_count,
                                        COALESCE(SUM(CASE WHEN tbl_event_participants.type = 'Subscribed' THEN 1 ELSE 0 END), 0) AS subscribed_count
                                    FROM tbl_events
                                    LEFT JOIN tbl_event_participants ON tbl_event_participants.event_id = tbl_events.id
                                    WHERE tbl_events.status = 5 AND day < ? AND venue_type = 'Other Platform'
                                    GROUP BY tbl_events.id
                                    ORDER BY day ASC;
                                    ";
                            foreach ($db->process_db($sql, "s", true, date("Y-m-d")) as $past_event) {
                            ?>
                                <tr>
                                    <td style="width: 220px; max-width: 220px; white-space:nowrap; text-overflow:ellipsis; overflow:hidden"><?php echo $past_event["title"] ?></td>
                                    <td><?php echo date_format(date_create($past_event["day"]), "F d, Y") ?></td>
                                    <td>
                                        <i class="fa-solid fa-user"></i>
                                        <?php echo $past_event["invited_count"] ?>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-user"></i>
                                        <?php echo $past_event["subscribed_count"] ?>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-user"></i>
                                        <?php echo $past_event["certificate_sent"] ?>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-user"></i>
                                        <?php echo $past_event["pending"] ?>
                                    </td>
                                    <td><a href="#" data-bs-toggle="modal" data-bs-target="#historyModal<?php echo $past_event["id"] ?>">View Details</a></td>
                                </tr>
                            <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
                <?php
                $sql = "SELECT * FROM tbl_events WHERE day < ? AND status = 5";
                foreach ($db->process_db($sql, "s", true, date("Y-m-d")) as $past_event) {
                ?>
                    <!-- History Modals -->
                    <div class="modal fade historyModal" id="historyModal<?php echo $past_event["id"] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Waiting for Certificates</h1>
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
                                                $sql2 = "SELECT tbl_event_participants.*, tbl_accounts.firstname, tbl_accounts.lastname FROM tbl_event_participants INNER JOIN tbl_accounts ON tbl_accounts.id = tbl_event_participants.account_id WHERE event_id = ? AND certificate_sent <> 1 AND role = 'Participant'";
                                                foreach ($db->process_db($sql2, "s", true, $past_event["id"]) as $participant) {
                                                ?>
                                                    <tr>
                                                        <td style="text-transform: capitalize;"><?php echo $participant["firstname"] . " " . $participant["lastname"] ?></td>
                                                        <td><?php echo $participant["status"] == 'Invited' ? "Step 1 In Progress" : $participant["status"] ?></td>
                                                        <td><?php echo $participant["type"] == 'Subscribed' ? "<span>Subscribed</span>" : $participant["type"] ?></td>
                                                        <td>
                                                            <form method="POST" action="" onsubmit="handleSubmit(event, <?php echo $participant['id'] ?>)">
                                                                <button type="submit" class="btn primary-btn view-assessment-btn send-certificate-button">
                                                                    Send Certificate
                                                                    <i class="fa-regular fa-paper-plane"></i>
                                                                </button>
                                                            </form>
                                                            <button type="button" class="btn primary-btn view-assessment-btn sent" style="cursor: default; display: none">
                                                                    Certificate Sent!
                                                                    <i class="fa-solid fa-check"></i>
                                                            </button>
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
    <script src="../../assets/js/certificate.js"></script>
    <script src="../../assets/js/admin.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                searching: false,
                language: {
                    info: 'Showing _START_ - _END_ of list'
                },
                scrollCollapse: true,
                scrollY: '450px',
                "language": {
                    "paginate": {
                        "previous": "<",
                        "next": ">"
                    }
                },
                pageLength: 8
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

        function handleSubmit(event, id) {
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: "../../modules/certificates/send_certificate.php",
                data: {
                    'account-id': id
                },
                success: function(response) {
                    if (!(response == "Done!")) {
                        console.log("Something went wrong!");
                    } else {
                        $(event.target).closest('td').find('.send-certificate-button').hide();
                        $(event.target).closest('td').find('.sent').show();
                        showError("Certificate Sent!", "success");
                    }
                }
            })
        }
    </script>
</body>

</html>