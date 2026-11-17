<?php
require_once __DIR__ . '/../../model/auth.php';
require_staff(); 
include('../../model/db_connection.php'); 

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

$reason = $_POST['reason'];
$data = $_POST['data'];
$apply = -1;
date_default_timezone_set('Asia/Colombo'); 
$date = date("Y/m/d");
$userID = $_SESSION["UserId"];

$Connection = setConnection();

$newData = array();

$msg = "Not happen anything";

for ($i=0; $i < sizeof($data); $i++) { 
	for ($j=0; $j < sizeof($data[$i]); $j++) { 
		$newData[$i][$j] = $data[$i][$j];
	}
	$change = (is_numeric($newData[$i][13]) ? (float)$newData[$i][13] : 0);
	if ($change > 0) {
		$apply = 0;
		$msg = "Focus to change";
	}
}

if ($apply == 0) {
	$msg = "Will be execeute";
	//save data in SalesRetu table > Take ID > with this Is save other data in SalesReturnItem Table
	
	// Save data in SalesReturn Table 
	$addPurchaseReturn = "INSERT INTO `tb_purchasereturn`(`PurchaseReturn_Date`, `PurchaseReturn_InvoiceNumber`, `PurchaseReturn_Reason`, `tb_Purchase_Purchase_ID`, `tb_Purchase_tb_user_user_ID`) VALUES ('".$date."','".$newData[0][14]."','".$reason."','".$newData[0][0]."','".$userID."')";

	if (mysqli_query($Connection, $addPurchaseReturn)) {
		for ($i=0; $i < sizeof($newData); $i++) { 

		//With this ID, save other data in SalesReturnItem Table
			$updateItemByItem = "UPDATE `tb_inventory` SET `Inventory_ReturnQty`= (`Inventory_ReturnQty` + '".$newData[$i][13]."') , `Inventory_CurrentQty`= (`Inventory_CurrentQty` - '".$newData[$i][13]."')  WHERE `Inventory_ID`= '".$newData[$i][1]."'";		


			$msg = "Added item";

			if (mysqli_query($Connection, $updateItemByItem)){
				echo json_encode($msg);
			}

			echo json_encode($msg);
		}
	}
}
else{
	echo json_encode($msg);
}
?>