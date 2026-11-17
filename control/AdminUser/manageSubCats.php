<?php 
include('../../model/db_connection.php'); 
// print_r($_POST);


if( isset($_POST['mainCatID'] ) )
{

	$mainCatID = $_POST['mainCatID'];

	$Connection = setConnection();


	$selectdata = " SELECT * FROM `tb_subcategory` WHERE `tb_MainCategory_MainCategory_ID` = '$mainCatID' ";

	$query = mysqli_query($Connection, $selectdata);

	while($row = mysqli_fetch_assoc($query))
	{
		echo "<option value=".$row['SubCategory_ID'].">".$row['SubCategory_ID']. " | " .$row['SubCategory_Name']."</option>";
	}

} 
 ?>

