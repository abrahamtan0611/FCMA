<?php
require('../PHPMailer/PHPMailerAutoload.php');

if(isset($_POST["reset-request-submit"])){  
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    $url = "localhost/FCMS-msater/create-new-pw.php?selector=" .$selector."&validator=" . bin2hex($token);
    
    $expires = date("U") + 1800;
    
    require "dtb.php";
    
    $userEmail = $_POST["email"];
    
    $sql = "DELETE FROM pwReset WHERE pwResetEmail=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        
        echo"There was an error!";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $userEmail);
        mysqli_stmt_execute(stmt);
        
    }
    
     $sql = "INSERT INTO pwReset (pwResetEmail, pwResetSelector, pwResetToken, pwResetExpires) VALUES (?, ?, ?, ?);";
    
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        
        echo"There was an error!";
        exit();
    } else {
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
        mysqli_stmt_execute(stmt);
        
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    $to = $userEmail;
    
    $subject = 'Reset your password for FoodEdge';
    
    $message = '<p> We received a password reset request. The link to reset your password is below. If you did not make this request, you can ignore this e-mail</p>';
    $message .= '<p>Here is your password reset link: </br>';
    $message .= 'a href="' . $url . '">' .$url . '</a></p>';
    
    $headers = "From: FoodEdge <FoodEdge@gmail.com> \r\n";
    $headers .= "Reply-To: FoodEdge@gmail.com\r\n";
    $headers .= "Content-type: text/html\r\n";
    
    mail($to, $subject, $message, $headers);
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
	$mail->Subject = $subject;
	$mail->Body = $message;
	$mail->AddAddress($to);

	$mail->Send();
    header("Location: ../resetpw.php?reset=success");
}else{
	header("Location:../index.php");
}	
?>
