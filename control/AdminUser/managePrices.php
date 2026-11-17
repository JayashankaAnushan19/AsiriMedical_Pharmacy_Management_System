<?php
require_once __DIR__ . '/../../model/auth.php';
require_staff(); 
include('../../model/db_connection.php'); 

// Main Category Manage
if (isset($_POST["invenID"])) {
	$ID = $_POST["invenID"];
	$Price = $_POST["inputValue"];

	if (!empty($ID)) {
		try{
			echo "<script type='text/javascript'> console.log('Its came');</script>";
			runQuary("UPDATE `tb_inventory` SET `Inventory_UnitSellingPrice`='$Price' WHERE `Inventory_ID`= '$ID'","Price Updated Successfully !!!");

		}
		catch(Exception $e) {
			echo "<script type='text/javascript'>alert('Error Occured.')</script>";
		}
	}

}


?>

