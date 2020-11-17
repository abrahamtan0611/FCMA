<?php
	// start the session()
	session_start();
	require "Include/header.php";
?>
	<?php
		include("Include/dtb.php");
		$sqlget = "SELECT * FROM productdb";
		$sqldata = mysqli_query($conn, $sqlget) or die("error getting data");
		
		if(isset($_POST['submit_menu']))
		{		
			$title = $_POST['ftitle'];
			$desc = $_POST['fdesc'];
			$price = $_POST['fprice'];
			$iprice = $_POST['iprice'];
			$stock = $_POST['stock'];
			
			$image = $_FILES['myfile']['tmp_name'];
			$img = file_get_contents($image);
			$sql = "INSERT INTO productdb(image, name, initialPrice, price, stock, description) VALUES(?, ?,?,?,?,?)";
			
			$stmt = mysqli_prepare($conn, $sql);
			mysqli_stmt_bind_param($stmt, "ssiiis",$img, $title, $iprice, $price, $stock, $desc);
			mysqli_stmt_execute($stmt);
			
			mysqli_close($conn);
			
			echo ("<script LANGUAGE='JavaScript'>
							window.alert('Succesfully Added To Inventory');
							window.location.href='edit_inventory.php';
							</script>");
		}
		
	?>
	<!-- FEATURE PRODUCT -->
	<div class="feature">
		<div class="small-container">
			<h2 class="title">Edit Menu</h2><br>
			<p><button type="button" id="UploadBtn" class="btn btn-success btn-lg" onclick="btnOnclick()">Upload New Menu</button><p>
			<div class="row">
				<?php
					while($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)){
				?>
				<div class="col-3">
					<img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image'])?>" width="100px" height="350px"/>
					<div class="fd_content">
						<p style="font-size:16px; margin: 10px 0;"class="food_title"><input type="hidden" id="fd_title<?php echo $row['productID'] ?>" value="<?php echo $row["name"]?>"><span id="title_<?php echo $row['productID'] ?>"><?php echo $row["name"]?></span></input></p>
						<span style="font-size: 16px;"><b>Description:</b></span>
						<p class="food_desc"><textarea rows="10" cols="40" style="border:hidden;resize:none" id="fd_desc<?php echo $row['productID']?>" readonly><?php echo $row["description"]?></textarea></p></p>
						<span style="font-size: 16px;"><b>Initial Price:</b></span>
						<p class="food_iprice"><input  type="hidden"  id="fd_iprice<?php echo $row['productID']?>" value="<?php echo $row["initialPrice"]?>"><span id="iprice_<?php echo $row['productID'] ?>">RM<?php echo number_format($row["initialPrice"],2)?></span></input></p>
						<span style="font-size: 16px;"><b>Selling Price:</b></span>
						<p class="food_price"><input  type="hidden"  id="fd_price<?php echo $row['productID']?>" value="<?php echo $row["price"]?>"><span id="price_<?php echo $row['productID'] ?>">RM<?php echo number_format($row["price"],2)?></span></input></p>
						<span style="font-size: 16px;"><b>Stock:</b></span>
						<p class="food_stock"><input  type="hidden"  id="fd_stock<?php echo $row['productID']?>" value="<?php echo $row["stock"]?>"><span id="stock_<?php echo $row['productID'] ?>"><?php echo $row["stock"] ?></span></input></p>
					</div>
					<button type="button" class="btn btn-danger btn_ex" id="<?php echo $row['productID'] ?>" onclick="myAjax(this.id)">
					<span class="glyphicon glyphicon-remove"></span> </button>
					<button type="button" class="btn btn-info btn_ex edit_btn" id="edit<?php echo $row['productID'] ?>" onclick="edit_onclick(this.id)">
					<span class="glyphicon glyphicon-pencil"></span> Edit</button>
					<button type="button" class="btn btn-success btn_ex done_btn" id="dedit<?php echo $row['productID'] ?>" onclick="done_onclick(this.id)"><span class="glyphicon glyphicon-ok"></span> Done</button>
				</div>
				<?php
					}
				?>
			</div>
		</div>
	</div>

			<div id="UploadModal" class="modal">
				<div class="modal-content">
					<span class="close">&times;</span>
					<h2>Upload New Menu</h2>
					<form class="upload_menu_form" method="POST" enctype="multipart/form-data">
						<div id="upload_img_modal">
							<img src="Images/upload.png" alt="image" width="100px" class="upload_img" id="upload_img"/>
							
							<div id="upload_content">
								<p>Upload Image</p>
								<p>308(w) X 200(h)</p>
							</div>
							<input type="file" id="myfile" name="myfile" onchange="loadFile(event)"/>
						</div>
						<div class="field">
							<label for="ftitle"><span class="form_title">Title</span></label><br/>
							<input type="text" id="ftitle" name="ftitle"/><br/>
							<label for="fdesc"><span class="form_title">Description</span></label><br/>
							<textarea id="fdesc" name="fdesc" cols="50"></textarea><br>
							<!--<input type="text" id="fdesc" name="fdesc"/><br/>-->
							<label for="stock"><span class="form_title">Stock Left </span></label><br/>
							<input type="text" id="stock" name="stock"/><br/>
							<label for="iprice"><span class="form_title">Initial Price</span></label><br/>
							<input type="text" id="iprice" name="iprice"/><br/>
							<label for="fprice"><span class="form_title">Selling Price(RM)</span></label><br/>
							<input type="text" id="fprice" name="fprice"/><br/>
							<button type="submit" class="btn btn-info upload_btn" id="submit_menu" name="submit_menu" onclick="uploadMenu()">Save</button>
							<button type="reset" class="btn btn-default upload_btn">Reset</button>		
						</div>
					</form>
				</div>
			</div>
			<?php
				mysqli_close($conn);
			?>
			<script src="javascript.js"></script>
		</div>		
	</div>	
	</div>
	<?php
	include_once "Include/footer.php"; 
?>
