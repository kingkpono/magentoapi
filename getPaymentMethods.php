<?php
//ini_set("display_errors",2);
use Magento\Framework\App\Bootstrap;
require __DIR__ . '/../app/bootstrap.php';


$bootstrap = Bootstrap::create(BP, $_SERVER);
$obj = $bootstrap->getObjectManager();
$state = $obj->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');


 $resource = \Magento\Framework\App\ObjectManager::getInstance()
        ->get('Magento\Framework\App\ResourceConnection');
 $connection= $resource ->getConnection();

//get shipping info

$quote=trim($_REQUEST['quote_id']);
 $paymentMethods = [];
    $quote = $this->checkoutSession->getQuote();
    if ($quote->getIsVirtual()) {
        foreach ($this->paymentMethodManagement->getList($quote->getId()) as $paymentMethod) {
            $paymentMethods[] = [
                'code' => $paymentMethod->getCode(),
                'title' => $paymentMethod->getTitle()
            ];
        }
    }
    return $paymentMethods;


  $connection->closeConnection();
 header('Content-Type: application/json');
echo json_encode($shipping_response,true);
 

