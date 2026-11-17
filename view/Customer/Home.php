<?php 
include('../../control/Customer/HeadAndFooter/HeaderCus.php'); 
include('../../model/db_connection.php'); 
?>
<style type="text/css">
	.PrdctBox{
		padding: 10px;
		border-radius: 8%;
		margin-right: auto;
		margin-left: auto;
		margin-bottom: 10px;
	}
	.PrdctBox .PrdctImg img{
		height: 160px;
		width: 175px; 
		border-radius: 13%;
		border: 1px solid black;
		/*box-shadow: 5px 5px #adaaaa;*/
	}
	.PrdctName{
		margin-top: 10px;
	}
	.PrdctName label{
		font-family: cursive;
		font-size: 20px;
	}
	.PrdctPrice{

	}
	.PrdctAddCart a{
		margin: auto;
		float: center;
		max-width: 200px;
	}
</style>
<!-- $_SESSION['CustomerCart'] -->
<?php

$Connection = setConnection();

if (isset($_POST['btnSearchPrdtsUser']) && !empty($_POST['txtSearchPrdtsUser'])){	
	$SearchText = $_POST['txtSearchPrdtsUser'];
}
else{
	$SearchText = "0";
}
?>



<div class="container-fluid" style="margin-top: 70px;">
	<div id="" class=""> 
		<div class="">
			<!-- ******************************************************** -->
			<div class="row form-inline">
				<?php 
				if ($SearchText == "0") {
					$Query = "SELECT * FROM `tb_inventory` INNER JOIN `tb_product` ON `tb_product`.`Product_ID` = `tb_inventory`.`tb_Product_Product_ID` WHERE  0 < `Inventory_CurrentQty` AND `Product_OpenSale`=1 GROUP BY `tb_Product_Product_ID`";
				}
				else{
					$Query = "SELECT * FROM `tb_inventory` INNER JOIN `tb_product` ON `tb_product`.`Product_ID` = `tb_inventory`.`tb_Product_Product_ID` WHERE  0 < `Inventory_CurrentQty` AND `tb_product`.`Product_ProductName` LIKE '%$SearchText%' AND `Product_OpenSale`=1 GROUP BY `tb_Product_Product_ID`";
				}

				$Result=mysqli_query($Connection, $Query);
				if (0 < mysqli_num_rows($Result)) {
					while ($row = mysqli_fetch_assoc($Result)) {
						$InvenID = $row['Inventory_ID'];
						$ImgLocat = $row['Product_ImageLocation'];
						$PrdctName = $row['Product_ProductName'];
						$QtyExists = $row['Inventory_CurrentQty'];
						$Price = $row['Inventory_UnitSellingPrice'];

						$PriceCheck = is_float($Price);
						if ($PriceCheck == true) {
							$Price = $Price;
						}
						else{
							$Price = number_format((float)($Price), 2, '.', '');
						}

						$Window = "<div class='card card-product-grid PrdctBox'>";
						$Window .= "<div class='PrdctImg'>";
						$Window .= "<img src='../AdminUser/prd_Images/".$ImgLocat."'>";
						$Window .= "</div>";
						$Window .= "<div class='PrdctName'>";
						$Window .= "<label>".$PrdctName."</label>";
						$Window .= "</div>";
						$Window .= "<div class='price-wrap mt-2 PrdctPrice'>";
						$Window .= "<label>Unit Price - Rs.".$Price."</label>";
						$Window .= "</div>";
						$Window .= "<div class='PrdctAddCart mt-2'>";
						$Window .= "<a href='CusShopCart.php?id=".$InvenID."' class='btn btn-block btn-primary'>Add to cart </a>";
						$Window .= "</div>";
						$Window .= "</div>";

						echo $Window;
					}
				}
				else{
					$Window = "<div class='card card-product-grid' style='text-align:center; font-size:25px; width: 100%'>";
					$Window .= "<br><br>";
					$Window .= " No Products to buy. Sorry for your convenience.";
					$Window .= "<br><br><br>";
					$Window .= "</div>";
					echo $Window;
				}
				?>
			</div>

			<!-- ******************************************************** -->
		</div>
	</div>
</div>
<br><br><br>
 
<!-- Footer part Start from here -->
<?php include('../../control/Customer/HeadAndFooter/FooterCus.php'); ?>