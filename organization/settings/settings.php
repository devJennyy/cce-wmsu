<?php
$settings = "active";
$css = "<link rel='stylesheet' type='text/css' href='settings.css' />";
$top_greet = "Welcome to your <span>Settings</span>";

include_once '../header.php';
?>

<div class="w-100 h-100 d-flex flex-column">
    <ul class="nav nav-tabs d-flex flex-row justify-content-center" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="manage-account-tab" data-bs-toggle="tab" data-bs-target="#manage-account-tab-pane" type="button" role="tab" aria-controls="manage-account-tab-pane" aria-selected="true">Manage Account</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="organization-tab" data-bs-toggle="tab" data-bs-target="#organization-tab-pane" type="button" role="tab" aria-controls="organization-tab-pane" aria-selected="false">Organizations</button>
        </li>
    </ul>
    <div class="tab-content w-100 h-100 flex-shrink-1" id="myTabContent">
        <div class="tab-pane fade show active h-100 w-100 manage-account-tab" id="manage-account-tab-pane" role="tabpanel" aria-labelledby="manage-account-tab" tabindex="0">
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
        <div class="tab-pane fade show h-100 w-100 p-0" id="organization-tab-pane" role="tabpanel" aria-labelledby="organization-tab" tabindex="0">
            <div class="w-100 h-100 d-flex flex-row">
                <div class="d-flex flex-column flex-shrink-0 py-4 px-5" style="width: 55%; box-shadow: 6px 6px 30px rgba(156, 43, 35, 0.10)">
                    <ul class="nav nav-tabs d-flex flex-row justify-content-between gap-1" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation" style="width: 50%;">
                            <button class="nav-link active" id="all-org-tab" data-bs-toggle="tab" data-bs-target="#all-org-tab-pane" type="button" role="tab" aria-controls="all-org-tab-pane" aria-selected="true">All Organizations</button>
                        </li>
                        <li class="nav-item flex-grow-1" role="presentation">
                            <button class="nav-link" id="my-org-tab" data-bs-toggle="tab" data-bs-target="#my-org-tab-pane" type="button" role="tab" aria-controls="my-org-tab-pane" aria-selected="false">My Organizations</button>
                        </li>
                    </ul>
                    <div class="tab-content w-100 flex-grow-1" id="myTabContent">
                        <div class="tab-pane p-0 fade show active h-100 w-100 all-org-tab"  id="all-org-tab-pane" role="tabpanel" aria-labelledby="all-org-tab" tabindex="0">
                            <div class="h-100 w-100 d-flex flex-column">
                                <div class="search-bar mt-3">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    <input type="text" class="form-control" id="search-invite" placeholder="Search participants to invite">
                                </div>

                                <ul class="nav nav-tabs d-flex flex-column mt-4 flex-grow-1" style="max-height: 450px; overflow: auto; flex-wrap: nowrap" id="orgTabs" role="tablist">
                                    <li class="nav-item w-100" role="presentation">
                                        <button class="nav-link py-4 active" style="position: relative" id="" data-bs-toggle="tab" data-bs-target="#tab-pane" type="button" role="tab" aria-controls="tab-pane" aria-selected="true">
                                            TechVista Innovations, Inc. -  (TVI)

                                            <i class="fa-solid fa-chevron-right me-3 angle-right" style="position: absolute; right: 0; top: 50%; transform: translateY(-50%)"></i>
                                        </button>
                                        
                                    </li>
                                    <li class="nav-item w-100" role="presentation">
                                        <button class="nav-link py-4" style="position: relative" id="" data-bs-toggle="tab" data-bs-target="#tab-pane" type="button" role="tab" aria-controls="tab-pane" aria-selected="false">
                                            TechVista Innovations, Inc. -  (TVI)

                                            <i class="fa-solid fa-chevron-right me-3 angle-right" style="position: absolute; right: 0; top: 50%; transform: translateY(-50%)"></i>
                                        </button>
                                    </li>
                                    <li class="nav-item w-100" role="presentation">
                                        <button class="nav-link py-4" style="position: relative" id="" data-bs-toggle="tab" data-bs-target="#tab-pane" type="button" role="tab" aria-controls="tab-pane" aria-selected="false">
                                            TechVista Innovations, Inc. -  (TVI)

                                            <i class="fa-solid fa-chevron-right me-3 angle-right" style="position: absolute; right: 0; top: 50%; transform: translateY(-50%)"></i>
                                        </button>
                                    </li>
                                    <li class="nav-item w-100" role="presentation">
                                        <button class="nav-link py-4" style="position: relative" id="" data-bs-toggle="tab" data-bs-target="#tab-pane" type="button" role="tab" aria-controls="tab-pane" aria-selected="false">
                                            TechVista Innovations, Inc. -  (TVI)

                                            <i class="fa-solid fa-chevron-right me-3 angle-right" style="position: absolute; right: 0; top: 50%; transform: translateY(-50%)"></i>
                                        </button>
                                    </li>
                                    <li class="nav-item w-100" role="presentation">
                                        <button class="nav-link py-4" style="position: relative" id="" data-bs-toggle="tab" data-bs-target="#tab-pane" type="button" role="tab" aria-controls="tab-pane" aria-selected="false">
                                            TechVista Innovations, Inc. -  (TVI)

                                            <i class="fa-solid fa-chevron-right me-3 angle-right" style="position: absolute; right: 0; top: 50%; transform: translateY(-50%)"></i>
                                        </button>
                                    </li>
                                    <li class="nav-item w-100" role="presentation">
                                        <button class="nav-link py-4" style="position: relative" id="" data-bs-toggle="tab" data-bs-target="#tab-pane" type="button" role="tab" aria-controls="tab-pane" aria-selected="false">
                                            TechVista Innovations, Inc. -  (TVI)

                                            <i class="fa-solid fa-chevron-right me-3 angle-right" style="position: absolute; right: 0; top: 50%; transform: translateY(-50%)"></i>
                                        </button>
                                    </li>
                                    <li class="nav-item w-100" role="presentation">
                                        <button class="nav-link py-4" style="position: relative" id="" data-bs-toggle="tab" data-bs-target="#tab-pane" type="button" role="tab" aria-controls="tab-pane" aria-selected="false">
                                            TechVista Innovations, Inc. -  (TVI)

                                            <i class="fa-solid fa-chevron-right me-3 angle-right" style="position: absolute; right: 0; top: 50%; transform: translateY(-50%)"></i>
                                        </button>
                                    </li>
                                    <li class="nav-item w-100" role="presentation">
                                        <button class="nav-link py-4" style="position: relative" id="" data-bs-toggle="tab" data-bs-target="#tab-pane" type="button" role="tab" aria-controls="tab-pane" aria-selected="false">
                                            TechVista Innovations, Inc. -  (TVI)

                                            <i class="fa-solid fa-chevron-right me-3 angle-right" style="position: absolute; right: 0; top: 50%; transform: translateY(-50%)"></i>
                                        </button>
                                    </li>
                                    
                                </ul>
                            </div>
                        </div>
                        <div class="tab-pane fade show h-100 w-100 my-org-tab" id="my-org-tab-pane" role="tabpanel" aria-labelledby="my-org-tab" tabindex="0">
                            My Org
                        </div>
                    </div>
                </div>
                <div class="flex-grow-1 w-100" >

                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once '../footer.php';
?>