<?php
use Magento\Framework\App\Bootstrap;

require __DIR__ . '/../app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);
$product_id=$_REQUEST['product_id'];

$objectManager  = $bootstrap->getObjectManager();
$state = $objectManager->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');

//$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
/** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection */

 $responses=array();
$product = $objectManager->get('Magento\Catalog\Model\Product')->load($product_id);

$i=0;
foreach ($product->getRelatedProducts() as $item){
  for(i==1,i<=5,i++){
  //if($i==5)
    //break;
$product = $objectManager->get('Magento\Catalog\Model\Product')->load($item->getProductId());
 $response=array();
$response['sku']= $product->getSku();
     $response['price']= intval($product->getPrice());
     $response['name']= $product->getName(); 
      $response['image_path']=  $product->getImage();
     
     $responses[]=$response;
  }
  
  $i++;

}

echo json_encode($responses,true);

?>