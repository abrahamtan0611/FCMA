<?php
  // start session
  session_start();
  if(!empty($_SESSION['uid'])){
    $id = $_SESSION['uid'];
    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname'];
    $email = $_SESSION['email'];
  }else{
    header("Location: ../index.php?error=invalidsession");
    exit();
  }

  require 'include/dtb.php';

  $status_msg = "";
  $input_valid_flag = false;

  // validate input field
  if(isset($_POST['update-submit'])){
    if (!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['current_pwd']) && !empty($_POST['new_pwd']) && !empty($_POST['rped_pwd'])){

      $fname = mysqli_escape_string($conn, $_POST['first_name']);
      $lname = mysqli_escape_string($conn, $_POST['last_name']);
      $currentpassword = mysqli_escape_string($conn, $_POST['current_pwd']);
      $newpassword = mysqli_escape_string($conn, $_POST['new_pwd']);
      $repeatpassword = mysqli_escape_string($conn, $_POST['rped_pwd']);

      // check new password is it same with repeat password or not
      if ($newpassword == $repeatpassword){
        $input_valid_flag = true;
      }
      else{
        $status_msg = "<p style='color:red'>Both passwords do not match. Please try again.</p>";
      }
    }
    else{
      $status_msg = "<p style='color:red'>Incomplete input. Please try again.</p>";
    }
  }

  // run only if new password and repeat password are the same
  if ($input_valid_flag){
    $sql = "SELECT * FROM users WHERE email=?";
    // statement
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
      header ("Location: accountSetting.php?error=sqlerror");
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($row = mysqli_fetch_assoc($result)){
        $pwdchk = password_verify($currentpassword, $row['password']);
        if ($pwdchk == false){
          $status_msg = "<p style='color:red'>Wrong password. Please retype current password.</p>";
        }
        else{
          mysqli_stmt_bind_param($stmt, "s",$email);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_get_result($stmt);
          $sql_add_record = "UPDATE users SET firstname=?, lastname=?, password=? WHERE email=?;";
          $stmt = mysqli_stmt_init($conn);
          // check if we can prepared the statement and connection to the database
          if(!mysqli_stmt_prepare($stmt, $sql_add_record)){
            header ("Location: accountSetting.php?error=sqlerror");
            exit();
          }else{
            $hashed_password = password_hash($newpassword, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "ssss",$fname, $lname, $hashed_password, $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            $_SESSION['fname'] = $_POST['first_name'];
            $_SESSION['lname'] = $_POST['last_name'];
            $status_msg = "<p style='color:green'>Account details are sucessfully updated.</p>";
          }
        }
      }
    }
  }
?>

<?php
  require "include/header.php";
 ?>

 <!-- HTML code -->
 <main>
    <div class="wrapper-main">
      <section class="updateprofile-form">
        <h1>Profile</h1>
        <form class="register-f" action="accountSetting.php" method="post">

          <div>
            <label>Username</label>
            <input type="text" name="name" id="username" value="<?php echo $username?>">
          </div>

          <div>
            <label>E-mail</label>
            <input type="text" name="email" disabled="disabled" value="<?php echo $email; ?>">
          </div>

          <div>
            <label>Curent password</label>
            <input type="password" name="current_pwd" id="cpwd" placeholder="Enter current password...">
          </div>

          <div>
            <label>New password</label>
            <input type="password" name="new_pwd" id="pwd" placeholder="Enter new password...">
          </div>

          <div>
            <label>Retype password</label>
            <input type="password" name="rped_pwd" disabled="disabled" id="rpdpwd" placeholder="Repeat new password...">
          </div>

          <button type="button" onclick="myFunction()" name="edit-info">Edit Details</button>
          <button type="submit" name="update-submit">Save</button>
          <div class="status"><?php echo $status_msg; ?></div>
        </form>
      </section>
     </div>
 </main>
</body>
</html>
