<?php
	// start session
	session_start();
	if (!empty($_SESSION['uid'])){
		$custId = $_SESSION['uid'];
		//$username = $_SESSION['username'];
		//$email = $_SESSION['email'];
	}else{
		echo '<script type="text/javascript">
					alert("Invalid Session!");
					window.location = "index.php";
				</script>';
		exit();
	}
	
	require 'Include/dtb.php';
	
	// get all information based on userID
	$sql = "SELECT * FROM userdb WHERE userID=?";
	$stmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt,$sql)){
		echo '<script type="text/javascript">
						alert("SQL Error.");
					</script>';
	}else{
		mysqli_stmt_bind_param($stmt, "s", $custId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		if($row = mysqli_fetch_assoc($result)){
			$email = $row['email'];
			//$username = $row['username'];
			$phoneNo = $row['phoneNo'];
		}else{
			header("Location: index.php?no-user!!");
			exit();
		}	
	}
	
	$status_msg = "";
	$input_valid_flag = false;
	
	// validate the field
	if (isset($_POST['update-submit'])){
		if (!empty($_POST['username']) && !empty($_POST['phoneNo']) && !empty($_POST['cpwd']) && !empty($_POST['npwd']) && !empty($_POST['rpwd'])){
			$username = mysqli_escape_string($conn, $_POST['username']);
			$phoneNo = mysqli_escape_string($conn, $_POST['phoneNo']);
			$currentPwd = mysqli_escape_string($conn, $_POST['cpwd']);
			$newPwd = mysqli_escape_string($conn, $_POST['npwd']);
			$repeatPwd = mysqli_escape_string($conn, $_POST['rpwd']);
			
			// validate if new pwd is the same with rpwd
			if ($newPwd == $repeatPwd){
				$input_valid_flag = true;
			}else{
				echo '<script type="text/javascript">
						alert("New Password and Repeat Password does not match. Please try again.");
					</script>';
			}
		}else{
			echo '<script type="text/javascript">
						alert("Incomplete form. Please fill in all field.");
					</script>';
		}
	}
	
	// only run if $input_valid_flag is true
	if ($input_valid_flag){
		$sql = "SELECT * FROM userdb WHERE email=?";
		$stmt = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($stmt, $sql)){
			echo '<script type="text/javascript">
						alert("SQL Error.");
					</script>';
		}else{
			mysqli_stmt_bind_param($stmt, "s", $email);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			if ($row = mysqli_fetch_assoc($result)){
				$pwdchk = password_verify($currentPwd, $row['password']);
				if ($pwdchk == false){
					echo '<script type="text/javascript">
						alert("Wrong Password. Please retype current password.");
					</script>';
				}else{
					mysqli_stmt_bind_param($stmt, "s",$email);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_get_result($stmt);
					$sql_add_record = "UPDATE userdb SET username=?, password=?, phoneNo=? WHERE email=?;";
					$stmt = mysqli_stmt_init($conn);
					if(!mysqli_stmt_prepare($stmt, $sql_add_record)){
						echo '<script type="text/javascript">
						alert("SQL Error.");
					</script>';
					}else{
						$hashed_password = password_hash($newPwd, PASSWORD_DEFAULT);
						mysqli_stmt_bind_param($stmt, "ssss",$username, $hashed_password, $phoneNo, $email);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_close($stmt);
						$_SESSION['username'] = $_POST['username'];
						echo '<script type="text/javascript">
							alert("Account details are successfully updated.");
							window.location.href="index.php";
						</script>';
						exit();
					}
				}
			}
		}
    }
?>

<!-- HTML -->
<?php
	require 'Include/header.php';
?>
<div class="profile-input-field">
	<h3>Account Settings</h3>
	<form id="updateProfile" method="POST">
		<div class="form-group">
			<label>Username</label>
			<input type="text" class="form-control" name="username" value="<?php echo $username?>" />
		</div>
		<div class="form-group">
			<label>E-mail</label>
			<input type="email" class="form-control" name="email" value="<?php echo $email?>" disabled/>
		</div>
		<div class="form-group">
			<label>Phone No</label>
			<input type="text" class="form-control" name="phoneNo" value="<?php echo $phoneNo?>" />
		</div>
		<div class="form-group">
			<label>Current Password</label>
			<input type="password" class="form-control" name="cpwd" placeholder="Enter current password" />
		</div>
		<div class="form-group">
			<label>New password</label>
			<input type="password" class="form-control" name="npwd" placeholder="Enter new password"  />
		</div>
		<div class="form-group">
			<label>Retype New Password</label>
			<input type="password" class="form-control" name="rpwd" placeholder="Retype new password"/>
		</div>
		<button type="submit" name="update-submit" class="btn btn-primary">Update</button>
		<button type="reset" name="update-reset" class="btn btn-primary">Reset</button>
	</form>
</div>
</body>
</html>