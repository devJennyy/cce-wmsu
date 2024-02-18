<?php
$certificates = "active";
$css = "<link rel='stylesheet' type='text/css' href='certificates.css' />";
$top_greet = "Welcome to your <span>Certificates</span>";
$js = "certificates.js";

include_once '../header.php';
?>

<div class="certificates-content d-flex flex-column">
    <div class="search-div">
        <input class="form-control" placeholder="Search title">
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
                    WHERE account_id = ? AND tbl_event_participants.certificate_sent = 1 AND venue_type = 'Other Platform' AND tbl_event_participants.role = 'Participant'";
                foreach ($db->process_db($sql, "s", true, $_SESSION["id"]) as $pastJoinedEvents) {
                ?>
                    <tr>
                        <td><p class="m-0 mt-1" style="max-width: 190px; white-space:nowrap; text-overflow:ellipsis; overflow:hidden"><?php echo $pastJoinedEvents["title"] ?></p></td>
                        <td><p class="m-0 mt-1"><?php echo date_format(date_create($pastJoinedEvents["day"]), "F d, Y") ?></p></td>
                        <td><p class="m-0 mt-1"><?php echo date_format(date_create($pastJoinedEvents["startTime"]), "h:i A") . " - " . date_format(date_create($pastJoinedEvents["endTime"]), "h:i A") ?></p></td>
                        <td><p class="m-0 mt-1"><?php echo ($pastJoinedEvents["status"] == 'Invited') ? "Step 1 In Progress" : $pastJoinedEvents["status"] ?></p></td>
                        <td>
                            <?php
                            if ($pastJoinedEvents["certificate_sent"] == 1) {
                            ?>
                                <a class="py-1 px-2 download-btn d-flex flex-row justify-content-center align-items-center" href="../../modules/events/generate_certificate.php?id=<?php echo $pastJoinedEvents["id"] ?>">
                                    Download file 
                                    <span class="material-symbols-outlined" style="font-size: 16px;">
                                        download
                                    </span>
                                </a>
                            <?php
                            } else {
                            ?>
                                <a href="#">View Details</a>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                <?php
                }
                ?>

            </tbody>
        </table>
    </div>
</div>

<?php
include_once '../footer.php';
?>