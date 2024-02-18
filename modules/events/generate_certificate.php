<?php
session_start();
if(!isset($_SESSION["id"])){
    echo "Please Login!";
    exit();
}

include_once '../../includes/database.php';

$verifySQL = "SELECT * FROM tbl_event_participants WHERE account_id = ? AND certificate_sent = 1";
$verify = $db->process_db($verifySQL, "s", true, $_SESSION["id"]);
if(empty($verify)){
    echo "Empty";
}
else {


$sql = "SELECT * FROM tbl_certificates WHERE event_id = ?";

// Initialize
$imagePath = '';
$name = "";
$font = ''; 
$font_size = 0;
$font_weight = 0;
$text_box = [
    'x' => 0,         
    'y' => 0,         
    'width' => 0,    
    'height' => 0    
];

// Get stored certificate data from the database
foreach($db->process_db($sql, "s", true, $_GET["id"]) as $certificate_details){
    $imagePath = '../../assets/attachments/certificates/' . $certificate_details["source"];

    $name = ucwords($_SESSION["firstname"] . " " . $_SESSION["lastname"]);
    $font = '../../assets/attachments/certificates/ttf/' . $certificate_details["font_style"]; // Specify the path to a TrueType font file with font weight
    $font_size = intval($certificate_details["font_size"]) - 10;
    $font_weight = intval($certificate_details["font_weight"]);
    $text_box = [
        'x' => intval($certificate_details["x_pos"])-10,         // X-coordinate of the top-left corner of the text box
        'y' => intval($certificate_details["y_pos"])-5,         // Y-coordinate of the top-left corner of the text box
        'width' => intval($certificate_details["width"]),    // Width of the text box
        'height' => intval($certificate_details["height"])    // Height of the text box
    ];
}


// Check if the file exists
if (file_exists($imagePath)) {
    // Get the image type based on MIME type
    $imageType = exif_imagetype($imagePath);

    // Check if the image type is valid (JPEG or PNG)
    if ($imageType === IMAGETYPE_JPEG || $imageType === IMAGETYPE_PNG) {
        // Load the original image
        if ($imageType === IMAGETYPE_JPEG) {
            $image = imagecreatefromjpeg($imagePath);
            $text_color = imagecolorallocate($image, 0, 0, 0); 
        } elseif ($imageType === IMAGETYPE_PNG) {
            $image = imagecreatefrompng($imagePath);
            $text_color = imagecolorallocate($image, 0, 0, 0);
        }

        
        // Calculate the border coordinates to surround the text box
        $border_x1 = $text_box['x'];
        $border_y1 = $text_box['y'];
        $border_x2 = $text_box['x'] + $text_box['width'];
        $border_y2 = $text_box['y'] + $text_box['height'];

        // Calculate the text box
        $text_box_size = imagettfbbox($font_size, 0, $font, $name);
        $text_width = $text_box_size[4] - $text_box_size[6];
        $text_height = $text_box_size[1] - $text_box_size[7];

        // Calculate the center position within the text box for the text
        $text_x = $border_x1 + ($text_box['width'] - $text_width) / 2;
        $text_y = $border_y1 + ($text_box['height'] + $text_height) / 2;


        // Add the text to the image with font weight
        imagettftext($image, $font_size, 0, $text_x, $text_y, $text_color, $font, $name);

        
        // Random alphanumeric for the file name.
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
    
        for ($i = 0; $i < 8; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        // Send the appropriate headers for downloading
        if ($imageType === IMAGETYPE_JPEG) {
            header('Content-Type: image/jpeg');
            header('Content-Disposition: attachment; filename="' . $randomString . '.jpg"');
            imagejpeg($image);
        } elseif ($imageType === IMAGETYPE_PNG) {
            header('Content-Type: image/png');
            header('Content-Disposition: attachment; filename="' . $randomString . '.png"');
            imagepng($image);
        }

        // Free up memory
        imagedestroy($image);
    } else {
        die("Unsupported image type.");
    }
} else {
    die("Image file not found.");
}
    
}
?>
