<?php include_once './includes/database.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/template.css" />
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
    <link rel="icon" type="image/x-icon" href="./assets/img/logo/cce-logo.png">
    <title>Center of Continuing Education</title>
</head>
<style>
    body,
    html {
        height: 100%;
        width: 100%;
    }
</style>

<body>
    <div class="w-100 h-100 d-flex flex-row justify-content-center align-items-center">
        <form id="admin-form" class="px-4 gap-3 d-flex align-items-center flex-column" style="margin-top: -12px; width: 100%; min-width: 350px; max-width: 700px;">
            <img src="./assets/img/logo/cce-logo.png" class="mb-3">

            <div class="w-100">
                <h6>Username/Email</h6>
                <input class="form-control" name="username" placeholder="Username or Email">
            </div>
            <div class="w-100">
                <h6>Password</h6>
                <input type="password" class="form-control" name="password" placeholder="Password">
            </div>

            <button type="submit" class="btn btn-primary w-100" style="border: 0; border-radius: 4px; color: white; background-color: var(--red-1)">LOGIN</button>
        </form>
    </div>

    <div class="modal fade" id="event-picker" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body w-100 p-4">
                    <h3 style="font-weight: 600">Choose Event: </h3>
                    <select id="event-select" class="form-select w-100" aria-label="Default select example">
                        <?php
                        $sql = "SELECT * FROM tbl_events WHERE day >= ? AND status = '5' AND venue_type = 'Set Location' ORDER BY day ASC";
                        foreach ($db->process_db($sql, "s", true, date("Y-m-d")) as $upcoming_event) {
                        ?>
                            <option value="<?php echo $upcoming_event["id"] ?>"><?php echo $upcoming_event["title"] ?></option>
                        <?php
                        }
                        ?>
                    </select>

                    <a id="confirm-btn" class="btn btn-primary w-100 mt-4" style="border: 0; border-radius: 4px; color: white; background-color: var(--red-1)">CONFIRM</a>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        $("#confirm-btn").attr("href", "./modules/events/scan_attendance.php?id=" + $("#event-select").val());

        $("#event-select").on("change", function() {
            $("#confirm-btn").attr("href", "./modules/events/scan_attendance.php?id=" + $(this).val());
        });

        $("#admin-form").submit(function(event) {
            event.preventDefault();

            $.ajax({
                url: "./modules/events/admin_login.php",
                type: "POST", 
                data: $(this).serialize(), 
                dataType: "json",
                success: function(response) {
                    if (response.status) {
                        // Show Modal
                        $("#event-picker").modal("show");
                    } else {
                        alert("Invalid Credentials!");
                    }
                }
            });
        });
    });
</script>

</html>