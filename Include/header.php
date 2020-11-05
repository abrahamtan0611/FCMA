<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="author" content="Pass Task Team" />
    <meta name="description" content="Home Page" />
    <meta name="keywords" content="Food Ordering, Catering Service" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css" rel="stylesheet" href="Style/style.css" type="text/css" />
    <script type="text/javascript" src="javascript.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <title>Food Edge</title>
</head>

<body>
    <header>
        <div class="topnav">
            <a href="index.php">Home</a>
            <?php
          if (isset($_SESSION['uid'])){
			echo '<a href="cart.php">Cart</a>';
          }
           ?>
            <div class="login-container">
                <?php
            // check session, if there is a session display the logout button
            if (isset($_SESSION['uid'])){
              $username = $_SESSION['username'];
			  echo '<a href="accountSetting.php">Account Settings</a>';
              echo '<a class="username-hover">'.$username.'</a>';
              echo '<form class="header-form" action = "Include/logout.php" method="post">
                <button type="submit" name="logout-submit">Logout</button>
              </form>';
            }
            else{
              echo '<form class="header-form" action="login.php" method="post">
                <button type="submit" name="login-submit">Login</button>
              </form>
              <form class="header-form" action="register.php" method="post">
                <button type="submit" name="signup-submit">Register</button>
              </form>';
            }
            ?>
            </div>
        </div>
    </header>
