<?php
$servername = "162.13.77.157";
$username = "root";
$password = "ohdaix6quohsohmaaf7aiR";

$dbname = "yudala_ent_final";

$code=trim($_GET['code']);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "select src.code,sr.name,sr.discount_amount, src.times_used,src.expiration_date,src.created_at from yudala_ent_final.salesrule_coupon src,yudala_ent_final.salesrule sr WHERE sr.rule_id=src.rule_id AND code='".$code."'";
$result = $conn->query($sql);
$rows=array();
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	$rows[]=$row;
     }
 }  else{
 	echo "<h4 align='center'>Invalid Coupon Code </h4>";
 	exit;
 } 
?>


<style type="text/css">
	.TFtable{
		width:100%; 
		border-collapse:collapse; 
	}
	.TFtable th{ 
		padding:7px; color:#fff; border:#4e95f4 1px solid;
	}
	.TFtable td{ 
		padding:7px; border:#4e95f4 1px solid;
	}
	/* provide some minimal visual accomodation for IE8 and below */
	.TFtable tr{
		background: #e90b8d;
	}
	/*  Define the background color for all the ODD background rows  */
	.TFtable tr:nth-child(odd){ 
		background: #e90b8d;
	}
	/*  Define the background color for all the EVEN background rows  */
	.TFtable tr:nth-child(even){
		background: #dae5f4;
	}
</style>


<?php
  echo "<h2 style='text-align:center;'>Coupon Code Verfication</h2>";
  echo "<table class='TFtable'>";
  echo "<tr><th>Code</th><th>Label</th><th> Coupon Amount</th><th>Usage</th><th>Expires</th><th>Date Created</th></tr>";
foreach ($rows as $row) {
   echo "<tr>";
   foreach ($row as $column) {

      echo "<td>$column</td>";
   }
   echo "</tr>";
}    
echo "</table>";


?>