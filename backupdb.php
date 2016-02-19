<?php
require 'vendor/autoload.php';
require 'resources/library/db.php';
define('DEBUG_ON', TRUE);
if(DEBUG_ON){error_reporting(-1);}
$now = date("Ymd_His");
syslog(LOG_INFO, "phpMyS3Backup - Starting run ID $now");
// ********************************
// Get list of databases
// ********************************
$alldb = array();
$GLOBALS['con'] = getDbConn();
$res = mysqli_query($GLOBALS['con'], "SHOW DATABASES;");
while($row = mysqli_fetch_array($res)){
        if($row['Database'] != "information_schema"){
                $alldb[] = $row['Database'];
                deb("Database found: {$row['Database']}");
        }
}
// ********************************
// MySQLDump each database
// ********************************
system("mkdir /tmp/$now/");
foreach($alldb as $db){
        $cmd = "mysqldump $db -h ".getDbHost()." -u controller -panvi2416 > /tmp/{$now}/$db.sql";
        deb("Doing: $cmd");
        system($cmd);
}
// ********************************
// gzip databases
// ********************************
foreach($alldb as $db){
        system("gzip /tmp/{$now}/$db.sql");
}
// ********************************
// Upload the files to S3
// ********************************
$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-east-1'
]);
$bucket = strtolower('phpmys3backup'.'-'.$now );
deb("Creating Bucket $bucket");
$create_bucket_response = $s3->createBucket([
    'ACL' => 'public-read',
    'Bucket' => $bucket
]);
deb("created bucket $bucket");
deb("bucket created - doing file add");
foreach ($alldb as $db) {
	$filename = "$db.sql.gz";
	$path = "/tmp/{$now}/";
	$uploadfile = $path.$filename;
	$result = $s3->putObject([
		'ACL' => 'public-read',
		'Bucket' => $bucket,
		'Key' => $uploadfile,
		'SourceFile' => $uploadfile
	]);
	$objUrl = $result['ObjectURL'];
	deb("Uploaded Object URL: $objUrl");
}
// ********************************
// Cleanup the local filesystem
// ********************************
system("rm -rf /tmp/{$now}/");
deb("DONE");
syslog(LOG_INFO, "phpMyS3Backup - completed run ID $now");
// ********************************
// Done!
// ********************************
function deb ($msg) {
        if(DEBUG_ON) { print $msg . "\n</p>"; }
}
//header('Location: /introspection.php');
?>
