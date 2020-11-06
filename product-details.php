<?php
	// start the session()
	session_start();
	require "Include/header.php";
	
	$productID = $_SESSION['productID'];
?>
<!---- single product details ---->
<div class="small-container single-product">
	<div class="row">
		<div class="col-2">
			<img src="Images/menu1.jpg" width="100%">
		</div>
		
		<div class="col-2">
			<h1><?php echo $productID; ?></h1>
			<h4>$50.00</h4>
			<p>Product descriptionkdjakldjalkdjalksdjalkdjaslk asdahdadhadhada<br>dadahdahdadjas<br>akjdakljdakld<br>dadadasda.</p>
			<label>Quantity: </label>
			<input type="number" value="1"><br>
			<label>Special Instruction:</label>
			<textarea name="special-instruction"></textarea><br>
			<a href="" class="btn">Add to cart</a>
		</div>
	</div>
</div>

<?php
 include_once "Include/footer.php"; 
 ?>
