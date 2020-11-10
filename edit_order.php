<?php
	session_start();
	require 'Include/dtb.php';
	require 'Include/header.php';
	$editOrderID=$_SESSION['editOrderID'];
	$editProductID=$_SESSION['editProductID'];
	
	if(isset($_POST['update'])){
		$newQuantity=$_POST['newQuantity'];
		$newTime=$_POST['newTime'];
		$newDate=$_POST['newDate'];
		$newAddress=$_POST['newAddress'];
		$newInstruct=$_POST['newInstruct'];
		$newStatus=$_POST['newStatus'];
		$newMethod=$_POST['newMethod'];
		//$editOrderID=$_SESSION['editOrderID'];
		//$editProductID=$_SESSION['editProductID'];
		
		
		//$sql = "UPDATE orderdetailsdb od JOIN orderdb o ON od.orderId=o.orderID SET od.quantity=$newQuantity, o.deliveryTime=$newTime, o.deliveryDate=$newDate, o.address=$newAddress, od.special_description=$newInstruct, o.paymentStatus=$newStatus, o.paymentMethod=$newMethod where od.orderID=$editOrderID and od.productID=$editProductID";
		
		$sql = "UPDATE orderdetailsdb od JOIN orderdb o ON od.orderId=o.orderID SET quantity='$newQuantity', deliveryTime='$newTime', deliveryDate='$newDate', address='$newAddress', special_description='$newInstruct', paymentStatus='$newStatus', paymentMethod='$newMethod' where od.orderID='$editOrderID' and od.productID='$editProductID'";
		
		mysqli_query($conn, $sql) or die(mysqli_error($conn));
		mysqli_close($conn);
		header('Location: orderManagement.php');
	}
	
	$sql = "SELECT * FROM orderdetailsdb od JOIN orderdb o ON od.orderId=o.orderID where od.orderID=$editOrderID and od.productID=$editProductID order by od.orderID, deliveryDate, deliveryTime ASC";
	$sqldata = mysqli_query($conn, $sql) or die("error getting data");
	
	while($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)){
?>
		<form action="edit_order.php" method="post">
			<p><label for="newMenuId">Menu ID:</label><br/>
			<input type="text" id="newMenuId" name="newMenuId" value="<?php echo $row['productID']; ?>"></p>
			
			<p><label for="newQuantity">Quantity:</label><br/>
			<input type="text" id="newQuantity" name="newQuantity" value="<?php echo $row['quantity']; ?>"></p>
			
			<p><label for="newTime">Time:</label><br/>
			<input type="time" id="newTime" name="newTime" value="<?php echo $row['deliveryTime']; ?>"></p>
			
			<p><label for="newDate">Date:</label><br/>
			<input type="date" id="newDate" name="newDate" value="<?php echo $row['deliveryDate']; ?>"></p>
			
			<p><label for="newAddress">Address:</label><br/>
			<input type="text" id="newAddress" name="newAddress" value="<?php echo $row['address']; ?>"></p>
			
			<p><label for="newInstruct">Instruction:</label><br/>
			<input type="text" id="newInstruct" name="newInstruct" value="<?php echo $row['special_description']; ?>"></p>
			
			<p><label for="newStatus">Payment Status:</label><br/>
			<input type="text" id="newStatus" name="newStatus" value="<?php echo $row['paymentStatus']; ?>"></p>
			
			<p><label for="newMethod">Payment Method:</label><br/>
			<input type="text" id="newMethod" name="newMethod" value="<?php echo $row['paymentMethod']; ?>"></p>
			
			<input type="submit" value="Update Order" name="update">
			<input type="reset" value="Reset">
		</form>
<?php
	}
?>


































