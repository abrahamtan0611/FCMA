<?php
	 //start session
	 session_start();
	 require_once 'Include/dtb.php';
	
	// check for session
	if (!empty($_SESSION['uid'])){
		$userID = $_SESSION['uid'];
		$subtotal = $_SESSION['subtotal'];
		$dis = $_SESSION['disAmount'];
		$final = $_SESSION['total'];
	}else{
		echo '<script type="text/javascript">
					alert("Invalid Session!");
					window.location = "index.php";
				</script>';
		exit();
	}
	
	$status = "pending";
	
	if (isset($_POST['payment-submit'])){
		if (!empty($_POST['payment'])){
			$payment = $_POST['payment'];
			
			$sql = 'SELECT * FROM orderdb WHERE (userID=? AND paymentStatus="" AND paymentMethod="")';
			$stmt = mysqli_stmt_init($conn);
			
			if (!mysqli_stmt_prepare($stmt, $sql)){
			echo '<script type="text/javascript">
						alert("SQL statement Error.");
					</script>';
			}else{
				mysqli_stmt_bind_param($stmt, "s", $userID);
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);
				$row = mysqli_fetch_assoc($result);
				$orderID = $row['orderID'];
				$_SESSION['orderID'] = $row['orderID'];
				
				$totalInitPrice = 0;
				$sql_update_init = "SELECT * FROM orderdetailsdb JOIN productdb ON orderdetailsdb.productID = productdb.productID WHERE orderdetailsdb.orderID = ?";
				$stmt = mysqli_stmt_init($conn);
				if (!mysqli_stmt_prepare($stmt, $sql_update_init)){
				echo '<script type="text/javascript">
							alert("SQL statement Error.");
						</script>';
				}else{
					mysqli_stmt_bind_param($stmt, "s", $orderID);
					mysqli_stmt_execute($stmt);
					$result = mysqli_stmt_get_result($stmt);
					while($row = mysqli_fetch_assoc($result)){
						$totalInitPrice += $row['initialPrice'];
					}
				}
				$sql_add_record = "UPDATE orderdb SET totalOriPrice=?,paymentStatus=?, paymentMethod=? WHERE orderID=?;";
				$stmt = mysqli_stmt_init($conn);
				if(!mysqli_stmt_prepare($stmt, $sql_add_record)){
						echo '<script type="text/javascript">
						alert("SQL statement Error.");
					</script>';
					}else{
						mysqli_stmt_bind_param($stmt, "isss",$totalInitPrice,$status,$payment, $orderID);
						mysqli_stmt_execute($stmt);

						mysqli_stmt_close($stmt);
						require_once 'invoice.php';
						require_once 'mail.php';
						
						echo ("<script LANGUAGE='JavaScript'>
							window.alert('Thank you for your purchased! Your order will be process shortly!');
							window.location.href='index.php';
                        </script>");
					}		
			}
		}else{
			echo '<script type="text/javascript">
					alert("Please select a payment method.");
				</script>';
		}	
}

	// variables
	require_once 'Include/dtb.php';
	$count = 1;
	$tempSum = 0;
	$price = 0;
	$total = 0;

	// display all information based on userID
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
				alert("SQL statement error.");
			</script>';
	}else{
		mysqli_stmt_bind_param($stmt, 's', $userID);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		
		require 'Include/header.php';
		echo '<section id="content">';
		echo '<div class="cart-page">';
		echo '<h3 class="cart-h3">Order Summary</h3>';
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
		echo 'RM '.number_format($subtotal,2,'.',',');
		echo '</td></tr><tr><td class="total-style">Discount:</td><td>';
		echo '-'.$rank*10 .'% (RM' .$dis . ')';
		echo '</td></tr><tr><td class="total-style">Total:</td><td>';
		echo 'RM' .number_format($final,2,'.',',');
		echo '</td></tr></table></div>';
	}
?>

	<form id="payment-form" method="POST">		
		<div class="form-group">
			<label>Please select a payment method</label>
			<label class="required">*</label>
			<p id="btns">
				<input type="radio" id="onlineBankingBtn" name="payment" value="online_banking" onclick="displayOnlineBanking()"><label>Online Banking</label>
				<input type="radio" name="payment" value="qrcode" id="qrCodeBtn" onclick="displayQrCode()"><label>Qr Code</label>
				<input type="radio" name="payment" value="cash_on_delivery" id="cash-on-delivery" onclick="displayOnDelivery()"><label>Cash on delivery</label>
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
				<img src="Images/qrcode.png" alt="QR CODE" width="100px" height="100px">
				<p><b>Qr code is valid for Wechat/ Sarawak Pay/ Boost</b></p>
				<p><b>Please email proof/receipt of payment to <a href="mailto:foodedgegourmetcatering@gmail.com">FEGC</a>.</b></p>
				
			</div>
		</div>	
		<div class="form-group" style="border-top: 1px solid black; padding: 10px 0;">
			<button type="submit" name="payment-submit" class="btn btn-primary">Place Order</button>
			<button type="button" name="reset-submit" style="background-color:red; border:0;" class="btn btn-primary" onclick="location.href='cart.php'">Back</button>
		</div>
</form>
</section>
</div>
<?php
include_once "Include/footer.php"; 
?>
	