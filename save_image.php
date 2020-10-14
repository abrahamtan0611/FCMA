<?php
	include("Include/dtb.php");
	if(isset($_POST['submit_menu']))
	{		
		$title = $_POST['ftitle'];
		$desc = $_POST['fdesc'];
		$price = $_POST['fprice'];
		$quantity = 1;
		
		$image = $_FILES['myfile']['tmp_name'];
		$img = file_get_contents($image);
		$sql = "INSERT INTO inventorydb(image, name, price, quantity, description) VALUES(?,?,?,?,?)";
		
		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, "ssdis",$img, $title, $price, $quantity, $desc);
		mysqli_stmt_execute($stmt);
		
		mysqli_close($conn);
		
		header("location:edit_inventory.php");
	}
?>