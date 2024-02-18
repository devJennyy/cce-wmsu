<div class="modal fade create-event-one create-modal" id="modal-createEvent" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="exampleModalLabel">CREATE EVENT</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mdl-content">
                    <form id="create-event-form" action="../../modules/events/create_event.php" method="POST" enctype="multipart/form-data">
                        <div class="step-1" id="step-1">
                            <div class="input event-title mb-3">
                                <label class="form-label d-flex flex-row justify-content-between">
                                    EVENT TITLE
                                </label>
                                <input type="text" class="form-control" name="event-title" placeholder="Enter event title" required>
                            </div>

                            <div class="more-info-div d-flex flex-row justify-content-between">
                                <div class="input day">
                                    <label class="form-label">DAY</label>
                                    <input type="date" class="form-control" name="day" id="day-picker" min="<?php echo date('Y-m-d', strtotime('+1 day')) ?>" placeholder="22 December 2022" required>
                                </div>
                                <div class="input hour">
                                    <label class="form-label">START TIME</label>
                                    <input type="time" class="form-control" name="startTime" id="start-time" placeholder="10am" required>
                                </div>
                                <div class="input minute">
                                    <label class="form-label">END TIME</label>
                                    <input type="time" class="form-control" name="endTime" id="end-time" placeholder="11am" required>
                                </div>
                                <div class="input slots">
                                    <label class="form-label">SLOTS</label>
                                    <input type="number" class="form-control" name="slots" id="slots" placeholder="100" min="1" required>
                                </div>
                            </div>

                            <div class="info-label w-100 d-flex flex-row justify-content-start my-3">
                                <span class="check" style="display: none;"><i class="fa-solid fa-check"></i></span>
                                <span class="wrong"><i class="fa-solid fa-xmark"></i></span>
                                <p>This event will take place on <span id="info-day" style="color: #5E5A5A">-</span> from <span id="info-startTime" style="color: #5E5A5A">-</span> until <span id="info-endTime" style="color: #5E5A5A">-</span> <b>(<span id="info-slots" style="color: #5E5A5A">-</span> slots available).</b></p>
                            </div>

                            <div class="venue-reminder-wrapper d-flex flex-row w-100 gap-4">
                                <div class="venue" style="width: 97%;">
                                    <label class="form-label">VENUE</label>
                                    <div class="d-flex flex-row">
                                        <div class="input input-group d-flex flex-row">
                                            <input class="form-control flex-grow-1" list="datalistOptions" id="set-location-select" name="venue" style="width: 31%; border-top-right-radius: 0 !important; border-bottom-right-radius: 0 !important" placeholder="Enter Location" required>
                                            <datalist id="datalistOptions">
                                                <option value="WMSU Gymnasium">
                                                <option value="WMSU Covered Court">
                                                <option value="CCE Building">
                                            </datalist>
                                            <input type="text" class="form-control flex-grow-1" name="venue" id="other-platform-select" placeholder="Enter Link" style="width: 31%; border-top-right-radius: 0 !important; border-bottom-right-radius: 0 !important" required hidden disabled>
                                            <select class="form-select flex-grow-1" id="venue-select" name="venuetype" style="border-top-left-radius: 0 !important; border-bottom-left-radius: 0 !important" required>
                                                <option value="Set Location" selected>Physical</option>
                                                <option value="Other Platform">Virtual</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="reminder" style="width: 78%;">
                                    <label class="form-label">REMINDER</label>
                                    <select class="form-select" name="reminder">
                                        <option value="15mins">15 minutes before the event</option>
                                        <option value="30mins">30 minutes before the event</option>
                                        <option value="1hour">1 hour before the event</option>
                                        <option value="2hours">2 hours before the event</option>
                                    </select>
                                </div>
                            </div>

                            <div class="description w-100">
                                <label class="form-label">DESCRIPTION</label>
                                <textarea class="form-control description-textarea" rows="4" name="description"></textarea>
                            </div>

                            <div class="agenda w-100">
                                <label class="form-label">AGENDA</label>
                                <div id="editor" style="height: 150px;">

                                </div>
                            </div>

                            <div class="attachments w-100 mt-3">
                                <label class="form-label">UPLOAD EVENT BANNER</label>
                                <input class="form-control" type="file" id="formFile" name="image" required>
                            </div>

                            <div class="divider-div w-100 mt-3">
                                <div class="d-flex flex-row justify-content-between">
                                    <label class="form-label" style="font-weight: 500;">SPEAKERS</label>
                                </div>
                                <span class="divider w-100"></span>
                            </div>

                            <div class="team-invitation-div d-flex flex-row w-100 gap-3">
                                <div class="content-left">
                                    <div class="input participants">
                                        <label class="form-label">INVITE SPEAKERS</label>
                                        <div class="search-bar">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                            <input type="text" class="form-control" id="search-speakers" placeholder="Search name to invite as a speaker">
                                        </div>

                                        <div class="participants-list w-100">
                                            <table class="table" id="invite-speakers-table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sql = "SELECT * FROM tbl_accounts WHERE verified = '2' AND faculty_role <> 'Organization'";
                                                    foreach ($db->process_db($sql, "", true, "") as $user) {
                                                    ?>
                                                        <tr>
                                                            <td scope="row" class="d-flex flex-row w-100 justify-content-between align-items-end">
                                                                <div class="d-flex flex-row w-75">
                                                                    <div class="participant-picture">
                                                                        <img src="../../assets/img/admin/participant-img.png" width="38" height="38">
                                                                    </div>
                                                                    <div class="participant-details d-flex flex-column">
                                                                        <input hidden class="faculty_hidden" value="<?php echo $user["faculty_role"] ?>">
                                                                        <input hidden name="speaker-id[]" class="input-id" value="<?php echo $user["id"] ?>" form="no-form">
                                                                        <h6 class="name"><?php echo $user["firstname"] . " " . $user["lastname"] ?></h6>
                                                                        <p class="position"><?php echo $user["faculty_role"] ?> - Faculty Member</p>
                                                                    </div>
                                                                </div>
                                                                <button type="button" class="btn btn-primary speakers-btn" data-source="invite-speakers-table" data-target="invited-speakers-table"><img class="button-icon" src="../../assets/img/admin/invite-user-button.svg"></button>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>

                                                    <?php
                                                    $sql = "SELECT tbl_accounts.id, tbl_accounts.firstname, tbl_accounts.lastname, tbl_accounts.verified, tbl_organization.id AS org_id, tbl_organization.org_name, tbl_organization.org_shortname, tbl_organization_members.role FROM tbl_accounts INNER JOIN tbl_organization_members ON tbl_accounts.id = tbl_organization_members.account_id INNER JOIN tbl_organization ON tbl_organization_members.organization_id = tbl_organization.id WHERE tbl_accounts.verified = '2'";
                                                    foreach ($db->process_db($sql, "", true, "") as $org_member) {
                                                    ?>
                                                        <tr>
                                                            <td scope="row" class="d-flex flex-row w-100 justify-content-between align-items-end">
                                                                <div class="d-flex flex-row w-75">
                                                                    <div class="participant-picture">
                                                                        <img src="../../assets/img/admin/participant-img.png" width="38" height="38">
                                                                    </div>
                                                                    <div class="participant-details d-flex flex-column">
                                                                        <input hidden class="org_hidden" value="<?php echo $org_member["org_id"] ?>">
                                                                        <input hidden name="speaker-id[]" class="input-id" value="<?php echo $org_member["id"] ?>" form="no-form">
                                                                        <h6 class="name"><?php echo $org_member["firstname"] . " " . $org_member["lastname"] ?></h6>
                                                                        <p class="position"><?php echo $org_member["org_shortname"] ?> - <?php echo $org_member["role"] ?></p>
                                                                    </div>
                                                                </div>
                                                                <button type="button" class="btn btn-primary speakers-btn" data-source="invite-speakers-table" data-target="invited-speakers-table"><img class="button-icon" src="../../assets/img/admin/invite-user-button.svg"></button>
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
                                <div class="content-right">
                                    <div class="input participants">
                                        <label class="form-label">SPEAKERS ADDED</label>
                                        <div class="search-bar">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                            <input type="text" class="form-control" id="search-invited-speakers" placeholder="Search added speakers">
                                        </div>

                                        <div class="participants-list w-100">
                                            <table class="table" id="invited-speakers-table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col"></th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>


                    <div class="step-2" id="step-2" style="display: none;">
                        <div class="divider-div w-100">
                            <div class="d-flex flex-row justify-content-between">
                                <label class="form-label" style="font-weight: 500;">TEAM INVITATION</label>
                                <div class="d-flex flex-row" style="width: fit-content;">
                                    <label class="form-label">SLOTS:</label>
                                    <label class="form-label" style="margin-left: 8px;" id="slotCount"></label>
                                </div>
                            </div>
                            <span class="divider w-100"></span>
                        </div>

                        <div class="team-invitation-div d-flex flex-row w-100 gap-3">
                            <div class="content-left">
                                <div class="input participants">
                                    <label class="form-label">ORGANIZATION</label>
                                    <div class="search-bar">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        <input type="text" class="form-control" id="search-org" placeholder="Search organization to invite">
                                    </div>

                                    <div class="organization-list w-100">
                                        <table class="table" id="invite-org-table">
                                            <thead>
                                                <tr>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT tbl_organization_members.organization_id, COUNT(*) as MemberCount, tbl_organization.org_name, tbl_organization.org_shortname, tbl_accounts.verified
													FROM tbl_organization_members 
													INNER JOIN tbl_organization ON tbl_organization.id = tbl_organization_members.organization_id 
													INNER JOIN tbl_accounts ON tbl_accounts.id = tbl_organization.account_id
													WHERE tbl_accounts.verified = 2
													GROUP BY organization_id;";
                                                foreach ($db->process_db($sql, "", true, "") as $organization) {
                                                ?>
                                                    <tr>
                                                        <td scope="row" class="d-flex flex-row w-100 justify-content-between align-items-end">
                                                            <div class="d-flex flex-row w-75">
                                                                <div class="participant-picture">
                                                                    <img src="../../assets/img/admin/participant-img.png" width="38" height="38">
                                                                </div>
                                                                <div class="participant-details d-flex flex-column">
                                                                    <h6 class="name"><?php echo $organization["org_name"] ?></h6>
                                                                    <p class="position"><?php echo $organization["MemberCount"] ?> People</p>
                                                                </div>
                                                            </div>
                                                            <button hidden type="button" class="btn btn-primary invited-btn pe-3"><i class="fa-solid fa-check"></i></button>
                                                            <button type="button" class="btn btn-primary organization-btn" data-target="<?php echo $organization["organization_id"] ?>"><img class="button-icon" src="../../assets/img/admin/invite-user-button.svg"></button>
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
                            <div class="content-right">
                                <div class="input participants">
                                    <label class="form-label">FACULTY</label>
                                    <div class="search-bar">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        <input type="text" class="form-control" id="search-faculty" placeholder="Search faculty to invite">
                                    </div>

                                    <div class="faculty-list w-100">
                                        <table class="table" id="invite-faculty-table">
                                            <thead>
                                                <tr>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT * FROM tbl_faculty_list ORDER BY faculty_name";
                                                foreach ($db->process_db($sql, "", true, "") as $faculty) {
                                                ?>
                                                    <tr>
                                                        <td scope="row" class="d-flex flex-row w-100 justify-content-between align-items-end">
                                                            <div class="d-flex flex-row w-75">
                                                                <div class="participant-picture">
                                                                    <img src="../../assets/img/admin/participant-img.png" width="38" height="38">
                                                                </div>
                                                                <div class="participant-details d-flex flex-column">
                                                                    <h6 style="display: none"><?php echo $faculty["abbreviation"] ?></h6>
                                                                    <h6 class="name"><?php echo $faculty["faculty_name"] ?></h6>
                                                                    <?php
                                                                    $countSQL = "SELECT COUNT(*) FROM tbl_accounts WHERE faculty_role = ?";
                                                                    foreach ($db->process_db($countSQL, "s", true, $faculty["abbreviation"]) as $count) {
                                                                        echo "<p class='position'>" . $count["COUNT(*)"] . " People</p>";
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <button hidden type="button" class="btn btn-primary invited-btn pe-3"><i class="fa-solid fa-check"></i></button>
                                                            <button type="button" class="btn btn-primary faculty-btn" data-target="<?php echo $faculty["abbreviation"] ?>"><img class="button-icon" src="../../assets/img/admin/invite-user-button.svg"></button>
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

                        <div class="divider-div w-100" style="margin-top: 18px;">
                            <label class="form-label mt-4" style="font-weight: 500;">INDIVIDUAL INVITATION</label>
                            <span class="divider w-100"></span>
                        </div>

                        <div class="indi-invitation-div d-flex flex-row w-100 gap-3">
                            <div class="content-left">
                                <div class="input participants">
                                    <label class="form-label">INVITE PARTICIPANTS</label>
                                    <div class="search-bar">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        <input type="text" class="form-control" id="search-invite" placeholder="Search participants to invite">
                                    </div>

                                    <div class="participants-list w-100">
                                        <table class="table" id="invite-table">
                                            <thead>
                                                <tr>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT * FROM tbl_accounts WHERE verified = '2' AND faculty_role <> 'Organization' AND faculty_role <> 'Administrator'";
                                                foreach ($db->process_db($sql, "", true, "") as $user) {
                                                ?>
                                                    <tr>
                                                        <td scope="row" class="d-flex flex-row w-100 justify-content-between align-items-end">
                                                            <div class="d-flex flex-row w-75">
                                                                <div class="participant-picture">
                                                                    <img src="../../assets/img/admin/participant-img.png" width="38" height="38">
                                                                </div>
                                                                <div class="participant-details d-flex flex-column">
                                                                    <input hidden class="faculty_hidden" value="<?php echo $user["faculty_role"] ?>">
                                                                    <input hidden name="id[]" class="input-id" value="<?php echo $user["id"] ?>" form="no-form">
                                                                    <h6 class="name"><?php echo $user["firstname"] . " " . $user["lastname"] ?></h6>
                                                                    <p class="position"><?php echo $user["faculty_role"] ?> - Faculty Member</p>
                                                                </div>
                                                            </div>
                                                            <button type="button" class="btn btn-primary participant-btn" data-source="invite-table" data-target="invited-table"><img class="button-icon" src="../../assets/img/admin/invite-user-button.svg"></button>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>

                                                <?php
                                                $sql = "SELECT tbl_accounts.id, tbl_accounts.firstname, tbl_accounts.lastname, tbl_accounts.verified, tbl_organization.id AS org_id, tbl_organization.org_name, tbl_organization.org_shortname, tbl_organization_members.role FROM tbl_accounts INNER JOIN tbl_organization_members ON tbl_accounts.id = tbl_organization_members.account_id INNER JOIN tbl_organization ON tbl_organization_members.organization_id = tbl_organization.id WHERE tbl_accounts.verified = '2'";
                                                foreach ($db->process_db($sql, "", true, "") as $org_member) {
                                                ?>
                                                    <tr>
                                                        <td scope="row" class="d-flex flex-row w-100 justify-content-between align-items-end">
                                                            <div class="d-flex flex-row w-75">
                                                                <div class="participant-picture">
                                                                    <img src="../../assets/img/admin/participant-img.png" width="38" height="38">
                                                                </div>
                                                                <div class="participant-details d-flex flex-column">
                                                                    <input hidden class="org_hidden" value="<?php echo $org_member["org_id"] ?>">
                                                                    <input hidden name="id[]" class="input-id" value="<?php echo $org_member["id"] ?>" form="no-form">
                                                                    <h6 class="name"><?php echo $org_member["firstname"] . " " . $org_member["lastname"] ?></h6>
                                                                    <p class="position"><?php echo $org_member["org_shortname"] ?> - <?php echo $org_member["role"] ?></p>
                                                                </div>
                                                            </div>
                                                            <button type="button" class="btn btn-primary participant-btn" data-source="invite-table" data-target="invited-table"><img class="button-icon" src="../../assets/img/admin/invite-user-button.svg"></button>
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
                            <div class="content-right">
                                <div class="input participants">
                                    <label class="form-label">PEOPLE ADDED</label>
                                    <div class="search-bar">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        <input type="text" class="form-control" id="search-invited" placeholder="Search added participants">
                                    </div>

                                    <div class="participants-list w-100">
                                        <table class="table" id="invited-table">
                                            <thead>
                                                <tr>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="step-3" id="step-3" style="display: none">
                        <div class="input event-title mb-3">
                            <label class="form-label d-flex flex-row justify-content-between">
                                CERTIFICATE
                            </label>
                            <div class="d-flex flex-row w-100 gap-2">
                                <input type="text" class="form-control w-75" name="event-certificate" form="create-event-form" placeholder="Input text title of the certificate" required>
                                <input type="text" class="form-control w-25" name="certificate-from" form="create-event-form" placeholder="from" required>
                            </div>
                        </div>
                        <div class="input event-attachment mb-3 w-100" id="cert-attachment">
                            <label class="form-label d-flex flex-row justify-content-between">
                                UPLOAD TEMPLATE
                            </label>
                            <input accept=".jpg, .jpeg, .png" type="file" class="form-control w-100" id="certificate-img" name="certificate-file" form="create-event-form" placeholder="from" required>
                        </div>

                        <div class="w-100" id="modify-div" style="display: none !important">
                            <div class="divider-div w-100 mt-4">
                                <div class="d-flex flex-row justify-content-between">
                                    <label class="form-label">MODIFY TEXTFIELD LOCATION</label>
                                </div>
                                <span class="divider w-100"></span>
                            </div>

                            <div class="w-100 d-flex flex-row gap-2" style="height: 300px;">
                                <div class="image-container-wrapper w-75 d-flex flex-row justify-content-center">
                                    <div class="image-container" id="imageContainer">
                                        <img id="image" src="#" alt="Certificate Image">
                                        <div id="textField" class="d-flex flex-column justify-content-center">Lorem Ipsum Dolor</div>
                                    </div>
                                </div>

                                <div class="image-options w-25 d-flex flex-column gap-2">
                                    <div class="input textfield-position w-100 d-flex flex-column">
                                        <label class="form-label" style="font-size: 12px;">X and Y Position</label>
                                        <div class="w-100 d-flex flex-row gap-2">
                                            <input type="number" id="x" min="1" class="form-control w-50" form="create-event-form" placeholder="X Pos" value="1" required>
                                            <input type="number" id="y" min="1" class="form-control w-50" form="create-event-form" placeholder="Y Pos" value="1" required>
                                        </div>
                                    </div>

                                    <div class="input textfield-size w-100 d-flex flex-column">
                                        <label class="form-label" style="font-size: 12px;">Width and Height</label>
                                        <div class="w-100 d-flex flex-row gap-2">
                                            <input type="number" id="width" min="1" class="form-control w-50" form="create-event-form" placeholder="Width" value="100" required>
                                            <input type="number" id="height" min="1" class="form-control w-50" form="create-event-form" placeholder="Height" value="30" required>
                                        </div>
                                    </div>

                                    <div class="divider-div w-100 mt-2">
                                        <div class="d-flex flex-row justify-content-between">
                                            <label class="form-label">FONT STYLING</label>
                                        </div>
                                        <span class="divider w-100 m-0"></span>
                                    </div>

                                    <div class="input textfield-size w-100 d-flex flex-column">
                                        <label class="form-label" style="font-size: 12px;">Style</label>
                                        <div class="w-100 d-flex flex-row gap-2">
                                            <input accept=".ttf" type="file" min="1" class="form-control w-100" name="textfield-fstyle" id="customFont" form="create-event-form" placeholder="Font Style">
                                        </div>
                                    </div>

                                    <div class="input textfield-size w-100 d-flex flex-column">
                                        <label class="form-label" style="font-size: 12px;">Size and Weight</label>
                                        <div class="w-100 d-flex flex-row gap-2">
                                            <input type="number" min="1" id="fontSize" class="form-control w-50" form="create-event-form" placeholder="Size" value="18" required>
                                            <input type="number" min="100" max="900" step="100" id="fontWeight" class="form-control w-50" name="textfield-fweight" form="create-event-form" placeholder="Weight" value="600" required>
                                        </div>
                                    </div>
                                </div>

                                <input name="textfield-x" id="true-x" value=0 form="create-event-form" hidden>
                                <input name="textfield-y" id="true-y" value=0 form="create-event-form" hidden>
                                <input name="textfield-width" id="true-width" value=0 form="create-event-form" hidden>
                                <input name="textfield-height" id="true-height" value=0 form="create-event-form" hidden>
                                <input name="textfield-fsize" id="true-fsize" value=0 form="create-event-form" hidden>
                            </div>
                        </div>
                    </div>

                    <div class="step-4" id="step-4" style="display: none">
                        <div class="divider-div w-100">
                            <label class="form-label" style="font-weight: 500;">NON-INVITED</label>
                            <span class="divider w-100"></span>
                        </div>

                        <div class="event-options-div d-flex flex-column w-100 gap-3">
                            <div class="input visibility">
                                <label class="form-label">SELECT WHAT SHOULD BE VISIBLE TO NON-INVITED INDIVIDUALS</label>
                                <select class="form-select" name="event_visibility" form="create-event-form" id="event-visibility" required>
                                    <option value="1" selected>Event is visible and allows registration</option>
                                    <option value="2">Event is visible but is closed</option>
                                    <option value="3">Event is not visible for those who are not invited</option>
                                </select>
                            </div>
                            <div class="d-flex flex-column gap-3" id="event-options">
                                <div class="input price">
                                    <label class="form-label">EVENT PRICE</label>
                                    <input type="number" min="0" value="0" name="event-price" class="form-control" placeholder="Enter Amount in Peso" form="create-event-form">
                                </div>
                                <div class="divider-div w-100 mt-3">
                                    <label class="form-label" style="font-weight: 500;">PAYMENT DETAILS</label>
                                    <span class="divider w-100" style="margin-bottom: 4px !important;"></span>
                                </div>
                                <div class="input gcash mt-2">
                                    <label class="form-label">GCASH ONLY</label>
                                    <div class="d-flex flex-row gap-1" style="flex: 1;">
                                        <input type="text" name="gcash-number" style="flex: 1" class="form-control" placeholder="Enter your GCASH number" form="create-event-form">
                                        <input type="text" name="gcash-name" style="flex: 1" class="form-control" placeholder="Enter your GCASH name" form="create-event-form">
                                    </div>
                                </div>
                                <div class="input visibility mt-2">
                                    <label class="form-label">UNIQUE CODE FOR PAYMENT</label>
                                    <div class="input-group mb-3">
                                        <input type="text" name="unique-code" class="form-control" id="unique-code" placeholder="Enter Text" form="create-event-form">
                                        <button class="btn btn-outline-secondary" type="button" id="randomize-code">Randomize</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="step-5 d-flex flex-column" id="step-5" style="display: none !important">
                        <div class="divider-div w-100">
                            <div class="d-flex flex-row justify-content-between">
                                <label class="form-label">CREATE ASSESSMENT</label>
                            </div>
                            <span class="divider w-100"></span>
                        </div>

                        <div class="input mb-3">
                            <div class="d-flex flex-row align-items-center">
                                <label class="form-label m-0 me-2" style="min-width: 14px;">1.</label>
                                <input form="create-event-form" type="text" class="form-control w-75 flex-grow-1 me-2" name="question[]" value="Who was the guest speaker or presenter for this webinar?" style="background-color: rgba(207, 174, 172, .1) !important; color: #5E5A5A; border: 0; border-radius: 0 !important; border-bottom: 1px #5E5A5A solid" readonly required>
                                <select form="create-event-form" class="form-select w-25" id="answer-select-1" name="answer-key[]" style="border-radius: 0 !important" required>
                                    <option value="" selected hidden disabled>Answer Key</option>
                                    <option id="option-A1">A</option>
                                    <option id="option-B1">B</option>
                                    <option id="option-C1">C</option>
                                    <option id="option-D1">D</option>
                                </select>
                            </div>

                            <div class="d-flex flex-column gap-2 mt-2 w-75">
                                <div class="d-flex flex-row align-items-center ps-3">
                                    <input form="create-event-form" type="text" class="form-control" onchange="setupOptionInputs(1, 'A', this)" name="option-A[]" id="option-input-A1" placeholder="A. Add Option" style="color: #5E5A5A; border: 0; border-radius: 0 !important; border-bottom: 1px rgba(94, 90, 90, .8) solid; margin-left: 6px" required>
                                </div>

                                <div class="d-flex flex-row align-items-center ps-3">
                                    <input form="create-event-form" type="text" class="form-control" onchange="setupOptionInputs(1, 'B', this)" name="option-B[]" id="option-input-B1" placeholder="B. Add Option" style="color: #5E5A5A; border: 0; border-radius: 0 !important; border-bottom: 1px rgba(94, 90, 90, .8) solid; margin-left: 6px" required>
                                </div>

                                <div class="d-flex flex-row align-items-center ps-3">
                                    <input form="create-event-form" type="text" class="form-control" onchange="setupOptionInputs(1, 'C', this)" name="option-C[]" id="option-input-C1" placeholder="C. Add Option" style="color: #5E5A5A; border: 0; border-radius: 0 !important; border-bottom: 1px rgba(94, 90, 90, .8) solid; margin-left: 6px" required>
                                </div>

                                <div class="d-flex flex-row align-items-center ps-3">
                                    <input form="create-event-form" type="text" class="form-control" onchange="setupOptionInputs(1, 'D', this)" name="option-D[]" id="option-input-D1" placeholder="D. Add Option" style="color: #5E5A5A; border: 0; border-radius: 0 !important; border-bottom: 1px rgba(94, 90, 90, .8) solid; margin-left: 6px" required>
                                </div>
                            </div>

                        </div>

                        <div class="input mb-3 mt-3">
                            <div class="d-flex flex-row align-items-center">
                                <label class="form-label m-0 me-2" style="min-width: 14px;">2.</label>
                                <input form="create-event-form" type="text" class="form-control w-75 flex-grow-1 me-2" name="question[]" value="What was the main key-points of the event all about?" style="background-color: rgba(207, 174, 172, .1) !important; color: #5E5A5A; border: 0; border-radius: 0 !important; border-bottom: 1px #5E5A5A solid" readonly required>
                                <select form="create-event-form" class="form-select w-25" id="answer-select-2" name="answer-key[]" style="border-radius: 0 !important" required>
                                    <option value="" selected hidden disabled>Answer Key</option>
                                    <option id="option-A2">A</option>
                                    <option id="option-B2">B</option>
                                    <option id="option-C2">C</option>
                                    <option id="option-D2">D</option>
                                </select>
                            </div>

                            <div class="d-flex flex-column gap-2 mt-2 w-75">
                                <div class="d-flex flex-row align-items-center ps-3">
                                    <input form="create-event-form" type="text" class="form-control" onchange="setupOptionInputs(2, 'A', this)" name="option-A[]" id="option-input-A2" placeholder="A. Add Option" style="color: #5E5A5A; border: 0; border-radius: 0 !important; border-bottom: 1px rgba(94, 90, 90, .8) solid; margin-left: 6px" required>
                                </div>

                                <div class="d-flex flex-row align-items-center ps-3">
                                    <input form="create-event-form" type="text" class="form-control" onchange="setupOptionInputs(2, 'B', this)" name="option-B[]" id="option-input-B2" placeholder="B. Add Option" style="color: #5E5A5A; border: 0; border-radius: 0 !important; border-bottom: 1px rgba(94, 90, 90, .8) solid; margin-left: 6px" required>
                                </div>

                                <div class="d-flex flex-row align-items-center ps-3">
                                    <input form="create-event-form" type="text" class="form-control" onchange="setupOptionInputs(2, 'C', this)" name="option-C[]" id="option-input-C2" placeholder="C. Add Option" style="color: #5E5A5A; border: 0; border-radius: 0 !important; border-bottom: 1px rgba(94, 90, 90, .8) solid; margin-left: 6px" required>
                                </div>

                                <div class="d-flex flex-row align-items-center ps-3">
                                    <input form="create-event-form" type="text" class="form-control" onchange="setupOptionInputs(2, 'D', this)" name="option-D[]" id="option-input-D2" placeholder="D. Add Option" style="color: #5E5A5A; border: 0; border-radius: 0 !important; border-bottom: 1px rgba(94, 90, 90, .8) solid; margin-left: 6px" required>
                                </div>
                            </div>

                        </div>

                        <div class="input mb-3 mt-3">
                            <div class="d-flex flex-row align-items-center">
                                <label class="form-label m-0 me-2" style="min-width: 14px;">3.</label>
                                <input form="create-event-form" type="text" class="form-control w-75 flex-grow-1 me-2" name="question[]" value="Who organized the event?" style="background-color: rgba(207, 174, 172, .1) !important; color: #5E5A5A; border: 0; border-radius: 0 !important; border-bottom: 1px #5E5A5A solid" readonly required>
                                <select form="create-event-form" class="form-select w-25" id="answer-select-3" name="answer-key[]" style="border-radius: 0 !important" required>
                                    <option value="" selected hidden disabled>Answer Key</option>
                                    <option id="option-A3">A</option>
                                    <option id="option-B3">B</option>
                                    <option id="option-C3">C</option>
                                    <option id="option-D3">D</option>
                                </select>
                            </div>

                            <div class="d-flex flex-column gap-2 mt-2 w-75">
                                <div class="d-flex flex-row align-items-center ps-3">
                                    <input form="create-event-form" type="text" class="form-control" onchange="setupOptionInputs(3, 'A', this)" name="option-A[]" id="option-input-A3" placeholder="A. Add Option" style="color: #5E5A5A; border: 0; border-radius: 0 !important; border-bottom: 1px rgba(94, 90, 90, .8) solid; margin-left: 6px" required>
                                </div>

                                <div class="d-flex flex-row align-items-center ps-3">
                                    <input form="create-event-form" type="text" class="form-control" onchange="setupOptionInputs(3, 'B', this)" name="option-B[]" id="option-input-B3" placeholder="B. Add Option" style="color: #5E5A5A; border: 0; border-radius: 0 !important; border-bottom: 1px rgba(94, 90, 90, .8) solid; margin-left: 6px" required>
                                </div>

                                <div class="d-flex flex-row align-items-center ps-3">
                                    <input form="create-event-form" type="text" class="form-control" onchange="setupOptionInputs(3, 'C', this)" name="option-C[]" id="option-input-C3" placeholder="C. Add Option" style="color: #5E5A5A; border: 0; border-radius: 0 !important; border-bottom: 1px rgba(94, 90, 90, .8) solid; margin-left: 6px" required>
                                </div>

                                <div class="d-flex flex-row align-items-center ps-3">
                                    <input form="create-event-form" type="text" class="form-control" onchange="setupOptionInputs(3, 'D', this)" name="option-D[]" id="option-input-D3" placeholder="D. Add Option" style="color: #5E5A5A; border: 0; border-radius: 0 !important; border-bottom: 1px rgba(94, 90, 90, .8) solid; margin-left: 6px" required>
                                </div>
                            </div>

                        </div>

                        <div class="input mb-3 mt-3">
                            <div class="d-flex flex-row align-items-center">
                                <label class="form-label m-0 me-2" style="min-width: 14px;">4.</label>
                                <input form="create-event-form" type="text" class="form-control w-75 flex-grow-1 me-2" name="question[]" value="Where was the event held?" style="background-color: rgba(207, 174, 172, .1) !important; color: #5E5A5A; border: 0; border-radius: 0 !important; border-bottom: 1px #5E5A5A solid" readonly required>
                                <select form="create-event-form" class="form-select w-25" id="answer-select-4" name="answer-key[]" style="border-radius: 0 !important" required>
                                    <option value="" selected hidden disabled>Answer Key</option>
                                    <option id="option-A4">A</option>
                                    <option id="option-B4">B</option>
                                    <option id="option-C4">C</option>
                                    <option id="option-D4">D</option>
                                </select>
                            </div>

                            <div class="d-flex flex-column gap-2 mt-2 w-75">
                                <div class="d-flex flex-row align-items-center ps-3">
                                    <input form="create-event-form" type="text" class="form-control" onchange="setupOptionInputs(4, 'A', this)" name="option-A[]" id="option-input-A4" placeholder="A. Add Option" style="color: #5E5A5A; border: 0; border-radius: 0 !important; border-bottom: 1px rgba(94, 90, 90, .8) solid; margin-left: 6px" required>
                                </div>

                                <div class="d-flex flex-row align-items-center ps-3">
                                    <input form="create-event-form" type="text" class="form-control" onchange="setupOptionInputs(4, 'B', this)" name="option-B[]" id="option-input-B4" placeholder="B. Add Option" style="color: #5E5A5A; border: 0; border-radius: 0 !important; border-bottom: 1px rgba(94, 90, 90, .8) solid; margin-left: 6px" required>
                                </div>

                                <div class="d-flex flex-row align-items-center ps-3">
                                    <input form="create-event-form" type="text" class="form-control" onchange="setupOptionInputs(4, 'C', this)" name="option-C[]" id="option-input-C4" placeholder="C. Add Option" style="color: #5E5A5A; border: 0; border-radius: 0 !important; border-bottom: 1px rgba(94, 90, 90, .8) solid; margin-left: 6px" required>
                                </div>

                                <div class="d-flex flex-row align-items-center ps-3">
                                    <input form="create-event-form" type="text" class="form-control" onchange="setupOptionInputs(4, 'D', this)" name="option-D[]" id="option-input-D4" placeholder="D. Add Option" style="color: #5E5A5A; border: 0; border-radius: 0 !important; border-bottom: 1px rgba(94, 90, 90, .8) solid; margin-left: 6px" required>
                                </div>
                            </div>

                        </div>

                        <div class="input mb-3 mt-3">
                            <div class="d-flex flex-row align-items-center">
                                <label class="form-label m-0 me-2" style="min-width: 14px;">5.</label>
                                <input form="create-event-form" type="text" class="form-control w-75 flex-grow-1 me-2" name="question[]" value="What is the event code?" style="background-color: rgba(207, 174, 172, .1) !important; color: #5E5A5A; border: 0; border-radius: 0 !important; border-bottom: 1px #5E5A5A solid" readonly required>
                                <button class="btn btn-outline-secondary w-25" type="button" id="randomize-event-code" style="color: #212529; font-size: 14px !important; border-radius: 0 !important; border: 1px #dee2e6 solid">Randomize</button>
                            </div>

                            <div class="d-flex flex-column gap-2 mt-2 w-75">
                                <div class="d-flex flex-row align-items-center ps-3">
                                    <input form="create-event-form" type="text" class="form-control" name="event-random-code" id="event-random-code" placeholder="Enter Code" style="color: #5E5A5A; border: 0; border-radius: 0 !important; border-bottom: 1px rgba(94, 90, 90, .8) solid; margin-left: 6px" required>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer flex-row justify-content-center">
                <div class="d-flex flex-row justify-content-center  gap-2 step-1-footer">
                    <button type="button" class="btn btn-primary cancel-modal-btn" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary next-modal-btn" id="next-toS2">Next</button>
                </div>
                <div class="d-flex flex-row justify-content-center  gap-2 step-2-footer" style="display:none !important">
                    <button type="button" class="btn btn-primary back-modal-btn" id="back-toS1">Back</button>
                    <button type="button" class="btn btn-primary next-modal-btn" id="next-toS3">Next</button>
                </div>
                <div class="d-flex flex-row justify-content-center  gap-2 step-3-footer" style="display:none !important">
                    <button type="button" class="btn btn-primary back-modal-btn" id="back-toS2">Back</button>
                    <button type="button" class="btn btn-primary create-modal-btn" id="next-toS4">Next</button>
                </div>
                <div class="d-flex flex-row justify-content-center  gap-2 step-4-footer" style="display:none !important">
                    <button type="button" class="btn btn-primary back-modal-btn" id="back-toS3">Back</button>
                    <button type="button" class="btn btn-primary create-modal-btn" id="next-toS5">Next</button>
                </div>
                <div class="d-flex flex-row justify-content-center  gap-2 step-5-footer" style="display:none !important">
                    <button type="button" class="btn btn-primary back-modal-btn" id="back-toS4">Back</button>
                    <button type="submit" name="submit" form="create-event-form" class="btn btn-primary create-modal-btn">Publish</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-load" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="background: transparent; border: 0">
            <div class="modal-body d-flex flex-row justify-content-center" style="background: transparent">
                <span class="loader" style="display: block"></span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete-user-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content test">
            <form id="delete-form" method="POST" action="../../modules/settings/delete_account.php">
                <input form="delete-form" hidden name="acc-id" value="" id="user-id">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel" style="font-weight: 600">Delete User?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    This will delete the user completely and the action is irreversible!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button form="delete-form" type="submit" name="submit-del" style="border: 0; background-color: var(--red-1)" class="btn btn-primary">Confirm</button>
                </div>
                <form>
        </div>
    </div>
</div>

<script>
    var quill = new Quill('#editor', {
        theme: 'snow'
    });
</script>