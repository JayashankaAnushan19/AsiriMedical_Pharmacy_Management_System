<?php 
include('../../control/Customer/HeadAndFooter/HeaderCus.php'); 
include('../../model/db_connection.php'); 
$Connection = setConnection();

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

?>

<style type="text/css">
	#mainTable tbody tr td{
		padding: auto 0px;
	}
	h4{
		margin-top: 10px;
	}
	h4 span{ 
		font-family: cursive;
		color: #001313;
		text-decoration: underline;
	}
	#btnPlaceOrder{
		margin-right: 20px;
		margin-bottom: 20px;
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
	img {
		padding: 5px;
		border: 1px solid #555;
	}
</style>

<?php 

if (isset($_GET['act']) && $_GET['act']=="DelItm" && $_GET['id'] != "")
{
	$RemID = $_GET['id'];

	$ID = (is_numeric($_SESSION['cartID']) ? (int)$_SESSION['cartID'] : 0);
	$ID++;
	for ($i=0; $i < $ID ; $i++) 
	{
		if ($_SESSION['CartArr'][$i][0] == $RemID) 
		{
			unset($_SESSION['CartArr'][$i]);

			?>
			<html>
			<head>
				<meta http-equiv="Refresh" content="0;url=CusShowShopCart.php">
				<title>Loading ...</title>
			</head>
			<body>
			</body>
			</html>
			<?php 

		}
		else
		{

			?>
			<html>
			<head>
				<meta http-equiv="Refresh" content="0;url=CusShowShopCart.php">
				<title>Loading ...</title>
			</head>
			<body>
			</body>
			</html>
			<?php 

		}	  
	}
}

?>



<div class="container-fluid" style="margin-top: 70px;">
	<div class='card card-product-grid PrdctBox'>

		<h4>&nbsp;&nbsp;&nbsp;<span>Your Shopping Cart...</span></h4>

		<?php 
		// print_r($_SESSION);
		// unset($_SESSION['CartArr']);
		// unset($_SESSION['cartID']);
		// unset($_SESSION['Temp']);
		?>

		<table class="table table-striped table-hover table-condensed" id="mainTable">
			<thead class="thead">
				<th>#</th>
				<th>Product</th>
				<th>Price</th>
				<th>Qty</th>
				<th>Sub Total</th>
				<th>Remove</th>
			</thead>
			<tbody>
				<?php
				$_SESSION['Total'] ="0";
				if (isset($_SESSION['CartArr']) &&  0 < sizeof($_SESSION['CartArr'])) {
					// print_r($_SESSION['CartArr']);

					// $max=sizeof($_SESSION['CartArr']);
					// $max++;
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
							$DataRow .= "<td><a href='CusShowShopCart.php?act=DelItm&id=".$_SESSION['CartArr'][$row][0]."' class='btn btn-danger'><i class='fa fa-trash' aria-hidden='true'></i></a></td>";
							$DataRow .= "</tr>";
							$Total += $SubTotal;
							$No++;
							echo $DataRow;
						}

					}

					$DataRow = "<tr>";
					$DataRow .= "<td colspan='3'></td>";
					$DataRow .= "<td>Total</td>";
					$DataRow .= "<td> Rs. ".number_format((float)($Total), 2, '.', '')."</td>";
					$DataRow .= "<td></td>";
					$DataRow .= "</tr>";
					if (isset($SubTotal) && 0<$SubTotal) {
						$_SESSION['Total'] ="0";
						$_SESSION['Total'] = $Total;
					}
					echo $DataRow;

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
				<tr></tr>
			</tbody>
		</table><hr>
		
		

		<?php 


		if (isset($Total) && 0 < $Total) {
			?>
			<div class="row">
				<div class="col float-right">
					<a href="CusShippingForm.php">
						<button height="10px" id="btnPlaceOrder" name="btnPlaceOrder" class=" tn btn-primary btn-lg float-right">Place Order</button>
					</a>
				</div>

			</div>

			<?php 
		}
		?>
	</div>
</div><br><br>
<!-- Footer part Start from here -->
<?php include('../../control/Customer/HeadAndFooter/FooterCus.php'); ?>