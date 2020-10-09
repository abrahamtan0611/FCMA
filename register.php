<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="Food Catering System">
	<meta name="keywords" content="HTML, CSS, JavaScript, PHP">
	<meta name="author" content="Didier Luther Ho Chih-Yuan">
	<title>Registration</title>
	<link rel="stylesheet" href="style.css" type="text/css"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<!--php header here-->

<div class="form">
<h1>Registration</h1>
	<form name="registration" action="register.php" method="post">	
	<p><label>Username: </label><br/>
	<input type="text" name="username" placeholder="Enter your firstname" required="required"></p>
	<p><label for="email">Email Address: </label><br/>
	<input type="email" name="email" placeholder="Email Address" required="required" /></p>
	<p><label for="contact">Phone number: </label><br/>
	<input type="text" name="contact" placeholder="Phone number" maxlength="12" required="required" /></p>
	<p><label for="password">Password: </label><br/>
	<input type="password" name="password" placeholder="Password" required="required" /></p>
	<p><label for="password">Retype Password: </label><br/>
	<input type="password" name="Re-password" placeholder="Re-enter your password" required="required" /></p>
	
	<p><input type="reset" name="reset" value="Reset" /></p>
	<p><input type="submit" name="submit" value="Register" /></p>
</form>
</div>
<?php
include("dtb.php");
if (isset($_REQUEST['username'])){
	$username = stripslashes($_REQUEST['username']);
	$email = stripslashes($_REQUEST['email']);
	$contact = stripslashes($_REQUEST['contact']);
	$password = stripslashes($_REQUEST['password']);
	$rePassword=stripslashes($_REQUEST['Re-password']);
	$contactPattern = "/^([0-9]{3})\\-([0-9]{7})$/";
	$errMsg="";
	$inputChk=true;

	$sql = $conn->query("INSERT INTO userdb(type, name, password, email, phoneNo) Values('0', '$username', '".md5($password)."', '$email', '$contact')");
	
	if($password!=$rePassword){
		$inputChk=false;
		$errMsg.="Password for both Password field and Retype Password field must be the same. ";
	}
	
	if(!preg_match($contactPattern, $contact)){
		$inputChk=false;
		$errMsg.="Please enter a valid phone number. ";
	}

	if(inputChk){
		if ($sql === TRUE) {
		  echo "New record created successfully";
		} else {
		  echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}else{
		echo"<p>".$errMsg."</p>";
	}
}else{
	echo "<div class='form'>
		<h3>registered failed.</h3>";
}
?>
<!--php footer here-->
</body>
</html>














