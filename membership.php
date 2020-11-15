<?php
	$customerID = $_SESSION['uid'];
	
	$sql = "Select totalAmount FROM orderdb WHERE userID = $customerID AND paymentStatus!='' AND paymentMethod!=''";
	
	$query = mysqli_query($conn, $sql) or die("error getting data");
	
	$total = 0;
	while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
		$total += $row['totalAmount'];
	}
	
	$rank = intval($total/500);
	if ($rank > 5){
		$rank = 5;
	}
	$_SESSION['rank'] = $rank;
	
	$update = "Update userdb SET totalPurchased = $total, membershipRank = $rank WHERE userID = $customerID";
	$update_query = mysqli_query($conn, $update) or die("error getting data2");
?>