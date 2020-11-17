<?php
// start session
session_start();
require "Include/header.php";
require "Include/dtb.php";
?>
<section id="content">
<div class="login-input-field">
    <h3>Create New Password</h3>
    <?php
    $selector = $_GET["selector"];
    $validator = $_GET["validator"];
    
    if (empty($selector) || empty($validator)){
        echo "Could not validate your request!";
        
    }else{
            if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
                ?>
    <form action="Include/reset-password.php" method="post">
        <input type="hidden" name="selector" value="<?php echo $selector ?>">
        <input type="hidden" name="validator" value="<?php echo $validator ?>">
        <input type="password" name="pwd" placeholder="Enter a new password..">
        <input type="password" name="pwd-repeat" placeholder="Repeat new password">
        <button type="submit" name="reset-password-submit">Reset password</button>
    </form>

    <?php   
            }   
        } 
?>
</div>
</section>
</div>
<?php
	include_once "Include/footer.php"; 
?>
	