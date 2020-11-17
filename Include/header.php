<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8"/>
	<meta name="author" content="Pass Task Team"/>
	<meta name="description" content="Home Page"/>
	<meta name="keywords" content="Food Ordering, Catering Service"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="Style/style.css"/>
	<script type="text/javascript" src="javascript.js"></script>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<title>Food Edge</title>
	<script>
		$(function(){
			$(".toggle").on("click", function(){
				if ($(".item").hasClass("active")){
					$(".item").removeClass("active");
				}else{
					$(".item").addClass("active");
				}
			})
		});
		
		$(function(){
			var dtToday = new Date();
    
			var month = dtToday.getMonth() + 1;
			var day = dtToday.getDate();
			var year = dtToday.getFullYear();
			if(month < 10)
				month = '0' + month.toString();
			if(day < 10)
				day = '0' + day.toString();
			
			var maxDate = year + '-' + month + '-' + day;
			$('#shootdate').attr('min', maxDate);
});
	</script>
</head>
<body>
	<nav id="header_c">
		<ul class="nav-bar">
			<li class="logo"><a href="index.php">FoodEdge</a></li>
			<?php
			include_once("Include/dtb.php");
			if (isset($_SESSION['uid'])){
				$type = $_SESSION['type'];
				if ($_SESSION['type'] == 1){
					echo '<li class="item"><a href="product.php">Menu</a></li>';
				}else if($type == 2){
					echo '<li class="item"><a href="edit_inventory.php">Edit Menu</a></li>';
					echo '<li class="item"><a href="orderManagement.php">View Client Order</a></li>';
					echo '<li class="item"><a href="receive_feedback.php">Reply Feedback</a></li>';
				}else if ($type == 3){
					echo '<li class="item"><a href="chart.php">View Profit/Sales</a></li>';
				}
			}	
			?>
			<?php 
			if (isset($_SESSION['uid']))
			{
				include("membership.php");
				$tierList = array("Unranked", "Bronze", "Silver", "Gold", "Platinum", "Diamond");
				$index = $_SESSION['rank'];
				$membershipRank = $tierList[$index];
				$username = $_SESSION['username'];
				
				if (isset($type))
				{
					if ($type == 1){
						echo '<li class="item"><a href="cart.php">Cart</a></li>';
						echo '<li class="item"><a href="status.php">My Orders</a></li>';
					}
				}
				echo '<li class="item"><i class="material-icons">account_circle</i></li>';
				echo '<li class="item"><a href="accountSetting.php"><span id="rank">'.$membershipRank."</span> | ".$username.'</a></li>';
				echo '<li class="item button"><a href="Include/logout.php">Logout</a></li>';
			}else{
				echo '<li class="item button"><a href="register.php">Register</a></li>';
				echo '<li class="item button secondary"><a href="login.php">Login</a></li>';
			}
			?>
			<li class="toggle"><span class="bars"></span></li>
			<script>
				var rankColor = document.getElementById("rank");
				var data = <?php echo json_encode($membershipRank, JSON_HEX_TAG); ?>;
				if(data == "Unranked")
				{
					rankColor.style.opacity = "0.4";
				}
				else if(data == "Bronze")
				{
					rankColor.style.color = "#8B4513";
				}else if(data == "Silver")
				{
					rankColor.style.color = "#DCDCDC";
					rankColor.style.opacity = "0.8";
				}else if(data == "Gold")
				{
					rankColor.style.color = "#DAA520";
				}else if(data == "Platinum")
				{
					rankColor.style.color = "#40E0D0";
				}else if(data == "Diamond")
				{
					rankColor.style.color = "#4169E1";
				}
			</script>
		</ul>
	</nav>
