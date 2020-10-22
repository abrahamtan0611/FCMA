<?php
	// start the session()
	session_start();
	require "include/header.php";
?>
	<?php
		include("Include/dtb.php");
		$sqlget = "SELECT * FROM inventorydb";
		$sqldata = mysqli_query($conn, $sqlget) or die("error getting data");
		
	?>
		<div id="title" class="row">
			<div class="col-md-12">
				<h1>Edit Menu
				<button type="button" id="UploadBtn" class="btn btn-success btn-lg" onclick="btnOnclick()">Upload</button>
				</h1>
			</div>
		</div>
		<div id="article" class="row">
			<div id="menu" class="col-md-12">
				<?php
					while($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)){
				?>	
				<div class="food_col2">
					<img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>" width="308px" height="200px" class="fd_img"/> 
						<div class="fd_content">
							
								<p class="food_title"><input type="hidden" id="fd_title<?php echo $row['menuID'] ?>"value="<?php echo $row["name"]?>"><span id="title_<?php echo $row['menuID'] ?>"><?php echo $row["name"]?></span></input></p>
								<p class="food_desc"><input type="hidden"  id="fd_desc<?php echo $row['menuID']?>" value="<?php echo $row["description"]?>"><span id="desc_<?php echo $row['menuID'] ?>"><?php echo $row["description"]?></span></input></p>
								<p class="food_price"><input  type="hidden"  id="fd_price<?php echo $row['menuID']?>" value="<?php echo $row["price"]?>"><span id="price_<?php echo $row['menuID'] ?>">RM<?php echo number_format($row["price"],2)?></span></input></p>
							
						</div>
						<button type="button" class="btn btn-danger btn_ex" id="<?php echo $row['menuID'] ?>" onclick="myAjax(this.id)">
						<span class="glyphicon glyphicon-remove"></span> </button>
						<button type="button" class="btn btn-info btn_ex edit_btn" id="edit<?php echo $row['menuID'] ?>" onclick="edit_onclick(this.id)">
						<span class="glyphicon glyphicon-pencil"></span> Edit</button>
						<button type="button" class="btn btn-success btn_ex done_btn" id="dedit<?php echo $row['menuID'] ?>" onclick="done_onclick(this.id)"><span class="glyphicon glyphicon-ok"></span> Done</button>
						
						
				</div>
				<?php
					}
				?>
			</div>
			<div id="UploadModal" class="modal">
				<div class="modal-content">
					<span class="close">&times;</span>
					<h2>Upload Menu</h2>
					<form class="upload_menu_form" method="POST" action="save_image.php" enctype="multipart/form-data">
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
							<input type="text" id="ftitle" name="ftitle"><br/>
							<label for="fdesc"><span class="form_title">Description</span></label><br/>
							<input type="text" id="fdesc" name="fdesc"><br/>
							<label for="fprice"><span class="form_title">Price</span></label><br/>
							<input type="text" id="fprice" name="fprice"><br/>
							<button type="submit" class="btn btn-info upload_btn" id="submit_menu" name="submit_menu" onclick="uploadMenu()">Save</button>
							<button type="button" class="btn btn-default upload_btn">Reset</button>
							
							
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
		<div id="footer" class="row">
			<div class="col-md-12">
				<!-- put your footer here -->
				<p>Footer</p>
			</div>
		</div>
	</div>
</body>
</html>