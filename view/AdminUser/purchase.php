<?php 
include('../../control/AdminUser/HeadAndFooter/header.php'); 
include('../../model/db_connection.php'); 
?>

<style type="text/css">
	.autocomplete {
		/*the container must be positioned relative:*/
		position: relative;
		display: inline-block;
	}
	.autocomplete-items {
		position: absolute;
		border: 1px solid #d4d4d4;
		border-bottom: none;
		border-top: none;
		z-index: 99;
		/*position the autocomplete items to be the same width as the container:*/
		top: 100%;
		left: 0;
		right: 0;
	}
	.autocomplete-items div {
		padding: 10px;
		cursor: pointer;
		background-color: #fff;
		border-bottom: 1px solid #d4d4d4;
	}
	.autocomplete-items div:hover {
		/*when hovering an item:*/
		background-color: #e9e9e9;
	}
	.autocomplete-active {
		/*when navigating through the items using the arrow keys:*/
		background-color: DodgerBlue !important;
		color: #ffffff;
	}
</style>





<?php 
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

if (isset($_GET['act'])) {
	if ($_GET['act']=='RemSes' && isset($_SESSION['Item_List'])) {

		// echo "Got Data||| {$_GET['act']} | {$_GET['id']}";
		// $RemSesID = $_GET['id'];
		// $SessionItemList = $_SESSION['Item_List'];
		// $Arrr = $SessionItemList["{$RemSesID}"];
		// unset($Arrr);

		$max=sizeof($_SESSION['Item_List']);

		for ($row = 0; $row < $max; $row++) {
			if ($row == $_GET['id']) {
				// print_r($_SESSION['Item_List'][$row]);
				

				$UntCst = (is_numeric($_SESSION['Item_List'][$row][2]) ? (float)$_SESSION['Item_List'][$row][2] : 0);
				$PrdctQt = (is_numeric($_SESSION['Item_List'][$row][1]) ? (int)$_SESSION['Item_List'][$row][1] : 0);
				$TtlAmnt = (is_numeric($_SESSION['Total_Amount']) ? (int)$_SESSION['Total_Amount'] : 0);
				$TtlAmnt -= $UntCst * $PrdctQt;

				$_SESSION['Total_Amount'] = $TtlAmnt;

				unset($_SESSION['Item_List'][$row]);

				echo'<meta http-equiv="Location" content="purchase.php">';
			}
		}
		?>
		<html>
		<head>
			<meta http-equiv="Refresh" content="0;url=purchase.php">
			<title>Loading ...</title>
		</head>
		<body>
		</body>
		</html>
		<?php 
	}
}

if (isset($_POST['btn_AddPurchase'])){

	if ($_SESSION['Invoice_Data'][0]!="") {

		$Connection = setConnection();

		$UsrID = $_SESSION["UserId"];
		$postInvoice_No = $_SESSION['Invoice_Data'][0];
		$postInvoice_Date = $_SESSION['Invoice_Data'][1];
		$postInvoice_Company = $_SESSION['Invoice_Data'][2];
		$postInvoice_Agent = $_SESSION['Invoice_Data'][3];
		$postInvoice_PaymntMethod = $_SESSION['Invoice_Data'][4];

		try
		{
			$invoiceComd = "INSERT INTO `tb_purchase`(`Purchase_InvoiceDate`, `Purchase_InvoiceNumber`, `Purchase_Agent`, `Purchase_PaymentMethod`, `Purchase_Active`, `tb_Company_Company_ID`, `tb_Adminuser_user_ID`) VALUES ('".$postInvoice_Date."', '".$postInvoice_No."', '".$postInvoice_Agent."', '".$postInvoice_PaymntMethod."', '1', '".$postInvoice_Company."', '".$UsrID."')";

			//'$_SESSION["UserId"]'
			if (mysqli_query($Connection, $invoiceComd)) {

				try
				{
					$TakePurchaseId = "SELECT `Purchase_ID` FROM `tb_purchase` ORDER BY `Purchase_ID` DESC LIMIT 1";
					$PurIDExecuteResult = mysqli_query($Connection, $TakePurchaseId);

					while ($row = $PurIDExecuteResult->fetch_assoc()) {
						$PurchaseID =  $row['Purchase_ID'];
						// echo "<script type='text/javascript'>alert('{$PurchaseID}')</script>";
					}

					$max=sizeof($_SESSION['Item_List']);

					for ($row = 0; $row < $max; $row++) {

						//SELECT `Purchase_ID` FROM `tb_purchase` WHERE `Purchase_InvoiceNumber`= ORDER BY `Purchase_ID` DESC LIMIT 1;
						//SELECT  FROM `tb_purchase` WHERE `Purchase_InvoiceNumber`=

						$Item_PrdctId = $_SESSION['Item_List'][$row][0];
						$Item_Qty = (is_numeric($_SESSION['Item_List'][$row][1]) ? (int)$_SESSION['Item_List'][$row][1] : 0);
						$Item_UnitCost = (is_numeric($_SESSION['Item_List'][$row][2]) ? (float)$_SESSION['Item_List'][$row][2] : 0);
						$Item_SellCost = (is_numeric($_SESSION['Item_List'][$row][3]) ? (float)$_SESSION['Item_List'][$row][3] : 0);
						$Item_ManuDate = $_SESSION['Item_List'][$row][4];
						$Item_ExpDate = $_SESSION['Item_List'][$row][5];

						$itemSaveToSystem = "INSERT INTO `tb_inventory`(`Inventory_InvoiceNumber`, `tb_Product_Product_ID`, `Inventory_ImportQty`, `Inventory_ReturnQty`, `Inventory_CurrentQty`, `Inventory_UnitCost`, `Inventory_UnitSellingPrice`, `Inventory_ManufactureDate`, `Inventory_ExpireDate`, `Inventory_Active`, `tb_Purchase_Purchase_ID`) VALUES ( '".$postInvoice_No."', '".$Item_PrdctId."', '".$Item_Qty."', '0', '".$Item_Qty."', '".$Item_UnitCost."', '".$Item_SellCost."', '".$Item_ManuDate."', '".$Item_ExpDate."', '1', '".$PurchaseID."')";

						if (mysqli_query($Connection, $itemSaveToSystem)) 
						{
							unset($_SESSION['Item_List'][$row]);
						}
						else {
							echo "Error ". mysqli_error($Connection);					
						}
					}
					unset($_SESSION['Invoice_Data']);
					unset($_SESSION['Total_Items']);
					unset($_SESSION['Total_Amount']);

					echo "<script type='text/javascript'>alert('New Stock Added Successfully.')</script>";

				}
				catch (exception $ex)
				{
					echo 'Caught exception: ', $ex -> getMessage(), "\n";
				}
			}
			else {
				// echo "Error check ". mysqli_error($Connection);
				// $Msg = "Error ". mysqli_error($Connection);
				if (mysqli_errno($Connection) == 1062) {
					$Msg = "Invoice Number Duplicated. Can not Add Invoice. Enter different invoice Number.";
				}
				else{
					$Msg = "";
				}
				
				echo "<script type='text/javascript'>alert('Error. '+ '{$Msg}')</script>";

			}
		}
		catch (exception $ex)
		{
			echo 'Caught exception: ', $ex -> getMessage(), "\n";
		}
		finally
		{
			mysqli_close($Connection);
		}
	}
	?>
<!-- 	<html>
	<head>
		<meta http-equiv="Refresh" content="0;url=purchase.php">
		<title>Loading ...</title>
	</head>
	<body>
	</body>
	</html> -->
	<?php 
}


if (isset($_POST['btn_AddItem']))
{
		// Product Items add to list as Session array
	if (isset($_SESSION['Item_List'])) {

		$NoOfLists_of_ItemList = is_array($_SESSION['Item_List']) ? count($_SESSION['Item_List']) : 0 ;

		$ID = $NoOfLists_of_ItemList;
		$_SESSION['Item_List'][$ID] = array();

		$_SESSION['Item_List'][$ID][0] = $_POST['slctPdrctID'];
		$_SESSION['Item_List'][$ID][1] = $_POST['txtPrdctQty'];
		$_SESSION['Item_List'][$ID][2] = $_POST['txtUnitCost'];
		$_SESSION['Item_List'][$ID][3] = $_POST['txtSellingPrice'];
		$_SESSION['Item_List'][$ID][4] = $_POST['txtManuDate'];
		$_SESSION['Item_List'][$ID][5] = $_POST['txtExpDate'];

		$_SESSION['Total_Items'] = count($_SESSION['Item_List']);
		if (isset($_SESSION['Total_Amount'])) {

			$UntCst = (is_numeric($_POST['txtUnitCost']) ? (float)$_POST['txtUnitCost'] : 0);
			$PrdctQt = (is_numeric($_POST['txtPrdctQty']) ? (int)$_POST['txtPrdctQty'] : 0);
			$TtlAmnt = (is_numeric($_SESSION['Total_Amount']) ? (int)$_SESSION['Total_Amount'] : 0);
			$TtlAmnt += $UntCst * $PrdctQt;

			$_SESSION['Total_Amount'] = $TtlAmnt;
		}


	}
	else{
		$_SESSION['Item_List'] = array();

		$ID = 0;
		$_SESSION['Item_List'][$ID] = array();

		$_SESSION['Item_List'][$ID][0] = $_POST['slctPdrctID'];
		$_SESSION['Item_List'][$ID][1] = $_POST['txtPrdctQty'];
		$_SESSION['Item_List'][$ID][2] = $_POST['txtUnitCost'];
		$_SESSION['Item_List'][$ID][3] = $_POST['txtSellingPrice'];
		$_SESSION['Item_List'][$ID][4] = $_POST['txtManuDate'];
		$_SESSION['Item_List'][$ID][5] = $_POST['txtExpDate'];

		$_SESSION['Total_Items'] = 1;

		$UntCst = (is_numeric($_POST['txtUnitCost']) ? (float)$_POST['txtUnitCost'] : 0);
		$PrdctQt = (is_numeric($_POST['txtPrdctQty']) ? (int)$_POST['txtPrdctQty'] : 0);
		$TtlAmnt = $UntCst * $PrdctQt;

		$_SESSION['Total_Amount'] = $TtlAmnt;

	}

		// Invoice Data Add to list as Session array
	if (isset($_SESSION['Invoice_Data'])) {

		$_SESSION['Invoice_Data'][0] = $_POST['txtInvoiceNo'];
		$_SESSION['Invoice_Data'][1] = $_POST['txtInvoiceDate'];
		$_SESSION['Invoice_Data'][2] = $_POST['slctCompany'];
		$_SESSION['Invoice_Data'][3] = $_POST['slctAgent'];
		$_SESSION['Invoice_Data'][4] = $_POST['slctPaymentMethod'];
	}
	else
	{
		$_SESSION['Invoice_Data'] = array();

		$_SESSION['Invoice_Data'][0] = $_POST['txtInvoiceNo'];
		$_SESSION['Invoice_Data'][1] = $_POST['txtInvoiceDate'];
		$_SESSION['Invoice_Data'][2] = $_POST['slctCompany'];
		$_SESSION['Invoice_Data'][3] = $_POST['slctAgent'];
		$_SESSION['Invoice_Data'][4] = $_POST['slctPaymentMethod'];
	}

	?>
	<html>
	<head>
		<meta http-equiv="Refresh" content="0;url=purchase.php">
		<title>Loading ...</title>
	</head>
	<body>
	</body>
	</html>
	<?php 

}

// print_r($_SESSION['Invoice_Data']);
// echo "<br>";
// echo($_SESSION['Total_Items']);
// echo "<br>";
// echo($_SESSION['Total_Amount']);
// echo "<br>";
// print_r($_SESSION['Item_List']);

?>


<div class="container-fluid">
	<div id="demo-element" class="card shadow">
		<div class="card-header py-3" style="max-height: 50px;">


			<!-- <button class="btn btn-info" id="go-button" style="float: right;"><i class="icon-fullscreen">Full Screen</i></button> -->


			<form action="" method="POST">
				<p class="text-primary m-0 font-weight-bold">New Item Purchase &nbsp;&nbsp;
					<input type="hidden" name="destroyCurrentPageSessions" value="1">
					<?php if (isset($_SESSION['Invoice_Data']))
					{
						echo '<input type="submit" class="btn btn-info btn-sm" value="Clear All" style="float: right;"/>';
					}

					$destroySessionFlag = filter_input(INPUT_POST, 'destroyCurrentPageSessions');
					if ($destroySessionFlag == 1) {
						unset($_SESSION['Invoice_Data']);
						unset($_SESSION['Item_List']);
						unset($_SESSION['Total_Items']);
						unset($_SESSION['Total_Amount']);	
					}

					?>
				</form>
			</p>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-12 text-nowrap">
					<div class="form-row">
						<div class="col">
							<div id="ErrMsgBG" class="alert alert-danger alert-dismissible fade show" role="alert" hidden>
								<strong>Error!</strong> <label id="ErrMsg">Danger Label</label>.
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<form action="purchase.php" method="POST">
								<div class="row" style="border-bottom: solid 1px #b2beb5; padding-bottom: 0px;">
									<!-- Invoice No -->
									<div class="col">
										<div class="col">
											<label class="col-3" for="txtInvoiceNo">Invoice No</label>
											<input class="col form-control form-control-sm" type="text" id="txtInvoiceNo" name="txtInvoiceNo" value="<?php echo (!empty($_SESSION['Invoice_Data'][0])) ? $_SESSION['Invoice_Data'][0] : ''; ?>" required>
										</div>
									</div>

									<!-- Invoice Date -->
									<div class="col">
										<div class="col">
											<label class="col-3" for="txtInvoiceDate">Invoice Date</label>
											<input class="col form-control form-control-sm" type="date" id="txtInvoiceDate" name="txtInvoiceDate" value="<?php echo (!empty($_SESSION['Invoice_Data'][1])) ? $_SESSION['Invoice_Data'][1] : ''; ?>" required>
										</div>
									</div>

									<!-- Company -->
									<div class="col">
										<div class="col">
											<label class="col" for="">Company</label>
											<?php
											try
											{
												$Connection = setConnection();

												$myCoCommand = "SELECT * FROM `tb_company` WHERE `Company_Active` = '1' ";
												$CoResult=mysqli_query($Connection, $myCoCommand);

												$companyToPurchase = '<select id="slctCompany" name="slctCompany" class="col form-control form-control-sm" required>';
												// $companyToPurchase .='<option value=0 disabled selected> - Select Manufacture / Supplier - </option>';

												while ($record = mysqli_fetch_assoc($CoResult)) 
												{
													$supplierId=$record['Company_ID'];
													$supplierName=$record['Company_Name'];

													if (!empty($_SESSION['Invoice_Data'][2]) && $_SESSION['Invoice_Data'][2]==$supplierId) {
														$companyToPurchase .='<option value="'.$supplierId.'" selected>'.$supplierName.'</option>';
													}
													else
													{
														$companyToPurchase .='<option value="'.$supplierId.'">'.$supplierName.'</option>';
													}
												}
												$companyToPurchase .='</select>&nbsp;';
												echo $companyToPurchase;
											}
											catch (exception $ex)
											{
												echo 'Caught exception: ', $ex -> getMessage(), "\n";
											}
											finally 
											{
												mysqli_close($Connection);
											}
											?>
										</div>
									</div>

									<!-- Agent -->
									<div class="col">
										<div class="col">
											<label class="col" for="">Agent</label>
											<?php
											try
											{
												$Connection = setConnection();

												$myCoCommand = "SELECT * FROM `tb_agent` WHERE `Agent_Active` = '1' ";
												$CoResult=mysqli_query($Connection, $myCoCommand);

												$agentToPurchase = '<select id="slctAgent" name="slctAgent" class="col form-control form-control-sm" required>';
												// $agentToPurchase .='<option value=0 disabled selected> - Select Agent - </option>';

												while ($record = mysqli_fetch_assoc($CoResult)) 
												{
													$AgentId=$record['Agent_ID'];
													$AgentName=$record['Agent_Name'];

													if (!empty($_SESSION['Invoice_Data'][3]) && $_SESSION['Invoice_Data'][3]==$AgentId) 
													{
														$agentToPurchase .='<option value="'.$AgentId.'" selected>'.$AgentId.'|'.$AgentName.'</option>';
													}
													else
													{
														$agentToPurchase .='<option value="'.$AgentId.'">'.$AgentId.'|'.$AgentName.'</option>';
													}
												}
												$agentToPurchase .='</select>&nbsp;';
												echo $agentToPurchase;
											}
											catch (exception $ex)
											{
												echo 'Caught exception: ', $ex -> getMessage(), "\n";
											}
											finally 
											{
												mysqli_close($Connection);
											}
											?>
										</div>
									</div>

									<!-- Payment Method -->
									<div class="col">
										<div class="col">
											<label class="col" for="">Payment Method</label>
											<?php 
											$purchaseMethod = '<select class="col form-control form-control-sm" id="slctPaymentMethod" name="slctPaymentMethod" required>';
											if (!empty($_SESSION['Invoice_Data'][4]) && $_SESSION['Invoice_Data'][4]==0) 
											{
												$purchaseMethod .='<option value="0" selected>Cash</option>';
												$purchaseMethod .='<option value="1">Card</option>';
												$purchaseMethod .='<option value="2">Credit</option>';
											}
											elseif (!empty($_SESSION['Invoice_Data'][4]) && $_SESSION['Invoice_Data'][4]==1) 
											{
												$purchaseMethod .='<option value="0">Cash</option>';
												$purchaseMethod .='<option value="1" selected>Card</option>';
												$purchaseMethod .='<option value="2">Credit</option>';
											}
											elseif (!empty($_SESSION['Invoice_Data'][4]) && $_SESSION['Invoice_Data'][4]==2) 
											{
												$purchaseMethod .='<option value="0">Cash</option>';
												$purchaseMethod .='<option value="1">Card</option>';
												$purchaseMethod .='<option value="2" selected>Credit</option>';												}
												else
												{
													$purchaseMethod .='<option value="0">Cash</option>';
													$purchaseMethod .='<option value="1">Card</option>';
													$purchaseMethod .='<option value="2">Credit</option>';
												}
												$purchaseMethod .='</select>';
												echo $purchaseMethod;
												?>


											</select>
										</div>
									</div>
								</div>

								<script src="../../assets/js/jquery-editable-select-master/jquery-1.12.4.min.js"></script>
								<script src="../../assets/js/jquery-editable-select-master/jquery-editable-select.min.js"></script>
								<link href="../../assets/js/jquery-editable-select-master/jquery-editable-select.min.css" rel="stylesheet">

								<!-- Select Product for Add to List -->
								<div class="row" style="border-bottom: solid 1px #b2beb5; padding-top: 20px;">
									<div class="col">
										<label class="" for="">Select Product</label>
										<?php
										try
										{
											$Connection = setConnection();

											$myCoCommand = "SELECT * FROM `tb_product` WHERE `Product_Active` = '1' ";
											$CoResult=mysqli_query($Connection, $myCoCommand);

											$prdctToPurchase = '<select id="slctPdrctID" name="slctPdrctID" class="col form-control form-control-sm" required>';
											// $prdctToPurchase .='<option value=0 disabled selected> - Select Product - </option>';

											while ($record = mysqli_fetch_assoc($CoResult)) 
											{
												$ProductID=$record['Product_ID'];
												$ProductName=$record['Product_ProductName'];

												$prdctToPurchase .='<option value="'.$ProductID.'">'.$ProductID.'|'.$ProductName.'</option>';
											}
											$prdctToPurchase .='</select>&nbsp;';
											echo $prdctToPurchase;
										}
										catch (exception $ex)
										{
											echo 'Caught exception: ', $ex -> getMessage(), "\n";
										}
										finally 
										{
											mysqli_close($Connection);
										}
										?>
									</div>
									<script>
										$('#slctPdrctID').editableSelect();
									</script>
									<div class="col">
										<label class="" for="txtPrdctQty" >Unit Quantity</label>
										<div class="">
											<input class="col form-control form-control-sm" type="text" id="txtPrdctQty" name="txtPrdctQty" required>
										</div>
									</div>
									<div class="col">
										<label class="" for="txtUnitCost" >Unit Cost (Rs.)</label>
										<div class="">
											<input class="col form-control form-control-sm" type="text" id="txtUnitCost" name="txtUnitCost" required>
										</div>
									</div>
									<div class="col">
										<label class="" for="txtSellingPrice" >Unit Sell Price (Rs.)</label>
										<div class="">
											<input class="col form-control form-control-sm" type="text" id="txtSellingPrice" name="txtSellingPrice" required>
										</div>
									</div>
									<div class="col">
										<label class="" for="txtManuDate" >Manufacture Date</label>
										<div class="">
											<input class="col form-control form-control-sm" type="date" id="txtManuDate" name="txtManuDate" value="" required>
										</div>
									</div>
									<div class="col">
										<label class="" for="txtExpDate" >Expire Date</label>
										<div class="">
											<input class="col form-control form-control-sm" type="date" id="txtExpDate" name="txtExpDate" value="" required>
										</div>
									</div>
									<div class="col" >
										<label class="">&nbsp;</label>
										<div class="">
											<button class="bttnWidth col form-control form-control-sm btn btn-primary bttnWidth" id="btn_AddItem" name="btn_AddItem" type="submit"><span class="badge badge-info"><i class="fas fa-plus"></i></span>&nbsp; Add</button>
											<style type="text/css">
												.bttnWidth{
													float: left;
													display: block;
													width: 90px;
												}
											</style>
										</div>
									</div>
								</div>
							</form>

							<div class="row table-wrapper-scroll-y my-custom-scrollbar col-md-12" style="line-height: 0.1; overflow-x:auto; border-bottom: solid 1px #b2beb5; padding-top: 20px;">
								<style type="text/css">
									table tr{
										max-height: 10px;
									}
								</style>
								<table class="table table-bordered table-striped 	">
									<thead>
										<tr style="max-height: 5px;">
											<th>#</th>
											<th>Product</th>
											<th>Quantity</th>
											<th>Unit Cost (Rs.)</th>
											<th>Unit Sell Price (Rs.)</th>
											<th>Manufacture Date</th>
											<th>Expire Date</th>
											<th>Remove</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										if (isset($_SESSION['Item_List'])) {

											$Num = 1;
											$max=sizeof($_SESSION['Item_List']);
											$DataRow ="";

											for ($row = 0; $row < $max; $row++) {
												if (isset($_SESSION['Item_List'][$row])) {
													try
													{
														$Connection = setConnection();

														try{
															$IDofPrduct = $_SESSION['Item_List'][$row][0];
															$myCoCommand = "SELECT `Product_ProductName` FROM `tb_product` WHERE `Product_Active`='1' AND `Product_ID`='".$IDofPrduct."' ";
															$CoResult=mysqli_query($Connection, $myCoCommand);

															while ($record = mysqli_fetch_assoc($CoResult)) 
															{
																$prdtName=$record['Product_ProductName'];

															}
														}
														catch (exception $ex)
														{
															$prdtName = $_SESSION['Item_List'][$row][0];
														}

													}
													catch (exception $ex)
													{
														$prdtName = $_SESSION['Item_List'][$row][0];
													}
													finally 
													{
														mysqli_close($Connection);
													}

													$DataRow = "<tr>";
													$DataRow .= "<td>(".$Num.")</td>";
													$DataRow .= "<td>".$prdtName."</td>";
													$DataRow .= "<td>".$_SESSION['Item_List'][$row][1]."</td>";
													$DataRow .= "<td>".$_SESSION['Item_List'][$row][2]."</td>";
													$DataRow .= "<td>".$_SESSION['Item_List'][$row][3]."</td>";
													$DataRow .= "<td>".$_SESSION['Item_List'][$row][4]."</td>";
													$DataRow .= "<td>".$_SESSION['Item_List'][$row][5]."</td>";
													$DataRow .= "<td id=".$_SESSION['Item_List'][$row][0].">
													<a href='purchase.php?id=".$row."&act=RemSes' style='text-decoration: none;'><i class='btn btn-danger btn-sm fas fa-trash'></i> </a></td>";
													$DataRow .= "</tr>";
													$Num++;
												}

												echo $DataRow;



												// echo "<p><b>Row number $row</b></p>";
												// echo "<ul>";
												// for ($col = 0; $col < 6; $col++) {
												// 	echo "<li>".$_SESSION['Item_List'][$row][$col]."</li>";
												// }
												// echo "</ul>";
											}
										} 
										// unset($_SESSION['Item_List']);
										?>
									</tbody ><br>
								</table>
							</div> 
		
							<div class="row" style="border-bottom: solid 1px #b2beb5; padding-top: 20px;">
								<div class="col">
									<label>Total Items</label>
									<input type="text" name="" disabled="" value="<?php echo (!empty($_SESSION['Total_Items'])) ? $_SESSION['Total_Items'] : '0'; ?>">
								</div>
								<div class="col">
									<label>Total Amount (Rs.)</label>
									<input type="text" name="" disabled="" value="<?php echo (!empty($_SESSION['Total_Amount'])) ? $_SESSION['Total_Amount'] : '0'; ?>">
								</div>
								<div class="col">
									<form action="#" method="post">
										<div class="form-row">
											<?php if (isset($_SESSION['Invoice_Data']) && isset($_SESSION['Item_List']))
											{
												echo '<input type="submit" class="btn btn-primary btn-sm" value="Add Invoice" style="float: right;" name="btn_AddPurchase" id="btn_AddPurchase" />';
											}
											?>
											<!-- unset($_SESSION['Invoice_Data']);
											unset($_SESSION['Item_List']);
											unset($_SESSION['Total_Items']);
											unset($_SESSION['Total_Amount']);	 -->
											
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	if (document.getElementById('txtInvoiceNo').value != "") 
	{
		document.getElementById('ErrMsg').value = "";

		if (document.getElementById('txtInvoiceDate').value == "0") 
		{
			document.getElementById('ErrMsg').value = "| Select Date ";
			document.getElementById('ErrMsgBG').hidden=false;
		}
		if (document.getElementById('slctCompany').value == "0") 
		{
			document.getElementById('ErrMsg').value += "| Select Company ";
			document.getElementById('ErrMsgBG').hidden=false;
		}
		if (document.getElementById('slctAgent').value == "0") 
		{
			document.getElementById('ErrMsg').value += "| Select Agent";
			document.getElementById('ErrMsgBG').hidden=false;
		}
	}
	else{
		document.getElementById('ErrMsg').value = "";

		if (document.getElementById('txtInvoiceDate').value == "0") 
		{
			document.getElementById('ErrMsg').value = "| Select Date ";
			document.getElementById('ErrMsgBG').hidden=true;
		}
		if (document.getElementById('slctCompany').value == "0") 
		{
			document.getElementById('ErrMsg').value += "| Select Company ";
			document.getElementById('ErrMsgBG').hidden=true;
		}
		if (document.getElementById('slctAgent').value == "0") 
		{
			document.getElementById('ErrMsg').value += "| Select Agent";
			document.getElementById('ErrMsgBG').hidden=true;
		}
	}
	
</script>


<!-- Full screen Script -->
<script>
	function GoInFullscreen(element) {
		if(element.requestFullscreen)
			element.requestFullscreen();
		else if(element.mozRequestFullScreen)
			element.mozRequestFullScreen();
		else if(element.webkitRequestFullscreen)
			element.webkitRequestFullscreen();
		else if(element.msRequestFullscreen)
			element.msRequestFullscreen();
	}

	function GoOutFullscreen() {
		if(document.exitFullscreen)
			document.exitFullscreen();
		else if(document.mozCancelFullScreen)
			document.mozCancelFullScreen();
		else if(document.webkitExitFullscreen)
			document.webkitExitFullscreen();
		else if(document.msExitFullscreen)
			document.msExitFullscreen();
	}

	function IsFullScreenCurrently() {
		var full_screen_element = document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement || null;

		if(full_screen_element === null)
			return false;
		else
			return true;
	}

	$("#go-button").on('click', function() {
		if(IsFullScreenCurrently())
			GoOutFullscreen();
		else
			GoInFullscreen($("#demo-element").get(0));
	});

	$(document).on('fullscreenchange webkitfullscreenchange mozfullscreenchange MSFullscreenChange', function() {
		if(IsFullScreenCurrently()) {
			$("#go-button").text('Exit Full Screen');
		}
		else {
			$("#go-button").text('Full Screen');
		}
	});



	window.addEventListener('keypress', function (e) {
		if (e.keyCode !== 13) {
			chars.push(e.key);
		}
	}, false);

</script>

<!-- Footer part Start from here -->
<?php include('../../control/AdminUser/HeadAndFooter/footer.php');?>