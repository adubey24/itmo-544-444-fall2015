<?php
// Include the SDK using the Composer autoloader
require 'vendor/autoload.php';
use Aws\Sns\SnsClient;
$sns = SnsClient::factory(array(
'version' => 'latest',
'region' => 'us-east-1'
));
$topicArn = $sns->createTopic([
'Name' => 'MP2-SNS-test',
]);
echo $topicArn;
$topicAttributes = $sns->setTopicAttributes([
'AttributeName'=>'DisplayName',
'AttributeValue'=>'MP2-SNS-Display',
'topicArn'=>$topicResult->get($topicArn['Name']),
]);
