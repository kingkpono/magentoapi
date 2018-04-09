<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
use Magento\Framework\App\Bootstrap;


require __DIR__ . '/../app/bootstrap.php';


$mage_bootstrap = Bootstrap::create(BP, $_SERVER);
$object_manager = $mage_bootstrap->getObjectManager();
 
// add ustomer email
$customer_email = trim($_REQUEST['email']);
// echo $customer_email;
 
// Get object manager
$object_manager = \Magento\Framework\App\ObjectManager::getInstance();
 
 
$mage_url = \Magento\Framework\App\ObjectManager::getInstance();
$storeManager = $mage_url->get('\Magento\Store\Model\StoreManagerInterface');
$state_val = $object_manager->get('\Magento\Framework\App\State');
$state_val->setAreaCode('frontend');
 
// Get website id
$website_id = $storeManager->getWebsite()->getWebsiteId();
 
$store = $storeManager->getStore();
// Get Store ID
$store_id = $store->getStoreId();
 
$customer_factory = $object_manager->get('\Magento\Customer\Model\CustomerFactory');
$customer_data = $customer_factory->create();
 
$customer_data->setWebsiteId($website_id);
$customer_data->loadByEmail($customer_email);
// load customer by email address
// echo customer id 
// Magento 2 Get Customer name
// echo $customer_data->getFirstname();
// echo $customer_data->getLastname();
// echo $customer_data->getEmail();
 
 
 
//$customer_data->load('1');
 
// load customer by email address
$data = $customer_data->getData();
 
//$customer_id = $data['entity_id'];

//echo $customer_id;
header('Content-Type: application/json');
echo json_encode($data);
