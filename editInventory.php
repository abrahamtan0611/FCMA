<?php
$servername = "localhost";
$DBusername = "root";
$DBpassword = "";
$DBname = "fcms";

$conn = mysqli_connect($servername, $DBusername, $DBpassword, $DBname);

// Check connection
if (!$conn){
  die("Connection failed:" .mysqli_connect_error());
}

?>
