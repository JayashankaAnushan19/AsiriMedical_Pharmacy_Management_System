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

<?php 

date_default_timezone_set('Asia/Colombo'); 
$NowTime = date("h:i:s A");
$NowDay = date("Y-m-d");

// $_GET['act'] = "salesRepo";
// $_GET['frm'] = '2020-10-01';
// $_GET['to'] = '2020-10-28';


?>

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
		font-size: 20px;
		background-color: #46d6e0;
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
if (isset($_GET['act'])) {
	if ($_GET['act']=='salesRepo' && $_GET['frm'] !='' && $_GET['to'] !='') 
	{
		$DateFrom = $_GET['frm'];
		$DateTo = $_GET['to'];

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
								<h4><u>Sales Report</u></h4>
								<div class="text-gray-light form-inline">
									From:&nbsp;&nbsp;
									<h6 class="to"><?php echo($DateFrom) ?></h6> &nbsp;&nbsp;&nbsp;&nbsp;
									To:&nbsp;&nbsp;
									<h6 class="to"><?php echo($DateTo) ?></h6>
								</div>
							</div>
						</div>	

						<!-- Show the Graph  -->
						<div style="border: 1px solid red;">
							<div class="row">
								<br>
							</div>
							<div class="row form-inline">
								<div class="col-2"></div>
								<div class="col">
									<div id="chartContainer" style="height: 370px; max-width: 100%; margin: 0px auto;"></div>
									<script src="../../assets/js/canvasjs.min.js"></script>
								</div>
								<div class="col-2"></div>
							</div>
							<div class="row">
								<br>
							</div>
						</div>


						<br><br>

						<table border="1" cellspacing="0" cellpadding="0">
							<thead>
								<tr>
									<th>#</th>
									<th class="text-left"><b>&nbsp;&nbsp; Date &nbsp;</b></th>
									<th class="text-right"><b>&nbsp;&nbsp; Total Sale (Rs.) &nbsp;</b></th>
									<th class="text-right"><b>&nbsp;&nbsp; Total Discount (Rs.) &nbsp;</b></th>
								</tr>
							</thead>
							<tbody>

								<?php 

								$Connection = setConnection();

								$GrossSaleTotal = 0;
								$TotalDiscount = 0;
								$num = 1;
								$dataPoints = array();

								$selectSaleInvoicesDates = "SELECT DISTINCT `SaleInvoice_Date` FROM `tb_saleinvoice` WHERE `SaleInvoice_Date` BETWEEN '$DateFrom' AND '$DateTo'";

								$saleInvoicesDatesExceQuery = mysqli_query($Connection, $selectSaleInvoicesDates);
								while($Data = mysqli_fetch_assoc($saleInvoicesDatesExceQuery))
								{
									$SaleInvoicesDates[] = $Data['SaleInvoice_Date'];

								}

								if (!empty($SaleInvoicesDates)) {

							// print_r($SaleInvoicesDates);
									for ($i=0; $i < count($SaleInvoicesDates); $i++) { 
										$SubGrossTotal = 0;
										$SubTotalDiscount = 0;

										$selectSaleInvoiceIDs = "SELECT `SaleInvoice_ID`,`SaleInvoice_Discount` FROM `tb_saleinvoice` WHERE `SaleInvoice_Date`='$SaleInvoicesDates[$i]'";

										$saleInvoiceIdsExceQuery = mysqli_query($Connection, $selectSaleInvoiceIDs);
										while($DataInvID = mysqli_fetch_assoc($saleInvoiceIdsExceQuery))
										{
											$SaleInvoicesIDs[] = $DataInvID['SaleInvoice_ID'];
											$SubTotalDiscount += $DataInvID['SaleInvoice_Discount'];

										}
										if (!empty($SaleInvoicesIDs)) {

									// print_r($SaleInvoicesIDs);
											for ($j=0; $j < count($SaleInvoicesIDs); $j++) { 

												$selectSaleInvoiceItems = "SELECT * FROM `tb_saleinvoiceitems` WHERE `tb_SaleInvoice_SaleInvoice_ID`='$SaleInvoicesIDs[$j]'";

												$saleInvoiceItemsExceQuery = mysqli_query($Connection, $selectSaleInvoiceItems);
												while($DataInvITEMS = mysqli_fetch_assoc($saleInvoiceItemsExceQuery))
												{
													$Qty = $DataInvITEMS['SaleInvoiceItems_Qty'];
													$Sell = $DataInvITEMS['SaleInvoiceItems_UnitSellingCost'];
													$SubGrossTotal += ($Qty * $Sell);

												}

											}
										}
										else{


											echo "<script type='text/javascript'>alert('No Data for Priting.'); window.exit();</script>"; 
											?>
											<html>
											<head>
												<meta http-equiv="Refresh" content="0;url=gotoPageBecauseOfThis.php">
												<title>Loading ...</title>
											</head>
											<body>
											</body>
											</html>
											<?php 

										}

										$GrossSaleTotal += $SubGrossTotal;
										$TotalDiscount += $SubTotalDiscount;

										$salesReportRowDetails ='<tr>';
										$salesReportRowDetails .='<td class="no">&nbsp;&nbsp;'.$num.'&nbsp;&nbsp;</td>';
										$salesReportRowDetails .='<td class="text-left">&nbsp;&nbsp;'.$SaleInvoicesDates[$i].'&nbsp;&nbsp;</td>';
										$salesReportRowDetails .='<td class="unit">&nbsp;&nbsp;'.number_format((float)($SubGrossTotal), 2, '.', '').'&nbsp;&nbsp;</td>';
										$salesReportRowDetails .='<td class="qty">&nbsp;&nbsp;'.number_format((float)($SubTotalDiscount), 2, '.', '').'&nbsp;&nbsp;</td>';
										$salesReportRowDetails .='</tr>';

										echo $salesReportRowDetails;
										$dataPoint[$num-1] = array("x" => (strtotime($SaleInvoicesDates[$i]) * 1000), "y" => ($SubGrossTotal - $SubTotalDiscount));
										$num++;
									}
								}
								else{


									echo "<script type='text/javascript'>alert('No Data for Priting.'); window.exit();</script>"; 
									?>
									<html>
									<head>
										<meta http-equiv="Refresh" content="0;url=gotoPageBecauseOfThis.php">
										<title>Loading ...</title>
									</head>
									<body>
									</body>
									</html>
									<?php 

								}
								?>

							</tbody>
							<tfoot>
								<tr>
									<td></td>
									<td class="text-right">&nbsp;</td>
									<td class="unit">&nbsp;</td>
									<td class="unit">&nbsp;</td>
								</tr> 
								<tr>
									<td></td>
									<td class="text-right"></td>
									<td class="unit"><b>Total Gross Sale (Rs.)&nbsp;: &nbsp;</b></td>
									<td class="unit"><?php echo(number_format((float)($GrossSaleTotal), 2, '.', '')) ?></td>
								</tr> 
								<tr>
									<td></td>
									<td class="text-right"></td>
									<td class="unit"><b>Gross Discounts (Rs.)&nbsp;: &nbsp;</b></td>
									<td class="unit"><?php echo(number_format((float)($TotalDiscount), 2, '.', '')) ?></td>
								</tr> 
								<tr>
									<td></td>
									<td class="text-right"></td>
									<td class="unit"><b>Gross Sale (Rs.)&nbsp;: &nbsp;</b></td>
									<td class="unit"><?php echo(number_format((float)($GrossSaleTotal - $TotalDiscount), 2, '.', '')) ?></td>
								</tr> 
							</tfoot>
						</table><br><br><br><br><br>
						<div class="thanks text-center">Thank you!</div>
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
			window.onload = function () {

				var chart = new CanvasJS.Chart("chartContainer", {
					animationEnabled: true,
					theme: "light2",
					title:{

					},
					axisX:{
						valueFormatString: "DD MMM YY",
						intervalType: "day",
						interval: 1,
						crosshair: {
							enabled: true,
					// snapToDataPoint: true
						}
					},
					axisY: {
						title: "Gross Sale (Rs.)",
						includeZero: false,
						valueFormatString: "##0.00",
						crosshair: {
							enabled: true,
							snapToDataPoint: true,
							labelFormatter: function(e) {
								return "Rs." + CanvasJS.formatNumber(e.value, "##0.00");
							}
						}
					},
					data: [{
						type: "area",
						markerSize: 5,
						xValueFormatString: "DD MMM YY",
						yValueFormatString: "Rs #,##0.##",
						xValueType: "dateTime",
						dataPoints: <?php echo json_encode($dataPoint, JSON_NUMERIC_CHECK); ?>
					}]
				});
				chart.render();
			}
		</script>
		<script type="text/javascript">
			setTimeout( function() { window.print(); }, 2000);
		</script>
			<?php 

		}
	}
	else
	{
		echo "<script type='text/javascript'>alert('Report Printing Error. Please Contact System Admin.')</script>"; 

		?>
		<html>
		<head>
			<meta http-equiv="Refresh" content="0;url=reportBuyAndSell.php">
			<title>Loading ...</title>
		</head>
		<body>
		</body>
		</html>
		<?php 
	}
	?>


