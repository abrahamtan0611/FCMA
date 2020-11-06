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

	//validate name
    $name_message = '';
    $name_valid = false;
    $name = 'False';
    if(isset($_POST['name'])){
        
        $get_name = $_POST['name'];
        
        if (preg_match('/^[ a-z]*$/i', $get_name)){
            $name_valid = true;
            $name_message ="";
        }else{
			$name_message = '<h3 style="color: white">Invalid Name!</h3>';
		}
	}       
                    
	//check email format
    $emailErr = '';
    $email_valid = false;
    if(isset($_POST['cusEmail'])){
        $email = $_POST['cusEmail'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = '<h3 style="color: white">Invalid email</h3>'; 
        }else{
            $email_valid = true;
        }
	}
	
	
	$msg="";
	if (!empty($_POST['name']) && !empty($_POST['cusEmail']) && !empty($_POST['fbDesc'])){
	
		if (($name_valid == true) && ($email_valid == true)){
				$get_name = mysqli_escape_string($conn, $_POST['name']);
				$get_email = mysqli_escape_string($conn, $_POST['cusEmail']);
				$get_feedback = mysqli_escape_string($conn, $_POST['fbDesc']);
					
				$sql_ins = $conn -> prepare ("INSERT INTO feedbackdb (customerID,customerEmail,feedbackDesc, customerName) VALUES(?, ?, ?, ?)");
				$sql_ins->bind_param("isss", $custId, $get_email, $get_feedback, $get_name);
				$sql_ins->execute();
				mysqli_close($conn);
		}
		if ($sql_ins){
			$msg = '<h3 style="color:white">Your feedback has been saved.</h3>';
		}else{
			$msg = '<h3 style="color: white">Failed to send feedback!</h3>';
		}
	}
?>

<div class="testing">
<h1>Give Us Your Feedback</h1>
<h2>What Did You Think?</h2>
<form name="feedback" action="feedback.php" method="POST">
<label for="name">Your Name: </label><br>
<input type="text" id="name" name="name"><br>

<?php
	echo "<p>$name_message</p>";   
?>

<br>
<label for="cusEmail">Your Email: </label><br>
<input type="text" id="cusEmail" name="cusEmail"><br>

<?php
    echo "<p>$emailErr</p>";    
?>

<br>
<label for="fbDesc">Feedback to us: </label><br>
<textarea id="fbDesc" name="fbDesc" rows="4" cols="150"></textarea><br>

<br>
<input type="submit" value="Send">

<?php 
    echo "<p>$msg</p>";    
?>

</form>
</div>



