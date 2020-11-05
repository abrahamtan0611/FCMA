<?php
// start session
session_start();
require "Include/header.php";
require "Include/dtb.php";
?>

<div class="login-input-field">
    <h3>Reset Password</h3>
    <p>An e-mail will be sent to you with instructions on how to reset your password.</p>
    <form action="include/reset-request.php" method="post">
        <input type="text" name="email" placeholder="Enter your e-mail address..."><br><br>
        <button type="submit" name="reset-request-submit">Receive new password by e-mail</button>


    </form>
    <?php
    if(isset($_GET["reset"])){
        if($_GET["reset"] == "success"){
            echo '<p class = "signupsuccess">Check your e-mail!</p>';
        }
    
    }
?>
</div>



</body>

</html>
