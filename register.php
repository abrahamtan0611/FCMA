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
		echo '<script type="text/javascript">
						alert("SQL error.");
					</script>';
    }else{
		mysqli_stmt_bind_param($stmt, "s",$email);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		$resultCheck = mysqli_stmt_num_rows($stmt); // check whether email exist or not
		if($resultCheck > 0){
        echo '<script type="text/javascript">
						alert("Email is being taken or registered.");
					</script>';
		}else{
			if ($password !== $passwordRpt){
				echo '<script type="text/javascript">
						alert("Both password does not match. Please try again.");
					</script>';
			}else{
				$sql = "INSERT INTO userdb (type, username, password, email, phoneNo) VALUES (?, ?, ?, ?, ?)";
			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt, $sql)){
				echo '<script type="text/javascript">
						alert("SQL error.");
					</script>';
			}else{
				// hash the password using bcrypt
				$hashPwd = password_hash($password, PASSWORD_DEFAULT);
				mysqli_stmt_bind_param($stmt, "issss",$type, $username, $hashPwd, $email, $phoneno);
				mysqli_stmt_execute($stmt);
				echo '<script type="text/javascript">
					alert("Register Successful");
					window.location = "login.php";
				</script>';
				exit();
				}
			}	
		}
	}
	mysqli_stmt_close($stmt); // close the statement to save resources
	mysqli_close($conn);  // close the connection to save resources
}
?> 

<!-- HTML CODE -->
<div class="register-input-field">
	<h3>Register</h3>
	<form id="register" method="POST"> 
		<div class="form-group">
			<label>Username </label>
			<label class="required">*</label>
			<input type="text" class = "form-control" name="username" placeholder="Username" required />
		</div>
		<div class="form-group">
			<label>Email Address</label>
			<label class="required">*</label>
			<input type="email" class = "form-control" name="email" placeholder="Email Address" required />
		</div>
		<div class="form-group">
			<label>Phone Number </label>
			<label class="required">*</label>
			<input type="text" class = "form-control" name="phoneno" placeholder="Phone number" required />
		</div>
		<div class="form-group">
			<label>Password </label>
			<label class="required">*</label>
			<input type="password" class = "form-control" name="pwd" placeholder="Password" required />
		</div>
		<div class="form-group">
			<label>Retype Password </label>
			<label class="required">*</label>
			<input type="password" class = "form-control" name="pwd-repeat" placeholder="Retype Password" required />
		</div>
		<button type="submit" name="register-submit">Register</button>
		<button type="reset" name="register-reset-btn">Reset</button>
	</form>
</div>
