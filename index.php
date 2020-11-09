<?php
	// start the session()
	session_start();
	require_once "Include/header.php";
?>

<?php
	include_once("Include/dtb.php");
	$sqlget = "SELECT * FROM productdb LIMIT 3";
	$sqldata = mysqli_query($conn, $sqlget) or die("error getting data");	
?>
<!-- BANNER -->
<div class="header">
	<div class="container">
		<div class="row">
			<div class="col-2">
				<h1>FoodEdge Gourmet <br>Catering Service</h1>
				<p>FoodEdge Gourmet Catering is the perfect caterer for all your party, wedding, holiday and all kinds of events. We can satisfy all you needs with our experience in catering. We do our best to serve you right!</p>
				<a href="product.php" class="btn">Order Now &#8594;</a>
			</div>
			<div class="col-2">
				<img src="Images/banner.png">
			</div>
		</div>
	</div>
</div>
		
<!-- FEATURE PRODUCT -->
<div class="feature">
	<div class="small-container">
		<h2 class="title">Featured Products</h2>
		<div class="row">
			<?php
				while($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)){
			?>
			<div class="col-3" id="food_col_id<?php echo $row['productID']?>"onclick="menuFunction(this.id)">
				<img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image'])?>" width="100px" height="350px"/>
				<h4><?php echo $row['name'] ?></p>
			</div>
			<?php
				}
			?>
		</div>
	</div>
</div>

<!-- FEEDBACKS -->
<div class="feedbacks">
	<div class="container">
		<h2 class="title"> Customer Feedbacks</h2>
		<div class="row">
			<div class="col-3">
				<p>This is feedback item.hajsdhgajkhdajkdh ajkdhasjkdhaskjdhaskjahdkjhdasgd hasgdhasgdhjasgdahjgahjgah jdghjad gahjdgahjagh jsdgahjdgajhdgajhdgaduhag</p>
				<h3>Name</h3>
			</div>
			<div class="col-3">
				<p>This is feedback item.hajsdhgajkhdaj kdhajkdh asjkdhaskjdha skjahdkjh</p>
				<h3>Name</h3>
			</div>
			<div class="col-3">
				<p>This is feedback item.hajsdhga jkhdajkd hajkdhas jkdha skjdhaskj ahdkjh</p>
				<h3>Name</h3>
			</div>
		</div>
	</div>
</div>
<?php
 include_once "Include/footer.php"; 
 ?>

