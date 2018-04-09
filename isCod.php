<?php
ini_set('display_errors', 1);
use Magento\Framework\App\Bootstrap;
require __DIR__ . '/../app/bootstrap.php';
$bootstrap = Bootstrap::create(BP, $_SERVER);
$obj = $bootstrap->getObjectManager();
$state = $obj->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');
$resource = \Magento\Framework\App\ObjectManager::getInstance()
->get('Magento\Framework\App\ResourceConnection');
$connection= $resource ->getConnection();
  

$destState=trim($_REQUEST['state']);
$city=trim($_REQUEST['city']);


  $result = $connection->rawQuery('SELECT city FROM  state_city  WHERE  state=(SELECT default_name from directory_country_region where region_id='.$destState.')  AND  city like "%'.$city.'%" AND cod_type="cod"  LIMIT 1');


$response=array();
$response['isCod']="false";
$response['msg']=strtoupper($city)." is  not a Pay -On-Delivery location.";

foreach($result as $res)
{

$response['isCod']="true";

 
}
$connection->closeConnection();
  header('Content-Type: application/json');
echo json_encode($response,true);
?>