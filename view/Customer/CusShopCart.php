<?php 
include('../../control/Customer/HeadAndFooter/HeaderCus.php'); 
include('../../model/db_connection.php'); 
$Connection = setConnection();

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

?>

<style type="text/css">
	.PrdctBox{
		margin: 90px;
		padding: 10px;
		height:50%;
	}
	.PrdctImg{
		width:400px;
		height:300px;
	}
	.PrdctImg img {
		width:400px;
		height:400px;
		padding: auto;
		float:left;
	}
	.PrdctDetails{
		padding: auto auto;
		margin-right: 10px;
		float:right;
		font-size: 20px;
	}
	.PrdctDetailInside{
		margin-top: auto;
		padding: 30% 50px;
		float: left;
	}
	.PrdctDetailInside button{
		margin-top: 5px;
	}
</style>





<?php 

if (isset($_POST['btnAddToCart']))
{
	if (isset($_POST['txtQty']) && !empty($_POST['txtQty']))
	{

		if (isset($_SESSION['CartArr'])) {


			$ID = (is_numeric($_SESSION['cartID']) ? (int)$_SESSION['cartID'] : 0);
			$ID++;


			for ($i=0; $i < $ID ; $i++) { 
				
				if ($_SESSION['CartArr'][$i][0] == $_POST['txtInventID']) {
					$NewQty = (is_numeric($_SESSION['CartArr'][$i][3]) ? (int)$_SESSION['CartArr'][$i][3] : 0) + (is_numeric($_POST['txtInventID']) ? (int)$_POST['txtInventID'] : 0);
					if ($_POST['txtExistQty'] < $NewQty) {
						echo "<script type='text/javascript'>alert('Item request cannot exceed. Out of Stock.')</script>";
						$_SESSION['Temp']=1;
					}
					else{
						$_SESSION['CartArr'][$i][3] += $_POST['txtQty'];
						echo "<script type='text/javascript'>alert('Item Qty incresed successfully.')</script>";
						$_SESSION['Temp']=1;
					}
				}

				// echo "<script type='text/javascript'>alert('For loop {$_SESSION}.')</script>";
			}
			if ($_SESSION['Temp'] != 1) {
				$_SESSION['CartArr'][$ID][0] = $_POST['txtInventID'];
				$_SESSION['CartArr'][$ID][1] = $_POST['txtUnitCost'];
				$_SESSION['CartArr'][$ID][2] = $_POST['txtUnitSell'];
				$_SESSION['CartArr'][$ID][3] = $_POST['txtQty'];
				$_SESSION['CartArr'][$ID][4] = $_POST['txtPrdctID'];

				$_SESSION['Temp'] = 0;
				$_SESSION['cartID'] = $ID;
				echo "<script type='text/javascript'>alert('Item Added to cart successfully. Re-Direct to Home Page')</script>";
			}
			else{
				$_SESSION['Temp'] = 0;
			}
		}
		else
		{
			$_SESSION['CartArr'] = array();
			$ID = "0";
			$_SESSION['CartArr'][$ID] = array();

			$_SESSION['CartArr'][$ID][0] = $_POST['txtInventID'];
			$_SESSION['CartArr'][$ID][1] = $_POST['txtUnitCost'];
			$_SESSION['CartArr'][$ID][2] = $_POST['txtUnitSell'];
			$_SESSION['CartArr'][$ID][3] = $_POST['txtQty'];
			$_SESSION['CartArr'][$ID][4] = $_POST['txtPrdctID'];

			$_SESSION['cartID'] = $ID;
			echo "<script type='text/javascript'>alert('Item Added to cart successfully. Re-Direct to Home Page')</script>";

			
		}
	}
	else
	{
		echo "<script type='text/javascript'>alert('Empty Values detected. Please Enter valid details.')</script>";
	}
}

?>




<?php 
if (isset($_GET['id']) && !empty($_GET['id'])) 
{
	$ID = $_GET['id'];

	$Query = "SELECT * FROM `tb_inventory` INNER JOIN `tb_product` ON `tb_product`.`Product_ID` = `tb_inventory`.`tb_Product_Product_ID` WHERE  `Inventory_ID` = '$ID'";
	$Result=mysqli_query($Connection, $Query);
	if ($row = mysqli_fetch_assoc($Result)) {
		$InvenID = $row['Inventory_ID'];
		$ImgLocat = $row['Product_ImageLocation'];
		$PrdctID = $row['Product_ID'];
		$PrdctName = $row['Product_ProductName'];
		$QtyExists = $row['Inventory_CurrentQty'];
		$Cost = $row['Inventory_UnitCost'];
		$Price = $row['Inventory_UnitSellingPrice'];
	}
	$PriceCheck = is_float($Price);
	if ($PriceCheck == true) {
		$NewPrice = $Price;
	}
	else{
		$NewPrice = number_format((float)($Price), 2, '.', '');
	}
	?>
	<div class="container-fluid" style="margin-top: 70px;">
		<div class='card card-product-grid PrdctBox'>
			<form class="form" action="CusShopCart.php" method="POST">
				<div class="row">
					<div class="col PrdctImg">
						<?php echo "<img src='../AdminUser/prd_Images/".$ImgLocat."'>" ?>
					</div>
					<div class="col PrdctDetails card shadow">
						<div class="PrdctDetailInside">
							<div class="row">
								<div class="col-6">
									Product
								</div>
								<div class="col-6" style="color: black;">
									<input type="text" id="txtInventID" name="txtInventID" value="<?php echo $InvenID ?>"  hidden>
									: <?php echo $PrdctName ?>
								</div>
							</div>
							<div class="row">
								<div class="col-6">
									Unit Price
								</div>
								<div class="col-6" style="color: #2e8fb0">
									<input type="text" id="txtPrdctID" name="txtPrdctID" value="<?php echo $PrdctID ?>"  hidden>
									<input type="text" id="txtExistQty" name="txtExistQty" value="<?php echo $QtyExists ?>" hidden>
									<input type="text" id="txtUnitCost" name="txtUnitCost" value="<?php echo $Cost ?>"  hidden>
									<input type="text" id="txtUnitSell" name="txtUnitSell" value="<?php echo $Price ?>"  hidden>
									:  Rs. <?php echo $NewPrice ?>
								</div>
							</div>
							<div class="row">
								<div class="col-6">
									<label class="">
										Quantity
									</label>
								</div>
								<div class="col-6">
									<input class="form-control form-control-sm" type="number" min="0" step="1" pattern="\d+" id="txtQty" onkeypress="return isNumberKey(event)" onkeyup="" name="txtQty" required>
								</div>
								<script type="text/javascript">
									var input = document.getElementById("txtQty");
									input.addEventListener("keyup", function () {
										calSubTtl(); 
										checkStock();
									});

									function isNumberKey(evt)
									{
										var charCode = (evt.which) ? evt.which : evt.keyCode;
										// alert(charCode);
										if (charCode == 46 && charCode > 31 
											&& (charCode < 48 || charCode > 57))
											return false;
										return true;
									}
									function calSubTtl(){
										var x = parseFloat(document.getElementById('txtUnitSell').value);
										var y = parseFloat(document.getElementById('txtQty').value);
										var m = parseFloat(document.getElementById('txtExistQty').value);

										if (x!=null && x!=null && 0<x) {
											if (y<m || y==m) {
												document.getElementById('txtSubTotal').innerHTML = x * y;
												document.getElementById('divSubTtl').hidden = false;
											}
											else
											{
												alert('Requested quentity not available in Stock. Please enter a lower quentity.');
												document.getElementById('txtQty').value = "0";
												document.getElementById('txtSubTotal').innerHTML = "0.00";
												document.getElementById('divSubTtl').hidden = true;
											}
										}
										else{
											document.getElementById('divSubTtl').hidden = true;
										}
									}
								</script>
							</div>
							<div class="row">
								<div class="col-6">
									<div class="">
										<div id="divSubTtl" hidden>
											Total : Rs. <span id="txtSubTotal">0.00</span>
										</div>
									</div>
								</div>
								<div class="col-6">
									<div class="">
										<button type="submit" class="form-control form-control-sm btn btn-primary" id="btnAddToCart" name="btnAddToCart" style="width: 200px;">
											<i class="fas fa-shopping-cart"></i> &nbsp;&nbsp;
											Add to Cart
										</button>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<?php 

}
else
{
	?>
	<html>
	<head>
		<meta http-equiv="Refresh" content="0;url=Home.php">
		<title>Loading ...</title>
	</head>
	<body>
	</body>
	</html>
	<?php 
}
?>

<?php 

// print_r($_SESSION['CartArr']);

?>

<!-- Footer part Start from here -->
<?php include('../../control/Customer/HeadAndFooter/FooterCus.php'); ?>