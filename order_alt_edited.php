<?php
	// start the session()
	session_start();
	require "Include/header.php";
	$mID = $_SESSION['indexMenuID'];
?>

	<!-- The Modal -->
	<?php echo $mID ?>
	<div id="myModal" class="modal">

	  <!-- Modal content -->
	  <div class="modal-content">
		<span class="close">&times;</span>
		<div id="details">
		 <?php
			include ("Include/dtb.php");
			if (isset($_SESSION['indexMenuID'])){
				$mID = $_SESSION['indexMenuID'];
				
				echo $mID;
				
				$sql = "SELECT * From inventorydb where menuID=$mID";
				$sqldata = mysqli_query($conn, $sql) or die(mysqli_error($conn));
				$row = mysqli_fetch_array($sqldata,MYSQLI_ASSOC);
				//session_unset();
			}else{
				echo '<script type="text/javascript">
							alert("NO SESSION!.");
						</script>';
			}
			
			//echo $mID;

			$custID = 7;
			
			if (isset($_POST['quantity'])){
				$mquantity = mysqli_escape_string($conn, $_POST['quantity']);
				$minstruction = mysqli_escape_string($conn, $_POST['instruction']);
				$sql_ins = $conn -> prepare ("INSERT INTO orderdb (customerID, menuID, quantity, instruction) VALUES(?, ?, ?, ?)");
				$sql_ins->bind_param("isss", $custID, $mID, $mquantity, $minstruction);
				$sql_ins->execute();
				echo '<script type="text/javascript">
							alert("Done.");
						</script>';
				$sql_ins->close();
				$conn->close();
			}
			

		
		?>
		<p class="food_name_modal"><?php echo $row["name"]?> </p>
		<p><img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>" width="100%" height="340px"/> </p>
		<p id="desc">Description:</p>
		<hr>
		<p class="food_desc_modal"><?php echo $row['description'] ?></p>
		<p class="food_price_modal"><span id="prc">Price:</span> RM<?php echo number_format($row['price'],2) ?></p>
		<p class="food_quantity"></p>
		<form name = "order" id = "orderform" action = "order_alt.php" method = "POST">
		<div id="qtty">
		<label for="quantity">Quantity:</label>
		<input type = "number" id="quantity" name="quantity" min="1" max="100" value="1">
		</div>
		<div id="ins">
		<label for="instruction">Special instruction (Can leave it blank if none): <br></label>
		<textarea id = "instruction" name = "instruction" rows="2" cols="50" placeholder="Any Instruction? Write it down here~"></textarea>
		</div>
		<br><br>
		<input type="reset" value="Reset">
		<input type="submit" value="Add to Cart">
		</form>
	  </div>
	  </div>
	</div>
