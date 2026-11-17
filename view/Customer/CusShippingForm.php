<?php 
include('../../control/Customer/HeadAndFooter/HeaderCus.php'); 
include('../../model/db_connection.php'); 
$Connection = setConnection();

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
?>


<style type="text/css">
	h4, h5{
		margin-top: 10px;
	}
	h4 span,h5 .tpcc{ 
		font-family: cursive;
		color: #001313;
		text-decoration: underline;
	}
	#frmShipping div{
		margin-top: 5px;
	}
	.element {
		@include float-left;
	}
	.another-element {
		@include float-right;
	}
	.one-more {
		@include float-none;
	}
	form #btnShippingData{
		margin-right: 20px;
	}
</style>


<div class="container-fluid" style="margin-top: 70px;">
	<div class='card card-product-grid'>
		<h4>&nbsp;&nbsp;&nbsp;
			<span> Enter Your Shopping Details </span></h4>
			<form id="frmShipping" action="../../control/Customer/manageShippingDetails.php" method="POST" style="padding: 10px;">
				<div class="row" style="margin-top: -5px;">
					<div class="col">
						<label class="col">
							Name:
							<span class="" style="color: red;">*</span>
						</label>
						<input class="col form-control form-control-sm" type="text" id="txtCusName" name="txtCusName" required>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<label class="col">
							Tel:
							<span class="" style="color: red;">*</span>
						</label>
						<input class="col form-control form-control-sm" pattern="[0-9]{10}" title="Ex: 0771234567 (10 numbers only)" type="tel" id="txtTel" name="txtTel" required>
					</div>
					<div class="col">
						<label class="col">
							Email:
							<span class="" style="color: red;">*</span>
						</label>
						<input class="col form-control form-control-sm" type="email" title="Ex: example@info.com" id="txtEmail" name="txtEmail" required>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<label class="col">
							Shipping Address:
							<span class="" style="color: red;">*</span>
						</label>
						<textarea class="col form-control form-control-sm" id="txtAddress" name="txtAddress" style="resize: none;" cols="40" rows="2" required></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<div class="alert-sm alert-info" role="alert">
							&nbsp;&nbsp;
							# Every orders will be cofirm over telephone call before shipping.
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<span class="float-left" style="color: red;">* Feilds are required.</span>

						<?php if ((isset($_SESSION['Total']) && !empty($_SESSION['Total']) && 0<$_SESSION['Total'])): ?>
							<input type="submit" class="btn btn-primary float-right" id="btnShippingData" name="btnShippingData" value="Place Order">
						<?php endif ?>
					</div>
				</div>
			</form>

			<div class='card card-product-grid' style="padding: 20px;">
				<h5>&nbsp;&nbsp;&nbsp;
					<span class="tpcc">
						Ordered Items
					</span> 
					- Total Amount: Rs. 
					<span id="netTotal">
						<?php
						$Ttl = 0.00;
						if ((isset($_SESSION['Total']) && !empty($_SESSION['Total']) && 0<$_SESSION['Total'])) {
							// $Ttl = $_SESSION['Total'];
							$Ttl = "0.00";
						}

						echo(number_format((float)($Ttl), 2, '.', ''));
						?>
					</span></h5>

					<table class="table table-striped table-hover table-condensed">
						<?php
						$_SESSION['Total'] ="0";
						if (isset($_SESSION['CartArr']) &&  0 < sizeof($_SESSION['CartArr'])) {

							$DataRow = "<tr>";
							$DataRow .= "<td>#</td>";
							$DataRow .= "<td>Product</td>";
							$DataRow .= "<td>Price</td>";
							$DataRow .= "<td>Qty</td>";
							$DataRow .= "<td> Sub Total</td>";
							$DataRow .= "</tr>";
							echo $DataRow;


							$Cau = (is_numeric($_SESSION['cartID']) ? (int)$_SESSION['cartID'] : 0);
							$Cau++;

							$DataRow ="";
							$No = 1;
							$Total = 0;
							for ($row = 0; $row < $Cau; $row++) {
								if (isset($_SESSION['CartArr'][$row])) {

									$ID = $_SESSION['CartArr'][$row][4];
									$query = "SELECT * FROM `tb_product` WHERE `Product_ID` = '$ID' ";
									$Result=mysqli_query($Connection, $query);

									while ($record = mysqli_fetch_assoc($Result)) 
									{
										$ProductName=$record['Product_ProductName'];
										$ProductImg=$record['Product_ImageLocation'];
									}

									$DataRow = "<tr>";
									$DataRow .= "<td>".$No.")</td>";
									$DataRow .= "<td><img src='../AdminUser/prd_Images/".$ProductImg."' height='80px'> &nbsp;&nbsp; &nbsp;&nbsp;".$ProductName."</td>";
									$DataRow .= "<td>Rs. ".number_format((float)($_SESSION['CartArr'][$row][2]), 2, '.', '')."</td>";
									$DataRow .= "<td>".$_SESSION['CartArr'][$row][3]."</td>";

									$SubTotal = ((is_numeric($_SESSION['CartArr'][$row][2]) ? (float)$_SESSION['CartArr'][$row][2] : 0) * (is_numeric($_SESSION['CartArr'][$row][3]) ? (int)$_SESSION['CartArr'][$row][3] : 0));

									$DataRow .= "<td> Rs. ".number_format((float)($SubTotal), 2, '.', '')."</td>";
									$DataRow .= "</tr>";
									$Total += $SubTotal;
									$No++;
									echo $DataRow;
								}

							}
							$_SESSION['Total'] = $Total;

						}
						else
						{
							$DataRow = "<tr>";
							$DataRow .= "<td colspan='6'> No Items in Your Cart.</td>";
							$DataRow .= "</tr>";
							unset($_SESSION['cartID']);
							unset($_SESSION['CartArr']);
							unset($_SESSION['Total']);
							echo $DataRow;
						}
						?>
					</table>
				</div>
			</div>
		</div>
		<br><br><br>

		<script type="text/javascript">
			<?php 
			$TTT = $Total;
			 ?>
			document.getElementById('netTotal').innerHTML = <?php echo(number_format((float)($TTT), 2, '.', '')); ?>;
			<?php 
			$_SESSION['Total'] = $Total;
			?>
		</script>








		<!-- Footer part Start from here -->
		<?php include('../../control/Customer/HeadAndFooter/FooterCus.php'); ?>