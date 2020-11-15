<?php
	session_start();
	require 'Include/dtb.php';
	require 'Include/header.php';
	//$sql = "SELECT * FROM orderdetailsdb od JOIN orderdb o ON od.orderId=o.orderID order by od.orderID, deliveryDate, deliveryTime ASC";
	//$sql = "SELECT * FROM orderdb JOIN orderdetailsdb ON orderdb.orderID = orderdetailsdb.orderID JOIN userdb ON orderdb.userID = userdb.userID JOIN productdb ON orderdetailsdb.productID = productdb.productID order by orderdetailsdb.orderID, deliveryDate, deliveryTime ASC";
	$sql = "SELECT * FROM orderdb JOIN userdb ON orderdb.userID = userdb.userID order by deliveryDate ASC";
	$sqldata = mysqli_query($conn, $sql) or die("error getting data");
	?>
	

	<?php	
	$count=1;
	while($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)){
		/*$sql2="SELECT * FROM userdb JOIN orderdb ON $row['userID']=orderdb.userID";
		$username = mysqli_query($conn, $sql2);
		$row2 = mysqli_fetch_array($username, MYSQLI_ASSOC);*/
		$userid=$row['userID'];
		$orderid=$row['orderID'];
		?>
	<table border="1" width="80%"><tr>
		<th></th>
		<th width="10%">Customer Name</th>
		<th width="10%">Delivery Date</th>
		<th width="10%">Delivery Time</th>
		<th width="30%">Address</th>
		<th width="10%">Total Amount</th>
		<th width="10%">Payment Status</th>
		<th width="10%">Payment Method</th>
		<th></th>
		<th></th>
		<th></th></tr>
			<tr>
				<td><?php echo $count; ?></td>
				<td><?php echo $row['username']; ?></td>
				<td><?php echo $row['deliveryDate']; ?></td>
				<td><?php echo $row['deliveryTime']; ?></td>
				<td><?php echo $row['address']; ?></td>
				<td><?php echo $row['totalAmount']; ?></td>
				<td><?php echo $row['paymentStatus']; ?></td>
				<td><?php echo $row['paymentMethod']; ?></td>
				<td><button id="Edit-<?php echo $row['orderID'] ?>:<?php echo $row['productID'] ?>" onclick="editSortOrder(this.id)">Edit Status</button></td>
				<td><button id="<?php echo $row['orderID'] ?>:<?php echo $row['productID'] ?>" onclick="deleteData(this.id)">Delete</button></td>
				<td><button id="Show:<?php echo $row['orderID']; ?>" onclick="showDetails(this.id)">Show More</button></td>
			</tr>
	</table>
			
				<table class="hiddenTable" id="<?php echo $row['orderID']; ?>" border="1">
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

	
	
	
	
<!--
<div id="orderDetailsContainer">
				<table>
					<!--Menu name, Quantity, SubTotal, Sepcial Description
					<tr>
						<th>Menu name</th>
						<th>Quantity</th>
						<th>SubTotal</th>
						<th>Special Description</th>
					</tr>
					<?
					$sql3 = "SELECT * FROM orderdetailsdb JOIN productdb ON orderdetailsdb.productID = productdb.productID order by orderdetailsdb.orderID";
					$sqldata2 = mysqli_query($conn, $sql3);
					while($row4 = mysqli_fetch_array($sqldata2, MYSQLI_ASSOC)){ ?>
						<tr>
							<td><?php echo $row4['name']; ?></td>
							<td><?php echo $row4['quantity']; ?></td>
							<td><?php echo $row4['subtotal']; ?></td>
							<td><?php echo $row['special_description']; ?></td>
						</tr>
-->	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	