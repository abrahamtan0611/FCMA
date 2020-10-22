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
		echo "<h3>Cart</h3>";
		echo "<table>";
		echo "<tr><th>No.</th><th>Product</th><th>Quantity</th><th>Instruction</th><th>Price(RM)</th><th></th></tr>";
		
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
			echo "</td><td>";
			echo "<button type='button' name='delete-order-btn'".$row['orderID']."' onclick='deleteData(this.id)'>Delete</button>";
			echo "</td></tr>";
			$count++;
		}
		echo "<tr><td></td><td></td><td></td><td id='total-styling'>Total:</td><td id='price-styling'>RM".number_format($total,2,'.',',')."</td></tr>";
		echo "</table>";
	}

	if (isset($_POST['updateCart-submit'])){
		if (!empty($_POST['time']) && !empty($_POST['date']) && !empty($_POST['address'])){
			$time = mysqli_escape_string($conn, $_POST['time']);
			$date = mysqli_escape_string($conn, $_POST['date']);
			$address = mysqli_escape_string($conn, $_POST['address']);
			
			$sql = "SELECT * FROM orderdb WHERE customerID=?";
			$stmt = mysqli_stmt_init($conn);
			if (!mysqli_stmt_prepare($stmt, $sql)){
			echo '<script type="text/javascript">
						alert("SQL Error.");
					</script>';
			}else{
				mysqli_stmt_bind_param($stmt, "s", $custId);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_get_result($stmt);
				$sql_add_record = "UPDATE orderdb SET time=?, orderDate=?, address=? WHERE customerID=?;";
				$stmt = mysqli_stmt_init($conn);
				if(!mysqli_stmt_prepare($stmt, $sql_add_record)){
						echo '<script type="text/javascript">
						alert("SQL Error.");
					</script>';
					}else{
						mysqli_stmt_bind_param($stmt, "ssss",$time, $date, $address, $custId);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_close($stmt);
						header("Location: status.php");
						$_SESSION['total'] = $total;
						$_SESSION['count'] = $count;
					}
			
			}
		}else{
			echo '<script type="text/javascript">
						alert("Please fill in all field.");
					</script>';
		}
		
	}
?>

	<form id="updateProfile" method="POST">		
		<div class="form-group">
			<label>Time</label>
			<input type="time" class="form-control" name="time" placeholder="Time" />
		</div>
		<div class="form-group">
			<label>Date</label>
			<input type="date" class="form-control" name="date" placeholder="Date"/>
		</div>
		<div class="form-group">
			<label>Address</label><br>
			<textarea id="textarea-address" rows="4" name="address" placeholder="Address..."></textarea>
		</div>
		<div class="form-group">
			<label>Payment Method</label>
			<p id="btns">
				<button type="button" id="onlineBankingBtn" onclick="displayOnlineBanking()">Online Banking</button>
				<button type="button" id="qrCodeBtn" onclick="displayQrCode()">QR Code</button>
				<button type="button" id="onDeliveryBtn" onclick="displayOnDelivery()">Cash on delivery</button>
			</p>
			<div id="onlineBanking">
				<div id="bankDetails">
					<p>Account Name: FoodEdge Food Catering<br/>
						Bank Name: RHB Bank Berhad<br/>
						Account Number: 1-23456-78901234
					</p>
					<p><b>Please email proof/receipt of payment to <a href="mailto:fcms@gmail.com">FCMS</a>.</b></p>
				</div>	
			</div>
			<div id="qrCode">
				<!--qr code here-->
				<p><b>Wechat/ Sarawak Pay/ Boost</b></p>
				<p><b>Please email proof/receipt of payment to <a href="mailto:fcms@gmail.com">FCMS</a>.</b></p>
				<img src="Images/qrcode.png" alt="QR CODE" width="100px" height="100px">
				
			</div>
			<div id="onDelivery">
				<!--cash on delivery code here-->
				<h1>Selected: Cash on delivery</h1>
			</div>
		</div>
		<div class="form-group">
			<button type="submit" name="updateCart-submit" class="btn btn-primary">Confirm</button>
			<button type="reset" name="reset-submit" class="btn btn-primary">Reset</button>
		</div>
	</form>
</div>

		