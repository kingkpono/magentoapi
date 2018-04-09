<?php
//ini_set("display_errors",2);
use Magento\Framework\App\Bootstrap;
require __DIR__ . '/../app/bootstrap.php';
$bootstrap = Bootstrap::create(BP, $_SERVER);
$obj = $bootstrap->getObjectManager();
$state = $obj->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');
$storeManager = $obj->get('\Magento\Store\Model\StoreManagerInterface');
$base_url=$storeManager->getStore()->getBaseUrl();
$resource = \Magento\Framework\App\ObjectManager::getInstance()
->get('Magento\Framework\App\ResourceConnection');
$connection= $resource ->getConnection();

$contents= $connection->rawQuery("SELECT banner_id, name, click_url, image  
FROM magestore_bannerslider_banner");
$responses=[];


foreach($contents as $content){

	$reponse=[];
	$response['banner_id']=$content['banner_id'];
	$response['name']=$content['name'];
	$response['click_url']=$content['click_url'];
	$response['image']=$base_url.'pub/media/'.$content['image'];
	$responses[]=$response;

}



$connection->closeConnection();
array_values($responses);


header('Content-Type: application/json');
echo json_encode($responses);