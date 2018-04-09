<?php

use Magento\Framework\App\Bootstrap;
require __DIR__ . '/../app/bootstrap.php';
$bootstrap = Bootstrap::create(BP, $_SERVER);
$obj = $bootstrap->getObjectManager();
$state = $obj->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');

  
 
$customer_id = $_REQUEST['customer_id'];
//$address_id =  trim($_GET['shipping']);
 
// Create connection

 $resource = \Magento\Framework\App\ObjectManager::getInstance()
        ->get('Magento\Framework\App\ResourceConnection');
    $connection= $resource ->getConnection();
  

$responses=array();

//check if email exists
$sql = "SELECT * FROM   customer_address_entity  WHERE parent_id='".$customer_id."'";


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

header("Access-Control-Allow-Origin: *"); 
     header("Content-type:application/json");
   
}else{

   


    $response["status"]=300;
  
 echo json_encode($response);
 header("Access-Control-Allow-Origin: *"); 

 header("Content-type:application/json");
}
 
?>
