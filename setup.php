<? php

// Start the session^M

require 'vendor/autoload.php';

$rds = new Aws\Rds\RdsClient([
    'version' => 'latest',
    'region'  => 'us-east-1'
]);

$s3 = new Aws\s3\s3Client([
    'version' => 'latest',
    'region'  => 'us-east-1'
]);

//Create table
$result = $rds->createDBInstances([
    'DBInstanceIdentifier' => 'ad-db',

    #'AutoMinorVersionUpgrade' => true || false,
    #'AvailabilityZone' => '<string>',
    #'BackupRetentionPeriod' => <integer>,
   # 'CharacterSetName' => '<string>',
   # 'CopyTagsToSnapshot' => true || false,
   # 'DBClusterIdentifier' => '<string>',

   # 'DBInstanceClass' => 'db.t1.micro', // REQUIRED
    #'DBInstanceIdentifier' => 'ad-db', // REQUIRED
    #'DBName' => 'customerrecords',

    #'DBParameterGroupName' => '<string>',
    #'DBSecurityGroups' => ['<string>', ...],
    #'DBSubnetGroupName' => '<string>',

    #'Engine' => 'MySQL', // REQUIRED
    #'EngineVersion' => '5.5.41',

    #'Iops' => <integer>,
    #'KmsKeyId' => '<string>',
   # 'LicenseModel' => '<string>',
  
#'MasterUserPassword' => 'anvi2416',
 #   'MasterUsername' => 'controller',

    #'MultiAZ' => true || false,
    #'OptionGroupName' => '<string>',
    #'Port' => <integer>,
    #'PreferredBackupWindow' => '<string>',
    #'PreferredMaintenanceWindow' => '<string>',
    
#'PubliclyAccessible' => true,

    #'StorageEncrypted' => true || false,
    #'StorageType' => '<string>',
   # 'Tags' => [
   #     [
   #         'Key' => '<string>',
   #         'Value' => '<string>',
   #     ],
        // ...
   # ],
    #'TdeCredentialArn' => '<string>',
    #'TdeCredentialPassword' => '<string>',
   # 'VpcSecurityGroupIds' => ['<string>', ...],

]);

#print "Create RDS DB results: \n";

# print_r($rds);

#$result = $rds->waitUntil('DBInstanceAvailable',['DBInstanceIdentifier' => 'ad-db']);

// Create a table 

#$result = $rds->describeDBInstances([
    'DBInstanceIdentifier' => 'ad-db'
#]);

$endpoint = $result['DBInstances'][0]['Endpoint']['Address'];
print "============\n". $endpoint . "================\n";

$link = mysqli_connect($endpoint,"controller","anvi2416","customerrecords") or die("Error " . mysqli_connect_error($link)); 
#echo "Here is the result: " . $link;
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

$link->close();
print "\n"
?>
