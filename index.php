<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8"/>
	<meta name="author" content="Pass Task Team"/>
	<meta name="description" content="Home Page"/>
	<meta name="keywords" content="Food Ordering, Catering Service"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- pending to change -->
	<link rel="stylesheet" href="Style/style.css" type="text/css"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>Food Edge</title>
</head>
<body>
	<?php
		include("dtb.php");
		$sqlget = "SELECT * FROM inventorydb LIMIT 8";
		$sqldata = mysqli_query($conn, $sqlget) or die("error getting data");
		
	?>
	<div class="container-fluid">
		<div id="header" class="row">
			<div id="logo" class="col-md-2">
				<p>logo</p>
				<!-- put your logo here -->
			</div>
			<div id="nav" class="col-md-10">
				<p>nav</p>
				<!-- put your nav here -->
			</div>
		</div>
		<div id="title" class="row">
			<div class="col-md-12">
				<h1>Hot Sell!!!</h1>
			</div>
		</div>
		<div id="article" class="row">
			<div id="menu" class="col-md-12">
				<?php
					while($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)){
				?>	
					<div class="food_col">
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