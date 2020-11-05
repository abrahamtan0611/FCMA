<?php
	 //start session
	 session_start();
	
	// check for session
	if (!empty($_SESSION['uid'])){
		$custId = $_SESSION['uid'];
	}else{
		echo '<script type="text/javascript">
					alert("Invalid Session!");
					window.location = "index.php";
				</script>';
		exit();
	}

	// variables
	require_once 'Include/dtb.php';
	$count = 1;
	$tempSum = 0;
	$price = 0;
	$total = 0;
	
	if (isset($_POST['updateCart-submit'])){
		if (!empty($_POST['time']) && !empty($_POST['date']) && !empty($_POST['address'])){
			$time = mysqli_escape_string($conn, $_POST['time']);
			$date = mysqli_escape_string($conn, $_POST['date']);
			$address = mysqli_escape_string($conn, $_POST['address']);
			
			$sql = "SELECT * FROM orderdb WHERE customerID=?";
			$stmt = mysqli_stmt_init($conn);
			if (!mysqli_stmt_prepare($stmt, $sql)){
			echo '<script type="text/javascript">
						alert("SQL statement Error.");
					</script>';
			}else{
				mysqli_stmt_bind_param($stmt, "s", $custId);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_get_result($stmt);
				$sql_add_record = "UPDATE orderdb SET time=?, orderDate=?, address=? WHERE customerID=?;";
				$stmt = mysqli_stmt_init($conn);
				if(!mysqli_stmt_prepare($stmt, $sql_add_record)){
						echo '<script type="text/javascript">
						alert("SQL statement Error.");
					</script>';
					}else{
						mysqli_stmt_bind_param($stmt, "ssss",$time, $date, $address, $custId);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_close($stmt);
						$_SESSION['address'] = $_POST['address'];
						header('Location: payment.php');
					}		
			}
		}else{
			echo '<script type="text/javascript">
					alert("Please fill in all field.");
				</script>';
		}
	}

	// display all information based on userID
	$sql = "SELECT * FROM orderdb o INNER JOIN inventorydb i ON o.menuID = i.menuID WHERE o.customerID = ?";
	$stmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt,$sql)){
		echo '<script type="text/javascript">
						alert("SQL Error.");
					</script>';
	}else{
		mysqli_stmt_bind_param($stmt, 's', $custId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		
		require 'Include/header.php';
		echo '<div class="cart-page">';
		echo '<h3 class="cart-h3">My Cart</h3>';
		echo '<table class="cart-table">';
		echo '<tr><th>No</th><th>Product</th><th>Instruction</th><th class="quantity">Quantity</th><th>Subtotal (RM)</th></tr>';
		
		while($row = mysqli_fetch_assoc($result)){
			echo '<tr><td>'.$count.'.</td>';
			echo '<td><div class="cart-info">';
			echo '<img src="data:image/jpg;charset=utf8;base64,';
			echo base64_encode($row['image']);
			echo '"/> ';
			echo '<div><p>'.$row['name'].'</p>';
			echo '<small>Price:RM'.number_format($row['price'],2,'.',',').'</small>';
			echo '<br>';
			echo '<button type="button" name="delete-order-btn"'.$row['orderID'].'" onclick="deleteData(this.id)">Remove</button>';
			echo '</div></div></td class="instruction">';
			if ($row['instruction'] == ''){
				echo '<td>-</td>';
			}else{
				echo '<td >'.$row['instruction'].'</td>';
			}
			echo '<td class="quantity">'.$row['quantity'].'</td>';
			$price = 0;
			$tempSum = $row['price']*$row['quantity'];
			$total += $tempSum;
			echo '<td>';
			echo number_format($tempSum,2,'.',',');
			echo '</td></tr>';
			$count++;
		}
		echo '</table>';
		echo '<div class="total-table"><table><tr>';
		echo '<td class="total-style">Subtotal:</td><td>';
		echo 'RM '.number_format($total,2,'.',',');
		echo '</td></tr><tr><td class="total-style">Discount:</td><td>';
		echo 'RM -25.00';
		echo '</td></tr><tr><td class="total-style">Total:</td><td>';
		echo 'RM 100.00';
		echo '</td></tr></table></div>';
	}

	
?>

	<form id="cart-form" method="POST">		
		<div class="form-group">
			<label>Delivery Time (8am - 5pm)</label>
			<label class="required">*</label>
			<input type="time" class="form-control" name="time" min="08:00:00" max="17:00:00" placeholder="Select your delivery time..." />
		</div>
		<div class="form-group">
			<label for="shootdate">Delivery Date</label>
			<label class="required">*</label>
			<input type="text" class="form-control" name="date" id="shootdate" placeholder="Select your delivery date..."/>
		</div>
		<div class="form-group">
			<label>Delivery Address</label>
			<label class="required">*</label>
			<textarea id="textarea-address" rows="4" name="address" placeholder="   Delivery Address..."></textarea>
		</div>
		<div class="form-group">
			<button type="submit" name="updateCart-submit" class="btn btn-primary">Proceed to Checkout</button>
			<button type="reset" name="reset-submit" class="btn btn-primary">Reset</button>
		</div>
	</form>
	</div>
</div>
</body>
</html>