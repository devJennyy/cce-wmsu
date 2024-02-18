<?php
$organizations = "active";
$css = "<link rel='stylesheet' type='text/css' href='organizations.css' />";
$top_greet = "Welcome to <span>Organizations</span>";

include_once '../header.php';
?>
<div class="tab-content w-100 h-100" id="myTabContent">
    <div class="tab-pane fade show active h-100 w-100" id="approval-tab-pane" role="tabpanel" aria-labelledby="approval-tab" tabindex="0">
        <div class="req-header d-flex flex-row align-items-center w-100">
            <h6 class="top-text">My Events</h6>
            <select class="form-select" aria-label="Default select example">
                <option selected value="All">All</option>
                <option value="Unread">One</option>
                <option value="Read">Two</option>
            </select>
        </div>
        <div class="label-div d-flex flex-row">
            <label class="time-txt">Time</label>
            <label class="org-txt">Events</label>
        </div>
        <div class="content-wrapper d-flex flex-column">
            <div class="request-div d-flex flex-row w-100">
                <div class="time-div h-100">
                    <h6 class="date">Today</h6>
                    <h6 class="time">10:00</h6>
                </div>
                <div class="main-req-content d-flex flex-row w-100 h-100">
                    <div class="avatar-div d-flex flex-row h-100">
                        <div class="red-thingy"></div>
                        <div class="avatar-wrapper">
                            <img src="../../assets/img/admin/participant-img.png" alt="Avatar" width="32">
                        </div>
                    </div>
                    <div class="info-div d-flex flex-column w-100 h-100">
                        <div class="header-text-div d-flex flex-row justify-content-between w-100">
                            <h6><b>Figma Organization</b> requested an "<b>International Jazz Festival</b>" event.</h6>

                            <div class="status-div d-flex flex-row justify-content-center align-items-center rejected">REJECTED</div>
                        </div>
                        <div class="org-details-div w-100">
                            <h6><b>Purpose:</b></h6>
                            <h6>"To foster a collaborative and inclusive teaching environment, where faculty members actively engage professional development activities and share best practices to enhance student learning outcomes."</h6>
                            <div class="info-div d-flex flex-row w-100 mt-3 gap-4">
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
                        </div>
                        <div class="btn-div d-flex flex-row justify-content-end h-100 w-100">
                            <button class="btn btn-primary view-btn" data-bs-toggle="modal" data-bs-target="#view-modal">View Details</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="request-div d-flex flex-row w-100">
                <div class="time-div h-100">
                    <h6 class="date">Today</h6>
                    <h6 class="time">10:00</h6>
                </div>
                <div class="main-req-content d-flex flex-row w-100 h-100">
                    <div class="avatar-div d-flex flex-row h-100">
                        <div class="red-thingy"></div>
                        <div class="avatar-wrapper">
                            <img src="../../assets/img/admin/participant-img.png" alt="Avatar" width="32">
                        </div>
                    </div>
                    <div class="info-div d-flex flex-column w-100 h-100">
                        <div class="header-text-div d-flex flex-row justify-content-between w-100">
                            <h6><b>Figma Organization</b> requested an "<b>International Jazz Festival</b>" event.</h6>

                            <div class="status-div d-flex flex-row justify-content-center align-items-center approved">APPROVED</div>
                        </div>
                        <div class="org-details-div w-100">
                            <h6><b>Purpose:</b></h6>
                            <h6>"To foster a collaborative and inclusive teaching environment, where faculty members actively engage professional development activities and share best practices to enhance student learning outcomes."</h6>
                            <div class="info-div d-flex flex-row w-100 mt-3 gap-4">
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
                        </div>
                        <div class="btn-div d-flex flex-row justify-content-end h-100 w-100">
                            <button class="btn btn-primary approve-btn" data-bs-toggle="modal" data-bs-target="#approve-modal">Join Event</button>
                            <button class="btn btn-primary view-btn" data-bs-toggle="modal" data-bs-target="#view-modal">View Details</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="request-div d-flex flex-row w-100">
                <div class="time-div h-100">
                    <h6 class="date">Today</h6>
                    <h6 class="time">10:00</h6>
                </div>
                <div class="main-req-content d-flex flex-row w-100 h-100">
                    <div class="avatar-div d-flex flex-row h-100">
                        <div class="red-thingy"></div>
                        <div class="avatar-wrapper">
                            <img src="../../assets/img/admin/participant-img.png" alt="Avatar" width="32">
                        </div>
                    </div>
                    <div class="info-div d-flex flex-column w-100 h-100">
                        <div class="header-text-div d-flex flex-row justify-content-between w-100">
                            <h6><b>Figma Organization</b> requested an "<b>International Jazz Festival</b>" event.</h6>

                            <div class="status-div d-flex flex-row justify-content-center align-items-center review">UNDER REVIEW</div>
                        </div>
                        <div class="org-details-div w-100">
                            <h6><b>Purpose:</b></h6>
                            <h6>"To foster a collaborative and inclusive teaching environment, where faculty members actively engage professional development activities and share best practices to enhance student learning outcomes."</h6>
                            <div class="info-div d-flex flex-row w-100 mt-3 gap-4">
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
                        </div>
                        <div class="btn-div d-flex flex-row justify-content-end h-100 w-100">
                            <button class="btn btn-primary view-btn" data-bs-toggle="modal" data-bs-target="#view-modal">View Details</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade view-modal" id="view-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-top-img w-100 d-flex flex-row justify-content-center align-items-end">
                        <img src="../../assets/img/admin/event-modal-icon.svg" width="40%">
                    </div>
                    <div class="content-wrapper-modal">
                        <h6><span>REQUESTING FOR APPROVAL</span></h6>
                        <div class="representative-details w-100">
                            <h6 class="header-text">REPRESENTATIVE DETAIlS</h6>
                            <div class="info-wrapper w-100 d-flex flex-row">
                                <label class="label-text">Full name:</label>
                                <label class="info-text">Jenny Pieloor</label>
                            </div>
                            <div class="info-wrapper w-100 d-flex flex-row">
                                <label class="label-text">Email:</label>
                                <label class="info-text">JennyPieloor@gmail.com</label>
                            </div>
                        </div>
                        <div class="organization-details w-100">
                            <h6 class="header-text">ORGANIZATION DETAIlS</h6>
                            <div class="info-wrapper w-100 d-flex flex-row">
                                <label class="label-text">Name:</label>
                                <label class="info-text">Technical Organization</label>
                            </div>
                            <div class="info-wrapper w-100 d-flex flex-row">
                                <label class="label-text">Acronym:</label>
                                <label class="info-text">XYZ Org.</label>
                            </div>
                            <div class="info-wrapper w-100 d-flex flex-row">
                                <label class="label-text">Attachment:</label>
                                <label class="info-text"><a href="#">See all 5 attachments</a></label>
                            </div>
                            <div class="info-wrapper w-100 d-flex flex-row">
                                <label class="label-text">Details:</label>
                                <label class="info-text">XYZ Tech Solutions Inc. is a leading technology company specializing in providing innovative IT solutions for businesses of all sizes. With over a mile</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php
include_once '../footer.php';
?>