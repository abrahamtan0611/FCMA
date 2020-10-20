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
		echo 'alert("SQL error!)';
		exit();
    }else{
		mysqli_stmt_bind_param($stmt, "s", $username);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		if($row = mysqli_fetch_assoc($result)){
			$pwsCheck = password_verify($password, $row['password']);
			// verify password
			if ($pwsCheck == false){
				header("Location: login.php?error=wrgpassword");
				exit();
			}else if ($pwsCheck == true){
				session_start(); // start session
				// store value in session
				$_SESSION['uid'] = $row['customerID'];
				$_SESSION['username'] = $row['username'];
				
				header("Location: index.php?login=success");
				exit();
			}else{
				header("Location: login.php?error=wrgpassword");
				exit();
			}
		
		}else{
			header("Location: ../login.php?error=no-user");
			exit();
		}
	}
}
?>
<!-- HTML CODE -->
<div class="container">
    <form id="login" method="POST">
        <div class="form-header">
            <h3>Login</h3>
            <!--<p>Please fill in the follwoing details</p> -->
        </div>
        <div class="form-line"></div>
        <div class="inputs">
            <input type="text" name="username" placeholder="Username" required />
            <input type="password" name="pwd" placeholder="Password" required />

            <button type="submit" name="login-btn">LOGIN</button>
            <!-- <a id="register-submit">SIGN UP</a> -->
        </div>
    </form>
</div>
