<?php
	session_start();
	include("Include/dtb.php");
	
	if(isset($_POST['id'])){
		$id = $_POST['id'];
		$sql = "SELECT name From productdb where productID = $id";
		$sqldata = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC);
		$name = $row['name'];
		
		$sql2 = "Delete From productdb Where productID = $id";
		mysqli_query($conn, $sql2);
		
		mysqli_close($conn);
		
		echo "$name has been successfully deleted";	
	}
	
	if(isset($_POST['title']))
	{
		$title = $_POST['title'];
		$desc = $_POST['desc'];
		$price = $_POST['price'];
		$initialPrice = $_POST['initialPrice'];
		$stock = $_POST['stock'];
		$id = $_POST['menuid'];
		
		$sql = "UPDATE productdb SET name = '$title' , description = '$desc', price = $price, initialPrice = $initialPrice, stock = $stock WHERE productID = $id";
		
		mysqli_query($conn, $sql);
		
		mysqli_close($conn);
	}
	
	if (isset($_POST['orderid'])) {
		$id = $_POST['orderid'];
		$sql = "SELECT * From orderdb where orderID=$id";
		$sqldata = mysqli_query($conn, $sql)or die(mysqli_error($conn));
		$row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC);
		$name = $row['orderID'];

		$sql2 = "Delete From orderdb Where orderID =$id";
		mysqli_query($conn, $sql2);

		mysqli_close($conn);
	}
	
	// order Management
	if (isset($_POST['orderid']) && isset($_POST['productid'])) {
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
	
	// order Management
	if (isset($_POST['editorderid']) && isset($_POST['editproductid'])) {
		$_SESSION['editOrderID'] = $_POST['editorderid'];
		$_SESSION['editProductID'] = $_POST['editproductid'];
		$editorderid=$_POST['editorderid'];
		$pending="pending";
		$done="done";
		$chkStatus="Select paymentStatus from orderdb where orderID='$editorderid'";
		//$chkStatus="UPDATE orderdb SET paymentStatus='$pending' where orderID='$editorderid'";
		$sqldata = mysqli_query($conn, $chkStatus);
		$row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC);
		if($row['paymentStatus']=="pending"){
			$sql="UPDATE orderdb SET paymentStatus='$done' where orderID='$editorderid'";
			mysqli_query($conn, $sql)or die(mysqli_error($conn));
			mysqli_close($conn);
		}else{
			$sql="UPDATE orderdb SET paymentStatus='$pending' where orderID='$editorderid'";
			mysqli_query($conn, $sql)or die(mysqli_error($conn));
			mysqli_close($conn);
		}
	}
	
	if(isset($_POST['cart'])){
		$orderID = $_SESSION['orderID'];
		$productID = $_POST['cart'];
		$sql = "SELECT * FROM orderdetailsdb WHERE orderID = '$orderID' AND productID = '$productID'";
		$sqldata = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC);
		if(mysqli_num_rows($sqldata)){
			$sql1 = "DELETE FROM orderdetailsdb WHERE orderID = '$orderID' AND productID = '$productID'";
			mysqli_query($conn, $sql1)or die(mysqli_error($conn));
			mysqli_close($conn);		
		}
	}
	
	if(isset($_POST['product'])){
		$_SESSION['productID'] = $_POST['product'];
	}
?>























