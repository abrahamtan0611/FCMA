<?php
	// start the session()
	session_start();
	if (!empty($_SESSION['uid'])){
		$custId = $_SESSION['uid'];
	}else{
		echo '<script type="text/javascript">
					alert("Invalid Session!");
					window.location = "index.php";
				</script>';
		exit();
	}
	
	require "Include/header.php";
	
	include("Include/dtb.php");

	if (isset ($_POST['fbDesc'])){
			$get_email = mysqli_escape_string($conn, $_POST['email']);
			$get_feedback = mysqli_escape_string($conn, $_POST['fbDesc']);
			
			$sql_ins = $conn -> prepare ("INSERT INTO feedbackdb (customerID,feedbackDesc, customerEmail) VALUES(?, ?, ?)");
			$sql_ins->bind_param("iss", $custId, $get_feedback, $get_email);
            $sql_ins->execute();
			mysqli_close($conn);
	}else{
		echo 'error';
	}
?>

<div id="testing">
<h1>Give Us Your Feedback</h1>
<h2>What Did You Think?</h2>
<form name="feedback" action="feedback.php" method="POST">
<label for="email">Your Email: </label><br>
<input type="text" id="email" name="email"><br>
<br>
<label for="fbDesc">Feedback to us: </label><br>
<textarea id="fbDesc" name="fbDesc" rows="4" cols="150"></textarea><br>
<br>
<input type="submit" value="Send">
</form>
</div>
