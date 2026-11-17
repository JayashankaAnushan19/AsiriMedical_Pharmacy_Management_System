<?php
require_once __DIR__ . '/../../model/auth.php';
require_staff(); 
include('../../model/db_connection.php'); 
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">


<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<style type="text/css">
	#invoice{
		padding: 30px;
	}

	.invoice {
		position: relative;
		background-color: #FFF;
		min-height: 680px;
		padding: 15px
	}

	.invoice header {
		padding: 10px 0;
		margin-bottom: 20px;
		border-bottom: 1px solid #3989c6
	}

	.invoice .company-details {
		text-align: right
	}

	.invoice .company-details .name {
		margin-top: 0;
		margin-bottom: 0
	}

	.invoice .contacts {
		margin-bottom: 20px
	}

	.invoice .invoice-to {
		text-align: left
	}

	.invoice .invoice-to .to {
		margin-top: 0;
		margin-bottom: 0
	}

	.invoice .invoice-details {
		text-align: right
	}

	.invoice .invoice-details .invoice-id {
		margin-top: 0;
		color: #3989c6
	}

	.invoice main {
		padding-bottom: 50px
	}

	.invoice main .thanks {
		margin-top: -100px;
		font-size: 2em;
		margin-bottom: 50px
	}

	.invoice main .notices {
		padding-left: 6px;
		border-left: 6px solid #3989c6
	}

	.invoice main .notices .notice {
		font-size: 1em
	}

	.invoice table {
		width: 100%;
		border-collapse: collapse;
		border-spacing: 0;
		margin-bottom: 20px
	}

	.invoice table td,.invoice table th {
		/*padding: 15px;*/
		background: #eee;
		/*border-bottom: 1px solid #fff*/
	}

	.invoice table th {
		white-space: nowrap;
		font-weight: 400;
		font-size: 16px
	}

	.invoice table td h3 {
		margin: 0;
		font-weight: 400;
		color: #3989c6;
		font-size: 1.2em
	}

	.invoice table .qty,.invoice table .total,.invoice table .unit {
		text-align: right;
		font-size: 1.2em
	}

	.invoice table .unit {
		background: #ddd
	}

	.invoice footer {
		width: 100%;
		text-align: center;
		color: #777;
		border-top: 1px solid #aaa;
		padding: 8px 0
	}

	/* style sheet for "A4" printing */
	@media print and (width: 21cm) and (height: 29.7cm) {
		@page {
			margin: 3cm;
		}
	}

	/* style sheet for "letter" printing */
	@media print and (width: 8.5in) and (height: 11in) {
		@page {
			margin: 1in;
		}
	}

	/* A4 Landscape*/
	@page {
		size: A7;
	}
</style>

<?php 

// $_GET['act'] = "BuySellAll";
// $_GET['frm'] = '2020-10-01';
// $_GET['to'] = '2020-10-30';

?>


<?php  
if (isset($_GET['act'])) {
	if ($_GET['act']=='BuySellAll' && $_GET['frm'] !='' && $_GET['to'] !='') 
	{
		$DateFrom = $_GET['frm'];
		$DateTo = $_GET['to'];



		$Connection = setConnection();

		$selectdata = "SELECT DISTINCT `tb_Product_Product_ID` FROM `tb_purchase` INNER JOIN `tb_inventory` on `tb_inventory`.`tb_Purchase_Purchase_ID` = `tb_purchase`.`Purchase_ID` WHERE `tb_purchase`.`Purchase_InvoiceDate` BETWEEN '$DateFrom' AND '$DateTo' ";

		$query = mysqli_query($Connection, $selectdata);
		while($Data = mysqli_fetch_assoc($query))
		{
			$PrductArray[] = $Data['tb_Product_Product_ID'];

			date_default_timezone_set('Asia/Colombo'); 
			$NowTime = date("h:i:s A");
			$NowDay = date("Y-m-d");
		}
		if (empty($PrductArray)) {
			echo "<script type='text/javascript'>alert('No Data for Priting.'); window.exit();</script>"; 

			?>
			<html>
			<head>
				<meta http-equiv="Refresh" content="0;url=reportSales.php">
				<title>Loading ...</title>
			</head>
			<body>
			</body>
			</html>
			<?php 
		}
		else{
			// print_r($PrductArray);
			?>

			<div id="invoice" class="sheet padding-10mm">
				<div id="invoice" class="invoice overflow-auto">
					<div style="min-width: 600px">
						<header>
							<div class="row">
								<div class="">
									<img src="../../assets/img/logoo1.png" data-holder-rendered="true" width="80px;" />
								</div>
								<div class="col ">
									<h4 class="name">
										Airi Medical Pvt Ltd
									</h4>
									<div>No.58, Kurunegala Rd, Polgahawela.</div>
									<div>(037) 2244 354</div>
								</div>
								<div class="date" style="float: right;">
									Date: <?php echo($NowDay) ?> &nbsp;&nbsp; 
									Time: <?php echo($NowTime) ?> &nbsp;&nbsp;&nbsp;
								</div>
							</div>
						</header>
						<main>
							<div class="row contacts">
								<div class="col invoice-to">
									<h4><u>Buy And Sell Report - All Products</u></h4>
									<div class="text-gray-light form-inline">
										From:&nbsp;&nbsp;
										<h6 class="to"><?php echo($DateFrom) ?></h6> &nbsp;&nbsp;&nbsp;&nbsp;
										To:&nbsp;&nbsp;
										<h6 class="to"><?php echo($DateTo) ?></h6>
									</div>
								</div>
							</div>


							<table border="1" cellspacing="0" cellpadding="0">
								<thead>
									<tr>
										<th>&nbsp; #</th>
										<th class="text-left">&nbsp;&nbsp;Product</th>
										<th class="text-right">&nbsp;&nbsp; Brought Qty &nbsp;&nbsp;</th>
										<th class="text-right">&nbsp;&nbsp; Sell Qty &nbsp;&nbsp;</th>
										<!-- <th class="text-right">&nbsp;&nbsp; Remain stock (<?php echo($DateTo) ?>) &nbsp;&nbsp;</th> -->
									</tr>
								</thead>
								<tbody>

									<?php 

									$num = 1;
									$maxLen = count($PrductArray); 
									for ($rowNum=0; $rowNum < $maxLen; $rowNum++) { 

										$prdctID = $PrductArray[$rowNum];

										$GetPrdcutImportQty = "SELECT `tb_inventory`.`tb_Product_Product_ID`, SUM(`tb_inventory`.`Inventory_ImportQty`), SUM(`tb_inventory`.`Inventory_ReturnQty`)  FROM `tb_purchase` INNER JOIN `tb_inventory` on `tb_inventory`.`tb_Purchase_Purchase_ID` = `tb_purchase`.`Purchase_ID` WHERE `tb_purchase`.`Purchase_InvoiceDate` BETWEEN '$DateFrom' AND '$DateTo' AND `tb_inventory`.`tb_Product_Product_ID` = '$prdctID'";

										$importQtyExecuteResult = mysqli_query($Connection, $GetPrdcutImportQty);
										while($Data = mysqli_fetch_assoc($importQtyExecuteResult))
										{
											$importQty = $Data['SUM(`tb_inventory`.`Inventory_ImportQty`)'];
											$returnQty = $Data['SUM(`tb_inventory`.`Inventory_ReturnQty`)'];
											$totlBuyQty = $importQty - $returnQty;
										}

										$GetPrdcutSellQty = "SELECT `tb_inventory`.`tb_Product_Product_ID`, SUM(`tb_saleinvoiceitems`.`SaleInvoiceItems_Qty`) FROM `tb_saleinvoiceitems`  INNER JOIN `tb_saleinvoice` on `tb_saleinvoiceitems`.`tb_SaleInvoice_SaleInvoice_ID` = `tb_saleinvoice`.`SaleInvoice_ID` INNER JOIN `tb_inventory` ON `tb_saleinvoiceitems`.`SaleInvoiceItems_InventoryID` = `tb_inventory`.`Inventory_ID` WHERE `tb_saleinvoice`.`SaleInvoice_Date` BETWEEN '$DateFrom' AND '$DateTo' AND `tb_inventory`.`tb_Product_Product_ID` = '$prdctID'";

										$sellQtyExecuteResult = mysqli_query($Connection, $GetPrdcutSellQty);
										while($Data = mysqli_fetch_assoc($sellQtyExecuteResult))
										{
											$sellQty = $Data['SUM(`tb_saleinvoiceitems`.`SaleInvoiceItems_Qty`)'];
										}

										$remainQty = $totlBuyQty - $sellQty;

										$GetPrdcutName = "SELECT * FROM `tb_product` WHERE `Product_ID`= '$prdctID'";

										$getPrdctNameExecuteResult = mysqli_query($Connection, $GetPrdcutName);
										while($Data = mysqli_fetch_assoc($getPrdctNameExecuteResult))
										{
											$prdctName = $Data['Product_ProductName'];
										}

										$buySellPrdctRowDetails ='<tr>';
										$buySellPrdctRowDetails .='<td class="no">&nbsp;&nbsp;'.$num.'&nbsp;&nbsp;</td>';
										$buySellPrdctRowDetails .='<td class="text-left">&nbsp;&nbsp;'.$prdctName.'&nbsp;&nbsp;</td>';
										$buySellPrdctRowDetails .='<td class="unit">&nbsp;&nbsp;'.$totlBuyQty.'&nbsp;&nbsp;</td>';
										$buySellPrdctRowDetails .='<td class="qty">&nbsp;&nbsp;'.$sellQty.'&nbsp;&nbsp;</td>';
										// $buySellPrdctRowDetails .='<td class="total">&nbsp;&nbsp;'.$remainQty.'&nbsp;&nbsp;</td>';
										$buySellPrdctRowDetails .='</tr>';
										echo $buySellPrdctRowDetails;
										$num++;


									}


									?>

								<!-- <tr>
									<td class="no">04</td>
									<td class="text-left">
										Youtube channel-Useful videos-to improve your Javascript skills. Subscribe and stay tuned :)
									</td>
									<td class="unit">0.00</td>
									<td class="qty">100</td>
									<td class="total">0.00</td>
								</tr> -->
							</tbody>
							<tfoot>
								<tr>
									<td colspan="2"></td>
									<td colspan="2"></td>
									<td></td>
								</tr>
							</tfoot>
						</table><br>

						<div class="notices">
							<div class="notice">Report Generated Successfully.</div>
						</div>
					</main>
					<footer>
						Report was created on a computer and is valid without the signature and seal.
					</footer>
				</div>
				<!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
				<div></div>
			</div>
		</div>

		<script>
			function toggleDataSeries(e){
				if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
					e.dataSeries.visible = false;
				}
				else{
					e.dataSeries.visible = true;
				}
				chart.render();
			}
		</script>
	</head>


	<script type="text/javascript">
		window.print();
			// window.close();
		</script>

		<?php 
	}
}
else
{
	echo "<script type='text/javascript'>alert('Report Printing Error. Invalid input Detected. Please Contact System Admin.')</script>"; 

	?>
	<html>
	<head>
		<meta http-equiv="Refresh" content="0;url=reportSales.php">
		<title>Loading ...</title>
	</head>
	<body>
	</body>
	</html>
	<?php 
}
}
else
{
	echo "<script type='text/javascript'>alert('Report Printing Error. Please Contact System Admin.')</script>"; 

	?>
	<html>
	<head>
		<meta http-equiv="Refresh" content="0;url=reportSales.php">
		<title>Loading ...</title>
	</head>
	<body>
	</body>
	</html>
	<?php 
}
?>


