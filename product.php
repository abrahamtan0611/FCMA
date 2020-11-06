<?php
	// start session
	session_start();
	require_once "Include/header.php";
  
	include_once("Include/dtb.php");
	$sqlget = "SELECT * FROM productdb";
	$sqldata = mysqli_query($conn, $sqlget) or die("error getting data");
?>
 
 <!-- FEATURE PRODUCT -->
<div class="feature">
	<div class="small-container">
		<h2 class="title">Products</h2>
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

<?php
 include_once "Include/footer.php"; 
 ?>
