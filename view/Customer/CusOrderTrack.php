<?php 
include('../../control/Customer/HeadAndFooter/HeaderCus.php'); 
include('../../model/db_connection.php'); 
$Connection = setConnection();

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
?>

<style type="text/css">
	form{
		margin-top: 50px;
	}
	form #mainDiv{
		padding: 10px;
		margin: auto;
		width: 50%;
		border: 1px solid green;
	}
	form #mainDiv div{
		margin-top: 5px;
	}
	form #mainDiv #btnTrack{
		padding: 2px;
		margin-left: 33.3%;
		margin-top: 10px;
		width: 33.3%;
		height: 50px;
	}
	#orderTitle{
		font-family: cursive;
		width: 100%;
		text-align: center;
		text-decoration: underline;
		font-size: 20px;
	}
	#btnNewTrack{
		padding: auto;
		margin-left: 33.3%;
		margin-top: 10px;
		width: 33.3%;
	}
</style>



<div id="detailFrm" class="container-fluid" style="margin-top: 70px;">
	<div class='card card-product-grid PrdctBox'>
		<form action="CusOrderTrack.php" class="form" method="POST">
			<div id="mainDiv">
				<div class="col">
					<label id="orderTitle">
						Enter Order Details
					</label>
				</div>
				<div id="orderAlertDiv" style="display: none;" class="col alert alert-danger alert-dismissible fade show" role="alert">
					<label id="orderAlert" class="" style="text-align: center;">
						Err Message
					</label>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>					
				</div>
				<div class="col">
					<div class="row">
						<div class="col">
							<label>Order Number</label>
						</div>
						<div class="col">
							<input class="form-control" type="text" id="txtOrder" name="txtOrder" required>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="row">
						<div class="col">
							<label>Email</label>
						</div>
						<div class="col">
							<input class="form-control" type="email" id="txtEmail" name="txtEmail" required>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="row">
						<div class="col">
							<label>Tel</label>
						</div>
						<div class="col">
							<input class="form-control" type="tel" pattern="[0-9]{10}" title="Ex: 071234567" id="txtTel" name="txtTel" required>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="row">
						<div class="col">
							<input type="submit" class="btn btn-primary btn-lg" id="btnTrack" name="btnTrack" value="Track Order">
						</div>
					</div>
				</div>
			</div>
			<br><br><br>
		</form>

	</div>
</div>


<?php 

if (isset($_POST['btnTrack']) && !empty($_POST['txtOrder']) && !empty($_POST['txtEmail']) && !empty($_POST['txtTel'])) {
	$OrderNo = $_POST['txtOrder'];
	$Email = $_POST['txtEmail'];
	$Tel = $_POST['txtTel'];

	$Query = "SELECT * FROM `tb_onlinesellinvoices` WHERE `OnlineSellInvoices_ID`='$OrderNo' AND `OnlineSellInvoices_Email`='$Email' AND `OnlineSellInvoices_Tel`='$Tel' LIMIT 1";

	echo "<script>alert({$OrderNo} - {$Email} - {$Tel})</script>";

	$Result = mysqli_query($Connection, $Query);

	if (mysqli_num_rows($Result)==1 || 0 <  mysqli_num_rows($Result) ) {
		$row = mysqli_fetch_assoc($Result);

		echo "<script>alert('Data Found')</script>";

		$Order = $row['OnlineSellInvoices_ID'];
		$Customer = $row['OnlineSellInvoices_CustomerName'];
		$Address = $row['OnlineSellInvoices_BillingAddress'];
		$Email = $row['OnlineSellInvoices_Email'];
		$Status = $row['OnlineSellInvoices_OrderStatus'];

		if ($Status == "0") {
			$Status = "Order Pending.";
		}
		elseif($Status == "1"){
			$Status = "Order Shipped.";
		}


		?>
		<div id="orderFrm" class="container-fluid" style="margin-top: 70px;">
			<div class='card card-product-grid PrdctBox'>
				<form class="form">
					<div id="mainDiv">
						<div class="col">
							<label style="font-family: cursive; width: 100%; text-align: center; text-decoration: underline; font-size: 20px;">
								Order Status
							</label>
						</div>
						<div class="col">
							<div class="row">
								<div class="col">
									<label>Order Number</label>
								</div>
								<div class="col">
									<label class="form-control"><?php echo $Order; ?></label>
								</div>
							</div>
						</div>
						<div class="col">
							<div class="row">
								<div class="col">
									<label>Customer Name</label>
								</div>
								<div class="col">
									<label class="form-control"><?php echo $Customer; ?></label>
								</div>
							</div>
						</div>
						<div class="col">
							<div class="row">
								<div class="col">
									<label>Shipping Address</label>
								</div>
								<div class="col">
									<label class="form-control"><?php echo $Address; ?></label>
								</div>
							</div>
						</div>
						<div class="col">
							<div class="row">
								<div class="col">
									<label>Email</label>
								</div>
								<div class="col">
									<label class="form-control"><?php echo $Email; ?></label>
								</div>
							</div>
						</div>
						<div class="col">
							<div class="row">
								<div class="col">
									<label>Order Status</label>
								</div>
								<div class="col">
									<label class="form-control"><?php echo $Status; ?></label>
								</div>
							</div>
						</div>
						<div class="col">
							<div class="row">
								<div class="col">
									<a href="CusOrderTrack.php" class="btn btn-info" id="btnNewTrack">Track New Order</a>
								</div>
							</div>
						</div>
					</div>
					<br><br><br>
				</form>
			</div>
		</div>
		<html translate="no">
		<script type="text/javascript">
			
			document.getElementById('orderFrm').style.display = 'block';
			document.getElementById('detailFrm').style.display = 'none';
		</script>
		<?php

	}
	else{
		?>
		<script type="text/javascript">
			document.getElementById('orderAlertDiv').style.display = 'block';
			document.getElementById('orderAlert').innerHTML = " Wrong input. Please Enter valid Details"; 
			document.getElementById('orderFrm').style.display = 'none';
			document.getElementById('detailFrm').style.display = 'block';
		</script>
		<?php 
	}
}
else{
	?>
	<script type="text/javascript">
		document.getElementById('orderFrm').style.display = 'none';
		document.getElementById('detailFrm').style.display = 'block';
	</script>

	<?php  

}

?>
<script type="text/javascript">
	$('.alert').alert()
</script>








<!-- Footer part Start from here -->
<?php include('../../control/Customer/HeadAndFooter/FooterCus.php'); ?>