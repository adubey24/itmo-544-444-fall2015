<?php
session_start();
include 'header.php';
echo "<h3 center>";
echo "UserName is  " . $_SESSION["uname"] . ".<br>";
echo "Email is " . $_SESSION["email"] . ".<br>";
echo "Phone number is  " . $_SESSION["phone"] . ".<br>";
echo "</h3>";
include 'footer.php';
?>
