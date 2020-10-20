<link rel="stylesheet" type="text/css" href="Style/style.css">
<script type="text/javascript" src="javascript.js"></script>
<?php
	// start the session()
	session_start();
	$_SESSION['uid'] = 6; 
	require "Include/header.php";
?>
	<?php
		include("Include/dtb.php");
		// $sqlgetmenuID = "SELECT menuID FROM orderdb where customerID = $_SESSION['uid']";
		
		// $sqldata1 = mysqli_query($conn, $sqlgetmenuID) or die("error getting data");
		$sqlcombinetable = "SELECT orderdb.quantity, inventorydb.price, inventorydb.image FROM orderdb, inventorydb WHERE orderdb.menuID = inventorydb.menuID AND orderdb.customerID = 6";
		
		$sqldata = mysqli_query($conn, $sqlcombinetable) or die("error getting data");
		
	?>
		<div id="title" class="row">
			<div class="cartSummary">
				<h1>Cart Summary</h1>
				<?php
					$orderCount=0;
					$totalPrice=0;
					while($row = mysqli_fetch_array($sqldata,MYSQLI_ASSOC)){
						$orderCount++;
						$totalPrice += $row['price'];
						
					// while($row = mysqli_fetch_array($sqlcombinetable, MYSQLI_ASSOC)){
						// if($row['customerID']==$_SESSION['uid']){
							// $orderCount++;
							// while($menuRow = mysqli_fetch_array($sqlgetPrice, MYSQLI_ASSOC)){
								// if($row['menuID']==$menuRow['menuId']){
									// $totalPrice+=$menuRow['price'];
								// }
							// }
						// }
						
				?>
						<div class="summaryRow">
							<p class="totalCount">
								<img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>" width="308px" height="200px"/> 
								<?php 
								echo $row['price'];
								?>
							</p>
						</div>
				<?php
					}
					echo "<p>Total number of orders made: ".$orderCount."</p>";
					echo "<p>Total price: ".$totalPrice."</p>";
				?>
			</div>
		</div>
		<h2 id="test">Please select a payment method: </h2>
		<p>
			<button type="button" id="onlineBankingBtn" onclick="displayOnlineBanking()">Online Banking</button>
			<button type="button" id="qrCodeBtn" onclick="displayQrCode()">E-Wallet</button>
			<button type="button" id="onDeliveryBtn" onclick="displayOnDelivery()">Cash on Delivery</button>
		</p>
		<div id="onlineBanking">
			<div id="bankDetails">
				<p>Account Name: FoodEdge Food Catering<br/>
					Bank Name: RHB Bank Berhad<br/>
					Account Number: 1-23456-78901234
				</p>
			</div>	
			<p>Please select your bank of choise: </p>
			<div id="bankSelection">
				<a href="https://www.ambank.com.my/eng/" target="_blank"><img src="Images/ambank.png" alt="Ambank"></a>
				<a href="https://www.hlb.com.my/en/personal-banking/home.html" target="_blank"><img src="Images/hongleong.jpg" alt="Hong Leong"></a>
				<a href="https://www.maybank2u.com.my/home/m2u/common/login.do" target="_blank"><img src="Images/maybank.png" alt="Maybank"></a>
			</div>
		</div>
		<div id="qrCode">
			<!--qr code here-->
			<h1>QR test</h1>
		</div>
		<div id="onDelivery">
			<!--cash on delivery code here-->
			<h1>Delivery test</h1>
		</div>
		<div id="confirmPayment">
			<button type="button">Confirm Payment</button>
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