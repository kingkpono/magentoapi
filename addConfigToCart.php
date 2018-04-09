<?php
ini_set("display_errors",1);
use Magento\Framework\App\Bootstrap;

require __DIR__ . '/../app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);

$product_id=$_REQUEST['product_id'];
$quote_id=$_REQUEST['quote_id'];

$objectManager  = $bootstrap->getObjectManager();
$state = $objectManager->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');



$productRepository= $objectManager->get('Magento\Catalog\Api\ProductRepositoryInterface');
try {
    $product = $productRepository->getById($product_id);
} catch (NoSuchEntityException $e) {
    $product = null;
    $record['msg']='Item could not be added to cart';
}

$quoteRepository = $objectManager->get('\Magento\Quote\Api\CartRepositoryInterface');
$quote = $quoteRepository->get($quote_id);




try{
// Add configurable product to cart
$quote->addProduct($product, 
                    array( 'product_id' => $product->getId,
                              'qty' => 1,
                              'options' => array( "1018" =>"2378","1019"=>"2404" ));
// Save cart
$quote->save(); 
$record['msg']='Item succesfully added to cart';
 
   echo json_encode($record);

}catch(Exception $e){

 $record['msg']='Item could not be added to cart';
 
   echo json_encode($record);
}


?>