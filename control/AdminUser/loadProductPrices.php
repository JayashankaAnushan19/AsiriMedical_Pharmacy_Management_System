<?php 
include('../../model/db_connection.php'); 
// print_r($_POST);


if( isset($_POST['prdctID'] ) )
{

	$prdctID = $_POST['prdctID'];

	$Connection = setConnection();


	$selectdata = "SELECT * FROM `tb_inventory` WHERE `Inventory_CurrentQty` > 0 AND `tb_Product_Product_ID` = '$prdctID' ";

	$query = mysqli_query($Connection, $selectdata);

	while($row = mysqli_fetch_assoc($query))
	{
		echo "<option value=".$row['Inventory_ID'].">" .$row['Inventory_UnitSellingPrice']."</option>";
	}

} 
 ?>