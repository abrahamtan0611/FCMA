<?php
	session_start();
	require 'Include/dtb.php';
	require 'Include/header.php';
	
	// check for session
	if ($_SESSION['type'] == 1){
		$userID = $_SESSION['uid'];
		$rank = $_SESSION['rank'];
	}else{
		echo '<script type="text/javascript">
					alert("Unauthorised Access!");
					window.location = "index.php";
				</script>';
		exit();
	}
	
	$sql = "SELECT * FROM orderdb WHERE userID = '$userID'";
	$sqldata = mysqli_query($conn, $sql) or die("error getting data");
	?>
	
	<section id="content">
	<div class="replyFeedback-page">
		<h3 class="feedback-h3">My Orders</h3>
		

<?php	
	$count=1;
	while($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)){
		$userid=$row['userID'];
		$orderid=$row['orderID'];
?>
	<table class="cart-table" style="margin-bottom: 30px;">
		<tr>
			<th width="10%">Order No.</th>
			<th width="10%">Delivery Date</th>
			<th width="10%">Delivery Time</th>
			<th width="30%">Delivery Address</th>
			<th width="10%">Total Amount</th>
			<th width="10%">Payment Status</th>
			<th width="10%">Payment Method</th>
			<th>Action</th>
		</tr>
		
		<tr>
			<td><?php echo $count; ?></td>
			<td><?php echo $row['deliveryDate']; ?></td>
			<td><?php echo $row['deliveryTime']; ?></td>
			<td><?php echo $row['address']; ?></td>
			<td><?php echo $row['totalAmount']; ?></td>
			<td><?php echo $row['paymentStatus']; ?></td>
			<td><?php echo $row['paymentMethod']; ?></td>
			<td><button class="btn btn-info upload_btn" id="Show:<?php echo $row['orderID']; ?>" onclick="showDetails(this.id)">Show More</button></td>
		</tr>
		<tr>
		<table class="cart-table" id="<?php echo $row['orderID']; ?>" style="display: none; margin-top: -30px; margin-bottom: 30px;">
			<tr>
				<th>Menu name</th>
				<th>Quantity</th>
				<th>SubTotal</th>
				<th>Special Description</th>
			</tr>
		
<?php
			$sql3="SELECT * FROM orderdetailsdb JOIN productdb ON orderdetailsdb.productID = productdb.productID where orderdetailsdb.orderID='$orderid'";
			$sqlProduct=mysqli_query($conn, $sql3)or die("error here");
			while($row3 = mysqli_fetch_array($sqlProduct, MYSQLI_ASSOC)){
?>	
			<tr>
				<td><?php echo $row3['name']; ?></td>
				<td><?php echo $row3['quantity']; ?></td>
				<td><?php echo $row3['subtotal']; ?></td>
				<td><?php echo $row3['special_description']; ?></td>
			</tr>
<?php
			}
?>
		</table>
		</tr>
<?php
	$count++;
}					
?>
		</table>
	</div>
	</section>
	</div>
<?php
include_once "Include/footer.php"; 
?>







	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	