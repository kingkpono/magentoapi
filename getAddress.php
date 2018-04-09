<?php

use Magento\Framework\App\Bootstrap;
require __DIR__ . '/../app/bootstrap.php';
$bootstrap = Bootstrap::create(BP, $_SERVER);
$obj = $bootstrap->getObjectManager();
$state = $obj->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');

  
 

$address_id =  trim($_REQUEST['address_id']);
 
// Create connection

 $resource = \Magento\Framework\App\ObjectManager::getInstance()
        ->get('Magento\Framework\App\ResourceConnection');
    $connection= $resource ->getConnection();
  

$responses=array();

//check if email exists
$sql = "SELECT cae.*,ce.email FROM   customer_address_entity cae,customer_entity ce  WHERE cae.entity_id='".$address_id."' AND cae.parent_id=ce.entity_id";


   $result= $connection->rawQuery($sql);

    $connection->closeConnection();

if($result->rowCount()>0){
     //$response["status"]=200;

     $response = array();
     foreach ($result as $key)
     {
        $response[] = $key;
     }
     echo json_encode($response);
     header("Content-type:application/json");
   
}else{

   
      $connection->closeConnection();

    $response["status"]=300;
  
 echo json_encode($response);
 header("Content-type:application/json");
}
 
?>
