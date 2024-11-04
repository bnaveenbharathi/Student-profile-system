<?php 
session_start();

if (!isset($_SESSION['roll_no'])) {
    header("Location: login.php"); 
    exit();
}

?>



