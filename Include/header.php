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
	<nav>
		<ul class="nav-bar">
			<li class="logo"><a href="index.php">FoodEdge</a></li>
			<li class="item"><a href="product.php">Menu</a></li>
			<li class="item"><a href="#">About Us</a></li>
			<?php 
			if (isset($_SESSION['uid']))
			{
				$username = $_SESSION['username'];
				if (isset($_SESSION['type']))
				{
					echo '<li class="item"><a href="cart.php">Cart</a></li>';
				}
				echo '<li class="item"><a href="accountSetting.php">Settings</a></li>';
				echo '<li class="item"><i class="material-icons">account_circle</i></li>';
				echo '<li class="item username"><a class="username-hover">'.$username.'</a></li>';
				echo '<li class="item button"><a href="Include/logout.php">Logout</a></li>';
			}else{
				echo '<li class="item button"><a href="register.php">Register</a></li>';
				echo '<li class="item button secondary"><a href="login.php">Login</a></li>';
			}
			?>
			<li class="toggle"><span class="bars"></span></li>
		</ul>
	</nav>
