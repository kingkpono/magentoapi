<?php 
use Magento\Framework\App\Bootstrap;
require __DIR__ . '/../app/bootstrap.php';
require 'token.php';
$bootstrap = Bootstrap::create(BP, $_SERVER);
$obj = $bootstrap->getObjectManager();
$state = $obj->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');
$storeManager = $obj->get('\Magento\Store\Model\StoreManagerInterface');
$base_url=$storeManager->getStore()->getBaseUrl();
  $websiteId = $storeManager->getWebsite()->getWebsiteId();


$customerFactory = $obj->get('\Magento\Customer\Model\CustomerFactory'); 
    $customer=$customerFactory->create();
    $customer->setWebsiteId($websiteId);


$data = json_decode(file_get_contents('php://input'), true);

$username=$data['username'];
$password=$data['password'];



$body='{
    "username": "'.$username.'",
  "password": "'.$password.'"
}';
$url= $base_url.'rest/default/V1/integration/customer/token';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch,CURLOPT_POSTFIELDS, $body);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json',
'Authorization: Bearer '.$token
)
);
$response= json_decode(curl_exec($ch));
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$api_response=[];
$api_response['status_code']=$httpcode;

if($httpcode==200){
$api_response['token']=$response;
 $customer->loadByEmail($username);// load customer by email address
    $data= $customer->getData();
    $api_response['firstname']=$data['firstname'];
    $api_response['id']=$data{'entity_id'};

    }
else
{
	$api_response['message']=$response->{'message'};
}


    
   


header('Access-Control-Allow-Origin: *'); 
header('Content-Type: application/json');

echo json_encode($api_response);
?>