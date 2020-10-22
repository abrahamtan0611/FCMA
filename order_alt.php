<?php
  // start session
  session_start();
  require "Include/header.php";
 ?>
 
<h2>Menu Example</h2>
<!-- Trigger/Open The Modal -->
<button id="myBtn">Make an Order</button>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
	<div id="details">
     <?php
			include ("Include/dtb.php");
			$mID = "4";
			$custID = 6;
			$sql = "SELECT * From inventorydb where menuID=$mID";
			$sqldata = mysqli_query($conn, $sql);
			$row = mysqli_fetch_array($sqldata,MYSQLI_ASSOC);
			
			if (isset ($_POST['quantity'])){
				
				$mquantity = mysqli_escape_string($conn, $_POST['quantity']);
				$minstruction = mysqli_escape_string($conn, $_POST['instruction']);
			
			$sql_ins = $conn -> prepare ("INSERT INTO orderdb (customerID,menuID, quantity, instruction) VALUES(?, ?, ?,?)");
			$sql_ins->bind_param("isss", $custID, $mID, $mquantity, $minstruction);
            $sql_ins->execute();
			mysqli_close($conn);
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






<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}


// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>

</body>
</html>