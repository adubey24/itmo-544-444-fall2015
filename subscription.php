<?php
require 'vendor/autoload.php';
require 'resources/library/db.php';
session_start();
$email = $_SESSION["email"];
echo "Adding Email".$email." as a confirmed Subscriber to email alerts";
setSubscribed($email);
header('Location: /upload.php');    
?>
