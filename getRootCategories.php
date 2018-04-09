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

$contents= $connection->rawQuery("SELECT DISTINCT cce.entity_id AS id ,ccev.value AS name FROM catalog_category_entity cce, catalog_category_entity_varchar ccev WHERE cce.entity_id=ccev.entity_id AND level=2 and ccev.attribute_id=45");
$responses=[];

foreach($contents as $content){

	$reponse=[];
	$response['id']=$content['id'];
	$response['name']=$content['name'];
	$responses[]=$response;

}



$connection->closeConnection();
array_values($responses);


header('Content-Type: application/json');
echo json_encode($responses);;