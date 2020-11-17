<?php
	//start session
	session_start();
	
	// check for session
	if (!empty($_SESSION['uid'])){
		$userID = $_SESSION['uid'];
		$rank = $_SESSION['rank'];
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
	
	if (isset($_POST['updateCart-submit'])){
		if (!empty($_POST['time']) && !empty($_POST['date']) && !empty($_POST['address'])){
			$x = $_SESSION['total'];
			$time = mysqli_escape_string($conn, $_POST['time']);
			$date = mysqli_escape_string($conn, $_POST['date']);
			$address = mysqli_escape_string($conn, $_POST['address']);
			
			$sql = "SELECT * FROM orderdb WHERE userID=? and paymentStatus='' and paymentMethod=''";
			$stmt = mysqli_stmt_init($conn);
			if (!mysqli_stmt_prepare($stmt, $sql)){
			echo '<script type="text/javascript">
						alert("SQL statement Error.");
					</script>';
			}else{
				mysqli_stmt_bind_param($stmt, "s", $userID);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_get_result($stmt);
				$sql_add_record = "UPDATE orderdb SET deliveryTime=?, deliveryDate=?, address=? , totalAmount=? WHERE userID=? and paymentStatus='' and paymentMethod='';";
				$stmt = mysqli_stmt_init($conn);
				if(!mysqli_stmt_prepare($stmt, $sql_add_record)){
						echo '<script type="text/javascript">
						alert("SQL statement Error.");
					</script>';
					}else{
						mysqli_stmt_bind_param($stmt, "sssdi",$time, $date, $address, $x, $userID);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_close($stmt);
						$_SESSION['address'] = $_POST['address'];
						header('Location: payment.php?cart=success');
					}		
			}
		}else{
			echo '<script type="text/javascript">
					alert("Please fill in all required field.");
				</script>';
		}
	}
	
	// display cart information
	$sql = 'SELECT *
			FROM orderdb
			JOIN orderdetailsdb
			ON orderdb.orderID = orderdetailsdb.orderID
			JOIN productdb
			ON productdb.productID = orderdetailsdb.productID
			WHERE (orderdb.userID = ? AND orderdb.paymentStatus="" AND orderdb.paymentMethod="");';
	$stmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt,$sql)){
		echo '<script type="text/javascript">
				alert("SQL Error.");
			</script>';
	}else{
		mysqli_stmt_bind_param($stmt, 's', $userID);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		require 'Include/header.php';
		echo '<section id="content">';
		echo '<div class="cart-page">';
		echo '<h3 class="cart-h3">My Cart</h3>';
		echo '<table class="cart-table">';
		echo '<tr><th>No</th><th>Product</th><th>Special Instruction</th><th class="quantity">Quantity</th><th>Subtotal (RM)</th></tr>';
		$total = 0;
		while($row = mysqli_fetch_assoc($result)){
			echo '<tr><td>'.$count.'.</td>';
			echo '<td><div class="cart-info">';
			echo '<img src="data:image/jpg;charset=utf8;base64,';
			echo base64_encode($row['image']);
			echo '"/> ';
			echo '<div><p>'.$row['name'].'</p>';
			echo '<small>Price:RM'.number_format($row['price'],2,'.',',').'</small>';
			echo '<br>';
			echo '<button type="button" id='.$row['productID'] .' name="delete-order-btn"'.$row['orderID'].'" onclick="deleteCartData(this.id)">Remove</button>';
			echo '</div></div></td class="instruction">';
			if ($row['special_description'] == ''){
				echo '<td>-</td>';
			}else{
				echo '<td >'.$row['special_description'].'</td>';
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
		$_SESSION['subtotal'] = $total;
		echo 'RM '.number_format($total,2,'.',',');
		$_SESSION['total'] = $total;
		echo '</td></tr><tr><td class="total-style">Discount:</td><td>';
		$dis = $rank/10;
		$disAmount = $total * $dis;
		$_SESSION['disAmount'] = $disAmount;
		echo '-'.$rank*10 .'% (RM' .$disAmount . ')';
		echo '</td></tr><tr><td class="total-style">Total:</td><td>';
		$final = $total - $disAmount;
		$_SESSION['total'] = $final;
		echo 'RM' .number_format($final,2,'.',',');
		echo '</td></tr></table></div>';
	}
?>

<!-- CART FORM -->
<form id="cart-form" method="POST">		
	<div class="form-group">
		<label>Delivery Time (8am - 5pm)</label>
		<label class="required">*</label>
		<input type="time" class="form-control" name="time" min="08:00:00" max="17:00:00" placeholder="Select your delivery time..." />
	</div>
	<div class="form-group">
		<label for="shootdate">Delivery Date</label>
		<label class="required">*</label>
		<input type="date" class="form-control" name="date" id="shootdate" placeholder="Select your delivery date..."/>
	</div>
	<div class="form-group" style="border-bottom: 1px solid black; padding: 10px 0;">
		<label>Delivery Address</label>
		<label class="required">*</label>
		<textarea id="textarea-address" rows="4" name="address" placeholder="Delivery Address..."></textarea>
	</div>
	<div class="form-group">
		<button type="submit" name="updateCart-submit" class="btn btn-primary">Proceed to Checkout</button>
		<button type="reset" name="reset-submit" class="btn btn-primary">Reset</button>
	</div>
</form>
</section>
</div>
<?php
	include_once "Include/footer.php"; 
?>

