
<?php
session_start();
include 'header.php';
?>
	<!-- Foundation.js -->
	<script>
      		$(document).foundation();
    	</script>

	<!-- jQuery -->
	<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>

	<!-- Fotorama -->
	<link href="resources/css/fotorama.css" rel="stylesheet">
	<script src="resources/js/fotorama.js"></script>
  
<?php
$email = $_SESSION["email"];
echo "Entered email:  ".$email;
require 'vendor/autoload.php';
require 'resources/library/db.php';
$link = getDbReadConn();
$link->real_query("SELECT * FROM items WHERE email = '$email'");
$res = $link->use_result();
echo "<p/>";
echo "Result set order:\n";
echo "<div class=\"fotorama\" data-nav=\"thumbs\">";
//echo "<div class="fotorama" data-nav="thumbs">";
while ($row = $res->fetch_assoc()) {
echo "<a href =\" " . $row['s3rawurl'] . "\" ><img src =\"" .$row['s3finishedurl'] . "\"/></a>";
}
echo "</div>";
$link->close();
//include 'footer.php';
?>
	</body>
</html>
