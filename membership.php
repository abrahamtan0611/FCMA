<?php
	include("Include/dtb.php");
	$customerID = $_SESSION['uid'];
	$sqlget = "SELECT orderdb.quantity, inventorydb.price from orderdb, inventorydb WHERE orderdb.customerID = $customerID AND orderdb.menuID = inventorydb.menuID";
	$sqldata = mysqli_query($conn, $sqlget) or die("error getting data");
	
	$total = 0;
	while($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)){
		$total += $row['price'];
	}
	
	$rank = intval($total/500);
	$_SESSION['rank'] = $rank;
	$update = "Update userdb SET TotalPurchased = $total, MembershipRank = $rank WHERE customerID = $customerID";
	$sqldata2 = mysqli_query($conn, $update) or die("error getting data");
	
	$conn->close();
?>