<?php 
include('../model/db_connection.php'); 
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
		/*padding: 15px;*/
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
		/*padding: 10px 20px;*/
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



<!--Author      : @arboshiki-->
<div id="invoice" class="sheet padding-10mm">

	<!-- <div class="toolbar hidden-print">
		<div class="text-right">
			<button id="printInvoice" onclick="window.print()" class="btn btn-info"><i class="fa fa-print"></i> Print</button>
			<button class="btn btn-info"><i class="fa fa-file-pdf-o"></i> Export as PDF</button>
		</div>
		<hr>
	</div> -->
	<div id="invoice" class="invoice overflow-auto">
		<div style="min-width: 600px">
			<header>
				<div class="row">
					<div class="col">
						<a target="_blank" href="https://lobianijs.com">
							<img src="../assets/img/logoo1.png" data-holder-rendered="true" width="80px;" />
						</a>
					</div>
					<div class="col company-details">
						<h4 class="name">
							Airi Medical Pvt Ltd
						</h4>
						<div>No.58, Kurunegala Rd, Polgahawela.</div>
						<div>(037) 2244 354</div>
					</div>
				</div>
			</header>
			<main>
				<div class="row contacts">
					<div class="col invoice-to">
						<div class="text-gray-light">INVOICE TO:</div>
						<h6 class="to">Mr./Mrs./Thev.  Tharindu Deshan</h6>
					</div>
					<div class="col invoice-details">
						<h6 class="invoice-id">INVOICE No: #2565225</h6>
						<div class="date">Date of Invoice: 01/10/2018</div>
						<div class="date">Time: 22.54 am</div>
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
						<tr>
							<td class="no">04</td>
							<td class="text-left">
								Youtube channel-Useful videos-to improve your Javascript skills. Subscribe and stay tuned :)
							</td>
							<td class="unit">0.00</td>
							<td class="qty">100</td>
							<td class="total">0.00</td>
						</tr>
						<tr>
							<td class="no">01</td>
							<td class="text-left">Website DesignCreating a recognizable design solution based on the company's existing visual identity</td>
							<td class="unit">40.00</td>
							<td class="qty">30</td>
							<td class="total">1,200.00</td>
						</tr>
						<tr>
							<td class="no">02</td>
							<td class="text-left">Website DevelopmentDeveloping a Content Management System-based Website</td>
							<td class="unit">40.00</td>
							<td class="qty">80</td>
							<td class="total">3,200.00</td>
						</tr>
						<tr>
							<td class="no">03</td>
							<td class="text-left">Search Engines OptimizationOptimize the site for search engines (SEO)</td>
							<td class="unit">40.00</td>
							<td class="qty">20</td>
							<td class="total">800.00</td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="2"></td>
							<td colspan="2">SUBTOTAL</td>
							<td>5,200.00</td>
						</tr>
						<tr>
							<td colspan="2" class="text-left">Payment Method: Cash</td>
							<td colspan="2">Discount</td>
							<td>1,300.00</td>
						</tr>
						<tr>
							<td colspan="2" class="text-left"></td>
							<td colspan="2">GRAND TOTAL</td>
							<td>6,500.00</td>
						</tr>
					</tfoot>
				</table><br><br><br>
				<div class="thanks text-center">Thank you!</div>
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