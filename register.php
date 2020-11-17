<?php
  // start session
  session_start();
  require_once "Include/header.php";
 ?>
 
 <?php
if (isset($_POST['register-submit'])){
	require_once'Include/dtb.php';
	
	// variables
	$username = $_POST['username'];
	$email = $_POST['email'];
	$phoneno = $_POST['phoneno'];
	$password = $_POST['pwd'];
	$passwordRpt = $_POST['pwd-repeat'];
	$totalP = 0;
	$type = 1;
	
	$sql = "SELECT email FROM userdb WHERE email=?";
	$stmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo '<script type="text/javascript">
				alert("SQL statement error.");
			</script>';
    }else{
		mysqli_stmt_bind_param($stmt,"s",$email);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		$resultCheck = mysqli_stmt_num_rows($stmt); // check whether email exist or not
		if($resultCheck > 0){
        echo 	'<script type="text/javascript">
					alert("Email is being taken or registered.");
				</script>';
		}else{
			// validate password
			if ($password !== $passwordRpt){
				echo '<script type="text/javascript">
						alert("Both password does not match. Please try again.");
					</script>';
			}else{
				// validate phone no
				if (is_numeric($phoneno)){
					$sql = "INSERT INTO userdb (type, username, password, email, phoneNo, totalPurchased) VALUES (?, ?, ?, ?, ?, ?)";
					$stmt = mysqli_stmt_init($conn);
					if(!mysqli_stmt_prepare($stmt, $sql)){
						echo '<script type="text/javascript">
								alert("SQL statement error.");
							</script>';
					}else{
						// hash the password using bcrypt
						$hashPwd = password_hash($password, PASSWORD_DEFAULT);
						mysqli_stmt_bind_param($stmt, "issssi",$type, $username, $hashPwd, $email, $phoneno, $totalP);
						mysqli_stmt_execute($stmt);
						echo '<script type="text/javascript">
							alert("Register Successful");
							window.location = "login.php?register=success";
						</script>';
						exit();
					}
				}else{
					echo '<script type="text/javascript">
						alert("Please enter a valide phone number.");
					</script>';
				}
				
			}	
		}
	}
	mysqli_stmt_close($stmt); // close the statement to save resources
	mysqli_close($conn);  // close the connection to save resources
}
?> 
<!-- REGISTER FORM -->
<section id="content">
<div  class="register-input-field">
	<h3>Register</h3>
	<form id="register" method="POST"> 
		<div class="form-group">
			<label>Username </label>
			<label class="required">*</label>
			<input type="text" class = "form-control" name="username" placeholder="Username..." required />
		</div>
		<div class="form-group">
			<label>Email Address</label>
			<label class="required">*</label>
			<input type="email" class = "form-control" name="email" placeholder="Email Address..." required />
		</div>
		<div class="form-group">
			<label>Phone Number </label>
			<label class="required">*</label>
			<input type="text" class = "form-control" maxlength="10" name="phoneno" placeholder="Phone number..." required />
		</div>
		<div class="form-group">
			<label>Password </label>
			<label class="required">*</label>
			<input type="password" class = "form-control" name="pwd" placeholder="Password..." required />
		</div>
		<div class="form-group">
			<label>Retype Password </label>
			<label class="required">*</label>
			<input type="password" class = "form-control" name="pwd-repeat" placeholder="Retype Password..." required />
		</div>
		<button type="submit" name="register-submit">Register</button>
		<button type="reset" name="register-reset-btn">Reset</button>
	</form>
</div>
</section>
</div>
<?php
 include_once "Include/footer.php"; 
 ?>
