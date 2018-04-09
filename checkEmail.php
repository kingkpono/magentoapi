<?php
ini_set('display_errors', 1);
use Magento\Framework\App\Bootstrap;
require __DIR__ . '/../app/bootstrap.php';
$bootstrap = Bootstrap::create(BP, $_SERVER);
$obj = $bootstrap->getObjectManager();
$state = $obj->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');

  

$email=trim($_REQUEST['email']);
$customer = $obj->create('Magento\Customer\Model\Customer');
$customer->setWebsiteId(1);

  $customer->loadByEmail($email);

        if ($customer->getId()) {
           $response["status"]=200;
        }else
        {
        	  $response["status"]=300;
        }
  
  header('Content-Type: application/json');
echo json_encode($response,true);
?>