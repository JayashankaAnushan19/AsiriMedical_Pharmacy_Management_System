<?php 
include('../../control/AdminUser/HeadAndFooter/header.php'); 
include('../../model/db_connection.php'); 

$Connection = setConnection();

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

// $_GET['act'] ="viewInventory";
// $_GET['id'] = 1;

?>

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
		width: 80px;
	}
	table tbody tr td:first-child {
		background-color: #bdbfbf;
	}
	table{
		text-align: center;
	}
	table tbody tr td:nth-child(5), table tbody tr td:nth-child(3) {
		color: black;
		background-color: #e9f2f2;
	}
	table thead tr td:nth-child(6), table tbody tr td:nth-child(6) {
		text-align: center;
	} 
	.heading{ 
		color: black;
	}
	.heading .headingPdcts{
		font-size: 20px;
		font-family: cursive; 
		color: black;
	}
	.heading .headingPdcts:hover{
		cursor: pointer; 
		color: green;
	}
</style>

<?php 
if (isset($_GET['act'])) {
	if ($_GET['act']=='viewInventory' && $_GET['id'] !='') 
	{
		$PrdctID = $_GET['id'];
		$myPrdctQtyfind = "SELECT * FROM `tb_product` WHERE `Product_ID`='$PrdctID'";
		$prdctQtyResult=mysqli_query($Connection, $myPrdctQtyfind);
		while ($record = mysqli_fetch_assoc($prdctQtyResult)) 
		{
			$PrdctName=$record['Product_ProductName'];
			$PrdctReOrderLevel=$record['Product_ReOrderLevelQty'];
		}
		?>

		<div class="container-fluid">
			<div class="card shadow"> 
				<div class="card-header">
					<div class="form-inline">
						<h3 class="heading" class="col-12 col-sm-6 col-md-8"> Current Stock (<span class="headingPdcts">- <?php echo($PrdctName); ?> -</span>)</h3>
						&nbsp;&nbsp;&nbsp;
						<button class="btn btn-primary" onClick="window.location.reload();">
							<i class="fas fa-sync-alt"></i>
						</button>
					</div> 
				</div><span><a style="text-decoration: none;" href="stock.php">&nbsp;&nbsp; << Back to Stock</a></span>
				<div class="card-body shadow"> 
					<div class="table-responsive table mt-0">
						<?php 
						try{

							$Connection = setConnection();

							$myPrdctCommand = "SELECT * FROM `tb_inventory` INNER JOIN `tb_purchase` on `tb_inventory`.`tb_Purchase_Purchase_ID` = `tb_purchase`.`Purchase_ID` WHERE `tb_Product_Product_ID`='$PrdctID' AND `Inventory_CurrentQty`>0";
							$prdctResult=mysqli_query($Connection, $myPrdctCommand);

							$table='<table class="table my-0" id="productDataTable">';
							$table.='<thead><tr>
							<td style="background-color: #60b3ac;"><strong>#</strong></td>
							<td><strong>Inventory ID</strong></td>
							<td><strong>Purchase Date</strong></td>
							<td><strong>Unit Cost (Rs.)</strong></td>
							<td><strong>Unit Selling (Rs.)</strong></td>
							<td><strong>Current Qty</strong></td>
							<td><strong>Change Selling<br> Price (Rs.)</strong></td>
							</tr></thead><tbody>';


							$num = 0;
							$TtlQty = 0;
							while ($record = mysqli_fetch_assoc($prdctResult)) 
							{
								$num++;
								$InventoryId=$record['Inventory_ID'];
								$PurchaseDate=$record['Purchase_InvoiceDate'];
								$UnitCost=$record['Inventory_UnitCost'];
								$UnitSelling=$record['Inventory_UnitSellingPrice'];
								$CurrentQty=$record['Inventory_CurrentQty'];
								$TtlQty += $CurrentQty;

								$table.='<tr id="'.$InventoryId.'"">';
								$table.='<td>('.$num.')</td>';
								$table.='<td>'.$InventoryId.'</td>';
								$table.='<td>'.$PurchaseDate.'</td>';
								$table.='<td>'.number_format((float)($UnitCost), 2, '.', '').'</td>';
								$table.='<td>'.number_format((float)($UnitSelling), 2, '.', '').'</td>';
								$table.='<td>'.$CurrentQty.'</td>'; 



								$table.='<td>
								<a data-toggle="modal" data-price="'.number_format((float)($UnitSelling), 2, '.', '').'" data-id="'.$InventoryId.'" title="Add this item" class="ChengPriceClass btn btn-primary" href="#changePrice"><i class="fas fa-dollar-sign"></i></a>
								</button>
								</td>';
								$table.='</tr>';

							}
							$table.='<tr id="'.$InventoryId.'"">';
							$table.='<td></td>';
							$table.='<td colspan="3"></td>';
							$table.='<td> Total Qty </td>';
							$table.='<td><u>'.$TtlQty.'</u></td>'; 
							$table.='<td></td>'; 	
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
		<?php 

	} 
	else
	{
		echo "<script type='text/javascript'>alert('Error Occured. Please Contact System Admin.')</script>"; 

		?>
		<html>
		<head>
			<meta http-equiv="Refresh" content="0;url=stock.php">
			<title>Loading ...</title>
		</head>
		<body>
		</body>
		</html>
		<?php 
	}
}
?>

<!-- Modal -->
<div class="modal fade" id="changePrice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content" style="padding-right: 20px;">
			<div class="modal-header">
				<h3 style="color: black; text-decoration: underline;">Change Price</h3>
				<button class="close" data-dismiss="modal">×</button>

			</div>
			<div class="modal-body">
				<input type="hidden" name="InvenID" id="InvenID" value=""/>
				<div class="row form-inline">
					<label class="col">Current Seling Price Rs.</label>
					<input type="text" class="col form-control" name="SellPrice" id="SellPrice" disabled />
				</div>
				<div class="row form-inline">
					<label class="col">New Selling Price.</label>
					<input type="text" class="col form-control" name="txtNewPrice" id="txtNewPrice" onkeypress="return isNumberKey(event)" />
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" id="btnChangePriceModal" onclick="changePPrice();" name="btnChangePriceModal" class="btn btn-primary">Change Price</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	
	$(document).on("click", ".ChengPriceClass", function () {
		var InvenID = $(this).data('id');
		$(".modal-body #InvenID").val( InvenID );
		var SellPrice = $(this).data('price');
		$(".modal-body #SellPrice").val( SellPrice );
     // As pointed out in comments, 
     // it is unnecessary to have to manually call the modal.
     // $('#addBookDialog').modal('show');
 });

	function isNumberKey(evt)
	{
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode != 46 && charCode > 31 
			&& (charCode < 48 || charCode > 57))
			return false;

		return true;
	}

	function changePPrice() {
		var invenID = document.getElementById("InvenID").value;
		var inputValue = document.getElementById("txtNewPrice").value;

		if(inputValue != 0 && 0 < inputValue)
		{
			$.ajax({
				type: 'post',
				url: '../../control/AdminUser/managePrices.php',
				data: {

					invenID: invenID, inputValue:inputValue,

				},
				success: function () {
					window.location.reload();

				},
				cache: false
			}).fail(function () {
				alert('Error');
			});
		}
	}

</script>

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