<?php 
session_start(); 
$_SESSION["uname"] = $_POST['username'];
$_SESSION["email"] = $_POST['useremail'];
$_SESSION["phone"] = $_POST['phone'];
echo "Session variables are set.";
header('Location: /upload.php');
?>
