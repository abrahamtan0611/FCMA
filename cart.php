<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="Food Catering System">
	<meta name="keywords" content="HTML, CSS, JavaScript, PHP">
	<title>Cart</title>
	<link rel="stylesheet" href="style.css" type="text/css"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<!--php header here-->

<?php
	include("dtb.php");
	$sqlGet="SELECT * FROM orderdb";
	$sqldata = mysqli_query($conn, $sqlget) or die("error getting data");	
	
	echo"<table>";
	echo"<tr><th>menuID</th></tr>
		<tr><th>quantity</th></tr>
		<tr><th>time</th></tr>
		<tr><th>orderDate</th></tr>
		<tr><th>endDate</th></tr>
		<tr><th>address</th></tr>";
		
	while($row=mysqli_fetch_array($sqldata, MYSQLI_ASSOC)){
		echo"<tr><td>".$row["menuID"]."</tr></td>";
		echo"<tr><td>".$row["quantity"]."</tr></td>";
		echo"<tr><td>".$row["time"]."</tr></td>";
		echo"<tr><td>".$row["orderDate"]."</tr></td>";
		echo"<tr><td>".$row["endDate"]."</tr></td>";
		echo"<tr><td>".$row["address"]."</tr></td>";
	}
	echo"</table>";
?>
<!--php footer here-->
</body>
</html>














