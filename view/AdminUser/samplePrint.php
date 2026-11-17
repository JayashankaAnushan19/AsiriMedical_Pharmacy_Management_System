<?php 
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
		font-size: 1.2em
	}

	.invoice table {
		width: 100%;
		border-collapse: collapse;
		border-spacing: 0;
		margin-bottom: 20px
	}

	.invoice table td,.invoice table th {
		padding: 15px;
		background: #eee;
		border-bottom: 1px solid #fff
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

	.invoice table .no {
		color: #fff;
		background: #3989c6
	}

	.invoice table .unit {
		background: #ddd
	}

	.invoice table .total {
		background: #3989c6;
		color: #fff
	}

	.invoice table tbody tr:last-child td {
		border: none
	}

	.invoice table tfoot td {
		background: 0 0;
		border-bottom: none;
		white-space: nowrap;
		text-align: right;
		padding: 10px 20px;
		font-size: 1.2em;
		border-top: 1px solid #aaa
	}

	.invoice table tfoot tr:first-child td {
		border-top: none
	}

	.invoice table tfoot tr:last-child td {
		color: #3989c6;
		font-size: 1.4em;
		border-top: 1px solid #3989c6
	}

	.invoice table tfoot tr td:first-child {
		border: none
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
if (isset($_GET['act'])) 
{
	if ($_GET['act']=='printInvoice' && $_GET['id'] !='') 
	{	
		$printInvoiceID = $_GET['id'];

		?>

		<!--Author      : @arboshiki-->
		<div id="invoice" class="sheet padding-10mm">
			<div id="invoice" class="invoice overflow-auto">
				<div style="min-width: 600px">
					<header>
						<div class="row">
							<div class="col company-details">
								<img src="../../assets/img/logoo1.png" data-holder-rendered="true" width="80px;" />
							</div>
							<div class="col ">
								<h4 class="name">
									Asiri Medical Pvt Ltd
								</h4>
								<div>No.58, Kurunegala Rd, Polgahawela.</div>
								<div>(037) 2244 354</div>
							</div>
						</div>
					</header>

					<?php 
					$printInvoiceID = $_GET['id'];
					$Connection = setConnection();


					$selectdata = "SELECT * FROM `tb_saleinvoice` WHERE `SaleInvoice_ID` = '$printInvoiceID' ";

					$query = mysqli_query($Connection, $selectdata);
					while($Data = mysqli_fetch_assoc($query))
					{
						$CustomerName = $Data['SaleInvoice_CustomerNameorNIC'];
						$Date = $Data['SaleInvoice_Date'];
						$Time = date("h:i:sA");
					}
					?>
					<main>
						<div class="row contacts">
							<div class="col invoice-to">
								<div class="text-gray-light form-inline">Customer : Mr./Mrs./Thev. &nbsp; <h6 class="to">  <?php echo($CustomerName) ?></h6> </div>

							</div>
							<div class="col invoice-details">
								<h6 class="invoice-id">INVOICE No: #<?php echo($printInvoiceID) ?></h6>
								<div class="date">Date : <?php echo($Date) ?></div>
								<div class="date">Time : <?php echo($Time) ?></div>
							</div>
						</div>
						<table border="0" cellspacing="0" cellpadding="0">
							<thead>
								<tr>
									<th>#</th>
									<th class="text-left">Product</th>
									<th class="text-right">Unit Price (Rs.)</th>
									<th class="text-right">Unit Qty</th>
									<th class="text-right">Sub-Total (Rs.)</th>
								</tr>
							</thead>
							<tbody>

								<?php 


								$Connection = setConnection();

								$ShowBilledItems = "SELECT `tb_saleinvoice`.`SaleInvoice_Discount`, `tb_saleinvoice`.`SaleInvoice_PaymentMethod`, `tb_saleinvoice`.`SaleInvoice_PaymentCash`, `tb_saleinvoice`.`SaleInvoice_PaymentCardNo`, `tb_saleinvoice`.`SaleInvoice_Balance` , `tb_product`.`Product_ProductName`, `tb_inventory`.`Inventory_UnitSellingPrice`, `tb_saleinvoiceitems`.`SaleInvoiceItems_Qty` FROM `tb_saleinvoiceitems` INNER JOIN `tb_saleinvoice` ON `tb_saleinvoiceitems`.`tb_SaleInvoice_SaleInvoice_ID`=`tb_saleinvoice`.`SaleInvoice_ID` INNER JOIN `tb_inventory` ON `tb_saleinvoiceitems`.`SaleInvoiceItems_ID`=`tb_saleinvoiceitems`.`SaleInvoiceItems_InventoryID` INNER JOIN `tb_product` ON `tb_inventory`.`tb_Product_Product_ID`=`tb_product`.`Product_ID` WHERE `tb_saleinvoiceitems`.`tb_SaleInvoice_SaleInvoice_ID` = 1";

								$ShowBilledItemsResult=mysqli_query($Connection, $ShowBilledItems);

								$No = 1;
								$Total = 0;

								while ($record = mysqli_fetch_assoc($ShowBilledItemsResult)) 
								{	

									$ProductName = $record['Product_ProductName'];
									$ProductPrice =(is_numeric($record['Inventory_UnitSellingPrice']) ? (float)$record['Inventory_UnitSellingPrice'] : 0);
									$ProductQty = (is_numeric($record['SaleInvoiceItems_Qty']) ? (float)$record['SaleInvoiceItems_Qty'] : 0);

									$SubTtl =  $ProductPrice * $ProductQty;
									$Total += $SubTtl;

									$ProductCash=$record['SaleInvoice_PaymentCash'];
									$ProductDiscount=$record['SaleInvoice_Discount'];
									$ProductBalance=$record['SaleInvoice_Balance'];
									$ProductCardNumber=$record['SaleInvoice_PaymentCardNo'];
									$ProductPymntMethod=$record['SaleInvoice_PaymentMethod'];

									$prdctToPurchase ='<tr>';
									$prdctToPurchase .='<td class="no">'.$No.'</td>';
									$prdctToPurchase .='<td class="text-left">'.$ProductName.'</td>';
									$prdctToPurchase .='<td class="unit">'.number_format((float)$ProductPrice, 2, '.', '').'</td>';
									$prdctToPurchase .='<td class="qty">'.$ProductQty.'</td>';
									$prdctToPurchase .='<td class="total">'.number_format((float)$SubTtl, 2, '.', '').'</td>';
									$prdctToPurchase .='</tr>';

									echo $prdctToPurchase;
									$No++;
								}

								?>


							</tbody>
							<tfoot>
								<tr>
									<td colspan="2"></td>
									<td colspan="2">SUBTOTAL (Rs.)</td>
									<td><?php echo(number_format((float)$Total, 2, '.', '')) ?></td>
								</tr>
								<tr>
									<?php if ($ProductPymntMethod == '0')
									{
										echo'<td colspan="2" class="text-left">Payment Method: Cash Payment</td>';
									} 
									else
									{
										echo'<td colspan="2" class="text-left">Payment Method: Card Payment</td>';
									}
									?>

									<td colspan="2">Discount (Rs.)</td>
									<td><?php echo(number_format((float)$ProductDiscount, 2, '.', '')) ?></td>
								</tr>
								<tr>
									<td colspan="2"></td>
									<td colspan="2">Grand Total (Rs.)</td>
									<td><?php echo(number_format((float)($Total - $ProductDiscount), 2, '.', '')) ?></td>
								</tr>
								<?php
								if ($ProductPymntMethod == '0')
								{
									?>
									<tr>
										<td colspan="2"></td>
										<td colspan="2">Payment (Rs.)</td>
										<td><?php echo(number_format((float)$ProductCash, 2, '.', '')) ?></td>
									</tr>
									<tr>
										<td colspan="2"></td>
										<td colspan="2">Balance (Rs.)</td>
										<td><?php echo(number_format((float)$ProductBalance, 2, '.', '')) ?></td>
									</tr>
									<?php 
								}
								else {}
									?>
								<tr>
									<td colspan="2" class="text-left"></td>
									<td colspan="2"> </td>
									<td> </td>
								</tr>
							</tfoot>
						</table><br><br><br>
						<div class="thanks text-center">Thank you! Come Again...</div>
						<div class="notices">
							<div>NOTICE:</div>
							<div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
						</div>
					</main>
					<footer>
						Invoice was created on a computer and is valid without the signature and seal.
					</footer>
				</div>
				<!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
				<div></div>
			</div>
		</div>

		<script type="text/javascript">
			window.print();
			window.close();
		</script>
		
		<?php  

	}
	else
	{
		echo "<script type='text/javascript'>alert('Receipt Printing Error. Please Contact System Admin.')</script>"; 

		?>
		<html>
		<head>
			<meta http-equiv="Refresh" content="0;url=pos.php">
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
	echo "<script type='text/javascript'>alert('Receipt Printing Error. Please Contact System Admin.')</script>"; 

	?>
	<html>
	<head>
		<meta http-equiv="Refresh" content="0;url=pos.php">
		<title>Loading ...</title>
	</head>
	<body>
	</body>
	</html>
	<?php 
}
?>





