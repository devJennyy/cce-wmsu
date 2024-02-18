<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <link rel="icon" type="image/x-icon" href="../../assets/img/logo/cce-logo.png">
    <link rel="stylesheet" type="text/css" href="../../assets/css/template.css" />
    <link rel="stylesheet" type="text/css" href="../../assets/css/scan_qr.css" />
    <!-- Include ZXing library from CDN -->
    <script type="text/javascript" src="https://unpkg.com/@zxing/browser@latest"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="w-100 h-100 d-flex flex-row justify-content-center align-items-center">
        <div class="scanner-wrapper px-4 gap-3 d-flex align-items-center flex-column" style="width: 100%; min-width: 350px; max-width: 700px;">
            <div class="d-flex justify-content-center align-items-center flex-column mb-4">
                <h2 style="font-weight: 700; font-size: 1.8rem">Scan QR Code</h2>
                <h6 style="text-align: center; width: 80%; color: #B9B9B9; font-size: 11px; line-height: 22px;">Place qr code inside the frame to scan, avoid shaking to get results quickly.</h6>
            </div>
            <div class="container mt-4 mb-2" style="width: 85%; position: relative;">
                <div class="video-wrapper">
                    <video id="qr-video" width="100%" height="100%" autoplay></video>
                </div>
                <img src="../../assets/img/admin/qr-border.svg" style="aspect-ratio: 1; width: 100%; position: absolute; top: -12px; left: 0; z-index: 2">
                
                <div class="scan-again" style="width: 95%; background-color: rgba(0,0,0,.5); backdrop-filter: blur(5px); aspect-ratio: 1; position: absolute; top: -6px; left: 50%; transform: translateX(-50%);"></div>
                <button class="btn btn-primary scan-again" style="z-index: 3; position: absolute; top: 40%; left: 50%; transform: translate(-50%, -50%); font-size: 13px; background-color: var(--red-1); border: 0;">Scan Again</button>
                
                <h6 style="font-size: 12px; text-align: center" class="mt-5" id="scanner-status"><br></h6>
            </div>
            
            <h4 style="font-weight: 600; color: var(--red-1); margin-top: 4%; text-align: center; width: 95%;" id="result-status"></h4>
        </div>
    </div>
</body>
<script>
    // Script to scan for QR Attendance.
    document.addEventListener("DOMContentLoaded", function() {
        const video = document.getElementById("qr-video");
        let scanning = true; // Flag to control scanning

        $(".scan-again").click(function() {
            $(".scan-again").hide();
            scanning = true;

            $('#result-status').text('');
            $('#scanner-status').text("Scanning QR...");
        });

        $('.scan-again').hide();
        $('#scanner-status').text("Scanning QR...");

        // Check if the browser supports getUserMedia
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            // Access the device camera
            navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: "environment" // "user" for front camera, "environment" for back camera
                    }
                })
                .then(function(stream) {
                    // Set the video source to the camera stream
                    video.srcObject = stream;

                    // Initialize the code reader
                    const codeReader = new ZXingBrowser.BrowserQRCodeReader();

                    // Start scanning for QR codes
                    codeReader.decodeFromVideoDevice(undefined, 'qr-video', (result, err) => {
                        if (result && scanning) {
                            // Handle the scanned QR code result
               
                            $.ajax({
                                type: "POST",
                                url: "../../modules/events/attendance.php",
                                data: {
                                    event_id: <?php echo $_GET["id"] ?>,
                                    qr_str: result.text
                                },
                                success: function(response) {
                                    $('#scanner-status').text("Scanned Successfully!");

                                    $('#result-status').text(response[0].message);

                                    $('.scan-again').show();
                                    scanning = false;
                                }
                            })
                        }
                    });
                })
                .catch(function(err) {
                    console.error("Error accessing camera:", err);
                });
        } else {
            console.error("getUserMedia is not supported by this browser.");
        }
    });
</script>

</html>