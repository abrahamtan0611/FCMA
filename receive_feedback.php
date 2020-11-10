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
	
	include ("Include/dtb.php");
		$sqlget = "SELECT * FROM feedbackdb";
		$sqldata = mysqli_query($conn, $sqlget) or die("error getting data");
?>

<div class="testing">
<h1>Feedbacks</h1>

<table>
	<tr>
		<th>Name</th>
		<th>Feedbacks</th>
		<th>Reply</th>
	</tr>
	
<?php
	while($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)){
?>
	<tr>
		<td><?php echo $row["customerName"]?></td>
		<td><?php echo $row["feedbackDesc"]?></td>
		<td><a href="mailto: <?php echo $row["customerEmail"]?>">Reply Feedback </a></td>
	</tr>
<?php
	}
?>

</table>
</div>
