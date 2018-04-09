<?php
//ini_set("display_errors",2);
use Magento\Framework\App\Bootstrap;
require __DIR__ . '/../app/bootstrap.php';


$bootstrap = Bootstrap::create(BP, $_SERVER);
$obj = $bootstrap->getObjectManager();
$state = $obj->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');
$quote_id=trim($_REQUEST['quote_id']);

 //$helper = $obj->get('Yudala\Stepcheckout\Helper\Getpaymentmethods');
//$methods=$helper->getPaymentmethods($quote_id);

$methods=array(
array("code"=>"cashondelivery","title"=>"Pay On Delivery"),
array("code"=>"banktransfer","title"=>"Bank Transfer"),
array("code"=>"etranzact","title"=>"Etranzact"),
  array("code"=>"mastercard_paystack","title"=>"Mastercard Only " ),
array("code"=>"profibro_paystack","title"=>"Debit/Credit Card" ),
array("code"=>"checkmo","title"=>"Pay at Yudala Store")
);

 header('Content-Type: application/json');
echo json_encode($methods,true);


 

