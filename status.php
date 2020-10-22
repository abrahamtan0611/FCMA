<?php
	 //start session
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

	require 'Include/dtb.php';
	$count = 1;
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
		
		require 'Include/header.php';
		echo "<div class='cart-input-field'>";
		
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
?>
</div>

		