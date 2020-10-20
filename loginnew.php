<?php
  // start session
  session_start();
  require "Include/header.php";
 ?>




<?php

	Function connect(){
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "fcms";
	
		// Create connection
		$conn = new mysqli($servername, $username, $password,$dbname);

		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		return $conn;
		}
	$conn = connect();
    



		


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	test_input($_POST["username"],$_POST["pwd"]);
}

function test_input($username,$password) {
	$match = false;
	$id = 0;
	$username = trim($username);
	$password = trim($password);
	$conn = connect();
	$sql = "SELECT * FROM users";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			if($row["username"]==$username || $row["password"]==$password){
				$match = true;
				$id = $row["id"];
				$status = $row["status"];
			}
		}
	} else {
		echo "0 results";
	}
	if($match == true){
		session_start();
		$_SESSION["loggedin"] = true;
		$_SESSION["username"] = $_POST["username"];
		$_SESSION["loginid"] = $id;
		$_SESSION["loginstatus"] = $status;
		if($status == "admin"){
			header("refresh: 2; url=loginnew.php");
		}else{
			header("refresh: 2; url=index.php");
		}
		
	}
}?>


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
