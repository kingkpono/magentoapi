<?php

use Magento\Framework\App\Bootstrap;
require __DIR__ . '/../app/bootstrap.php';
$bootstrap = Bootstrap::create(BP, $_SERVER);
$obj = $bootstrap->getObjectManager();
$state = $obj->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');

 // Create connection

$resource = \Magento\Framework\App\ObjectManager::getInstance()
        ->get('Magento\Framework\App\ResourceConnection');
    $connection= $resource ->getConnection();
  

$responses=array();

//check if email exists
$sql = "SELECT * from directory_country_region where country_id='NG'";


 $result= $connection->rawQuery($sql);
 foreach ($result as $rest)
 {
 	$response = array();
 	$response['region_id'] = $rest['region_id'];
 	$response['default_name'] = $rest['default_name'];
 	$responses[] = $response;
 }

  echo json_encode($responses);
  header("Content-type:application/json");


 
?>
