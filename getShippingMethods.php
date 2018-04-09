<?php

use Magento\Framework\App\Bootstrap;
require __DIR__ . '/../app/bootstrap.php';
$bootstrap = Bootstrap::create(BP, $_SERVER);
$obj = $bootstrap->getObjectManager();
$state = $obj->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');

//get shipping info
$quote_id=trim($_REQUEST['quote_id']);
$address_id=trim($_REQUEST['address_id']);

$payload='{
  "addressId": '.$address_id.'
}';

$storeManager = $obj->get('\Magento\Store\Model\StoreManagerInterface');
$base_url=$storeManager->getStore()->getBaseUrl();

$url=$base_url.'rest/V1/carts/mine/estimate-shipping-methods-by-address-id?cart_id='.$quote_id;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch,CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                        
  'Content-Type: application/json',                                                                           
    'Authorization: Bearer 5g4citwif1fc6s1x077unxe5cpawfglo')                                                                       
);    


$shipping_response=json_decode(curl_exec($ch)); 

curl_close($ch);
$responses=[];

foreach($shipping_response as $response)
{

	$response2=[];
	 $response2["method_code"]=$response->{'method_code'};
	 $response2["method_title"]=$response->{'method_title'};
	  $response2["amount"]=$response->{'amount'};
	  $response2["error_message"]=$response->{'error_message'};
	

	//$response["method_title"]=$response->method_title;
	$responses[]=$response2;
}


if(count($responses)==0)
{
	$response2=[];
	 $response2["method_code"]="yucarrier";
	 $response2["method_title"]="Yucarrier";
	  $response2["amount"]=500;
	  $response2["error_message"]="";
	
	$responses[]=$response2;

	$response2=[];
	 $response2["method_code"]="flatrate";
	 $response2["method_title"]="Pickup at Yudala Store";
	  $response2["amount"]=150;
	  $response2["error_message"]="";
	
	$responses[]=$response2;
}

 header('Content-Type: application/json');
echo json_encode($responses,true);
 

