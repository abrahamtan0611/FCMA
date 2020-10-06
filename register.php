<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Registration</title>
<!--<link rel="stylesheet" href="styles/style.css" />-->
</head>
<body>
<!--php header here-->
<div class="form">
<h1>Registration</h1>
	<form name="registration" action="include/registerValidator.php" method="post">	
	<p><label>Username: </label><br/>
	<input type="text" name="username" placeholder="Enter your firstname"><br/></p>
	<p><label for="email">Email Address: </label><br/>
	<input type="email" name="email" placeholder="Email Address" required /><br/></p>
	<p><label for="contact">Phone number: </label><br/>
	<input type="text" name="contact" placeholder="Phone number" required /><br/></p>
	<p><label for="password">Password: </label><br/>
	<input type="password" name="password" placeholder="Password" required /><br/></p>
	<p><label for="password">Retype Password: </label><br/>
	<input type="password" name="Re-password" placeholder="Re-enter your password" required /><br/></p>
	
	<p><input type="reset" name="reset" value="Reset" /></p>
	<p><input type="submit" name="submit" value="Register" /></p>
</form>
</div>

<!--php footer here-->
</body>
</html>














