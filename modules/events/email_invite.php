<?php

use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception; 

require '../../vendor/autoload.php';

function sendEmail($address, $title, $link, $img_bg, $id, $isVirtual = false, $qr_data = null){
  $mail = new PHPMailer; 
 
  $mail->isSMTP();                      // Set mailer to use SMTP 
  // FOR HOSTINGER
  // $mail->Host = 'smtp.hostinger.com';       // Specify main and backup SMTP servers 
  // $mail->SMTPAuth = true;               // Enable SMTP authentication 
  // $mail->Username = 'cce@wmsu-cce.online';   // SMTP username 
  // $mail->Password = 'Sky123654;';   // SMTP password 
  // $mail->SMTPSecure = 'tls';            // Enable TLS encryption, `ssl` also accepted 
  // $mail->Port = 587;                    // TCP port to connect to 
  
  // Sender info 
  // $mail->setFrom('cce@wmsu-cce.online', 'Center of Continuing Education'); 
  // $mail->Subject = "CCE Event Invitation"; 
  // $mail->isHTML(true);
  // $mail->SMTPKeepAlive = true;

  // FOR GMAIL
  $mail->Host = 'smtp.gmail.com';
  $mail->Port = 465;
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
  $mail->SMTPAuth = true;

  $mail->Username = 'jennypieloor.connect@gmail.com';
  $mail->Password = 'asdfghjkl2212;';

  $mail->SetFrom("jennypieloor.connect@gmail.com", "WMSU-CCE");
  $mail->Subject = "CCE Event Invitation"; 
  $mail->isHTML(true);
  $mail->SMTPKeepAlive = true;

  foreach($address as $key => $recipient){
    $mail->clearAddresses();
    $mail->addAddress($recipient); 

    if($isVirtual){
      $template = file_get_contents('../../assets/email/template_virtual.php');
      $emailBody = strtr($template, ['{EVENT_LINK}' => $link, '{EVENT_IMG}' => $img_bg, '{EVENT_TITLE}' => $title, '{EVENT_ID}' => $id]);    
    }
    else {
      $template = file_get_contents('../../assets/email/template_physical.php');
      $emailBody = strtr($template, ['{EVENT_LINK}' => $link, '{EVENT_IMG}' => $img_bg, '{EVENT_TITLE}' => $title, '{EVENT_ID}' => $id, '{QR_IMG}' => generateQRCode($qr_data[$key])]);    
    }
    // Mail body content 
    $mail->Body    = $emailBody;

    if(!$mail->send()) { 
      echo 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo; 
    }
  }

}


