<?php
session_start();
include 'header.php';
echo "</p></p>";
echo "<h4>All Items </h4>";
$link = getDbConn();
$link->real_query("SELECT * FROM items");
$res = $link->use_result();
echo "Result set order...\n";
while ($row = $res->fetch_assoc()) {
    echo $row['id'] . " " . $row['email']. " " . $row['phone'];
}
$link->close();
include 'footer.php';
?>
