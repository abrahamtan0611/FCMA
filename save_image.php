<?php
	include("Include/dtb.php");
	if(isset($_POST['submit_menu']))
	{		
		$title = $_POST['ftitle'];
		$desc = $_POST['fdesc'];
		$price = $_POST['fprice'];
		$stock = $_POST['stock'];
		$iprice = $_POST['iprice'];
		
		$image = $_FILES['myfile']['tmp_name'];
		$img = file_get_contents($image);
		$sql = "INSERT INTO productdb(image, name, price, initialPrice, stock, description) VALUES(?,?,?,?,?,?)";
		
		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, "ssdis",$img, $title, $price, ,$iprice, $stock, $desc);
		mysqli_stmt_execute($stmt);
		
		mysqli_close($conn);
		
		header("location:edit_inventory.php");
	}
?>