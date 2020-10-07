<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Food Catering System">
	<meta name="keywords" content="HTML, CSS, JavaScript, PHP">
	<meta name="author" content="Didier Luther Ho Chih-Yuan">
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Place an order</title>
</head>
<body>
	<form action="?.php" method="post">
		<fieldset>
			<legend><b>Place an order</b></legend>
			<p><label for="posid">Position ID: </label><br/>
			<input type="text" id="posid" name="posid" maxlength="7" placeholder="" required="required"><br/></p>			
			
			<p><label for="description">Description: </label><br/>
			<textarea id="description" name="description" rows="4" cols="50" maxlength="250" placeholder="" required="required"></textarea><br/></p>
			
			<p><label for="closeDate">Closing Date: </label><br/>
			<input type="text" id="date" name="date" placeholder="<?=Date('d-m-Y')?>" required="required"><br/></p>

			<label for="application">Application by:<br></label>
			<input type="checkbox" id="post" name="post" value="Post">
			<label for="post">Post<br/></label>
			<input type="checkbox" id="mail" name="mail" value="Mail">
			<label for="mail">Mail<br/></label></p>
			
			<p><label for="location">Location:<br></label>
			<select name="location" id="location"><br/>			
				<option value="">---</option>
				<option value="Betong">Betong</option>
				<option value="Bintulu">Bintulu</option>
				<option value="Kapit">Kapit</option>
				<option value="Kuching">Kuching</option>
				<option value="Limbang">Limbang</option>
				<option value="Miri">Miri</option>
				<option value="Mukah">Mukah</option>
				<option value="Samarahan">Samarahan</option>
				<option value="Sarikei">Sarikei</option>
				<option value="Serian">Serian</option>
				<option value="Sibu">Sibu</option>
				<option value="Sri Aman">Sri Aman</option>
			</select></p>
			<p class="btns"><button type="submit">Submit</button></p>
		</fieldset>
	</form>
	
	<p id="linkHome"><a href="index.php">Back to homepage</a></p>
</body>
</html>

