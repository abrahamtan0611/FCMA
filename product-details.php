<?php
	// start the session()
	session_start();
	require_once "Include/header.php";
	include_once("Include/dtb.php");
	
	// check for session
	if (!empty($_SESSION['uid'])){
		$userID = $_SESSION['uid'];
	}else{
		echo '<script type="text/javascript">
					alert("Invalid Session!");
					window.location = "index.php";
				</script>';
		exit();
	}
	
	$productID = $_SESSION['productID'];
	
	$sql = "SELECT * FROM productdb WHERE productID = $productID";
	$sqldata = mysqli_query($conn, $sql) or die("error getting data");
	
	while($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)){
?>
<!---- single product details ---->
<div id="content" class="small-container single-product">
<h4><a href="product.php">Back To Menu</a> > <?php echo $row['name']; ?></h4><br>
	<div class="row">
		<div class="col-2">
			<img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image'])?>" width="600px" height="600px"/>
		</div>
		
		<div class="col-2">
		<form action="add-to-cart.php" method="POST">
			<h1><?php echo $row['name']; ?></h1>
			<h4>RM <?php echo $row['price']; ?></h4>
			<p><b>Description:</b></p>
			<p><?php echo $row['description']; ?></p>
			<br>
			<p><b>Availability:</b> <?php echo $row['stock'] ?> set(s) left</p>
			<label>Quantity: </label>
			<input type="number" name="quantity" value="1"><br><br>
			<p><b>Special Instruction:</b></p>
			<textarea id="specDesc" name="specDesc" rows="4" cols="50"></textarea><br>
			<button type="submit" name="addCart" class="btn">Add To Cart</button>
			<!--<a href="" class="btn" name="add-to-cart">Add To Cart &#8594;</a>-->
			<input type="hidden" name="hidden-productID" value="<?php echo $productID?>">
			<input type="hidden" name="hidden-price" value="<?php echo $row['price']?>">
			<?php
				}
			?>
		</form>
		</div>
	</div>
</div>
</div>

<?php
	include_once "Include/footer.php"; 
?>
