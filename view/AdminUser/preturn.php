<?php 
include('../../control/AdminUser/HeadAndFooter/header.php'); 
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

?>



<div class="container-fluid">
	<div class="card shadow"> 
		<div class="card-header">
			Purchase Return
		</div>
		<div class="card-body shadow">
			
			<div class="form-group">
				<label for="txtInvoiceNumber">
					<strong>Invoice Number<span id="msg" style="color: black;" class="bg-warning"></span></strong>
				</label>
				<div class="form-row">
					<input id="txtInvoiceNumber" class="form-control col" type="text" placeholder="Enter Invoice number" name="txtInvoiceNumber" required>
					&nbsp;
					<button class="btn btn-success col-2" onclick="viewData()">
						Search
					</button>
				</div> 
				<br>
				<div class="row">
					<div class="col-sm">
						<label>Invoice Date</label>
						<input class="form-control form-control-sm" type="text" id="txtInvoiceDate" name="txtInvoiceDate">
					</div>
					<div class="col-sm">
						<label>Company</label>
						<input class="form-control form-control-sm" type="text" id="txtCompany" name="txtCompany">
					</div>
					<div class="col-sm">
						<label>Agent</label>
						<input class="form-control form-control-sm" type="text" id="txtAgent" name="txtAgent">
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
					<button id="addPurchaseReturn" style="float: right;" class="btn btn-success col-4" onclick="saveReturn()">
						Add Purchase return
					</button>
				</div>			
			</div>
		</div>

		<script type="text/javascript">
			var list;
			var changed = false;
			document.getElementById('addPurchaseReturn').disabled = true;
			document.getElementById('returnReason').disabled = true;
			document.getElementById('txtInvoiceDate').disabled = true;
			document.getElementById('txtCompany').disabled = true;
			document.getElementById('txtAgent').disabled = true;
			const checkEmpty = string => (string.trim() === "") || !string.trim();

			//Check return Qty validity
			function checkValue(obj,val,index) {
				if (obj.value > val) {
					obj.value = "";
					list[index][13] = "0";
					alert('Can not exceed brought quentity.')
				}
				else if (checkEmpty(obj.value)) {
					list[index][13] = "0";
				}
				else{
					changed = true;
					document.getElementById('addPurchaseReturn').disabled = false;
					document.getElementById('returnReason').disabled = false;
					list[index][13] = obj.value;
				}
				// console.log(list);
			}

			//view data for update
			function viewData() {

				var id = document.getElementById('txtInvoiceNumber').value;

				if (!(checkEmpty(id))) {
					$.ajax({
						type: 'post',
						url: '../../control/AdminUser/loadPurchaseRetunData.php',
						data: {
							id:id
						},  
						success: function (result) { 
							// console.log("This is:" + result);
							

							document.getElementById('msg').innerHTML = " ";	
							document.getElementById('txtInvoiceDate').value =" ";
							document.getElementById('txtCompany').value = " ";
							document.getElementById('txtAgent').value = " ";			
							

							var obj = JSON.parse(result);
							
							var x = document.getElementById('showData');
							// obj[i][5]
							x.innerHTML = "";
							x.innerHTML = '<tr><th>No</th><th>Product</th><th>Import Qty</th><th>Already Return Qty</th><th>Current Stock Qty</th><th>Manufacture Date</th><th>Expire Date</th><th>Unit Cost (Rs.)</th><th>New Return Qty</th></tr>';
							for (var i = 0; i < obj.length; i++) {
								var qty;
								if (obj[i][6] > obj[i][12]) {
									qty = obj[i][12] - obj[i][7];
								}
								else{
									qty = obj[i][6] - obj[i][7];
								}
								if (obj[i][7] > 0) {
									document.getElementById('msg').innerHTML = "&nbsp;&nbsp; Some of item have return belong to this invoice. &nbsp;&nbsp;";
								}

								if (qty == 0) {
									x.innerHTML += '<tr><th>'+ (i + 1) +'</th> <th>' + obj[i][3]+ '</th> <th>' +obj[i][6]+ '</th> <th>' +obj[i][7]+ '</th><th>' +obj[i][12]+ '</th> <th>' +obj[i][8]+ '</th><th>' +obj[i][9]+ '</th> <th>' +obj[i][4]+ '</th><th> <input class="form-control" type="number" name="" min="0" max="' +qty+ '" onchange="checkValue(this,' +qty+ ',' +i+ ')" onkeyup ="checkValue(this,' +qty+ ',' +i+ ')" disabled> </th></tr>';
								}
								else{
									x.innerHTML += '<tr><th>'+ (i + 1) +'</th> <th>' + obj[i][3]+ '</th> <th>' +obj[i][6]+ '</th> <th>' +obj[i][7]+ '</th><th>' +obj[i][12]+ '</th> <th>' +obj[i][8]+ '</th><th>' +obj[i][9]+ '</th> <th>' +obj[i][4]+ '</th><th> <input class="form-control" type="number" name="" min="0" max="' +qty+ '" onchange="checkValue(this,' +qty+ ',' +i+ ')" onkeyup ="checkValue(this,' +qty+ ',' +i+ ')" > </th></tr>';
								}
							}
							list = obj;
							document.getElementById('txtInvoiceDate').value = obj[0][2] ;
							document.getElementById('txtCompany').value = obj[0][10] ;
							document.getElementById('txtAgent').value = obj[0][11] ;		
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
						url: '../../control/AdminUser/savePurchaseReturn.php',
						data: {
							reason : returnReason,
							data:list
						},  
						success: function (result) { 
							// console.log(result);
							document.getElementById('txtInvoiceNumber').value = "";
							document.getElementById('txtInvoiceDate').value = "";
							document.getElementById('txtCompany').value = "";
							document.getElementById('txtAgent').value = "";
							document.getElementById('returnReason').value = "";

							document.getElementById('addPurchaseReturn').disabled = true;
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
