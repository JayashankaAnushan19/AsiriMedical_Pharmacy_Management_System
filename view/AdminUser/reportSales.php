<?php 
include('../../model/db_connection.php'); 
include('../../control/AdminUser/HeadAndFooter/header.php'); 
?>

<?php 
if (isset($_POST['btnBuySellAll'])){

	echo "<script language=\"javascript\">window.open('printBuySellAll.php?act=BuySellAll&frm=".$_POST['frm']."&to=".$_POST['to']."',\"_blank\");</script>"; 
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
if (isset($_POST['btnSalesReport'])){

	echo "<script language=\"javascript\">window.open('printSales.php?act=salesRepo&frm=".$_POST['SLfrm']."&to=".$_POST['SLto']."',\"_blank\");</script>"; 
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

<style type="text/css">
	.mainTopic{
		color: #000000;
		font-size: 28px;
		font-family: fantasy;
	}
	.subTopic{
		color: #000000;
		font-size: 20px;
		font-family: initial;
		text-decoration: underline;
	}
	.reportType{
		color: black;
		padding-left: 50px;
		text-decoration: underline;
	}
	.newreportType{
		color: black;
		padding-left: 10px;
		text-decoration: underline;
	}
</style>


<div class="container-fluid">
	<div class="card shadow"> 
		<div class="card-header">
			<h5 class="mainTopic">- Sales Reports</h5>
		</div>
		<div class="card-body shadow">
			<h3 class="subTopic">For All Products</h3>
			<form action="reportSales.php" method="POST">
				<input type="text" name="act" value="BuySellAll" hidden>
				<div class="form-inline">
					<div class="col-4 reportType">Buy and Sales of All Products</div>

					<label class="col" for="frm">From: </label>
					<input class="col-2 form-control" type="date" name="frm" required>
					<label class="col" for="to">To: </label>
					<input class="col-2 form-control" type="date" name="to" required>

					<div class="col"></div>

					<input type="submit" class="btn btn-info" style="float: right;" value="View and Print" name="btnBuySellAll">

					<div class="col"></div>
				</div>
			</form>
			<form action="reportSales.php" method="POST">
				<input type="text" name="act" value="BuySellAll" hidden>
				<div class="form-inline">
					<div class="col-4 reportType">Sales of All Products</div>
					<label class="col" for="SLfrm">From: </label>
					<input class="col-2 form-control" type="date" name="SLfrm" >
					<label class="col" for="SLto">To: </label>
					<input class="col-2 form-control" type="date" name="SLto" >

					<div class="col"></div>

					<input type="submit" class="btn btn-info" style="float: right;" value="View and Print" name="btnSalesReport">

					<div class="col"></div>
				</div>
			</form>
		</div>
		<div style="display: none;" class="card-body shadow">
			<h3 class="subTopic">For Specified Products</h3>
			<br>
			<form class="col" action="reportSales.php" method="POST">
				<input type="text" name="act" value="BuySellOne" hidden>
				<div class="col newreportType"><h6>Buy and Sales</h6></div>
				<br>
				<div class="row form-inline">
					<label class="col" for="frm">Product: </label>
					<select class="col-2 form-control">
						<option>1</option>
						<option>2</option>
					</select>
					<label class="col" for="frm">From: </label>
					<input class="col-2 form-control" type="date" name="frm" required>
					<label class="col" for="to">To: </label>
					<input class="col-2 form-control" type="date" name="to" required>
					<div class="col"></div>
					<input type="submit" class="col-2 btn btn-info" style="float: right;" value="View and Print" name="btnBuySellAllOne">
				</div>
			</form>
			<form class="col" action="reportSales.php" method="POST">
				<input type="text" name="act" value="BuySellOne" hidden>
				<div class="col newreportType"><h6>Sales</h6></div>
				<br>
				<div class="row form-inline">
					<label class="col" for="frm">Product: </label>
					<select class="col-2 form-control">
						<option>1</option>
						<option>2</option>
					</select>
					<label class="col" for="frm">From: </label>
					<input class="col-2 form-control" type="date" name="frm" required>
					<label class="col" for="to">To: </label>
					<input class="col-2 form-control" type="date" name="to" required>
					<div class="col"></div>
					<input type="submit" class="col-2 btn btn-info" style="float: right;" value="View and Print" name="btnSalesReportOne">
				</div>
			</form>
		</div>
	</div>
</div>



<!-- Footer part Start from here -->
<?php include('../../control/AdminUser/HeadAndFooter/footer.php');?>



<!-- <div class="card-header">
	Sales Report
</div>
<div class="card-body shadow">
	<h6><u><i> For Specialied Products </i></u></h6>
	<br><br>
	<form action="#.php" method="POST">
		<input type="text" name="act" value="BuySellAll" hidden>
		<div class="form-inline">
			<label class="col" for="frm">From: </label>

			<?php
			try
			{
				$Connection = setConnection();

				$myCoCommand = "SELECT DISTINCT `tb_product`.`Product_ID` , `tb_product`.`Product_ProductName` FROM `tb_inventory` INNER JOIN `tb_product` ON `tb_inventory`.`tb_Product_Product_ID` = `tb_product`.`Product_ID` WHERE `Inventory_CurrentQty` > 0 ORDER BY `tb_product`.`Product_ProductName` ASC";
				$CoResult=mysqli_query($Connection, $myCoCommand);

				$prdctToPurchase = '<select id="slctPdrctID" name="slctPdrctID" class="col form-control form-control-sm" required>';

				while ($record = mysqli_fetch_assoc($CoResult)) 
				{
					$ProductID=$record['Product_ID'];
					$ProductName=$record['Product_ProductName'];

					$prdctToPurchase .='<option value="'.$ProductID.'">'.$ProductName.'</option>';
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
			<script src="../../assets/js/jquery-editable-select-master/jquery-1.12.4.min.js"></script>
			<script src="../../assets/js/jquery-editable-select-master/jquery-editable-select.min.js"></script>
			<link href="../../assets/js/jquery-editable-select-master/jquery-editable-select.min.css" rel="stylesheet">
			<script>
				$('#slctPdrctID').editableSelect();
			</script>

			<label class="col" for="frm">From: </label>
			<input class="col-2 form-control" type="date" name="frm" >
			<label class="col" for="to">To: </label>
			<input class="col-2 form-control" type="date" name="to" >

			<div class="col"></div>

			<input type="submit" class="btn btn-info" style="float: right;" value="View and Print" name="btnBuySellUnit">

			<div class="col"></div>
		</div>
	</form>
	<br>
	<div class="notice">**
		<span>This option can use to view all products status with given date range</span>
	</div>
	<style type="text/css">
		.notice{
			background: #f1f1ff;
		}
		.notice span{
			text-decoration: underline;
		}
	</style>
</div> -->