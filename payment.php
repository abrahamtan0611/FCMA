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
	
	if (isset($_POST['payment-submit'])){
		echo '<script type="text/javascript">
						alert("Thank you for your purchase. A receipt will be sent to your email shortly.");
					</script>';
		require_once 'invoice.php';
		require_once 'mail.php';
		}

	// variables
	require_once 'Include/dtb.php';
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
		mysqli_stmt_bind_param($stmt, 's', $custId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		
		require 'Include/header.php';
		echo '<div class="cart-page">';
		echo '<h3 class="cart-h3">Summary</h3>';
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

	<form id="payment-form" method="POST">		
		<div class="form-group">
			<label>Please select a payment method</label>
			<label class="required">*</label>
			<p id="btns">
				<button type="button" id="onlineBankingBtn" onclick="displayOnlineBanking()">Online Banking</button>
				<button type="button" id="qrCodeBtn" onclick="displayQrCode()">QR Code</button>
				<button type="button" id="onDeliveryBtn" onclick="displayOnDelivery()">Cash on delivery</button>
			</p>
			<div id="onlineBanking">
				<div id="bankDetails">
					<p>Account Name: FoodEdge Food Catering<br/>
						Bank Name: RHB Bank Berhad<br/>
						Account Number: 1-63567-90338231
					</p>
					<p><b>Please email proof/receipt of payment to <a href="mailto:foodedgegourmetcatering@gmail.com">FEGC</a>.</b></p>
				</div>	
			</div>
			<div id="qrCode">
				<!--qr code here-->
				<p><b>Wechat/ Sarawak Pay/ Boost</b></p>
				<img src="Images/qrcode.png" alt="QR CODE" width="100px" height="100px">
				<p><b>Please email proof/receipt of payment to <a href="mailto:foodedgegourmetcatering@gmail.com">FEGC</a>.</b></p>
				
			</div>
			<div id="onDelivery">
				<!--cash on delivery code here-->
				<h1>Selected: Cash on delivery</h1>
			</div>
		</div>	
		<div class="form-group">
			<button type="submit" name="payment-submit" class="btn btn-primary">Place Order</button>
			<button type="reset" name="reset-submit" class="btn btn-primary">Back</button>
		</div>
	</form>
	</div>