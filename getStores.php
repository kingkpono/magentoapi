<?php

use Magento\Framework\App\Bootstrap;
require __DIR__ . '/../app/bootstrap.php';
$bootstrap = Bootstrap::create(BP, $_SERVER);
$obj = $bootstrap->getObjectManager();
$state = $obj->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');

  
 
$region = trim($_REQUEST['state']);

    
 
// Create connection

 $resource = \Magento\Framework\App\ObjectManager::getInstance()
        ->get('Magento\Framework\App\ResourceConnection');
    $connection= $resource ->getConnection();
  



//check if email exists
$sql = "select storelocator_id,store_name,address,email,phone,city,state,longitude,latitude from magestore_storelocator_store where state='".$region."'";


   $result= $connection->rawQuery($sql);
   $responses=[];
  
if($result->rowCount()>0){
      $status=200;

    
     foreach ($result as $key)
     {
        $responses[] = $key;
     }
     
     
   
}else{

 
    $status=300;
 

}
     $data=[];

   $data["stores"]=array_values($responses);
    $data["status"]=$status;

   header("Content-type:application/json");
  
 echo json_encode($data);
 
?>
