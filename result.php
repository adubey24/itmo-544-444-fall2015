<?php
// Start the session
session_start();

include 'header.php';
$uploaddir = '/tmp/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
echo '<pre>';

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "File is valid, and was successfully uploaded.\n";
} else {
    echo "Possible file upload attack!\n";
}
print_r($_FILES);
print "</pre>";

$testimagefilename = $uploadfile.'_magick';
$testimage=new Imagick($uploadfile);
$testimage->thumbnailImage(100, 0);
$testimage->writeImages($testimagefilename,false);

require 'vendor/autoload.php';
require 'resources/library/db.php';

$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-east-1'
]);

use Aws\Sns\SnsClient;
$sns = SnsClient::factory(array(
'version' => 'latest',
'region' => 'us-east-1'
));

$bucket = uniqid("php-ad-",false);
$result = $s3->createBucket([
    'ACL' => 'public-read',
    'Bucket' => $bucket
]);
$result = $s3->putObject([
    'ACL' => 'public-read',
    'Bucket' => $bucket,
      'Expires' => gmdate("D, d M Y H:i:s T", strtotime("+1 day")),
   'Key' => $uploadfile,
	'SourceFile' => $uploadfile 
]); 

$url = $result['ObjectURL'];
$resultthumb = $s3->putObject([
    'ACL' => 'public-read',
    'Bucket' => $bucket,
     'Expires' => gmdate("D, d M Y H:i:s T", strtotime("+1 day")),
   'Key' => $testimagefilename,
        'SourceFile' => $testimagefilename
]);

$urlthumb = $resultthumb['ObjectURL'];
$link = getDbConn();
if (!($stmt = $link->prepare("INSERT INTO items (id, email,phone,filename,s3rawurl,s3finishedurl,status,issubscribed) VALUES (NULL,?,?,?,?,?,?,?)"))) {	
    echo "Prepare failed: (" . $link->errno . ") " . $link->error;

}
$email = $_SESSION["email"];
$phone = $_SESSION['phone'];
$s3rawurl = $url; //  $result['ObjectURL']; from above
$filename = basename($_FILES['userfile']['name']);
$s3finishedurl = $urlthumb;
$status =0;
$issubscribed=0;
$stmt->bind_param("sssssii",$email,$phone,$filename,$s3rawurl,$s3finishedurl,$status,$issubscribed);

if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
printf("%d Row inserted.\n", $stmt->affected_rows);
$stmt->close();
$link->real_query("SELECT * FROM items");
$res = $link->use_result();
echo "Result set order...\n";
while ($row = $res->fetch_assoc()) {
    echo $row['id'] . " " . $row['email']. " " . $row['phone'];
}
$link->close();
// creating sns topic
$topicArn = $sns->createTopic([
'Name' => 'MP2-sns-test',
]);

echo "<p/>";
echo "ARN is:";
echo $topicArn['TopicArn'];

$topicAttributes = $sns->setTopicAttributes([
	'TopicArn' => $topicArn['TopicArn'],
	'AttributeName'=>'DisplayName',
	'AttributeValue'=>'MP2-alert',
	]);

echo "<p/>";
echo "Created display name";
if(isSubscribed($email)) {
	echo "</p> The email: ".$email." is already subscribed";
} else {
	$listedSubscriptions = $sns->listSubscriptions(array(
		//'NextToken' => 'string',
	));
	echo $listedSubscriptions;
	echo "</p> Subscriptions: ".$listedSubscriptions->get('Subscriptions');
	echo "</p> TopicArn: ".$listedSubscriptions->get('TopicArn');
	$topicSubscribe = $sns->subscribe(array(
		'TopicArn' => $topicArn['TopicArn'],
		'Protocol' => 'email',
		'Endpoint' => $email,
	));
	echo "<p/>";
	echo "Please check your email and confirm subsciption";
?>

<form enctype="multipart/form-data" action="subscription.php" method="POST">
    <input type="hidden" name="email" value="<?php echo $email; ?>">
	Please press this button after confirming mail subscription 
	<input type="submit" value="Confirm" />
</form>
</p></p>
<?php
}
$topicResult = $sns->publish(array(
    'TopicArn' => $topicArn['TopicArn'],
    'Message' => 'S3 bucket successfully created, raw url is '.$s3rawurl,
    'Subject' => 'Important-regarding S3',
));
echo "<p/>";
echo "Published email.Please check your email";
// add code to generate SQS Message with a value of the ID returned from the most recent inserted piece of work
include 'footer.php';
?>
















