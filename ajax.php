<?php
	if(isset($_POST['id'])){
		include("Include/dtb.php");
		$id = $_POST['id'];
		$sql = "SELECT name From inventorydb where menuID = $id";
		$sqldata = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC);
		$name = $row['name'];
		
		$sql2 = "Delete From inventorydb Where menuID = $id";
		mysqli_query($conn, $sql2);
		
		mysqli_close($conn);
		
		echo "$name has been successfully deleted";
		
	}
	
	if(isset($_POST['title']))
	{
		include("Include/dtb.php");
		$title = $_POST['title'];
		$desc = $_POST['desc'];
		$price = $_POST['price'];
		$id = $_POST['menuid'];
		
		$sql = "UPDATE inventorydb SET name = '$title' , description = '$desc', price = $price WHERE menuID = $id";
		
		mysqli_query($conn, $sql);
		
		mysqli_close($conn);
		
		echo "$title has been successfully updated";
	}
	
	if (isset($_POST['orderid']) && isset($_POST['productid'])) {
		include("Include/dtb.php");
		$orderid = $_POST['orderid'];
		$productid = $_POST['productid'];
		$sql = "SELECT * From orderdetailsdb where orderID=$orderid and productID=$productid";
		$sqldata = mysqli_query($conn, $sql)or die(mysqli_error($conn));
		$row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC);
		$name = $row['orderID'];
		
		$sql2 = "Delete From orderdetailsdb Where orderID=$orderid and productID=$productid";
		mysqli_query($conn, $sql2);

		mysqli_close($conn);

		echo "Order has been successfully deleted";
	}
	
	if (isset($_POST['editorderid']) && isset($_POST['editproductid'])) {
		session_start();
		$_SESSION['editOrderID'] = $_POST['editorderid'];
		$_SESSION['editProductID'] = $_POST['editproductid'];
		
	}
	
	if(isset($_POST['menuID'])){
		session_start();
		$_SESSION['indexMenuID'] = $_POST['menuID'];
	}
	
	
?>























