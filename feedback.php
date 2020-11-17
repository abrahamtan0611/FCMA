<?php
	require "Include/header.php";
	
	include("Include/dtb.php");
	
	if (isset($_POST["feedback-btn"])){
		if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['fbDesc'])){
			$get_name = mysqli_escape_string($conn, $_POST['name']);
			$get_email = mysqli_escape_string($conn, $_POST['email']);
			$get_feedback = mysqli_escape_string($conn, $_POST['fbDesc']);
			
			$sql_ins = $conn -> prepare ("INSERT INTO feedbackdb (customerName, customerEmail, replyDescription) VALUES(?, ?, ?)");
				$sql_ins->bind_param("sss", $get_name, $get_email, $get_feedback);
				$sql_ins->execute();
				mysqli_close($conn);
				echo ("<script LANGUAGE='JavaScript'>
						window.alert('Thank you for your feedback. We will get back to you via email.');
						window.location.href='index.php';
						</script>");
		}else{
			echo '<script type="text/javascript">
						alert("Please fill in all required fill.");
					</script>';
		}
	}
?>

<section id="content" class="feedback-page">
<!-- HTML CODE -->
<div  class="login-input-field">
	<h3>Send Feedback</h3>
	<form id="login" method="POST">
		<div class="form-group">
			<label> Your name </label>
			<label class="required">*</label>
			<input type="text" class = "form-control" name="name" placeholder="Your name..." required />
		</div>
		<div class="form-group">
			<label> Email </label>
			<label class="required">*</label>
			<input type="email" class = "form-control" name="email" placeholder="Email..." required />
		</div>
		<div class="form-group">
			<label> Content </label>
			<label class="required">*</label>
			<textarea rows="4" cols="43" name="fbDesc"></textarea>
		</div>
		<button type="submit" name="feedback-btn">Send</button>
		<button type="reset" name="reset-btn">Reset</button>
	</form>
</div>
</section>
</div>
<?php
	include_once "Include/footer.php"; 
?>



