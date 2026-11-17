<?php
require_once __DIR__ . '/../../model/auth.php';
require_staff(); 
include('../../model/db_connection.php'); 

$id = $_POST['id'];

$Connection = setConnection();

$selectInvoiceDate = "SELECT * FROM `tb_purchase` INNER JOIN `tb_inventory` ON `tb_purchase`.`Purchase_ID` = `tb_inventory`.`tb_Purchase_Purchase_ID` INNER JOIN `tb_agent` ON `tb_purchase`.`Purchase_Agent` = `tb_agent`.`Agent_ID` INNER JOIN `tb_product` ON `tb_inventory`.`tb_Product_Product_ID` = `tb_product`.`Product_ID` INNER JOIN `tb_company` ON `tb_purchase`.`tb_Company_Company_ID` = `tb_company`.`Company_ID` WHERE `tb_purchase`.`Purchase_ID` = '$id' ";


$query = mysqli_query($Connection, $selectInvoiceDate); 
$records = mysqli_num_rows($query);

$InvComp = array();
$i = 0;
while($row = mysqli_fetch_assoc($query))
{
	$InvComp[$i][0] = $row['Purchase_ID'];
	$InvComp[$i][1] = $row['Inventory_ID'];
	$InvComp[$i][2] = $row['Purchase_InvoiceDate'];
	$InvComp[$i][3] = $row['Product_ProductName'];	
	$InvComp[$i][4] = number_format((float)$row['Inventory_UnitCost'], 2, '.', '');
	$InvComp[$i][5] = $row['Inventory_UnitSellingPrice'];
	$InvComp[$i][6] = $row['Inventory_ImportQty'];
	$InvComp[$i][7] = $row['Inventory_ReturnQty'];  
	$InvComp[$i][8] = $row['Inventory_ManufactureDate'];
	$InvComp[$i][9] = $row['Inventory_ExpireDate'];
	$InvComp[$i][10] = $row['Company_Name'];
	$InvComp[$i][11] = $row['Agent_Name'];
	$InvComp[$i][12] = $row['Inventory_CurrentQty'];
	$InvComp[$i][13] = 0;
	$InvComp[$i][14] = $row['Purchase_InvoiceNumber'];

	$i++;
}


echo json_encode($InvComp);

?>