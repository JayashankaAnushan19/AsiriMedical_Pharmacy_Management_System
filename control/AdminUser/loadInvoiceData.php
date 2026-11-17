<?php
require_once __DIR__ . '/../../model/auth.php';
require_staff(); 
include('../../model/db_connection.php'); 


if( isset($_POST['invicID'] ) )
{
	$Arr = array();

	$invicID = $_POST['invicID'];

	$Connection = setConnection();


	$selectInvoiceDate = "SELECT * FROM `tb_purchase` INNER JOIN `tb_company` ON `tb_purchase`.`tb_Company_Company_ID` = `tb_company`.`Company_ID`WHERE `Purchase_InvoiceNumber` = '$invicID' ";

	$query = mysqli_query($Connection, $selectInvoiceDate); 

	while($row = mysqli_fetch_assoc($query))
	{
		$InvComp[0] = $invicID;
		$InvComp[1] = $row['Purchase_ID'];
		$InvComp[2] = $row['Company_Name'];
		$InvComp[3] = $row['Purchase_InvoiceDate'];

	}

	$AllINVIds = "SELECT `Inventory_ID` FROM `tb_inventory` WHERE `Inventory_InvoiceNumber` = '$invicID' ";

	$query = mysqli_query($Connection, $AllINVIds);

	while($Inventrow = mysqli_fetch_assoc($query))
	{
		$InvenIDs[] = $Inventrow['Inventory_ID'];

	}

	$TotalAmount = 0;

	for ($i=0; $i < sizeof($InvenIDs) ; $i++) { 

		$FindTotal = "SELECT * FROM `tb_inventory` WHERE `Inventory_ID` = '$InvenIDs[$i]' ";

		$query = mysqli_query($Connection, $FindTotal);

		while($InventrowDetails = mysqli_fetch_assoc($query))
		{	
			$UnitCost = (is_numeric($InventrowDetails['Inventory_UnitCost']) ? (float)$InventrowDetails['Inventory_UnitCost'] : 0);
			$ImprtQty = (is_numeric($InventrowDetails['Inventory_ImportQty']) ? (float)$InventrowDetails['Inventory_ImportQty'] : 0);
			$ReturnQty = (is_numeric($InventrowDetails['Inventory_ReturnQty']) ? (float)$InventrowDetails['Inventory_ReturnQty'] : 0);
			$TtlQty = $ImprtQty - $ReturnQty;
			$SubTtl = $UnitCost * $TtlQty;
			$TotalAmount += $SubTtl;

		}
	}

	$InvComp[4] = $TotalAmount;


	$FindPaidTotal = "SELECT SUM(`Payment_Amount`) FROM `tb_payment` WHERE `Payment_InvoiceNumber` = '$invicID' ";

	$query = mysqli_query($Connection, $FindPaidTotal);

	while($TotalPymntRow = mysqli_fetch_assoc($query))
	{
		$TotalPymnt = $TotalPymntRow['SUM(`Payment_Amount`)'];
	}

	if (empty($TotalPymnt) || !is_numeric($TotalPymnt)) {
		$TotalPymnt = 0;
	}

	$TotalPayable = $TotalAmount - $TotalPymnt;

	$InvComp[5] = $TotalPayable;

	// print_r($InvComp);

	echo json_encode($InvComp);
} 
?>