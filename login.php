<?php
  // start session
  session_start();
  require "Include/header.php";
 ?>

<?php
if (isset($_POST['login-btn'])){
	require 'Include/dtb.php';
	
	$username = $_POST['username'];
	$password = $_POST['pwd'];
	$type = 1;
	
	$sql = "SELECT * FROM userdb WHERE username=?";
	$stmt = mysqli_stmt_init($conn); // check if we can prepared the statement and connection
	if(!mysqli_stmt_prepare($stmt,$sql)){
		echo '<script type="text/javascript">
						alert("SQL Error.");
					</script>';
		exit();
    }else{
		mysqli_stmt_bind_param($stmt, "s", $username);
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
				session_start(); // start session
				// store value in session
				$_SESSION['uid'] = $row['customerID'];
				$_SESSION['username'] = $row['username'];
				$_SESSION['type'] = $row['type'];
				//$_SESSION['email'] = $row['email'];
				echo '<script type="text/javascript">
						alert("Login successful.");
					</script>';
				header("Location: index.php?login=success");
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
<!-- HTML CODE -->
<div class="login-input-field">
    <h3>Login</h3>
    <form id="login" method="POST">
        <div class="form-group">
            <label> Username </label>
            <label class="required">*</label>
            <input type="text" class="form-control" name="username" placeholder="Username" required />
        </div>
        <div class="form-group">
            <label> Password </label>
            <label class="required">*</label>
            <input type="password" class="form-control" name="pwd" placeholder="Password" required />
        </div>
        <button type="submit" name="login-btn">Log in</button>
        <button type="reset" name="login-btn">Reset</button>
        <br>
        <?php
        if(isset($_GET["newpwd"])){
            if($_GET["newpwd"] == "passwordUpdated"){
                echo '<p class="signupsuccess">Your password has been reset!</p>';
                
            }
            
            
        }
        
       ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="resetpw.php">Forgot your password?</a>
    </form>
</div>
<!--
 <div class="container">
	 <form id="login" method="POST">
		<div class="form-header">
			<h3>Login</h3>
		</div>
		<div class="form-line"></div>
		<div class="inputs">
			<input type="text" name="username" placeholder="Username" required />
			<input type="password" name="pwd" placeholder="Password" required />
			
			<button type="submit" name="login-btn">LOG IN</button>
		</div>
	</form>
</div>
-->
