<?php

 //ini_set("display_errors",2);
use Magento\Framework\App\Bootstrap;
require __DIR__ . '/../app/bootstrap.php';


$bootstrap = Bootstrap::create(BP, $_SERVER);
$obj = $bootstrap->getObjectManager();
$state = $obj->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');


$storeManager = $obj->get('\Magento\Store\Model\StoreManagerInterface');
$base_url=$storeManager->getStore()->getBaseUrl();

$quote_id=trim($_REQUEST['quote_id']);

 $resource = \Magento\Framework\App\ObjectManager::getInstance()
        ->get('Magento\Framework\App\ResourceConnection');
    $connection= $resource ->getConnection();
  

   $items= $connection->rawQuery("SELECT item_id,product_id,name,qty,price 
    FROM quote_item WHERE quote_id=".$quote_id);


   //update PRICES in DB
   foreach($items as $item){
   	$product = $obj->get('Magento\Catalog\Model\Product')->load($item['product_id']);
    
if(intval($product->getSpecialPrice())>0){

  //update
	    $price=$product->getSpecialPrice();
	 $connection->query("UPDATE  quote_item SET price=".$price." WHERE item_id=".$item['item_id']);

  }
else{
	   $price=$product->getPrice();
 $connection->query("UPDATE  quote_item SET price=".$price." WHERE item_id=".$item['item_id']);
  }
  
   }



   $items= $connection->rawQuery("SELECT item_id,product_id,name,qty,price 
    FROM quote_item WHERE quote_id=".$quote_id);

   
      $responses=array();
       $product_id=0;
       $subtotal=0;
       
   foreach($items as $item)
       {

        if(intval($item['price'])>0)
        {
  
 
     

      $response['item_id']=$item['item_id'];
      $name=$item['name'];
      $name=str_replace('"', "",$name);
      $name=str_replace("'", "", $name);
      $response['name']=$name;
      $response['qty']=intval($item['qty']);
      $response['price']=intval($item['price']);
       $item_total=intval($item['price'])*$item['qty'];
       $response['item_total']=$item_total;
       $product_id=$item['product_id'];

     //get image path

   $pathRes= $connection->rawQuery("select value from catalog_product_entity_varchar where attribute_id=84 and entity_id=".$product_id);
   $basePath='';
   foreach ($pathRes as  $path) {
     $basePath=$path['value'];
   }

     
   $imageUrl=$base_url."pub/media/catalog/product". $basePath;
     $response['image_path']=$imageUrl;
   

        $responses[]=$response;
      }
      
       }
     
 
   $coupon_code="";
   $result= $connection->rawQuery("SELECT coupon_code,subtotal_with_discount,subtotal,grand_total  FROM quote q WHERE entity_id=".$quote_id);
    foreach ($result as  $res)
   {
      if($res['coupon_code']!='')
       {
      
        $data['coupon_code']=$res['coupon_code'];
          $coupon_code=$res['coupon_code'];
       
       }
        
         $data['subtotal']=$res['subtotal'];

        $data['grand_total']=$res['grand_total'];

   } 

    if($coupon_code!=null && $coupon_code!="")
    {
         
   $result= $connection->rawQuery("select sr.discount_amount,sr.name  from salesrule_coupon src,salesrule sr WHERE src.code='".$coupon_code."' AND sr.rule_id=src.rule_id" );
    foreach ($result as  $res)
    {
       $data['coupon_name']=$res['name'];
       $data['discount_amount']=$res['discount_amount'];
         
    }

     
     }
       
     $connection->closeConnection();

   $data["items"]=array_values($responses);
    
    

header('Content-Type: application/json');
echo json_encode($data);
 
 