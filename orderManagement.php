<?php
	session_start();
	require 'Include/dtb.php';
	require 'Include/header.php';
	$sql = "SELECT * FROM orderdetailsdb od JOIN orderdb o ON od.orderId=o.orderID order by od.orderID, deliveryDate, deliveryTime ASC";
	$sqldata = mysqli_query($conn, $sql) or die("error getting data");
	?>
	
	<table><tr>
		<th></th>
		<th>orderID</th>
		<th>productID</th>
		<th>userID</th>
		<th>quantity</th>
		<th>deliveryDate</th>
		<th>deliveryTime</th>
		<th>address</th>
		<th>special_description</th>
		<th>subtotal</th>
		<th>paymentStatus</th>
		<th>paymentMethod</th>
		<th></th>
		<th></th></tr>
	<?php	
	$count=1;
	while($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)){
		?>
			<tr><td><?php echo $count; ?></td>
			<td><?php echo $row['orderID']; ?></td>
			<td><?php echo $row['productID']; ?></td>
			<td><?php echo $row['userID']; ?></td>
			<td><?php echo $row['quantity']; ?></td>
			<td><?php echo $row['deliveryDate']; ?></td>
			<td><?php echo $row['deliveryTime']; ?></td>
			<td><?php echo $row['address']; ?></td>
			<td><?php echo $row['special_description']; ?></td>
			<td><?php echo $row['subtotal']; ?></td>
			<td><?php echo $row['paymentStatus']; ?></td>
			<td><?php echo $row['paymentMethod']; ?></td>
			<td><button id="Edit-<?php echo $row['orderID'] ?>:<?php echo $row['productID'] ?>" onclick="editSortOrder(this.id)">Edit</button></td>
			<td><button id="<?php echo $row['orderID'] ?>:<?php echo $row['productID'] ?>" onclick="deleteData(this.id)">Delete</button></td>
			</tr>
	
	
	
<?php
		$count++;
	}
	echo "</table>";
?>
</div>

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	