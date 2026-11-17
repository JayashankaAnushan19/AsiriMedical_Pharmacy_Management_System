<?php 
include('../../control/AdminUser/HeadAndFooter/header.php'); 
include('../../model/db_connection.php'); 

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

?>

<input class="form-control" type="number" name="" min="0" max="' +obj[i][6]+ '" onkeyup ="checkValue(this,' +qty+ ',' +i+ ')" disabled>


<style type="text/css">
	table{
		background-color: #d5f5f0;
	}
	table thead{
		color: black;
		font-size: 15px;
		background-color: #c7d4d2;
	} 
	table tbody{
		color: black; 
	}
	table tbody tr td .btn{
		width: 100px;
	}
	table tbody tr td:first-child {
		background-color: #bdbfbf;
	}
	table tbody tr td:nth-child(6), table tbody tr td:nth-child(3) {
		color: black;
		background-color: #e9f2f2;
	}
	table thead tr td:nth-child(7), table tbody tr td:nth-child(7) {
		text-align: center;
	}
	.heading{
		font-family: fantasy; 
		color: black;
	}
</style>
	

<div class="container-fluid">
	<div class="card shadow"> 
		<div class="card-header">
			
			<div class="form-inline">
				<h3 class="heading" class="col-12 col-sm-6 col-md-8"> Current Stock </h3>
				<!-- <div class="form-inline col-6 col-md-4" style="float: right;">
					<div class="form-group form-check">
						<input type="checkbox" class="form-check-input" id="exampleCheck1">
						<label class="form-check-label" for="exampleCheck1">Include Empty</label>
					</div>
				</div> -->
			</div>
			<input class="col form-control" type="text" onkeyup="mySubCatFunction(0)" placeholder="Search by Product Name..." id="txtSearch" name="txtSearch">
		</div>
		<div class="card-body shadow">
			<div class="table-responsive table mt-2">
				<?php 
				try{

					$Connection = setConnection();

					$myPrdctCommand = "SELECT DISTINCT `tb_Product_Product_ID` FROM `tb_inventory` WHERE `Inventory_CurrentQty`>0";
					$prdctResult=mysqli_query($Connection, $myPrdctCommand);
					while ($Record = mysqli_fetch_assoc($prdctResult)) {
						$StockPrdctIds[] = $Record['tb_Product_Product_ID'];
					}	

					// print_r($StockPrdctIds);

					$table='<table class="table my-0" id="productDataTable">';
					$table.='<thead><tr>
					<td style="background-color: #60b3ac;"><strong>#</strong></td>
					<td><strong>Product ID</strong></td>
					<td><strong>Product Name</strong></td>
					<td><strong>Main Category</strong></td>
					<td><strong>Sub Category</strong></td>
					<td><strong>Current Stock Qty</strong></td>
					<td><strong>View</strong></td>
					</tr></thead><tbody>';


					$num = 1;
					for ($i=0; $i < count($StockPrdctIds) ; $i++) {

						
						$PrdctDetails = "SELECT * FROM `tb_product` INNER JOIN `tb_subcategory` ON `tb_product`.`tb_SubCategory_SubCategory_ID` = `tb_subcategory`.`SubCategory_ID` INNER JOIN `tb_maincategory` on `tb_subcategory`.`tb_MainCategory_MainCategory_ID` = `tb_maincategory`.`MainCategory_ID` WHERE `Product_ID`='$StockPrdctIds[$i]'";

						$PrdctDetailsResult=mysqli_query($Connection, $PrdctDetails);
						while ($PrdctData = mysqli_fetch_assoc($PrdctDetailsResult)) 
						{	
							$Id=$PrdctData['Product_ID'];
							$ProductName=$PrdctData['Product_ProductName'];
							$MainCategoryName=$PrdctData['MainCategory_Name'];
							$SubCategoryName=$PrdctData['SubCategory_Name'];
						}

						$myPrdctQtyfind = "SELECT SUM(`Inventory_CurrentQty`) FROM `tb_inventory` WHERE `Inventory_CurrentQty`>0 AND `tb_Product_Product_ID`='$StockPrdctIds[$i]'";
						$prdctQtyResult=mysqli_query($Connection, $myPrdctQtyfind);
						while ($record = mysqli_fetch_assoc($prdctQtyResult)) 
						{
							$Qty=$record['SUM(`Inventory_CurrentQty`)'];

							$table.='<tr id="'.$Id.'"">';
							$table.='<td>('.$num.')</td>';
							$table.='<td>'.$Id.'</td>';
							$table.='<td>'.$ProductName.'</td>';
							$table.='<td>'.$MainCategoryName.'</td>';
							$table.='<td>'.$SubCategoryName.'</td>';
							$table.='<td class="CurQty">'.$Qty.'</td>';

							$table.='<td>
							<a href="viewStockMoreInfo.php?act=viewInventory&id='.$Id.'">
							<button class="btn btn-primary" onclick="myPrdctUpdateFunction('.$Id.')">
							<i class="fas fa-info-circle"></i>
							</button>
							</a>
							</td>';
							$table.='</tr>';

						}
						$num++;
					}
					$table.='</tbody></table>';
					echo $table;

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
			</div>
			
		</div>
	</div>
</div>

<script type="text/javascript">
	function mySubCatFunction() {
		var input, filter, table, tr, td, i, txtValue;
		input = document.getElementById("txtSearch");
		filter = input.value.toUpperCase();
		table = document.getElementById("productDataTable");
		tr = table.getElementsByTagName("tr");
		var n = 1;
		for (i = 1; i < tr.length; i++) {
			td = tr[i].getElementsByTagName("td")[2];
			if (td) {
				txtValue = td.textContent || td.innerText;
				if (txtValue.toUpperCase().indexOf(filter) > -1) {
					tr[i].style.display = "";
					n += 1;
				} else {
					tr[i].style.display = "none";
				}
			}       
		} 
	}
</script>

<!-- Footer part Start from here -->
<?php include('../../control/AdminUser/HeadAndFooter/footer.php');?>






