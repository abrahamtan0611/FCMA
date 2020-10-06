<?php
	// check if register submir button is clicked or not
	if (isset($_POST['submit'])){

		// require dtb.php for connection
		require 'dtb.php';

		// obtain input value from form
		$username = mysqli_escape_string($conn,$_POST['username']);
		$email = mysqli_escape_string($conn,$_POST['email']);
		$phoneNo = mysqli_escape_string($conn,$_POST['contact']); 
		$password = mysqli_escape_string($conn,$_POST['password']);
		$passwordRepeat = mysqli_escape_string($conn,$_POST['Re-password']);

		// check if username, email, password and repeat password is empty
		if(empty($firstname) || empty($email) || empty($phoneNo) || empty($password) ||empty($passwordRepeat)){
			header("Location: ../register.php?error=emptyfields&fname=".$firstname."&lname=".$lastname."&email=".$email);
			exit(); //stop the scipt from running if all the fields are empty
		}
		// check if email, firstname ans lastname is valid or not
		else if(!filter_var($email, FILTER_VALIDATE_EMAIL) && (!preg_match("/^[a-zA-Z0-9]*$/", $firstname)) && (!preg_match("/^[a-zA-Z0-9]*$/", $lastname))){
			header("Location: ../register.php?error=invalidfnamelnameemail");
			exit(); //stop the scipt from running email is invalid
		}
	  // check if email of valid or not
		else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			header("Location: ../register.php?error=invalidemail&fname=".$firstname."&lname".$lastname);
			exit(); //stop the scipt from running email is invalid
		}
	  // check if firstname is valid or not
		else if(!preg_match("/^[a-zA-Z0-9]*$/", $firstname)){
			header("Location: ../register.php?error=invalidfname&email=".$email);
			exit(); //stop the scipt from running if firstname is invalid
		}
	  // check is lastname is valid or not
		else if(!preg_match("/^[a-zA-Z0-9]*$/", $lastname)){
			header("Location: ../register.php?error=invalidlname&email=".$email);
			exit(); //stop the scipt from running if lastname if invalid
		}
	  // check is phone number is valid or not
		else if(!preg_match("/^[0-9]*$/", $lastname)){
			header("Location: ../register.php?error=invalidlname&email=".$email);
			exit(); //stop the scipt from running if phone number if invalid
		}
	  // check if password and password repeat is the same or not
		else if ($password !== $passwordRepeat){
			header("Location: ../register.php?error=errorpassword&fname=".$firstname."&lname=".$lastname."&email=".$email);
			exit(); //stop the scipt from running if password and repeat password are not same
		}
		else{
			//check sql connection
			$sql = "SELECT email FROM users WHERE email=?";
			$stmt = mysqli_stmt_init($conn);
			// check if we can prepared the statement and connection to the database
			if(!mysqli_stmt_prepare($stmt, $sql)){
				header("Location: ../register.php?error=sqlerror");
				exit();
			}
			else{
				mysqli_stmt_bind_param($stmt, "s",$email);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_store_result($stmt);
				$resultCheck = mysqli_stmt_num_rows($stmt);
				if($resultCheck > 0){
					header("Location: ../register.php?error=emailtaken&fname=".$firstname."&lname=".$lastname);
					exit();
				}
				else{
					$sql = "INSERT INTO users (firstname, lastname, email, phoneNo, password) VALUES (?, ?, ?, ?, ?)";
					$stmt = mysqli_stmt_init($conn);
					// check if we can prepared the statement and connection to the database
					if(!mysqli_stmt_prepare($stmt, $sql)){
						header("Location: ../register.php?error=sqlerror");
						exit();
					}
					else{
					// hash the password using bcrypt
					$hashPwd = password_hash($password, PASSWORD_DEFAULT);

					mysqli_stmt_bind_param($stmt, "ssss",$firstname, $lastname, $email, $phoneNo, $hashPwd);
					mysqli_stmt_execute($stmt);
					header("Location: ../register.php?register=success");
					exit();
					}

				}
			}

		}
		mysqli_stmt_close($stmt); // close the statement to save resources
		mysqli_close($conn);  // close the connection to save resources
	}
	else{
	  header("Location: ../register.php? ");
	  exit();
	}
?>
