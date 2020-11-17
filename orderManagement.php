<?php
	session_start();
	require 'Include/dtb.php';
	require 'Include/header.php';
	
	// check for session
	if ($_SESSION['type'] == 2){
		$userID = $_SESSION['uid'];
		$rank = $_SESSION['rank'];
	}else{
		echo '<script type="text/javascript">
					alert("Unauthorised Access!");
					window.location = "index.php";
				</script>';
		exit();
	}
	
	$sql = "SELECT * FROM orderdb JOIN userdb ON orderdb.userID = userdb.userID order by deliveryDate ASC";
	$sqldata = mysqli_query($conn, $sql) or die("error getting data");
	?>
	
	<section id="content">
	<div class="replyFeedback-page">
		<h3 class="feedback-h3">Customer's Order</h3>
	
	<?php	
	$count=1;
	while($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)){
		/*$sql2="SELECT * FROM userdb JOIN orderdb ON $row['userID']=orderdb.userID";
		$username = mysqli_query($conn, $sql2);
		$row2 = mysqli_fetch_array($username, MYSQLI_ASSOC);*/
		$userid=$row['userID'];
		$orderid=$row['orderID'];
		?>
		
		<table class="cart-table" style="margin-bottom: 30px;"><tr>
			<th></th>
			<th width="10%">Customer Name</th>
			<th width="10%">Delivery Date</th>
			<th width="10%">Delivery Time</th>
			<th width="15%">Address</th>
			<th width="10%">Total Amount</th>
			<th width="10%">Payment Status</th>
			<th width="10%">Payment Method</th>
			<th> Action</th>
			</tr>
				<tr>
					<td><?php echo $count; ?></td>
					<td><?php echo $row['username']; ?></td>
					<td><?php echo $row['deliveryDate']; ?></td>
					<td><?php echo $row['deliveryTime']; ?></td>
					<td><?php echo $row['address']; ?></td>
					<td><?php echo $row['totalAmount']; ?></td>
					<td><?php echo $row['paymentStatus']; ?></td>
					<td><?php echo $row['paymentMethod']; ?></td>
					<td><button class="btn btn-info upload_btn" id="Edit-<?php echo $row['orderID'] ?>:<?php echo $row['productID'] ?>" onclick="editSortOrder(this.id)">Toggle Status</button><button class="btn btn-info upload_btn" style="background-color: #c72a2a; border: none;" id="<?php echo $row['orderID'] ?>:<?php echo $row['productID'] ?>" onclick="deleteData(this.id)">Delete</button><button class="btn btn-info upload_btn" id="Show:<?php echo $row['orderID']; ?>" onclick="showDetails(this.id)">Show More</button></td>
				</tr>
		</table>
			
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
			
<?php				
		$count++;
	}
?>
</div>
</section>
</div>
<?php
	include_once "Include/footer.php"; 
?>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	