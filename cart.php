<?php
	require 'Include/dtb.php';
	$custId = 8;

	// display all information based on userID
	$sql = "SELECT * FROM orderdb o INNER JOIN inventorydb i ON o.menuID = i.menuID WHERE o.customerID = ?";
	$stmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt,$sql)){
		echo 'alert("SQL errorrrr!)';
		exit();
	}else{
		mysqli_stmt_bind_param($stmt, "s", $custId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		
		require 'Include/header.php';
		echo "<table>";
		echo "<tr><th>Product</th><th>Quantity</th><th>Instruction</th><th>Price</th></tr>";
		
		while($row = mysqli_fetch_assoc($result)){	
			echo "<tr><td>";
			echo "<button type='button' id='".$row['orderID']."' onclick='deleteData(this.id)'>Delete</button>";
			echo "</td><td>";
			echo $row['name'];
			echo "</td><td>";
			echo $row['quantity'];
			echo "</td><td>";
			echo $row['instruction'];
			echo "</td><td>";
			echo $row['price'];
			echo "</td></tr>";
		}
		echo "</table>";
	}

	if (isset($_POST['updateCart-submit'])){
		if (!empty($_POST['time']) && !empty($_POST['date']) && !empty($_POST['address'])){
			$time = mysqli_escape_string($conn, $_POST['time']);
			$date = mysqli_escape_string($conn, $_POST['date']);
			$address = mysqli_escape_string($conn, $_POST['address']);
			
			$sql = "SELECT * FROM orderdb WHERE customerID=?";
			$stmt = mysqli_stmt_init($conn);
			if (!mysqli_stmt_prepare($stmt, $sql)){
			echo '<script type="text/javascript">
						alert("SQL Error.");
					</script>';
			exit();
			}else{
				mysqli_stmt_bind_param($stmt, "s", $custId);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_get_result($stmt);
				$sql_add_record = "UPDATE orderdb SET time=?, orderDate=?, address=? WHERE customerID=?;";
				$stmt = mysqli_stmt_init($conn);
				if(!mysqli_stmt_prepare($stmt, $sql_add_record)){
						echo '<script type="text/javascript">
						alert("SQL Error.");
					</script>';
					}else{
						mysqli_stmt_bind_param($stmt, "ssss",$time, $date, $address, $custId);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_close($stmt);
		
					}
			
			}
		}else{
			echo '<script type="text/javascript">
						alert("Please fill in all field.");
					</script>';
			exit();
		}
		
	}
?>



<div class="profile-input-field">
	<form id="updateProfile" method="POST">		
		<div class="form-group">
			<label>Time</label>
			<input type="time" class="form-control" name="time" placeholder="Time" />
		</div>
		<div class="form-group">
			<label>Date</label>
			<input type="date" class="form-control" name="date" placeholder="Date"/>
		</div>
		<div class="form-group">
			<label>Address</label>
			<input type="text" class="form-control" name="address" placeholder="Address" />
		</div>
		<div class="form-group">
			<button type="submit" name="updateCart-submit" class="btn btn-primary">Purchase</button>
			<button type="reset" name="reset-submit" class="btn btn-primary">Reset</button>
		</div>
	</form>
</div>