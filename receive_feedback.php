<?php
	// start the session()
	session_start();
	require "Include/header.php";
	
	include ("Include/dtb.php");
		$sqlget = "SELECT * FROM feedbackdb";
		$sqldata = mysqli_query($conn, $sqlget) or die("error getting data");
?>

<section id="content">
<div class="replyFeedback-page">
<h3 class="feedback-h3">Customer's Feedbacks</h3>
<table class="cart-table" border="1">
	<tr>
		<th>No.</th>
		<th style="text-align:center;">Name</th>
		<th style="text-align:center;">Feedback Date</th>
		<th style="text-align:center;">Customer's Reply</th>
		<th>Action</th>
	</tr>
	
<?php
	$count = 1;
	while($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)){
?>
	<tr>
		<td><?php echo $count. "."?></td>
		<td><?php echo $row["customerName"]?></td>
		<td><?php echo $row["feedbackDate"]?></td>
		<td><?php echo $row["replyDescription"]?></td>
		<td><a style="color: #0c71e0; font-weight:bold;" href="mailto: <?php echo $row["customerEmail"]?>">Reply Feedback </a></td>
		<?php $count++; ?>
	</tr>
<?php
	}
?>

</table>
</div>
</section>
</div>
<?php
	include_once "Include/footer.php"; 
?>
