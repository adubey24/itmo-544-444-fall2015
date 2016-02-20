<? php

// Start the session^M

require 'vendor/autoload.php';
require 'resources/library/db.php';

$link = getDbConn();

$sql_comments = "CREATE TABLE comments 
(
ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
PosterName VARCHAR(32),
Title VARCHAR(32),
Content VARCHAR(500)
)";

$retVal1 = $link->query($sql_comments);

if($retVal1 === TRUE) {
print "Comments Table Created";
} else {
print "Could not create comments table";
}

$sql_items = "CREATE TABLE items 
(
ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
uname Varchar(20),
email Varchar(80), 
phone Varchar(20), 
s3rawurl Varchar(256), 
s3finishedurl Varchar(256), 
filename Varchar(256), 
status TinyInt(3), 
issubscribed TinyInt(3)
)";

$retVal2 = $link->query($sql_items);

if($retVal2 === TRUE) {
print "Items Table Created";
} else {
print "Could not create Items table";
}

$sql_config = "CREATE TABLE cloud_gallery_config 
(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
config_key Varchar(20),
config_value Varchar(80)
)";

$retVal3 = $link->query($sql_config);

if($retVal3 === TRUE) {
print "cloud_gallery_config Table Created";
} else {
print "Could not create cloud_gallery_config table";
}

$link->close();
print "\n";
?>
