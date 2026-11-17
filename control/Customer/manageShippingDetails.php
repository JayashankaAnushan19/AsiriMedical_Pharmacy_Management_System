<?php

include('HeadAndFooter/HeaderCus.php'); 

include('../../model/db_connection.php'); 
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

$Connection = setConnection();

if (isset($_POST["btnShippingData"])) 
{
	$Date = date("Y/m/d");
	$Name = $_POST["txtCusName"];
	$Tel = $_POST["txtTel"];
	$Email = $_POST["txtEmail"];
	$Address = $_POST["txtAddress"];


	$addOrderquery = "INSERT INTO `tb_onlinesellinvoices`(`OnlineSellInvoices_Date`, `OnlineSellInvoices_CustomerName`, `OnlineSellInvoices_BillingAddress`, `OnlineSellInvoices_Tel`, `OnlineSellInvoices_Email`, `OnlineSellInvoices_PymntStatus`, `OnlineSellInvoices_OrderStatus`,`OnlineSellInvoices_Active`) VALUES ('$Date','$Name','$Address','$Tel','$Email','0','0','1') ";

	$addOrderResult = mysqli_query($Connection, $addOrderquery);

	if ($addOrderResult)
	{
		$findOrderID = "SELECT * FROM `tb_onlinesellinvoices` WHERE `OnlineSellInvoices_CustomerName`='$Name' AND `OnlineSellInvoices_Date`='$Date' AND `OnlineSellInvoices_Email`='$Email' AND `OnlineSellInvoices_PymntStatus`=0 ORDER BY `OnlineSellInvoices_ID` DESC LIMIT 1";

		$findOrderIDResult = mysqli_query($Connection, $findOrderID);

		while($rowSell = mysqli_fetch_assoc($findOrderIDResult))
		{
			$OrderID = $rowSell['OnlineSellInvoices_ID'];
			$_SESSION['OrderID'] = $OrderID;
			// echo "<script type='text/javascript'>alert('OrderID: {$OrderID}')</script>";

			if (isset($_SESSION['CartArr']) &&  0 < sizeof($_SESSION['CartArr'])) 
			{
				$Cau = (is_numeric($_SESSION['cartID']) ? (int)$_SESSION['cartID'] : 0);
				$Cau++;

				for ($row = 0; $row < $Cau; $row++) {
					if (isset($_SESSION['CartArr'][$row])) 
					{
						$InvenID = $_SESSION['CartArr'][$row][0];
						$UnitCost = $_SESSION['CartArr'][$row][1];
						$SellCost = $_SESSION['CartArr'][$row][2];
						$Qty = $_SESSION['CartArr'][$row][3];
						$SaleInvoiceID = 0;
						$OnlineInvoiceID = $OrderID;


						$getCurrentQty = "SELECT * FROM `tb_inventory` WHERE `Inventory_ID` ='".$InvenID."' ";
						$QtyGettingExecute = mysqli_query($Connection, $getCurrentQty);

						while ($dataID = $QtyGettingExecute->fetch_assoc()) {
							$Item_CurrentQty =  $dataID['Inventory_CurrentQty'];
						}

						$itemSaveToSystem = "INSERT INTO `tb_saleinvoiceitems`(`SaleInvoiceItems_InventoryID`, `SaleInvoiceItems_UnitCost`, `SaleInvoiceItems_UnitSellingCost`, `SaleInvoiceItems_Qty`, `tb_SaleInvoice_SaleInvoice_ID`, `tb_OnlineSellInvoices_OnlineSellInvoices_ID`) VALUES ('".$InvenID."','".$UnitCost."','".$SellCost."','".$Qty."','".$SaleInvoiceID."','".$OnlineInvoiceID."')";


						if ( $Qty <= $Item_CurrentQty) 
						{
							if (mysqli_query($Connection, $itemSaveToSystem)) {
								$Item_NewQty =  $Item_CurrentQty - $Qty;

								$updateNewQtyOfTheInventory = "UPDATE `tb_inventory` SET `Inventory_CurrentQty`= '$Item_NewQty' WHERE `Inventory_ID` ='".$InvenID."' ";

								if (mysqli_query($Connection, $updateNewQtyOfTheInventory)) 
								{
									unset($_SESSION['CartArr'][$row]);
								}
								else{
									echo "Error ". mysqli_error($Connection);
								}
							}
							else
							{
								echo "Error ". mysqli_error($Connection);
							}
						}
					}
				}
				?>


				<style type="text/css">
					legend{
						margin-top: 10px;
						color: black;
						font-family: cursive;
						text-decoration: underline;
					}
					form fieldset #orderCusDetails
					{
						margin-left: 25%;
					}
					form fieldset legend
					{
						text-align: center;
					}
					.fieldName{
						margin-left: -30px;
					}
					[type="submit"]{
						float: right;
						margin-right: 40%;
					}
					#msg{
						margin-left: 15%;
						margin-right: 15%; 
						width: 70%;
						text-align: center;
					}
					.center {
						margin: auto;
						width: 50%;
						border: 1px solid green;
						padding: 10px;
					}
				</style>
				
				<form id="payment_form" name="payment_form" action="../../view/Customer/phpPaymentGateWay/payment_confirmation.php" method="post">
					<input type="hidden" name="access_key" value="645eaa0866f13e6db4db4ac07d1052e3">
					<input type="hidden" name="profile_id" value="EC28C876-BF71-4683-8601-7437754145FA">
					<input type="hidden" name="transaction_uuid" value="<?php echo uniqid() ?>">
					<input type="hidden" name="signed_field_names" value="access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency">
					<input type="hidden" name="unsigned_field_names">
					<input type="hidden" name="signed_date_time" value="<?php echo gmdate("Y-m-d\TH:i:s\Z"); ?>">
					<input type="hidden" name="locale" value="en">

					<input type="hidden" name="Customer Name" value="<?php echo (!empty($Name)) ? $Name : ''; ?>">
					<input type="hidden" name="Email" value="<?php echo (!empty($Email)) ? $Email : ''; ?>">
					<input type="hidden" name="Shipping Address" value="<?php echo (!empty($Address)) ? $Address : ''; ?>">
					<input type="hidden" name="Order Number" value="<?php echo (!empty($_SESSION['OrderID'])) ? $_SESSION['OrderID'] : ''; ?>" size="25" >
					<input type="hidden" name="Total Amount " size="25" value="<?php echo (!empty($_SESSION['Total'])) ? $_SESSION['Total'] : ''; ?>" >



					<input type="hidden" name="transaction_type" size="25" value="authorization" >
					<input type="hidden" name="reference_number" value="<?php echo (!empty($_SESSION['OrderID'])) ? $_SESSION['OrderID'] : ''; ?>" size="25" >
					<input type="hidden" name="amount" size="25" value="<?php echo (!empty($_SESSION['Total'])) ? $_SESSION['Total'] : ''; ?>" >
					<input type="hidden" name="currency" size="25" value="USD" >
					<label>Order Placed...</label>
					<input class="btn btn-success" style="display: block;" type="submit" id="submit" name="submit" value="Continue >>"/>
				</form>
				<script type="text/javascript">
					$("#payment_form").submit(function(){
						alert("Re-derect to Payment.");
					});
				</script>

				<?php  
			}
		}
	}
	else
	{
		echo "<script type='text/javascript'>alert('Order can not be processed. Please Contact system Admin.')</script>";
	}
}
?>  

<!-- Footer part Start from here -->
<?php include('HeadAndFooter/FooterCus.php'); ?>