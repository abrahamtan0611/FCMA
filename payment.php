
<?php
	// start the session()
	session_start();
	require "Include/header.php";
	$total = $_SESSION['total'];
	$count = $_SESSION['count'] -1 ;

	include("Include/dtb.php");
	$sqlget = "SELECT * FROM orderdb";
	$sqldata = mysqli_query($conn, $sqlget) or die("error getting data");
	$sqlgetPrice = "SELECT * FROM inventorydb";
	$sqlPriceData = mysqli_query($conn, $sqlgetPrice) or die("error getting data");
		
	?>
		<div id="title" class="row">
			<h1>Cart Summary</h1>
			<div class="cartSummary">
				<?php
					$orderCount=0;
					$totalPrice=0;
					while($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)){
						if($row['customerID']==$_SESSION['uid']){
							$orderCount++;
							while($menuRow = mysqli_fetch_array($sqlPriceData, MYSQLI_ASSOC)){
								if($row['menuID']==$menuRow['menuID']){
									$totalPrice+=$menuRow['price'];
								}
							}
						}
						
				?>
						
				<?php
					}
					echo "<p>Total number of orders made: <span id='orderCount'>".$count."</span></p>";
					echo "<p>Total price: <span id='priceCount'>".$total."</span></p>";
				?>
			</div><hr/>
		</div>
		<h2 class="main">Please select a payment method: </h2>
		<div id="paymentContainer">
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
				</div>	
			</div>
			<div id="qrCode">
				<!--qr code here-->
				<img src="Images/qrcode.png" alt="QR CODE">
			</div>
			<div id="onDelivery">
				<!--cash on delivery code here-->
				<h1>Delivery test</h1>
			</div>
		</div>
		<div id="footer" class="row">
			<div class="col-md-12">
				<!-- put your footer here -->
				<p>Footer</p>
			</div>
		</div>
	</div>
</body>
</html>