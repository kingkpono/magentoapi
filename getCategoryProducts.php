<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
use Magento\Framework\App\Bootstrap;

require __DIR__ . '/../app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);
$id=$_REQUEST['id'];

$obj = $bootstrap->getObjectManager();

$state = $obj->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');
$storeManager = $obj->get('\Magento\Store\Model\StoreManagerInterface');
$base_url=$storeManager->getStore()->getBaseUrl();
$_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
$object_manager = $_objectManager->create('Magento\Catalog\Model\Category')->load($id)->getProductCollection()->addAttributeToSelect('*')->setPageSize(15);


  $products=array();
                    foreach ($object_manager as $product) :
                    $record=array();
                    $record['image_path']=$base_url.'pub/media/catalog/product'.$product->getImage();
                    $record['name']=$product->getName();
                    $record['price']=intval($product->getPrice());
                    $record['sku']=$product->getSku();
                    $record['id']=$product->getId();
                               $products[]=$record;
                               endforeach;
   header('Content-Type: application/json');                            
   echo json_encode($products);
 

?>
