<?php
  // start session
  session_start();
  require_once "Include/header.php";
 ?>
 
 <?php
if (isset($_POST['login-btn'])){
	require_once 'Include/dtb.php';
	
	$email = $_POST['email'];
	$password = $_POST['pwd'];
	$type = 1;
	
	$sql = "SELECT * FROM userdb WHERE email=?";
	$stmt = mysqli_stmt_init($conn); // check if we can prepared the statement and connection
	if(!mysqli_stmt_prepare($stmt,$sql)){
		echo 	'<script type="text/javascript">
					alert("SQL Error.");
				</script>';
		exit();
    }else{
		mysqli_stmt_bind_param($stmt, "s", $email);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		if($row = mysqli_fetch_assoc($result)){
			$pwsCheck = password_verify($password, $row['password']);
			// verify password
			if ($pwsCheck == false){
				echo '<script type="text/javascript">
						alert("Wrong Password. Please try again.");
					</script>';
			}else if ($pwsCheck == true){
				// store value in session
				$_SESSION['uid'] = $row['userID'];
				$_SESSION['type'] = $row['type'];
				$_SESSION['username'] = $row['username'];
				$_SESSION['phoneno'] = $row['phoneNo'];
				$_SESSION['email'] = $row['email'];
				//$_SESSION['totalPurchased'] = $row['totalPurchased'];
				//$_SESSION['membership'] = $row['membershipRank'];
				echo ("<script LANGUAGE='JavaScript'>
						window.alert('Login Successful!');
						window.location.href='index.php';
						</script>");
				exit();
			}else{
				echo '<script type="text/javascript">
						alert("Wrong Password. Please try again.");
					</script>';
			}
		
		}else{
			echo '<script type="text/javascript">
						alert("No such user.");
					</script>';
		}
	}
}
?>
<section id="content">
<!-- HTML CODE -->
<div  class="login-input-field">
	<h3>Login</h3>
	<form id="login" method="POST">
		<div class="form-group">
			<label> Email </label>
			<label class="required">*</label>
			<input type="text" class = "form-control" name="email" placeholder="Email" required />
		</div>
		<div class="form-group">
			<label> Password </label>
			<label class="required">*</label>
			<input type="password" class = "form-control" name="pwd" placeholder="Password" required />
		</div>
		<button type="submit" name="login-btn">Log in</button>
		<button type="reset" name="login-btn">Reset</button>
	</form>
	<p style="margin: 10px;"><a href="resetpw.php"> Forgot Your password?</a><p>
</div>
</section>
</div>
<?php
if(isset($_GET['newpwd'])){
	if($_GET["newpwd"] == "passwordupdated"){
		echo "<p> Your password has been reset!</p>";
	}
}
 include_once "Include/footer.php"; 
 ?>
