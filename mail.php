<?php
require('PHPMailer/PHPMailerAutoload.php');

$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPAuth = true; 
$mail->SMTPSecure = 'tls';
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->isHTML();
$mail->Username = 'foodedgegourmetcatering@gmail.com';
$mail->Password = 'foodedgeswin';
$mail->setFrom('no-reply@fcms.com', 'no-reply@fcms.com');
$mail->Subject = 'Receipt';
$mail->Body = 'Thank you for your purchase! Our operation team will verify the payment and get in touch with you.';
$mail->addAttachment('Receipt/receipt.pdf');  
$mail->AddAddress('abrahamtan0611@outlook.com');

$mail->Send();
?>