<?php
  // start session
  session_start();
  require "Include/header.php";
 ?>
 
 <?php
if (isset($_POST['register-submit'])){
	require 'Include/dtb.php';
	
	$username = $_POST['username'];
	$email = $_POST['email'];
	$phoneno = $_POST['phoneno'];
	$password = $_POST['pwd'];
	$passwordRpt = $_POST['pwd-repeat'];
	$type = 1;
 
	$sql = "SELECT email FROM userdb WHERE email=?";
	$stmt = mysqli_stmt_init($conn); // check if we can prepared the statement and connection
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo 'alert("SQL error!)';
		//header("Location: register.php?error=sqlerror");
		exit();
    }else{
		mysqli_stmt_bind_param($stmt, "s",$email);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		$resultCheck = mysqli_stmt_num_rows($stmt); // check whether email exist or not
		if($resultCheck > 0){
        header("Location: register.php?error=emailtaken");
        exit();
		}else{
			$sql = "INSERT INTO userdb (type, username, password, email, phoneNo) VALUES (?, ?, ?, ?, ?)";
			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt, $sql)){
				echo 'alert("SQL error!")' ;
				exit();
			}else{
				// hash the password using bcrypt
				$hashPwd = password_hash($password, PASSWORD_DEFAULT);
				mysqli_stmt_bind_param($stmt, "issss",$type, $username, $hashPwd, $email, $phoneno);
				mysqli_stmt_execute($stmt);
				header("Location: login.php?register=success");
				exit();
			}
		}
	}
	mysqli_stmt_close($stmt); // close the statement to save resources
	mysqli_close($conn);  // close the connection to save resources
}
?> 
 
 
 <!-- HTML CODE -->
 <div class="container">
	 <form id="register" method="POST">
		<div class="form-header">
			<h3>Sign Up</h3>
			<p>Please fill in the follwoing details</p>
		</div>
		<div class="form-line"></div>
		<div class="inputs">
			<input type="text" name="username" placeholder="Username" required />
			<input type="email" name="email" placeholder="E-mail" required />
			<input type="text" name="phoneno" placeholder="Phone number" required />
			<input type="password" name="pwd" placeholder="Password" required />
			<input type="password" name="pwd-repeat" placeholder="Retype Password" required />
			
			<button type="submit" name="register-submit">SIGN UP</button>
			<!-- <a id="register-submit">SIGN UP</a> -->
		</div>
	</form>
</div>


	
 
 <!--
 <div class="form">
<h1>Registration</h1>
	<form name="registration" action="include/registerValidator.php" method="post">	
	<p><label>Username: </label><br/>
	<input type="text" name="username" placeholder="Enter your firstname"><br/></p>
	<p><label for="email">Email Address: </label><br/>
	<input type="email" name="email" placeholder="Email Address" required /><br/></p>
	<p><label for="contact">Phone number: </label><br/>
	<input type="text" name="contact" placeholder="Phone number" required /><br/></p>
	<p><label for="password">Password: </label><br/>
	<input type="password" name="password" placeholder="Password" required /><br/></p>
	<p><label for="password">Retype Password: </label><br/>
	<input type="password" name="Re-password" placeholder="Re-enter your password" required /><br/></p>
	
	<p><input type="reset" name="reset" value="Reset" /></p>
	<p><input type="submit" name="submit" value="Register" /></p>
</form>
</div>
-->
 