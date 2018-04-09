<?php

use Magento\Framework\App\Bootstrap;

require __DIR__ . '/../app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);


$objectManager = $bootstrap->getObjectManager();
$url = \Magento\Framework\App\ObjectManager::getInstance();
$storeManager = $url->get('\Magento\Store\Model\StoreManagerInterface');
$mediaurl= $storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
$state = $objectManager->get('\Magento\Framework\App\State');
$state->setAreaCode('frontend');
// Customer Factory to Create Customer
$customerFactory = $objectManager->get('\Magento\Customer\Model\CustomerFactory');
$websiteId = $storeManager->getWebsite()->getWebsiteId();



$email=$_REQUEST['email'];
$fname=$_REQUEST['fname'];
$lname=$_REQUEST['lname'];
$country_id='NG';
$region_id=$_REQUEST['region_id'];
$city=$_REQUEST['city'];
$tel=$_REQUEST['tel'];
$street=$_REQUEST['street'];





/// Get Store ID
$store = $storeManager->getStore();
$storeId = $store->getStoreId();

// Instantiate object (this is the most important part)
$customer = $customerFactory->create();
$customer->setWebsiteId($websiteId);

// Preparing data for new customer
$password = md5(uniqid(rand(1,6)));


$customer->setEmail($email);
$customer->setFirstname($fname);
$customer->setLastname($lname);
$customer->setPassword($password);

try{
// Save data
$customer->save();

// Add Address For created customer
$addresss = $objectManager->get('\Magento\Customer\Model\AddressFactory');
$address = $addresss->create();

$address->setCustomerId($customer->getId())
->setFirstname($fname)
->setLastname($lname)
->setCountryId($country_id)
->setRegionId($region_id) //state/province, only needed if the country is USA

->setCity($city)
->setTelephone($tel)
->setFax('234')
->setPostcode('31000')
->setStreet($street)
->setIsDefaultBilling('1')
->setIsDefaultShipping('1')
->setSaveInAddressBook('1');


 $response['status']=200;
  
  $response['customer_id']=$customer->getId();
  $response['message']= 'Succesfully created customer';
    $response['password']= $password;

try{
$address->save();
 $response['id']=$address->getId();
}
catch (Exception $e) {
Zend_Debug::dump($e->getMessage());
 $response['status']=300;
  $response['message']= $e->getMessage();
}
}
catch(Exception $e)
{

$response['status']=300;
  $response['message']= $e->getMessage();

}




header("Content-type:application/json");
echo json_encode($response);