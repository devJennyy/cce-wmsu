<?php

// Function to generate a QR code using the GoQR.me API
include_once '../../includes/functions.php';

// Example data to encode in the QR code
$dataToEncode = 'WmgiE3H2v8nq';

// Generate the QR code image
$qrCodeBase64 = generateQRCode($dataToEncode);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Example</title>
</head>
<body>
    <!-- Display the QR code directly in the browser -->
    <h1>This is the qr</h1>
    <img src="http://api.qrserver.com/v1/create-qr-code/?data=603lPaD5xveT&size=400x400" alt="QR Code">
</body>
</html>
