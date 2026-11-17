<?php 
include('../../control/AdminUser/HeadAndFooter/header.php'); 
include('../../model/db_connection.php'); 
?>

<script src="../../assets/js/jquery-editable-select-master/jquery-1.12.4.min.js"></script>
<script src="../../assets/js/jquery-editable-select-master/jquery-editable-select.min.js"></script>
<link href="../../assets/js/jquery-editable-select-master/jquery-editable-select.min.css" rel="stylesheet">
 
<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>
<link href="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.css" rel="stylesheet">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>


<?php 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (isset($_GET['act'])) {
    if ($_GET['act']=='RemSesItem' && isset($_SESSION['InvoiceListItm'])) {

        $max= $_SESSION['InvoiceList_No'];

        for ($row = 0; $row < $max + 1; $row++) {
            if ($row == $_GET['id']) {
                // print_r($_SESSION['Item_List'][$row]);


                $UntCst = (is_numeric($_SESSION['InvoiceListItm'][$row][5]) ? (float)$_SESSION['InvoiceListItm'][$row][5] : 0);
                $PrdctQt = (is_numeric($_SESSION['InvoiceListItm'][$row][3]) ? (int)$_SESSION['InvoiceListItm'][$row][3] : 0);

                $TtlAmnt = (is_numeric($_SESSION['Total_Amount']) ? (int)$_SESSION['Total_Amount'] : 0);
                $TtlAmnt -= $UntCst * $PrdctQt;

                $_SESSION['Total_Amount'] = $TtlAmnt;

                unset($_SESSION['InvoiceListItm'][$row]);

                echo'<meta http-equiv="Location" content="pos.php">';
            }
        }
        ?>
        <html>
        <head>
            <meta http-equiv="Refresh" content="0;url=pos.php">
            <title>Loading ...</title>
        </head>
        <body>
        </body>
        </html>
        <?php 
    }
}

if (isset($_POST['btn_AddToList']))
{   
    $Connection = setConnection();

    
        // Product Items add to list as Session array
    if (isset($_SESSION['InvoiceListItm'])) {


        $getCurrentQty = "SELECT * FROM `tb_inventory` WHERE `Inventory_ID` ='$_POST[slctPdrctPrice]' ";

        $QtyGettingExecute = mysqli_query($Connection, $getCurrentQty);

        while ($dataID = $QtyGettingExecute->fetch_assoc()) 
        {
            $Item_CurrentQty =  $dataID['Inventory_CurrentQty'];
        }
        if ($_POST['txtQty'] <= $Item_CurrentQty && 0 < $_POST['txtQty']) 
        {
            $ID = (is_numeric($_SESSION['InvoiceList_No']) ? (int)$_SESSION['InvoiceList_No'] : 0);
            $ID++;
            $_SESSION['InvoiceListItm'][$ID] = array();

            $_SESSION['InvoiceListItm'][$ID][0] = $_POST['slctPdrctID'];

        // Take Product Details fom database using Prdt ID
            $TakeProductDetails = "SELECT * FROM `tb_product` WHERE `Product_ID`= '".$_SESSION['InvoiceListItm'][$ID][0]."'";
            $ProductIDExecuteResult = mysqli_query($Connection, $TakeProductDetails);

            while ($rowN = $ProductIDExecuteResult->fetch_assoc()) 
            {
                $_SESSION['InvoiceListItm'][$ID][1] =  $rowN['Product_ProductName'];
                // echo "<script type='text/javascript'>alert('{$PurchaseID}')</script>";
            }


            $_SESSION['InvoiceListItm'][$ID][2] = $_POST['slctPdrctPrice']; //Inventory ID
            $_SESSION['InvoiceListItm'][$ID][3] = $_POST['txtQty'];

            //Take Inventory Details from database using Inventory ID
            $TakeItemSDetails = "SELECT * FROM `tb_inventory` WHERE `Inventory_ID`= '".$_SESSION['InvoiceListItm'][$ID][2]."'";
            $InventoryIDExecuteResult = mysqli_query($Connection, $TakeItemSDetails);

            while ($row = $InventoryIDExecuteResult->fetch_assoc()) {
                $_SESSION['InvoiceListItm'][$ID][4] =  $row['Inventory_UnitCost'];
                $_SESSION['InvoiceListItm'][$ID][5] =  $row['Inventory_UnitSellingPrice'];

                // echo "<script type='text/javascript'>alert('{$PurchaseID}')</script>";
            }

            $_SESSION['Total_Items'] = count($_SESSION['InvoiceListItm']);

            if (isset($_SESSION['Total_Amount'])) {

                $UntCst = (is_numeric($_SESSION['InvoiceListItm'][$ID][5]) ? (float)$_SESSION['InvoiceListItm'][$ID][5] : 0);
                $PrdctQt = (is_numeric($_POST['txtQty']) ? (int)$_POST['txtQty'] : 0);
                $TtlAmnt = (is_numeric($_SESSION['Total_Amount']) ? (int)$_SESSION['Total_Amount'] : 0);
                $TtlAmnt += $UntCst * $PrdctQt;

                $_SESSION['InvoiceListItm'][$ID][6] = number_format((float)($UntCst * $PrdctQt), 2, '.', '');
                $_SESSION['Total_Amount'] = $TtlAmnt;
            }
            $_SESSION['InvoiceList_No'] = $ID;
        }
        else
        {
            echo "<script type='text/javascript'>alert('This Item Not in stock enough Amount or Invalid input.')</script>";
        }
    }
    else{

        $getCurrentQty = "SELECT * FROM `tb_inventory` WHERE `Inventory_ID` ='$_POST[slctPdrctPrice]' ";
        $QtyGettingExecute = mysqli_query($Connection, $getCurrentQty);

        while ($dataID = $QtyGettingExecute->fetch_assoc()) 
        {
            $Item_CurrentQty =  $dataID['Inventory_CurrentQty'];
        }
        if ($_POST['txtQty'] <= $Item_CurrentQty && 0 < $_POST['txtQty']) 
        {
            $_SESSION['InvoiceListItm'] = array();

            $ID = 0;
            $_SESSION['InvoiceListItm'][$ID] = array();

            $_SESSION['InvoiceListItm'][$ID][0] = $_POST['slctPdrctID'];

 
            // Take Product Details fom database using Prdt ID
            $TakeProductDetails = "SELECT * FROM `tb_product` WHERE `Product_ID`= '".$_SESSION['InvoiceListItm'][$ID][0]."'";
            $ProductIDExecuteResult = mysqli_query($Connection, $TakeProductDetails);

            while ($rowN = $ProductIDExecuteResult->fetch_assoc()) 
            {
                $_SESSION['InvoiceListItm'][$ID][1] =  $rowN['Product_ProductName'];
                // echo "<script type='text/javascript'>alert('{$PurchaseID}')</script>";
            }

            $_SESSION['InvoiceListItm'][$ID][2] = $_POST['slctPdrctPrice']; //Inventory ID
            $_SESSION['InvoiceListItm'][$ID][3] = $_POST['txtQty'];


            $TakeItemSDetails = "SELECT * FROM `tb_inventory` WHERE `Inventory_ID`= '".$_SESSION['InvoiceListItm'][$ID][2]."'";
            $InventoryIDExecuteResult = mysqli_query($Connection, $TakeItemSDetails);

            while ($row = $InventoryIDExecuteResult->fetch_assoc()) {
                $_SESSION['InvoiceListItm'][$ID][4] =  $row['Inventory_UnitCost'];
                $_SESSION['InvoiceListItm'][$ID][5] =  $row['Inventory_UnitSellingPrice'];

                // echo "<script type='text/javascript'>alert('{$PurchaseID}')</script>";
            }

            $_SESSION['Total_Items'] = 1;

            $UntCst = (is_numeric($_SESSION['InvoiceListItm'][$ID][5]) ? (float)$_SESSION['InvoiceListItm'][$ID][5] : 0);
            $PrdctQt = (is_numeric($_POST['txtQty']) ? (int)$_POST['txtQty'] : 0);
            $TtlAmnt = $UntCst * $PrdctQt;

            $_SESSION['Total_Amount'] = $TtlAmnt;
            $_SESSION['InvoiceListItm'][$ID][6] = number_format((float)$TtlAmnt, 2, '.', '');
            // echo "<script type='text/javascript'>alert('{$PrdctQt}')</script>"; 

            $_SESSION['InvoiceList_No'] = 0;
        }
        else
        {
            echo "<script type='text/javascript'>alert('This Item Not in stock enough Amount or Invalid input.')</script>";
        }
    }





    // Invoice Data Add to list as Session array
    if (isset($_SESSION['InvoiceItem_Customer'])) {

        $_SESSION['InvoiceItem_Customer'] = $_POST['txtCustomerName'];
    }
    else
    {
        $_SESSION['InvoiceItem_Customer'] = array();

        $_SESSION['InvoiceItem_Customer'] = $_POST['txtCustomerName'];
    }

    ?>
    <html>
    <head>
        <meta http-equiv="Refresh" content="0;url=pos.php">
        <title>Loading ...</title>
    </head>
    <body>
    </body>
    </html>
    <?php 

}

if (isset($_POST['btn_SaveAndPrintBill'])){


    // if ($_SESSION['InvoiceListItm'][0]!="" && $_SESSION['InvoiceListItm'][1]!=null && $_SESSION['InvoiceListItm'][2]!="0" && $_SESSION['InvoiceListItm'][3]!="0" && $_SESSION['InvoiceListItm'][4]!="0") {
    if ($_SESSION['InvoiceListItm'][0]!="") {

        // echo "<script type='text/javascript'> alert('Got Item Data')</script>";

        $Connection = setConnection();

        $postDate = date("Y/m/d");
        $postCustomerName = $_SESSION['InvoiceItem_Customer'];
        $postDiscount = $_POST['txtDiscount'];
        $postPamntMethod = $_POST['slctPaymentMethod'];
        $postPymntCash = $_POST['txtPayment'];
        echo "<script type='text/javascript'>alert('Cash: {$postPymntCash}')</script>";
        if (!empty($_POST['txtCardNumber'])) {
            $postPymntCardNo = $_POST['txtCardNumber'];
        }
        else
        {
            $postPymntCardNo = '0';
        }
        $postBalance = $_POST['txtBalance'];
        echo "<script type='text/javascript'>alert('Balance: {$postBalance}')</script>";
        $UsrID = $_SESSION["UserId"];


        try
        {
            $invoiceAddCmd = "INSERT INTO `tb_saleinvoice`(`SaleInvoice_Date`, `SaleInvoice_CustomerNameorNIC`, `SaleInvoice_Discount`, `SaleInvoice_PaymentMethod`, `SaleInvoice_PaymentCash`, `SaleInvoice_PaymentCardNo`, `SaleInvoice_PaymentOnDeliveryReceived`, `SaleInvoice_Balance`, `SalesInvoice_Active`, `tb_Adminuser_user_ID`) VALUES ('".$postDate."','".$postCustomerName."','".$postDiscount."','".$postPamntMethod."','".$postPymntCash."','".$postPymntCardNo."','1','".$postBalance."','1','".$UsrID."')";
            //'".$postInvoice_Company."'

            //'$_SESSION["UserId"]'
            if (mysqli_query($Connection, $invoiceAddCmd)) {

                try
                {
                    $TakeInvoiceId = "SELECT `SaleInvoice_ID` FROM `tb_saleinvoice` WHERE `SaleInvoice_Date`='$postDate' AND `tb_Adminuser_user_ID`='$UsrID' ORDER BY `SaleInvoice_ID` DESC LIMIT 1";
                    $InvoiceIDExecuteResult = mysqli_query($Connection, $TakeInvoiceId);

                    while ($row = $InvoiceIDExecuteResult->fetch_assoc()) {
                        $InvoiceID =  $row['SaleInvoice_ID'];
                        // echo "<script type='text/javascript'>alert('{$InvoiceID}')</script>";
                    }

                    $max=$_SESSION['InvoiceList_No'];

                    for ($row = 0; $row < $max + 1; $row++) {

                        //SELECT `Purchase_ID` FROM `tb_purchase` WHERE `Purchase_InvoiceNumber`= ORDER BY `Purchase_ID` DESC LIMIT 1;
                        //SELECT  FROM `tb_purchase` WHERE `Purchase_InvoiceNumber`=

                        $Item_Name = $_SESSION['InvoiceListItm'][$row][1];
                        $Item_InventoryID = $_SESSION['InvoiceListItm'][$row][2];
                        $Item_UnitCost = $_SESSION['InvoiceListItm'][$row][4];
                        $Item_UnitSelling = $_SESSION['InvoiceListItm'][$row][5];
                        $Item_Qty = $_SESSION['InvoiceListItm'][$row][3];

                        $getCurrentQty = "SELECT * FROM `tb_inventory` WHERE `Inventory_ID` ='".$Item_InventoryID."' ";
                        $QtyGettingExecute = mysqli_query($Connection, $getCurrentQty);

                        while ($dataID = $QtyGettingExecute->fetch_assoc()) {
                            $Item_CurrentQty =  $dataID['Inventory_CurrentQty'];
                        }

                        $itemSaveToSystem = "INSERT INTO `tb_saleinvoiceitems`(`SaleInvoiceItems_InventoryID`, `SaleInvoiceItems_UnitCost`, `SaleInvoiceItems_UnitSellingCost`, `SaleInvoiceItems_Qty`, `tb_SaleInvoice_SaleInvoice_ID`) VALUES ('".$Item_InventoryID."','".$Item_UnitCost."','".$Item_UnitSelling."','".$Item_Qty."', '".$InvoiceID."')";


                        if ( $Item_Qty <= $Item_CurrentQty) 
                        {
                            if (mysqli_query($Connection, $itemSaveToSystem)) {
                                $Item_NewQty =  $Item_CurrentQty - $Item_Qty;

                                $updateNewQtyOfTheInventory = "UPDATE `tb_inventory` SET `Inventory_CurrentQty`= '$Item_NewQty' WHERE `Inventory_ID` ='".$Item_InventoryID."' ";

                                if (mysqli_query($Connection, $updateNewQtyOfTheInventory)) 
                                {
                                    unset($_SESSION['Item_List'][$row]);
                                    // echo "<script type='text/javascript'>alert('Item Added')</script>";
                                }
                                else{
                                    echo "Error ". mysqli_error($Connection);
                                }
                            }
                            else
                            {
                                echo "Error ". mysqli_error($Connection);
                            }
                        }
                        else {
                            echo "<script type='text/javascript'>alert('{$Item_Name} Not in stock enough Amount. Rest of items Billed.')</script>";

                        }


                    }
                    unset($_SESSION['InvoiceListItm']);
                    unset($_SESSION['Total_Amount']);
                    unset($_SESSION['InvoiceList_No']);  
                    unset($_SESSION['InvoiceItem_Customer']);  
                    echo "<script type='text/javascript'>alert('Invoice Added')</script>";
                    // echo "<script language=\"javascript\">window.open('cpdf.php',\"_blank\");</script>"; 

                    echo "<script language=\"javascript\">window.open('printInvoice.php?act=printInvoice&id=".$InvoiceID."',\"_blank\");</script>"; 
                    ?>


                    <html>
                    <head>
                        <meta http-equiv="refresh" content="5; URL=javascript:window.open('printInvoice.php?act=printInvoice&id='<?php echo($InvoiceID) ?>, '_blank');">
                        <title>Loading ...</title>
                    </head>
                    <body>
                    </body>
                    </html> 

                    <?php

                }
                catch (exception $ex)
                {
                    echo 'Caught exception: ', $ex -> getMessage(), "\n";
                }
            }
            else {
                echo "Error ". mysqli_error($Connection);

            }
        }
        catch (exception $ex)
        {
            echo 'Caught exception: ', $ex -> getMessage(), "\n";
        }
        finally
        {
            mysqli_close($Connection);
        }
    }
    ?>
<!-- <html>
<head>
    <meta http-equiv="Refresh" content="0;url=pos.php">
    <title>Loading ...</title>
</head>
<body>
</body>
</html> -->
<?php 
}



?>

<?php 
if (empty($_SESSION['InvoiceItem_Customer'])) {
   $_SESSION['InvoiceItem_Customer'] = "Cash";
} 
?>



<?php 
// print_r($_SESSION['InvoiceListItm']); 
// echo "<br>";
// echo"Total Amount".($_SESSION['Total_Amount']);
// echo "<br>";    
// echo"Number of Items".($_SESSION['InvoiceList_No']);
?>

<div class="container-fluid">
    <div id="demo-element" class="card shadow"> 
        <div class="card-header">

            <form action="" method="POST">
                <p class="text-primary m-0 font-weight-bold"> New Invoice &nbsp;&nbsp;
                    <input type="hidden" name="destroyCurrentPageSessions" value="1">
                    <?php if (isset($_SESSION['InvoiceListItm']) &&  0 < sizeof($_SESSION['InvoiceListItm']))
                    {
                        echo '<input type="submit" class="btn btn-info btn-sm" value=" &nbsp;&nbsp;-- New --&nbsp;&nbsp; " style="float: right;"/>';
                    }

                    $destroySessionFlag = filter_input(INPUT_POST, 'destroyCurrentPageSessions');
                    if ($destroySessionFlag == 1) {
                        unset($_SESSION['InvoiceListItm']);
                        unset($_SESSION['Total_Amount']);
                        unset($_SESSION['InvoiceList_No']);  
                        $_SESSION['InvoiceItem_Customer'] = "Cash";
                        ?>
                        <html>
                        <head>
                            <meta http-equiv="Refresh" content="0;url=pos.php">
                            <title>Loading ...</title>
                        </head>
                        <body>
                        </body>
                        </html>
                        <?php 
                    }

                    ?>
                </form>
            </p>
        </div>
        <!-- <br> -->
        <div class="form container-fluid ">
            <form action="#" method="POST">
                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                            <label>Customer</label>
                            <input class="form-control form-control-sm" type="text" id="txtCustomerName" name="txtCustomerName" value="<?php echo (!empty($_SESSION['InvoiceItem_Customer'])) ? $_SESSION['InvoiceItem_Customer'] : ''; ?>">
                        </div>
                        <div class="col-sm">
                            <label class="" for="slctPdrctID">Product</label>
                            <?php
                            try
                            {
                                $Connection = setConnection();

                                $myCoCommand = "SELECT DISTINCT `tb_product`.`Product_ID` , `tb_product`.`Product_ProductName` FROM `tb_inventory` INNER JOIN `tb_product` ON `tb_inventory`.`tb_Product_Product_ID` = `tb_product`.`Product_ID` WHERE `Inventory_CurrentQty` > 0 ORDER BY `tb_product`.`Product_ProductName` ASC";
                                $CoResult=mysqli_query($Connection, $myCoCommand);

                                $prdctToPurchase = '<select id="slctPdrctID" name="slctPdrctID" onchange="loadPrices();" onselect="loadPrices();" class="col form-control form-control-sm" required>';
                                            // $prdctToPurchase .='<option value=0 disabled selected> - Select Product - </option>';

                                while ($record = mysqli_fetch_assoc($CoResult)) 
                                {
                                    $ProductID=$record['Product_ID'];
                                    $ProductName=$record['Product_ProductName'];

                                    $prdctToPurchase .='<option value="'.$ProductID.'">'.$ProductID.' : '.$ProductName.'</option>';
                                }
                                $prdctToPurchase .='</select>&nbsp;';
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
                        </div>
                        <script src="../../assets/js/jquery-editable-select-master/jquery-1.12.4.min.js"></script>
                        <script src="../../assets/js/jquery-editable-select-master/jquery-editable-select.min.js"></script>
                        <link href="../../assets/js/jquery-editable-select-master/jquery-editable-select.min.css" rel="stylesheet">
                        <script>
                            // $('#slctPdrctID').editableSelect({ effects: 'slide' });
                            $('#slctPdrctID').editableSelect();
                        </script>
                        <script type="text/javascript">
                           function loadPrices(){
                                //Selected value
                                var inputValue = document.getElementById('slctPdrctID').value;

                                // alert(document.getElementById("slctPdrctID").innerHTML);
                                // alert('Got' + "  " + inputValue);

                                if(inputValue != 0)
                                {
                                    document.getElementById("slctPdrctPrice").disabled = false;
                                    document.getElementById("txtQty").disabled = false;
                                    // alert('Got data'+ inputValue);

                                    $.ajax({
                                        type: 'post',
                                        url: '../../control/AdminUser/loadProductPrices.php',
                                        data: {

                                            prdctID: inputValue,

                                        },
                                        success: function (response) {
                                            // We get the element having id of display_info and put the
                                            //  response inside it
                                            $('#slctPdrctPrice').empty();
                                            $('#slctPdrctPrice').append(response);
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
                        <div class="col-sm">
                            <label for="slctPdrctPrice">Labelled Price (Rs.)</label>
                            <select id="slctPdrctPrice" name="slctPdrctPrice" class="col form-control form-control-sm" disabled>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <label>Quantity</label>
                            <input class="form-control form-control-sm" onkeypress="return isNumberKey(event)" onkeyup="CalculatesubToatl();" type="text" id="txtQty" name="txtQty" disabled>
                        </div>

                        <script type="text/javascript">
                            function isNumberKey(evt)
                            {
                              var charCode = (evt.which) ? evt.which : evt.keyCode;
                              if (charCode != 46 && charCode > 31 
                                && (charCode < 48 || charCode > 57))
                                return false;

                            return true;
                        }

                            // Calculate Sub total of the Item which is going to add
                            function CalculatesubToatl(){
                                if (document.getElementById('txtQty').value != "0") {
                                    var x = $("#slctPdrctPrice").children("option").filter(":selected").text();
                                    y = document.getElementById('txtQty').value;
                                    document.getElementById('txtSubTotal').value = x * y;
                                }
                            }
                        </script>

                        <div class="col-sm">
                            <label>Sub Total (Rs.)</label>
                            <input class="form-control form-control-sm" type="text" id="txtSubTotal" name="txtSubTotal" disabled>
                        </div>
                        <div class="col-sm">
                            <div class="col-sm">&nbsp;</div>
                            <button class="btn btn-primary btn-block" id="btn_AddToList" name="btn_AddToList">Add to list</button>
                        </div>

                    </div>
                    <br>
                </div>
            </form>

            

            <!-- Table view strat -->
            <div class="container-fluid card">
                <div class="table-responsive table mt-2" id="mainDataTable">
                    <style type="text/css">
                        table tr{
                            max-height: 10px;
                        }
                    </style>
                    <table class="table table-bordered table-striped    ">
                        <thead>
                            <tr style="max-height: 5px;">
                                <th>Product</th>
                                <th>Unit Price (Rs.)</th>
                                <th>Quantity</th>
                                <th>Sub Total (Rs.)</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if (isset($_SESSION['InvoiceListItm'])) {

                                $max=sizeof($_SESSION['InvoiceListItm']);
                                $DataRow ="";

                                for ($row = 0; $row < $max; $row++) {
                                    if (isset($_SESSION['InvoiceListItm'][$row])) {

                                        $DataRow = "<tr>";
                                        $DataRow .= "<td>".$_SESSION['InvoiceListItm'][$row][2]."|".$row."|".$_SESSION['InvoiceListItm'][$row][1]."</td>";
                                        $DataRow .= "<td>".$_SESSION['InvoiceListItm'][$row][5]."</td>";
                                        $DataRow .= "<td>".$_SESSION['InvoiceListItm'][$row][3]."</td>";
                                        $DataRow .= "<td>".$_SESSION['InvoiceListItm'][$row][6]."</td>";
                                        $DataRow .= "<td id=".$_SESSION['InvoiceListItm'][$row][0].">
                                        <a href='pos.php?id=".$row."&act=RemSesItem' style='text-decoration: none;'><i class='btn btn-danger btn-sm fas fa-trash'></i> </a></td>";
                                        $DataRow .= "</tr>";
                                    }
                                    echo $DataRow;
                                    
                                }
                                $DataRow = "<tr>";
                                $DataRow .= "<td colspan='2'>Total Items: ".$max."</td>";
                                $DataRow .= "<td>Total Amount (Rs.)</td>";
                                $DataRow .= "<td style='text-decoration: underline;'>".number_format((float)$_SESSION['Total_Amount'], 2, '.', '')."</td>";
                                $DataRow .= "<td></td>";
                                $DataRow .= "</tr>";
                                echo $DataRow;
                            } 
                            ?>
                        </tbody ><br>
                    </table>
                </div>
            </div>
            <form action="pos.php" method="POST">
                <!-- Table view end -->
                <div class="container">
                    <br>
                    <div class="row">
                        <div class="col-sm">
                            <label>Discount (Rs.)</label>
                            <a href="#" data-toggle="tooltip" title="Enter Discount lessthan total Amount!"> (Help)</a>
                        </div>
                        <div class="col-sm">
                            <input class="form-control form-control-sm" type="text" id="txtDiscount" onkeypress="return isNumberKey(event)" onkeyup="Calculate_Toatl();" placeholder="0.00" name="txtDiscount">

                        </div>
                        <script>
                            $(document).ready(function(){
                              $('[data-toggle="tooltip"]').tooltip();   
                          });
                      </script>

                      <script type="text/javascript">

                        <?php $T_Amnt = (is_numeric($_SESSION['Total_Amount']) ? number_format((float)$_SESSION['Total_Amount'], 2, '.', '') : 0) ; ?>
                        function Calculate_Toatl(){
                            var x = <?php echo($T_Amnt) ?>;
                            var z = parseFloat(x);
                            y = document.getElementById('txtDiscount').value;

                            if (y != "0" && y > 0 ) {
                                if (y < z) {
                                    var Res = z - y;
                                    document.getElementById('txtTotal').value = Res.toFixed(2);
                                }
                                else
                                {
                                    var Res = x;
                                    document.getElementById('txtTotal').value = Res.toFixed(2);
                                }
                            }
                            else
                            {
                                var Res = x;
                                document.getElementById('txtTotal').value = Res.toFixed(2);
                            }
                        }
                    </script>
                    <div class="col-sm">
                        <label>Total (Rs.)</label>
                    </div>
                    <div class="col-sm">
                        <input class="form-control form-control-sm" type="text" id="txtTotal" value="<?php echo (!empty($_SESSION['Total_Amount'])) ? number_format((float)$_SESSION['Total_Amount'], 2, '.', '') : '0.00'; ?>" name="txtTotal" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <label>Payment Method</label>
                    </div>
                    <div class="col-sm">
                        <select class="form-control form-control-sm" id="slctPaymentMethod" onchange ="checkPaymntMethd();" name="slctPaymentMethod">
                            <option value="0">Cash</option>
                            <option value="1">Card</option>
                        </select>
                    </div>
                    <script type="text/javascript">
                        function checkPaymntMethd(){
                            var x = document.getElementById('slctPaymentMethod').value;
                            if (x == 0) {
                                document.getElementById('txtCardNumber').disabled = true;
                                document.getElementById('txtPayment').disabled = false;
                                document.getElementById('txtPayment').value = '0.00';
                                document.getElementById('txtCardNumber').required = false;
                                document.getElementById('txtBalance').value='0.00';
                                document.getElementById('txtBalance').disabled = false;
                                document.getElementById('txtPayment').required = true;
                                document.getElementById('txtCardNumber').value ='';
                            }
                            else{
                                document.getElementById('txtCardNumber').disabled = false;
                                document.getElementById('txtPayment').disabled = true;
                                document.getElementById('txtPayment').value = document.getElementById("txtTotal").value;
                                document.getElementById('txtCardNumber').required = true;
                                document.getElementById('txtBalance').value='0.00';
                                document.getElementById('txtBalance').disabled = true;
                                document.getElementById('txtPayment').required = false;
                                document.getElementById('txtCardNumber').value ='';
                            }
                        }
                    </script>
                    <div class="col-sm">
                        <label>Card No</label>
                    </div>
                    <div class="col-sm">
                        <!-- <input class="form-control form-control-sm" type="text" id="txtCardNumber"  name="txtCardNumber" disabled> -->
                        <input class="form-control form-control-sm" type="text" id="txtCardNumber" onkeypress="return isNumberKey(event)" onchange="checkPaymntMethd();" name="txtCardNumber" disabled>
                    </div>
                    <script type="text/javascript">
                        $("#txtCardNumber").inputmask({"mask": "9999-9999-9999-9999"});
                    </script>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <label>Payment (Rs.)</label>
                    </div>
                    <div class="col-sm">
                        <input class="form-control form-control-sm" type="text" id="txtPayment" onkeyup="calculateBalancePaymnt()" onkeypress="return isNumberKey(event)" value ="0.00" name="txtPayment">
                    </div>
                    <script type="text/javascript">
                        function calculateBalancePaymnt(){
                            var x = document.getElementById('txtPayment').value;
                            var y = document.getElementById('txtTotal').value;
                            var z = x - y;

                            if (x == y || x < y) {
                                document.getElementById('txtBalance').value = z.toFixed(2);
                            }
                            else{
                                document.getElementById('txtBalance').value = '0.00';
                            }
                        }
                    </script>
                    <div class="col-sm">
                        <label>Balance (Rs.)</label>
                    </div>
                    <div class="col-sm">
                        <input class="form-control form-control-sm" type="text" id="txtBalance" value ="0.00" name="txtBalance">
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-sm"></div>
                    <div class="col-sm"></div>
                    <div class="col-sm"></div>
                    <div class="col-sm">
                        <button class="btn btn-success btn-block" id="btn_SaveAndPrintBill" name="btn_SaveAndPrintBill">Save and Print</button>
                    </div>
                </div>
            </form>
        </div>
        <br>
    </div>
</div>
</div>
<!-- Footer part Start from here -->
<?php include('../../control/AdminUser/HeadAndFooter/footer.php');?>

<script>
    function GoInFullscreen(element) {
        if(element.requestFullscreen)
            element.requestFullscreen();
        else if(element.mozRequestFullScreen)
            element.mozRequestFullScreen();
        else if(element.webkitRequestFullscreen)
            element.webkitRequestFullscreen();
        else if(element.msRequestFullscreen)
            element.msRequestFullscreen();
    }

    function GoOutFullscreen() {
        if(document.exitFullscreen)
            document.exitFullscreen();
        else if(document.mozCancelFullScreen)
            document.mozCancelFullScreen();
        else if(document.webkitExitFullscreen)
            document.webkitExitFullscreen();
        else if(document.msExitFullscreen)
            document.msExitFullscreen();
    }

    function IsFullScreenCurrently() {
        var full_screen_element = document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement || null;

        if(full_screen_element === null)
            return false;
        else
            return true;
    }

    $("#go-button").on('click', function() {
        if(IsFullScreenCurrently())
            GoOutFullscreen();
        else
            GoInFullscreen($("#demo-element").get(0));
    });

    $(document).on('fullscreenchange webkitfullscreenchange mozfullscreenchange MSFullscreenChange', function() {
        if(IsFullScreenCurrently()) {
            $("#go-button").text('Exit Full Screen');
        }
        else {
            $("#go-button").text('Full Screen');
        }
    });

    
</script>