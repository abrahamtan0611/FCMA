<?php
session_start();      // start the session
session_unset();      //delete all the value in the session
session_destroy();    // destroy the session
header("Location: ../index.php");
 ?>
