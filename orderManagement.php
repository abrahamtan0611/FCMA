<?php
	/*//start session
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
*/
	require 'Include/dtb.php';
/*	$count = 1;
	$tempSum = 0;
	$price = 0;
	$total = 0;

	// display all information based on userID
	$sql = "SELECT * FROM orderdb o INNER JOIN inventorydb i ON o.menuID = i.menuID WHERE o.customerID = ?";
	$stmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt,$sql)){
		echo '<script type="text/javascript">
						alert("SQL Error.");
					</script>';
	}else{
		mysqli_stmt_bind_param($stmt, "s", $custId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
*/		
		require 'Include/header.php';
		//echo "<div class='cart-input-field'>";
/*		
		echo "<h3>My Orders</h3>";
		echo "<form method='POST'>";
		echo "<div class='form-group'>";
		echo "<button type='submit' name='chk-order' class='btn btn-primary'>Order 1</button>";
		echo "<span id='status-msg'>Status: </span><span id='pending'>Pending</span>";
		echo "</div>";
		echo "</form>";
		echo "<table>";
		
		if (isset($_POST['chk-order'])){
			echo "<tr><th>No.</th><th>Product</th><th>Quantity</th><th>Instruction</th><th>Price(RM)</th></tr>";
			while($row = mysqli_fetch_assoc($result)){	
			echo "<tr><td>";
			echo $count. ".";
			echo "</td><td>";
			echo $row['name'];
			echo "</td><td>";
			echo $row['quantity'];
			echo "</td><td class='instruction'>";
			if ($row['instruction'] == ""){
				echo "-";
			}else{
				echo $row['instruction'];
			}	
			echo "</td><td>";
			echo number_format($row['price'],2,'.',',');
			$tempSum = $row['price']*$row['quantity'];
			$total += $tempSum;
			echo "</td></tr>";
			$count++;
		}
		echo "<tr><td></td><td></td><td></td><td id='total-styling'>Total:</td><td id='price-styling'>RM".number_format($total,2,'.',',')."</td></tr>";
		echo "</table>";
		}
	}
*/
	// display all information based on userID
	$sql = "SELECT * FROM orderdb order by orderDate, time ASC";
	$sqldata = mysqli_query($conn, $sql) or die("error getting data");
	?>
	<table><tr>
		<th>orderID</th>
		<th>customerID</th>
		<th>menuID</th>
		<th>quantity</th>
		<th>time</th>
		<th>orderDate</th>
		<th>address</th>
		<th>Instruction</th>
		<th>Price(RM)</th>
		<th>Order Status</th>
		<th></th>
		<th></th></tr>
	<?php	
	while($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)){
		$sql2 = "SELECT price FROM inventorydb where menuID=".$row['menuID'];
		$sqlpricedata = mysqli_query($conn, $sql2) or die("error getting data");
		$price=mysqli_fetch_array($sqlpricedata, MYSQLI_ASSOC)
		?>
			<tr><td><?php echo $row['orderID']; ?></td>
			<td><?php echo $row['customerID']; ?></td>
			<td><?php echo $row['menuID']; ?></td>
			<td><?php echo $row['quantity']; ?></td>
			<td><?php echo $row['time']; ?></td>
			<td><?php echo $row['orderDate']; ?></td>
			<td><?php echo $row['address']; ?></td>
			<td><?php echo $row['instruction']; ?></td>
			<td><?php echo $price['price']*$row['quantity'] ?></td>
			<td>Order Status here</td>
			<td><button id="Edit<?php echo $row['orderID'] ?>" onclick="editOrder(this.id)">Edit</button></td>
			<td><button id="<?php echo $row['orderID'] ?>" onclick="deleteData(this.id)">Delete</button></td>
			</tr>
	
	
	
<?php
	}
	echo "</table>";
	
/*
<td id=\"edit<?php echo". $row['orderID']." ?>\" onclick=\"editOrder(this.id)>Edit</td>
<td id=\"delete<?php echo". $row['orderID']." ?>\" onclick=\"deleteOrder(this.id)> Delete</td>
*/
	
	
/*	$stmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt,$sql)){
		echo '<script type="text/javascript">
						alert("SQL Error.");
					</script>';
	}else{		
		$sqldata = mysqli_query($conn, $sql) or die("error getting data");
		echo "<tr><th>No.</th>
			<th>orderID</th>
			<th>customerID</th>
			<th>menuID</th>
			<th>quantity</th>
			<th>time</th>
			<th>orderDate</th>
			<th>address</th>
			<th>Instruction</th>
			<th>Price(RM)</th></tr>";
	
	}
		
orderID
customerID
menuID
quantity
time 
orderDate
	
	*/
?>
</div>

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	