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
	$change = (is_numeric($newData[$i][7]) ? (float)$newData[$i][7] : 0);
	if ($change > 0) {
		$apply = 0;
		$msg = "Focus to change";
	}
}

if ($apply == 0) {
	$msg = "Will be execeute";
	//save data in SalesRetu table > Take ID > with this Is save other data in SalesReturnItem Table
	
	// Save data in SalesReturn Table 
	$addSaleReturn = "INSERT INTO `tb_salesreturn`(`SalesReturn_Date`, `SalesReturn_Reason`, `SalesReturn_Active`, `tb_SaleInvoice_SaleInvoice_ID`, `tb_SaleInvoice_tb_Adminuser_user_ID`) VALUES ('".$date."','".$reason."',1,'".$newData[0][0]."','".$userID."')";

	// Take ID
	if (mysqli_query($Connection, $addSaleReturn)) {
		try
		{

			$TakeSaleRetunId = "SELECT `SalesReturn_ID` FROM `tb_salesreturn` WHERE `SalesReturn_Date`='$date' AND `tb_SaleInvoice_tb_Adminuser_user_ID`='$userID' ORDER BY `SalesReturn_ID` DESC LIMIT 1";
			$SalesRetunIDExecuteResult = mysqli_query($Connection, $TakeSaleRetunId);
			while ($row = $SalesRetunIDExecuteResult->fetch_assoc()) {
				$SaleRetunID =  $row['SalesReturn_ID'];
				$msg = "ID found";
				echo json_encode($msg);
			}


			for ($i=0; $i < sizeof($newData); $i++) { 

				//With this ID, save other data in SalesReturnItem Table
				$addItemByItem = "INSERT INTO `tb_salesreturnitems`( `SalesReturnItems_InventoryID`, `SalesReturnItems_UnitCostPrice`, `SalesReturnItems_UnitSellingPrice`, `SalesReturnItems_ReturnQty`, `tb_salesreturn_SalesReturn_ID`) VALUES ('".$newData[$i][1]."','".$newData[$i][4]."','".$newData[$i][5]."','".$newData[$i][7]."','".$SaleRetunID."')";

				$msg = "Added item";
				echo json_encode($msg);

				//Get current Qty
				$getCurrentQty = "SELECT * FROM `tb_inventory` WHERE `Inventory_ID` ='".$newData[$i][1]."' ";
				$QtyGettingExecute = mysqli_query($Connection, $getCurrentQty);

				while ($dataID = $QtyGettingExecute->fetch_assoc()) {
					$msg = "Got Current Qty";
					echo json_encode($msg);
					$Item_CurrentQty =  $dataID['Inventory_CurrentQty'];
				}
				$Item_NewQty =  $Item_CurrentQty + $newData[$i][7];

				//Update new qty of Inventory
				$updateNewQtyOfTheInventory = "UPDATE `tb_inventory` SET `Inventory_CurrentQty`= '$Item_NewQty' WHERE `Inventory_ID` ='".$newData[$i][1]."' ";

				if (mysqli_query($Connection, $addItemByItem)) 
				{
					$msg = "Added Items";
					echo json_encode($msg);
					if (mysqli_query($Connection, $updateNewQtyOfTheInventory)) 
					{
						$msg = "New Qty updated";
						$result = " Done";
						// echo json_encode($result);
						echo json_encode($msg);
					}
				}
			}

		}
		catch (exception $ex)
		{
			echo 'Caught exception: ', $ex -> getMessage(), "\n";
		}
	}
}
else{
	echo json_encode($msg);
}
?>