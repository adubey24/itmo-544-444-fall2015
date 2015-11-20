
<Html>
<head>
<title>Gallery</title>
</head>
<body>

<?php
session_start();
$email = $_POST["email"];
echo $email;
require 'vendor/autoload.php';

$rds = new Aws\Rds\RdsClient([
'version' => 'latest',
'region'  => 'us-east-1'
]);

//Create Table
$result = $rds->describeDBInstances([
    'DBInstanceIdentifier' => 'ad-db',
]);

$endpoint = $result['DBInstances'][0]['Endpoint']['Address'];

    // Do something with the message
    print "============\n". $endpoint . "================\n";
   

//echo "begin database";
$link = mysqli_connect($endpoint,"controller","anvi2416","customerrecords") or die("Error " . mysqli_error($link));

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

//below line is unsafe - $email is not checked for SQL injection -- don't do this in real life or use an ORM instead

$link->real_query("SELECT * FROM items WHERE email = '$email'");

//$link->real_query("SELECT * FROM items");

$res = $link->use_result();
echo "Result set order...\n";
while ($row = $res->fetch_assoc()) {
    echo "<img src =\" " . $row['s3rawurl'] . "\" />";
//echo <img src =\"" .$row['s3finishedurl'] . "\"/>";
echo "<p>".$row['id'] . "Email: " . $row['email']."</p>";
}
$link->close();
?>
</body>
</html>
