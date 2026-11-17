<?php 
include('../../control/AdminUser/HeadAndFooter/header.php'); 
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

?>


<div class="container-fluid">
	<div class="card shadow"> 
		<div class="card-header">
			Sales Return
		</div>
		<div class="card-body shadow">
			
			<div class="form-group">
				<label for="txtBillNumber">
					<strong>Invoice Number <span id="msg" style="color: black;" class="bg-warning"></span></strong>
				</label>
				<div class="form-row">
					<input id="txtBillNumber" class="form-control col" type="text" placeholder="Enter Bill number" name="txtBillNumber" required>
					&nbsp;
					<button class="btn btn-success col-2" onclick="viewData()">
						Search
					</button>
				</div> 
				<br>
				<div class="row">
					<div class="col-sm">
						<label>Customer Name / NIC</label>
						<input class="form-control form-control-sm" type="text" id="txtCustomerName" name="txtCustomerName">
					</div>
					<div class="col-sm">
						<label>Invoice Date</label>
						<input class="form-control form-control-sm" type="text" id="txtInvoiceDate" name="txtInvoiceDate">
					</div>
				</div>
				<br>
				<div class="">
					<table class="table table-strip" id="showData">	
						<!-- This is the thing					 -->
					</table>
				</div>	
				<div class="">
					<div class="form-group">
						<label for="returnReason">Reason to return sale:</label>
						<textarea class="form-control" rows="2" id="returnReason"></textarea>
					</div>
					<button id="addSaleReturn" style="float: right;" class="btn btn-success col-4" onclick="saveReturn()">
						Add Sale return
					</button>
				</div>			
			</div>
		</div>

		<script type="text/javascript">
			var list;
			var changed = false;
			document.getElementById('addSaleReturn').disabled = true;
			document.getElementById('returnReason').disabled = true;
			document.getElementById('txtCustomerName').disabled = true;
			document.getElementById('txtInvoiceDate').disabled = true;
			const checkEmpty = string => (string.trim() === "") || !string.trim();

			function checkValue(obj,val,index) {
				if (obj.value > val) {
					obj.value = "";
					list[index][7] = "0";
					alert('Can not exceed brought quentity.')
				}
				else if (checkEmpty(obj.value)) {
					list[index][7] = "0";
				}
				else{
					changed = true;
					document.getElementById('addSaleReturn').disabled = false;
					document.getElementById('returnReason').disabled = false;
					list[index][7] = obj.value;
				}
				// console.log(list);
			}

			//view data for update
			function viewData() {

				var id = document.getElementById('txtBillNumber').value;

				if (!(checkEmpty(id))) {
					$.ajax({
						type: 'post',
						url: '../../control/AdminUser/loadSalesRetunData.php',
						data: {
							id:id
						},  
						success: function (result) { 
							// console.log("This is:" + result);
							var gotData = JSON.parse(result);
							document.getElementById('msg').innerHTML = " ";
							if (gotData[0] == 1) {
								document.getElementById('msg').innerHTML = "&nbsp;&nbsp; Some of item have return belong to this invoice. &nbsp;&nbsp;";
							}

							var obj = gotData[1];
							
							var x = document.getElementById('showData');
							// obj[i][5]
							x.innerHTML = "";
							x.innerHTML = '<tr><th>No</th><th>Product</th><th>Qty</th><th>Already Return</th><th>Remain</th><th>New Return Qty</th></tr>';
							for (var i = 0; i < obj.length; i++) {
								var qty = obj[i][6] - obj[i][9];
								if (qty == 0) {
									x.innerHTML += '<tr><th>'+ (i + 1) +'</th><th>' + obj[i][3]+ '</th><th>' +obj[i][6]+ '</th><th>' +obj[i][9]+ '</th><th> '+qty+' </th><th> <input class="form-control" type="number" name="" min="0" max="' +obj[i][6]+ '" onkeyup ="checkValue(this,' +qty+ ',' +i+ ')" disabled> </th></tr>';
								}
								else{
									x.innerHTML += '<tr><th>'+ (i + 1) +'</th><th>' + obj[i][3]+ '</th><th>' +obj[i][6]+ '</th><th>' +obj[i][9]+ '</th><th> '+qty+' </th><th> <input class="form-control" type="number" name="" min="0" max="' +obj[i][6]+ '" onkeyup ="checkValue(this,' +qty+ ',' +i+ ')"> </th></tr>';
								}
							}
							list = obj;
							for (var i = 0; i < list.length; i++) {
								list[i][7]="0";
							}
							document.getElementById('txtCustomerName').value = obj[0][8] ;
							document.getElementById('txtInvoiceDate').value = obj[0][2] ;

							// console.log(list);
						},
						failure: function (response) {
							alert("Failure detected.");
						},
						error: function (response) {
							alert("Error detected.");
						}
					})
				}
				else{
					alert("Enter vlaid bill number.");
				}
			}
			function saveReturn() {
				var returnReason = document.getElementById('returnReason').value;
				if (changed == true) {
					$.ajax({
						type: 'post',
						url: '../../control/AdminUser/saveSalesReturn.php',
						data: {
							reason : returnReason,
							data:list
						},  
						success: function (result) { 
							// console.log(result);
							document.getElementById('txtCustomerName').value = "";
							document.getElementById('txtInvoiceDate').value = "";
							document.getElementById('returnReason').value = "";
							document.getElementById('txtBillNumber').value = "";

							document.getElementById('addSaleReturn').disabled = true;
							document.getElementById('returnReason').disabled = true;
							var x = document.getElementById('showData');
							x.innerHTML = "";
							alert('Sale Retur Added Successfully.');
							document.getElementById('msg').innerHTML = " ";
						},
						failure: function (response) {
							alert("Failure detected.");
						},
						error: function (response) {
							alert("Error detected.");
						}
					})

				}
				else{
					alert("No data changed");
				}
			}
		</script>


		<!-- Footer part Start from here -->
		<?php include('../../control/AdminUser/HeadAndFooter/footer.php');?>