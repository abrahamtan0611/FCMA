<?php
	// start the session()
	session_start();
	require "Include/header.php";
?>
<!--
<script>
	
	function menuFunction(e){
		alert("asdasd");
		//var modal2 = document.getElementById("myModal");
		//modal2.style.display = "block";
		var menuID = e.substr(11);
		
		$.ajax({
		type: "POST",
		url:'ajax.php',
		data:{menuID:menuID},
		success:function(html){
			//window.location.replace("order_alt.php");
			alert(menuID);
		}
		});

	}
	
</script>
-->
	<?php
		include("Include/dtb.php");
		$sqlget = "SELECT * FROM inventorydb LIMIT 8";
		$sqldata = mysqli_query($conn, $sqlget) or die("error getting data");
		
	?>
		<div id="title" class="row">
			<div class="col-md-12">
				<h1>Hot Sell!!!
				<?php
					if(isset($_SESSION['type'])){
						if ($_SESSION['type'] == 2){
							echo '<button type="button" class="btn btn-success btn-lg" id="myBtn" onclick="redirect()">Edit</button>';
						}	
					}
				?>
				
				
				
				</h1>
			</div>
		</div>
		<div id="article" class="row">
			<div id="menu" class="col-md-12">
				<?php
					while($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)){
				?>	
					<div class="food_col" id="food_col_id<?php echo $row['menuID']?> "onclick="menuFunction(this.id)">
						<img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>" width="308px" height="200px"/> 
						<p class="food_title"><?php echo $row["name"]?> <span class="rating"><span class="fa fa-star checked"></span>4.4/5(64)</span></p>
						<p class="food_desc"><?php echo $row['description'] ?></p>
						<p class="food_price">RM<?php echo number_format($row['price'],2) ?></p>
					</div>
				<?php
					}
				?>
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


