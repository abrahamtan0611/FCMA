<?php

if(isset($_POST["reset-password-submit"])){
    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["pwd"];
    $passwordRepeat = $_POST["pwd-repeat"];
    
    if(empty($password) || empty($passwordRepeat)){
        header("Location: ../create-new-pw.php?newpwd=empty");
        exit();
    }else if ($password != $passwordRepeat){
        header("Location: ../create-new-pw.php?newpwd=pwdnotsame");
        exit();
    }
    
    $currentDate = date("U");
    
    require 'dtb.php';
    
    $sql = "SELECT * FROM pwReset WHERE pwResetSelector=? AND pwResetExpires >= ?";
    
      $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        
        echo"There was an error!";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $selector);
        mysqli_stmt_execute(stmt);
        
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc()){
            echo "You need to re-submit your reset request.";
            exit();
            
        } else {
            $tokenBin = hex2bin($validator);
            $tokenCheck = password_verify($tokenBin, $row["pwResetToken"]);
            
            if($tokenCheck === false){
                echo "You need to re-submit your reset request.";
                exit();
                
            }elseif($tokenCheck === true){
                
                $tokenEmail = $row['pwResetEmail'];
                
                $sql = "SELECT * FROM userdb WHERE email=?;";//emailUsers? emailUserdb?
                
                  $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        
        echo"There was an error!";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
        mysqli_stmt_execute($stmt);
        
           $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc()){
            echo "There was an error!";
            exit();
            
        } else {
            $sql = "UPDATE userdb SET password=? WHERE email=?";
            if (!mysqli_stmt_prepare($stmt, $sql)){
        
        echo"There was an error!";
        exit();
    } else {
        $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
        $n
        
        mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenemail);
        mysqli_stmt_execute($stmt);
                
                $sql = "DELETE FROM pwReset WHERE pwResetEmail=?";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt,$sql)){
                    echo"There was an error!";
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../register.php?newpwd=passwordUpdated")
                }
                                        
            }
            
        }
        
    }
                
            }
            
        }
    }
    
} else{
    
    header("Location:  ../index.php");
}

?>
