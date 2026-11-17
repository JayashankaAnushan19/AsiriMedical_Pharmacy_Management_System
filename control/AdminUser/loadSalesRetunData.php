<?php
require_once __DIR__ . '/../../model/auth.php';
require_staff(); 
include('../../model/db_connection.php'); 

$id = $_POST['id'];

$Connection = setConnection();

$Date[0] = 0;

$selectInvoiceDate = "SELECT * FROM `tb_saleinvoiceitems` INNER JOIN `tb_inventory` ON `tb_saleinvoiceitems`.`SaleInvoiceItems_InventoryID` = `tb_inventory`.`Inventory_ID` INNER JOIN `tb_product` ON `tb_inventory`.`tb_Product_Product_ID` = `tb_product`.`Product_ID` INNER JOIN `tb_saleinvoice` ON `tb_saleinvoiceitems`.`tb_SaleInvoice_SaleInvoice_ID` = `tb_saleinvoice`.`SaleInvoice_ID` WHERE `tb_SaleInvoice_SaleInvoice_ID` = '$id' ";


$query = mysqli_query($Connection, $selectInvoiceDate); 
$records = mysqli_num_rows($query);

$InvComp = array();
$i = 0;
while($row = mysqli_fetch_assoc($query))
{
	$InvComp[$i][0] = $row['tb_SaleInvoice_SaleInvoice_ID'];
	$InvComp[$i][1] = $row['SaleInvoiceItems_InventoryID'];
	$InvComp[$i][2] = $row['SaleInvoice_Date'];
	$InvComp[$i][3] = $row['Product_ProductName'];
	$InvComp[$i][4] = $row['SaleInvoiceItems_UnitCost'];
	$InvComp[$i][5] = $row['SaleInvoiceItems_UnitSellingCost'];
	$InvComp[$i][6] = $row['SaleInvoiceItems_Qty'];
	$InvComp[$i][7] = "0";
	$InvComp[$i][8] = $row['SaleInvoice_CustomerNameorNIC'];
	$InvComp[$i][9] = 0;

	$selectReturn = "SELECT SUM(`tb_salesreturnitems`.`SalesReturnItems_ReturnQty`)  FROM `tb_salesreturn` INNER JOIN `tb_salesreturnitems` ON `tb_salesreturn`.`SalesReturn_ID` = `tb_salesreturnitems`.`tb_salesreturn_SalesReturn_ID` WHERE `tb_SaleInvoice_SaleInvoice_ID` = '".$row['tb_SaleInvoice_SaleInvoice_ID']."' AND `SalesReturnItems_InventoryID`= '".$row['SaleInvoiceItems_InventoryID']."' ";
 
	$Newquery = mysqli_query($Connection, $selectReturn);
	$records = mysqli_num_rows($Newquery); 
	if ($Newquery && $records > 0) { 
		while($row = mysqli_fetch_assoc($Newquery))
		{
			$InvComp[$i][9] = $row['SUM(`tb_salesreturnitems`.`SalesReturnItems_ReturnQty`)'];
			$Date[0] = 1;
		}
	}
	else{
		$InvComp[$i][9] = 0;
	}
	$i++;
}



$Date[1] = $InvComp;

echo json_encode($Date);

?>



<tr><th>No</th><th>Product</th><th>Import Qty</th><th>Already Return Qty</th><th>Current Stock Qty</th><th>Manufacture Date</th><th>Expire Date</th><th>Unit Cost (Rs.)</th><th>New Return Qty</th></tr>

