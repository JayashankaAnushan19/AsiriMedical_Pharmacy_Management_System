<?php 
include('../../control/AdminUser/HeadAndFooter/header.php');
include('../../model/db_connection.php'); 

$Connection = setConnection();

?>
<script src="../../assets/js/jquery-editable-select-master/jquery-1.12.4.min.js"></script>
<script src="../../assets/js/jquery-editable-select-master/jquery-editable-select.min.js"></script>
<link href="../../assets/js/jquery-editable-select-master/jquery-editable-select.min.css" rel="stylesheet">



<?php 


if (isset($_POST['btnAddPayment'])) {
  if (!empty($_POST['slctInvoiceNo'])) {
    $InvoiceNum = $_POST['slctInvoiceNo'];
    $Date = date("Y/m/d");
    $UserID = $_SESSION["UserId"];

    echo "<script type='text/javascript'>alert('{$InvoiceNum}')</script>";

    $checkInvoiceIDCmd = "SELECT * FROM `tb_purchase` WHERE `Purchase_InvoiceNumber`= '$InvoiceNum'";
    $checkInvoiceIDResult=mysqli_query($Connection, $checkInvoiceIDCmd);
    if ($checkInvoiceIDResult) {
      try{

        runQuary("INSERT INTO `tb_payment`(`Payment_InvoiceNumber`, `Payment_SubPaymentMethod`, `Payment_Amount`, `Payment_Date`, `tb_Purchase_Purchase_ID`, `tb_Purchase_tb_user_user_ID`) VALUES ('$InvoiceNum','$_POST[slctPaymentMethod]','$_POST[txtAmount]','$Date','$_POST[txtPurchaseID]','$UserID')","New Payment Added Successfully !!!");

      }
      catch(Exception $e) {
        echo "<script type='text/javascript'>alert('Error Occured. Please Contact System Admin.')</script>";
      }
    }
    else
    {
      echo "<script type='text/javascript'>alert('Invalid Invoice Number. Please Enter valid Invoice Number.')</script>";
    }
  }
  else
  {
    echo "<script type='text/javascript'>alert('Empty data. Please Enter valid Invoice Number.')</script>";
  }  

  ?>
  <html>
  <head>
    <meta http-equiv="Refresh" content="0;url=payment.php">
    <title>Loading ...</title>
  </head>
  <body>
  </body>
  </html>
  <?php 

}
elseif (isset($_POST['btnUpdatePayment'])) {
  if (!empty($_POST['txtAmount'])) {
    try{
      runQuary("UPDATE `tb_payment` SET `Payment_SubPaymentMethod`='$_POST[slctPaymentMethod]',`Payment_Amount`='$_POST[txtAmount]' WHERE `Payment_ID`= '$_POST[txtPaymentID]'","Payment Updated Successfully !!!");

    }
    catch(Exception $e) {
      echo "<script type='text/javascript'>alert('Error Occured. Please Contact System Admin.')</script>";
    }
  }

  ?>
  <html>
  <head>
    <meta http-equiv="Refresh" content="0;url=payment.php">
    <title>Loading ...</title>
  </head>
  <body>
  </body>
  </html>
  <?php 


}
elseif (isset($_POST['btnDeletePayment'])) {
  if (!empty($_POST['txtPaymentID'])) {
    try{
      runQuary("DELETE FROM `tb_payment` WHERE `Payment_ID`= '$_POST[txtPaymentID]'","Payment Deleted Successfully !!!");

    }
    catch(Exception $e) {
      echo "<script type='text/javascript'>alert('Error Occured. Please Contact System Admin.')</script>";
    }
  }

  ?>
  <html>
  <head>
    <meta http-equiv="Refresh" content="0;url=payment.php">
    <title>Loading ...</title>
  </head>
  <body>
  </body>
  </html>
  <?php 
}
?>




<div class="container-fluid">
  <div class="card shadow"> 
    <div class="card-header">
      Payment Management 
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <button id="btnNewExtra" class="btn btn-info" hidden>New</button>
    </div>
    <div class="card-body shadow">
      <form action="#" method="POST">
        <div class="container">
          <div>
            <strong><center><label class="" id="msg" hidden></label></center></strong><br>
          </div>
          <div class="row">
            <div class="col-sm">
              <label>Invoice No</label>
            </div>
            <div class="col-sm">
              <?php
              try
              {
                $Connection = setConnection();

                $myCoCommand = "SELECT * FROM `tb_purchase` WHERE `Purchase_PaymentMethod`=2";
                $CoResult=mysqli_query($Connection, $myCoCommand);

                $prdctToPurchase = '<select id="slctInvoiceNo" name="slctInvoiceNo" onchange="loadDataAboutInvoice();" onselect="loadDataAboutInvoice();" class="col form-control form-control">'; 

                while ($record = mysqli_fetch_assoc($CoResult)) 
                {
                  $InvoiceNo=$record['Purchase_InvoiceNumber'];

                  $prdctToPurchase .='<option value="'.$InvoiceNo.'">'.$InvoiceNo.'</option>';
                }
                $prdctToPurchase .='</select>';
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
              <script>
                $('#slctInvoiceNo').editableSelect();
              </script>
              <script type="text/javascript">
                function loadDataAboutInvoice(){
                  var inputValue = document.getElementById('slctInvoiceNo').value;


                  if(inputValue != "")
                  {

                    document.getElementById('txtPurchaseID').value = "";
                    document.getElementById('txtComName').value = "";
                    document.getElementById('txtInvoiceDate').value = "";
                    document.getElementById('txtTotalAmount').text = "";
                    document.getElementById('txtPayableAmount').value = "";

                    $.ajax({
                      type: 'post',
                      url: '../../control/AdminUser/loadInvoiceData.php',
                      data: {
                        invicID: inputValue,
                      },
                      success: function (response) {
                        var data = JSON.parse(response);
                        console.log(data[0]);
                        document.getElementById('txtPurchaseID').value = data[1];
                        document.getElementById('txtComName').value = data[2];
                        document.getElementById('txtInvoiceDate').value = data[3];
                        document.getElementById('txtTotalAmount').value = data[4];
                        document.getElementById('txtPayableAmount').value = data[5];

                        if (data[5] == 0 || data[5] < 0) {
                          document.getElementById("btnAddPayment").hidden = true;
                          document.getElementById("btnNewExtra").hidden = false;

                          document.getElementById("msg").hidden = false;
                          document.getElementById("msg").innerHTML = "This Invoice Payments are Complete.";
                          document.getElementById("msg").style.color = 'green';
                          document.getElementById("msg").className = 'alert alert-success';
                        }
                        else{
                          document.getElementById("btnAddPayment").hidden = false;
                          document.getElementById("btnNewExtra").hidden = true;

                          document.getElementById("msg").hidden = true;
                        }
                      }
                    });
                  }
                  else
                  {
                    $( '#slctPdrctPrice' ).append("No sub Categories");
                    $("#slctPdrctPrice").val("0");
                    document.getElementById("slctPdrctPrice").disabled = true;
                    document.getElementById("txtQty").disabled = true;
                  }
                };
              </script>
            </div>
            <div class="col-sm">
              <label>Company</label>
            </div>
            <div class="col-sm">
              <input class="form-control" type="text" id="txtComName" name="txtComName" disabled>
            </div>
          </div><br>
          <div class="row">
            <div class="col-sm">
              <label>Invoice Date</label>
            </div>
            <div class="col-sm">
              <input class="form-control" type="text" id="txtInvoiceDate" name="txtInvoiceDate" disabled>
            </div>
            <div class="col-sm">
              <label></label>
            </div>
            <div class="col-sm">
              <input class="" type="text" id="txtPaymentID" name="txtPaymentID" hidden>
              <input class="" type="text" id="txtPurchaseID" name="txtPurchaseID" hidden>
            </div>
          </div><br>
          <div class="row" id="divPayHistorySummary">
            <div class="col-sm">
              <label>Total Amount (Rs.)</label>
            </div>
            <div class="col-sm">
              <input class="form-control" type="text" id="txtTotalAmount" name="txtTotalAmount" value="0.00" disabled>
            </div>
            <div class="col-sm">
              <label>Amount to be paid (Rs.)</label>
            </div>
            <div class="col-sm">
              <input class="form-control" class="form-control" type="text" id="txtPayableAmount" value="0.00" name="txtPayableAmount" disabled>
            </div>
          </div><br>
          <div class="row">
            <div class="col-sm">
              <label>Payment method</label>
            </div>
            <div class="col-sm">
              <select id="slctPaymentMethod" name="slctPaymentMethod" class="form-control">
                <option value="0">- Cash - </option>
                <option value="1">- Card - </option>
                <option value="2">- Bank - </option>
              </select>
            </div>
            <div class="col-sm">
              <label>Amount (Rs.)</label>
            </div>
            <div class="col-sm">
              <input class="form-control" type="text" id="txtAmount" name="txtAmount" value="0.00">
            </div>
          </div><br>
          <div class="row">
            <div class="col-sm">
            </div>
            <div class="col-sm">
              <button id="btnAddPayment" name="btnAddPayment" class="btn btn-success btn-md">Add Payment</button> &nbsp;
              <button id="btnUpdatePayment" name="btnUpdatePayment" class="btn btn-warning btn-md">Update Payment</button> &nbsp;
              <button id="btnDeletePayment" name="btnDeletePayment" class="btn btn-danger btn-md">Delete Payment</button>
            </div>
            <div class="col-sm">
            </div>
          </div>
        </div>
      </form>


      <br>
      <!-- view recent Payments -->
      <div class="row"> 
        <div class="col form-inline">
          <h5 class="">Recent payments <h6>&nbsp;&nbsp;&nbsp; [<span id="rowCount"></span> row(s) detected.]</h6></h5>
        </div>
        <div class="col-8">
          <input class="form-control col-4" style="float: right;" type="text" id="myInput" onkeyup="myFunction(0)" placeholder="Search by Invoice Number..." title="Type in a name">
        </div>
      </div>

      <div class="table-responsive table mt-2">
        <table class="table my-0" id="mainPaymentTable" >
          <thead>
            <tr>
              <td><strong>#</strong></td>
              <td><strong>Payment ID</strong></td>
              <td><strong>Invoice No</strong></td>
              <td><strong>Date</strong></td>
              <td><strong>Company</strong></td>
              <td><strong>Amount (Rs.)</strong></td>
              <td><strong>Edit / Delete</strong></td>
            </tr>
          </thead>
          <tbody id="mainPaymentTableBody">
            <?php
            try {
              $Connection = setConnection();

              $selectPayments = "SELECT * FROM `tb_payment` INNER JOIN `tb_purchase` on `tb_payment`.`tb_Purchase_Purchase_ID` = `tb_purchase`.`Purchase_ID` INNER JOIN `tb_company` ON `tb_purchase`.`tb_Company_Company_ID` = `tb_company`.`Company_ID` ORDER BY `tb_payment`.`Payment_ID` DESC";

              $query = mysqli_query($Connection, $selectPayments); 
              $NumRow = 0;
              $NumRow = mysqli_num_rows($query);
              echo "<script type='text/javascript'>document.getElementById('rowCount').innerHTML ='{$NumRow}';</script>";

              $n = 1;
              while($row = mysqli_fetch_assoc($query))
              {

                $PriceCheck = is_float($row['Payment_Amount']);
                if ($PriceCheck == true) 
                {
                  $Price = $row['Payment_Amount'];
                } 
                else
                {
                  $Price = number_format((float)($row['Payment_Amount']), 2, '.', '');
                }

              if ($n < 6) {
                $DataRow ='<tr id="'.$row['Payment_ID'].'">';
                $DataRow .= "<td>".$n."</td>";
                $DataRow .= "<td>".$row['Payment_ID']."</td>";
                $DataRow .= "<td>".$row['Payment_InvoiceNumber']."</td>";
                $DataRow .= "<td>".$row['Payment_Date']."</td>";
                $DataRow .= "<td>".$row['Company_Name']."</td>";
                $DataRow .= "<td>".$Price."</td>";
                $DataRow .= "<td style='display:none;'>".$row['Payment_SubPaymentMethod']."</td>";
                $DataRow .='<td>
                <button class="btn btn-warning" onclick="myUpdateFunction('.$row['Payment_ID'].')"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" onclick="myDeleteFunction('.$row['Payment_ID'].')"><i class="fas fa-trash"></i></button></td>';
                $DataRow .= "</tr>";
                echo $DataRow;
              }
              else
              {
                $DataRow ='<tr id="'.$row['Payment_ID'].'" style="display:none;">';
                $DataRow .= "<td>".$n."</td>";
                $DataRow .= "<td>".$row['Payment_ID']."</td>";
                $DataRow .= "<td>".$row['Payment_InvoiceNumber']."</td>";
                $DataRow .= "<td>".$row['Payment_Date']."</td>";
                $DataRow .= "<td>".$row['Company_Name']."</td>";
                $DataRow .= "<td>".$row['Payment_Amount']."</td>";
                $DataRow .= "<td style='display:none;'>".$row['Payment_SubPaymentMethod']."</td>";
                $DataRow .='<td>
                <button class="btn btn-warning" onclick="myUpdateFunction('.$row['Payment_ID'].')"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" onclick="myDeleteFunction('.$row['Payment_ID'].')"><i class="fas fa-trash"></i></button></td>';
                $DataRow .= "</tr>";
                echo $DataRow;
              }
              $n++;
            }

          } catch (Exception $e) {
            $DataRow ='<tr>';
            $DataRow .= "<td colspan='5' style='align:Center;'> No Data to view</td>";
            $DataRow .= "</tr>";
            echo $DataRow;
          }  
          ?>
        </tbody> </table>
      </div>

      <script>
        document.getElementById("divPayHistorySummary").hidden = false;
        document.getElementById("btnAddPayment").hidden = false;
        document.getElementById("btnUpdatePayment").hidden = true;
        document.getElementById("btnDeletePayment").hidden = true;

        function myFunction() {
          var input, filter, table, tr, td, i, txtValue;
          input = document.getElementById("myInput");
          filter = input.value.toUpperCase();
          table = document.getElementById("mainPaymentTable");
          tr = table.getElementsByTagName("tr");
          var n = 1;
          for (i = 1; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[2];
            if (td) {
              txtValue = td.textContent || td.innerText;
              if (txtValue.toUpperCase().indexOf(filter) > -1 && n<6) {
                tr[i].style.display = "";
                n += 1;
              } else {
                tr[i].style.display = "none";
              }
            }       
          } 
        }

        function myUpdateFunction(mg){

          $('td').click(function(){
            var col = $(this).parent().children().index($(this));
            var row = $(this).parent().parent().children().index($(this).parent());

            var newRow = row ;
            table = document.getElementById("mainPaymentTable");
            tr = table.getElementsByTagName("tr");


            document.getElementById("txtPaymentID").value = tr[newRow].getElementsByTagName("td")[1].innerHTML;
            document.getElementById("slctInvoiceNo").value = tr[newRow].getElementsByTagName("td")[2].innerHTML;
            document.getElementById("txtInvoiceDate").value = tr[newRow].getElementsByTagName("td")[3].innerHTML;
            document.getElementById("txtComName").value = tr[newRow].getElementsByTagName("td")[4].innerHTML;
            document.getElementById("slctPaymentMethod").value = tr[newRow].getElementsByTagName("td")[6].innerHTML;
            document.getElementById("txtAmount").value = tr[newRow].getElementsByTagName("td")[5].innerHTML;

            document.getElementById("divPayHistorySummary").hidden = true;

            document.getElementById("msg").hidden = true;

            document.getElementById("slctInvoiceNo").disabled = true;
            document.getElementById("slctPaymentMethod").disabled = false;
            document.getElementById("txtAmount").disabled = false;

            document.getElementById("btnAddPayment").hidden = true;
            document.getElementById("btnUpdatePayment").hidden = false;
            document.getElementById("btnDeletePayment").hidden = true;
            document.getElementById("btnNewExtra").hidden = false;

          });
          if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
          }
          window.scrollTo(0,0);
        }




        $("#btnNewExtra").click(function (e) {
          document.getElementById("slctInvoiceNo").value = "";
          document.getElementById("txtInvoiceDate").value = "";
          document.getElementById("txtComName").value = "";
          document.getElementById("slctPaymentMethod").value = "0";
          document.getElementById("txtAmount").value = "0.00";
          document.getElementById("txtTotalAmount").value = "0.00";
          document.getElementById("txtPayableAmount").value = "0.00";

          document.getElementById("slctInvoiceNo").disabled = false;
          document.getElementById("txtInvoiceDate").disabled = true;
          document.getElementById("txtComName").disabled = true;
          document.getElementById("slctPaymentMethod").disabled = false;
          document.getElementById("txtAmount").disabled = false;

          document.getElementById("divPayHistorySummary").hidden = false;

          document.getElementById("msg").hidden = true;

          document.getElementById("btnNewExtra").hidden = true;
          document.getElementById("btnAddPayment").hidden = false;
          document.getElementById("btnUpdatePayment").hidden = true;
          document.getElementById("btnDeletePayment").hidden = true;

            // This prevents the page from scrolling down to where it was previously.
            if ('scrollRestoration' in history) {
              history.scrollRestoration = 'manual';
            }
        // This is needed if the user scrolls down during page load and you want to make sure the page is scrolled to the top once it's fully loaded. This has Cross-browser support.
        window.scrollTo(0,0);
      });



        function myDeleteFunction(gh){
          $('td').click(function(){
            var col = $(this).parent().children().index($(this));
            var row = $(this).parent().parent().children().index($(this).parent());

            var newRow = row ;
            table = document.getElementById("mainPaymentTable");
            tr = table.getElementsByTagName("tr");

            document.getElementById("txtPaymentID").value = tr[newRow].getElementsByTagName("td")[1].innerHTML;
            document.getElementById("slctInvoiceNo").value = tr[newRow].getElementsByTagName("td")[2].innerHTML;
            document.getElementById("txtInvoiceDate").value = tr[newRow].getElementsByTagName("td")[3].innerHTML;
            document.getElementById("txtComName").value = tr[newRow].getElementsByTagName("td")[4].innerHTML;
            document.getElementById("slctPaymentMethod").value = tr[newRow].getElementsByTagName("td")[6].innerHTML;
            document.getElementById("txtAmount").value = tr[newRow].getElementsByTagName("td")[5].innerHTML;

            document.getElementById("divPayHistorySummary").hidden = true;

            document.getElementById("btnAddPayment").hidden = true;
            document.getElementById("btnUpdatePayment").hidden = true;
            document.getElementById("btnDeletePayment").hidden = false;
            document.getElementById("btnNewExtra").hidden = false;

            document.getElementById("slctInvoiceNo").disabled = true;
            document.getElementById("slctPaymentMethod").disabled = true;
            document.getElementById("txtAmount").disabled = true;

            document.getElementById("msg").hidden = false;
            document.getElementById("msg").innerHTML = "Do you want to Remove this Payment?";
            document.getElementById("msg").style.color = 'red';
            document.getElementById("msg").className = 'alert alert-danger';
          });
        // This prevents the page from scrolling down to where it was previously.
        if ('scrollRestoration' in history) {
          history.scrollRestoration = 'manual';
        }
    // This is needed if the user scrolls down during page load and you want to make sure the page is scrolled to the top once it's fully loaded. This has Cross-browser support.
    window.scrollTo(0,0);
  }
</script>





<!-- Footer part Start from here -->
<?php include('../../control/AdminUser/HeadAndFooter/footer.php');?>