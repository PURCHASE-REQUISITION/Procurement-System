<?php 
session_start();
unset($_SESSION['sbeusernamex'],$_SESSION['sbelevelx'],$_SESSION['sbeuidx']);
// session_destroy();
header("Location: ../index.php");
?>