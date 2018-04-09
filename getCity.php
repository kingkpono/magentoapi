<?php

use Magento\Framework\App\Bootstrap;
require __DIR__ . '/../app/bootstrap.php';
$bootstrap = Bootstrap::create(BP, $_SERVER);
$obj = $bootstrap->getObjectManager();
$state = $obj->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');

$state_id = trim($_REQUEST['state']);
 // Create connection

$resource = \Magento\Framework\App\ObjectManager::getInstance()
        ->get('Magento\Framework\App\ResourceConnection');
    $connection= $resource ->getConnection();
  

$responses=array();

$sql = "select * from directory_country_city where region_code=(SELECT code from directory_country_region where region_id='".$state_id."')";


 $result= $connection->rawQuery($sql);
 $connection->closeConnection();

 foreach ($result as $rest)
 {
 	$response = array();
 	$response['region_id'] = $rest['id'];
 	$response['default_name'] = $rest['default_name'];
 	$responses[] = $response;
 }
 header("Content-type:application/json");
 echo json_encode($responses);




 
?>
