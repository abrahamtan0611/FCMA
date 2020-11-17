<?php
	//start session
	session_start();
	
	// check for session
	if (!empty($_SESSION['uid'])){
		$userID = $_SESSION['uid'];
	}else{
		echo '<script type="text/javascript">
					alert("Invalid Session!");
					window.location = "cart.php";
				</script>';
		exit();
	}
	
	require_once 'Include/dtb.php';
	
	if (isset($_POST['addCart'])){
		$quantity = $_POST['quantity'];
		$specialDesc = $_POST['specDesc'];
		$productID = $_POST['hidden-productID'];
		$price = $_POST['hidden-price'];
		$sql = 'SELECT *
			FROM orderdb
			JOIN orderdetailsdb
			ON orderdb.orderID = orderdetailsdb.orderID
			JOIN productdb
			ON productdb.productID = orderdetailsdb.productID
			WHERE (orderdb.userID = ? AND orderdb.paymentStatus="" AND orderdb.paymentMethod="");';
		if($stmt = $conn->prepare($sql)){
			$stmt->bind_param("s", $userID);
			$stmt->execute();
			$result = mysqli_stmt_get_result($stmt);
			$row = mysqli_fetch_assoc($result);
			if(mysqli_num_rows($result)){
				$orderID = $row['orderID'];
				$subtotal = $quantity * $price;
				$sql_add_record = $conn -> prepare('INSERT INTO orderdetailsdb(productID,orderID,quantity,subtotal,special_description) VALUES (?, ?, ?, ?, ?)');
				$sql_add_record->bind_param("iiiis",$productID,$orderID,$quantity,$subtotal,$specialDesc);
				$sql_add_record->execute();
				echo ("<script LANGUAGE='JavaScript'>
						window.alert('Succesfully Added To Cart');
						window.location.href='cart.php';
						</script>");		
			mysqli_free_result($result);
			}else{
				$sql1 = $conn-> prepare('INSERT INTO orderdb(userID) VALUES (?)');
				$sql1->bind_param('s',$userID);
				$sql1->execute();
				
				$sql2 = $conn-> prepare('SELECT * FROM orderdb WHERE (userID = ? AND paymentStatus="" AND paymentMethod="")');
				$sql2->bind_param('s',$userID);
				$sql2->execute();
				$result = mysqli_stmt_get_result($sql2);
				$row = mysqli_fetch_assoc($result);
				$orderID = $row['orderID'];
				$subtotal = $quantity * $price;
				
				$sql3 = $conn->prepare('INSERT INTO orderdetailsdb(productID,orderID,quantity,subtotal,special_description) VALUES (?, ?, ?, ?, ?)');
				$sql3->bind_param('iiiis',$productID,$orderID,$quantity,$subtotal,$specialDesc);
				$sql3->execute();
				
				echo ("<script LANGUAGE='JavaScript'>
						window.alert('Succesfully Added To Cart');
						window.location.href='cart.php';
						</script>");
			}
		}
		$_SESSION['orderID'] = $orderID;
		mysqli_close($conn);
	}
?>