<?php 
include('../../control/AdminUser/HeadAndFooter/header.php'); 
include('../../model/db_connection.php'); 
?>
<style type="text/css">
  #profileDisplay { display: block; height: 210px; width: 210px; padding-left: -10px; border-radius: 30%; }
  .img-placeholder {
    color: white;
    background: black;
    opacity: .7;
    height: 210px; 
    width: 210px;
    border-radius: 50%;
    z-index: 2;
    position: absolute;
    left: 65%;
    transform: translateX(-50%);
    display: none;
}
.img-placeholder h4 {
    margin-top: 40%;
    color: white;
}
.img-div:hover .img-placeholder {
    display: block;
    cursor: pointer;
}
</style>

<?php 

if (isset($_POST["btnAdd_Product"])) {

    try{

        // for the database
        $profileImageName = time() . '-' . $_FILES["profileImage"]["name"];
        // For image upload
        $target_dir = "prd_Images/";
        $target_file = $target_dir . basename($profileImageName);
        // VALIDATION
        // validate image size. Size is calculated in Bytes
        if($_FILES['profileImage']['size'] > 1000) {
            $msg = "Image size should not be greated than 200Kb";
            $msg_class = "alert-danger";
        }
        // check if file exists
        if(file_exists($target_file)) {
            $msg = "File already exists"; 
            $msg_class = "alert-danger";
        }
        // Upload image only if no errors
        if (empty($error)) {
            if(move_uploaded_file($_FILES["profileImage"]["tmp_name"], $target_file)) {

                runQuary("INSERT INTO `tb_product`(`Product_ProductName`, `Product_ExpireRemainDates`, `Product_ReOrderLevelQty`, `Product_Active`, `Product_OpenSale`, `Product_ImageLocation`, `tb_Company_Company_ID`, `tb_SubCategory_SubCategory_ID`, `tb_Agent_Agent_ID`) VALUES ('$_POST[txtProductName]','$_POST[txtExpireRemainDates]','$_POST[txtReOrderLevel]','1','$_POST[slctSellOnInternet]', '$profileImageName','$_POST[sltSupplierToSubCatDropDown]','$_POST[sltsubCatToAddProductDropDown]','$_POST[sltAgentToSubCatDropDown]')","New Product Added Successfully !!!");

            } 
            else 
            {
                if (!empty($_POST['sltsubCatToAddProductDropDown']) && !empty($_POST['sltAgentToSubCatDropDown'])) {

                    $Confirmation = "<script> window.confirm('Image moving Error, Continue without image?');</script>";

                    echo $Confirmation;

                    if ($Confirmation == true ) 
                    {
                      $profileImageName = "default_prdct_img.png";
                      runQuary("INSERT INTO `tb_product`(`Product_ProductName`, `Product_ExpireRemainDates`, `Product_ReOrderLevelQty`, `Product_Active`, `Product_OpenSale`, `Product_ImageLocation`, `tb_Company_Company_ID`, `tb_SubCategory_SubCategory_ID`, `tb_Agent_Agent_ID`) VALUES ('$_POST[txtProductName]','$_POST[txtExpireRemainDates]','$_POST[txtReOrderLevel]','1','$_POST[slctSellOnInternet]', '$profileImageName','$_POST[sltSupplierToSubCatDropDown]','$_POST[sltsubCatToAddProductDropDown]','$_POST[sltAgentToSubCatDropDown]')","New Product Added Successfully !!!");
                  }
                  else
                  {
                    ?>
                    <html>
                    <head>
                        <meta http-equiv="Refresh" content="0;url=product.php">
                        <title>Loading ...</title>
                    </head>
                    <body>
                    </body>
                    </html>
                    <?php
                }
            }
            else
            {
                echo "<script> alert('Empty Value detected. Please enter values for each feild.');</script>";
                ?>
                <html>
                <head>
                    <meta http-equiv="Refresh" content="0;url=product.php">
                    <title>Loading ...</title>
                </head>
                <body>
                </body>
                </html>
                <?php
            }
        }
    }
    else {
        $Confirmation = "<script> window.confirm('Continue without image?');</script>";

        echo $Confirmation;

        if ($Confirmation == true) {
            $profileImageName = "default_prdct_img.png";
            runQuary("INSERT INTO `tb_product`(`Product_ProductName`, `Product_ExpireRemainDates`, `Product_ReOrderLevelQty`, `Product_Active`, `Product_OpenSale`, `Product_ImageLocation`, `tb_Company_Company_ID`, `tb_SubCategory_SubCategory_ID`, `tb_Agent_Agent_ID`) VALUES ('$_POST[txtProductName]','$_POST[txtExpireRemainDates]','$_POST[txtReOrderLevel]','1','$_POST[slctSellOnInternet]', '$profileImageName','$_POST[sltSupplierToSubCatDropDown]','$_POST[sltsubCatToAddProductDropDown]','$_POST[sltAgentToSubCatDropDown]')","New Product Added Successfully !!!"); 
        }
    }

}
catch(Exception $e) {
    echo "<script type='text/javascript'>alert('Error Occured.')</script>";
}

}
elseif (isset($_POST["btnUpdate_Product"])) {


    try{
        // for the database
        $profileImageName = time() . '-' . $_FILES["profileImage"]["name"];
        // For image upload
        $target_dir = "prd_Images/";
        $target_file = $target_dir . basename($profileImageName);
        // VALIDATION
        // validate image size. Size is calculated in Bytes
        if($_FILES['profileImage']['size'] > 1000) {
            $msg = "Image size should not be greated than 200Kb";
            $msg_class = "alert-danger";
        }
        // check if file exists
        if(file_exists($target_file)) {
            $msg = "File already exists"; 
            $msg_class = "alert-danger";
        }
        // Upload image only if no errors
        if (empty($error)) {
            if(move_uploaded_file($_FILES["profileImage"]["tmp_name"], $target_file)) {

                runQuary("UPDATE `tb_product` SET `Product_ProductName`='$_POST[txtProductName]',`Product_ExpireRemainDates`='$_POST[txtExpireRemainDates]',`Product_ReOrderLevelQty`='$_POST[txtReOrderLevel]',`Product_OpenSale`='$_POST[slctSellOnInternet]', `Product_ImageLocation` = '$profileImageName' ,`tb_Company_Company_ID`='$_POST[sltSupplierToSubCatDropDown]',`tb_SubCategory_SubCategory_ID`='$_POST[sltsubCatToAddProductDropDown]',`tb_Agent_Agent_ID`='$_POST[sltAgentToSubCatDropDown]' WHERE `Product_ID` = '$_POST[txtProductID]'","Product Updated Successfully !!!");

                ?>
                <html>
                <head>
                    <meta http-equiv="Refresh" content="0;url=product.php">
                    <title>Loading ...</title>
                </head>
                <body>
                </body>
                </html>
                <?php


            } else {
                $Confirmation = "<script> window.confirm('Image will not change, is it okay to update rest of details?');</script>";

                echo $Confirmation;

                if ($Confirmation == true) {
                    runQuary("UPDATE `tb_product` SET `Product_ProductName`='$_POST[txtProductName]',`Product_ExpireRemainDates`='$_POST[txtExpireRemainDates]',`Product_ReOrderLevelQty`='$_POST[txtReOrderLevel]',`Product_OpenSale`='$_POST[slctSellOnInternet]',`tb_Company_Company_ID`='$_POST[sltSupplierToSubCatDropDown]',`tb_SubCategory_SubCategory_ID`='$_POST[sltsubCatToAddProductDropDown]',`tb_Agent_Agent_ID`='$_POST[sltAgentToSubCatDropDown]' WHERE `Product_ID` = '$_POST[txtProductID]'","Product Updated Successfully !!!");

                    ?>
                    <html>
                    <head>
                        <meta http-equiv="Refresh" content="0;url=product.php">
                        <title>Loading ...</title>
                    </head>
                    <body>
                    </body>
                    </html>
                    <?php

                }
            }
        }
    }
    catch(Exception $e) {
        echo "<script type='text/javascript'>alert('Error Occured.')</script>";
    }
}
elseif (isset($_POST["btnDelete_Product"])) {


    try{
        runQuary("UPDATE `tb_product` SET `Product_Active`=0 WHERE `Product_ID` = '$_POST[txtProductID]'","Product Deleted Successfully !!!");

    }
    catch(Exception $e) {
        echo "<script type='text/javascript'>alert('Error Occured.')</script>";
    }
}
?>






<div class="container-fluid">
    <div class="btn-group text-dark container-fluid " role="group" >
        <button style="border-right: 1px solid #C0C0C0;" onclick="hide('manageProduct'); show('manageProduct','mainPanel');" class="btn btn-primary">Product Manage()</button>
        <button style="border-right: 1px solid #C0C0C0; border-left: 1px solid #C0C0C0;" onclick="show('viewProduct','mainPanel'); hide('manageProduct');" class="btn btn-primary">View Products()</button>
        <button style="border-right: 1px solid #C0C0C0; border-left: 1px solid #C0C0C0;" onclick="show('mainCat','mainPanel'); hide('manageProduct');" class="btn btn-primary">Main Category()</button>
        <button style="border-left: 1px solid #C0C0C0;" onclick="show('subCat','mainPanel'); hide('manageProduct');" class="btn btn-primary">Sub Category()</button>
    </div><br>&nbsp;

    <div class="" id="mainPanel"></div>
</div>


<!-- Manage product Section -->
<div id="manageProduct" class="container-fluid" style="display:block;">
    <div class="card shadow">
        <!-- Main Cat start -->
        <div class="card-header py-3">
            <p class="text-primary m-0 font-weight-bold">Manage Products
                &nbsp;&nbsp;

                <button id="btnExtraNewProduct" onclick="btnExtraNewProduct()" class="btn btn-info" hidden>New</button>
            </p>                   
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 text-nowrap">
                    <!-- Form start from here to manage products -->
                    <form action="#" method="post" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="col">

                                <!-- Message showing division -->
                                <div class="row">
                                    <div class="col-12 form-group form-inline">
                                        <strong>
                                            <center>
                                                <label class="" id="msgForProducts" style="text-align: center;" hidden>
                                                </label>
                                            </center>
                                        </strong>
                                    </div>
                                </div>

                                <!-- Product id for futher work -->
                                <div class="row">
                                    <div>
                                        <strong>
                                            <center>
                                                <input type="text" id="txtProductID" name="txtProductID" hidden>
                                            </label>
                                        </center>
                                    </strong>
                                </div>
                            </div>

                            <!-- Product Name / Product Name / Main Cat / Sub Cat / Manufacture / Agent -->
                            <div class="row">
                                <div class="col-4">  
                                    <!-- Product Image -->
                                    <div class="row justify-content-sm-center">
                                        <div class="col-6 form-group text-center" style="position: relative;" >
                                            <span class="img-div">
                                                <div class="text-center img-placeholder"  onClick="triggerClick()">
                                                    <h4>Update image</h4>
                                                </div>
                                                <img src="prd_Images/default_prdct_img.png" onClick="triggerClick()" id="profileDisplay">
                                            </span>
                                            <input type="file" name="profileImage" onChange="displayImage(this)" id="profileImage" class="form-control" style="display: none;" accept=".jpg">

                                            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong> Product Image </strong></label>
                                        </div>
                                        <script type="text/javascript">
                                            function triggerClick(e) {
                                                document.querySelector('#profileImage').click();
                                            }
                                            function displayImage(e) {
                                                if (e.files[0]) {
                                                    var reader = new FileReader();
                                                    reader.onload = function(e){
                                                        document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
                                                    }
                                                    reader.readAsDataURL(e.files[0]);
                                                }                                                
                                            }
                                        </script>
                                    </div>                                                 
                                </div>
                                <div class="col-8">
                                    <div class="row">
                                        <div class="col form-group form-inline">
                                            <!-- Product Name -->
                                            <label class="col-4" for="txtProductName">
                                                <strong>Product Name</strong>
                                            </label>
                                            <input class="col form-control" type="text" placeholder="Category Name" id="txtProductName" name="txtProductName" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <!-- Main Catogeries -->
                                        <div class="col form-group form-inline">
                                            <label class="col-4"for="mCatName">
                                                <strong>Main category </strong>
                                            </label>

                                            <?php
                                            try
                                            {
                                                $Connection = setConnection();
                                                
                                                $myCoCommand = "SELECT * FROM `tb_maincategory` WHERE `MainCategory_Active` = '1' ";
                                                $CoResult=mysqli_query($Connection, $myCoCommand);

                                                $mCatViewToAddProductInDropDown = '<select id="sltMainCatToSubCatDropDown" name="sltMainCatToSubCatDropDown" onchange="loadSubCatData();" class="col form-control custom-select custom-select-md" style="width: 300px;">';
                                                $mCatViewToAddProductInDropDown .='<option value="0"> - Select Main Category - </option>';

                                                while ($record = mysqli_fetch_assoc($CoResult)) 
                                                {
                                                    $mCatId=$record['MainCategory_ID'];
                                                    $mCatName=$record['MainCategory_Name'];
                                                    
                                                    $mCatViewToAddProductInDropDown .='<option value="'.$mCatId.'">'.$mCatName.'</option>';
                                                }
                                                $mCatViewToAddProductInDropDown .='</select>&nbsp;';
                                                echo $mCatViewToAddProductInDropDown;
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
                                        <script type="text/javascript">
                                            function loadSubCatData(){
                                                //Selected value
                                                var inputValue = document.getElementById('sltMainCatToSubCatDropDown').value;

                                                // alert(document.getElementById("sltMainCatToSubCatDropDown").innerHTML);
                                                // alert('Got' + "  " + inputValue);

                                                if(inputValue != 0)
                                                {
                                                    document.getElementById("sltsubCatToAddProductDropDown").disabled = false;
                                                    
                                                    $.ajax({
                                                        type: 'post',
                                                        url: '../../control/AdminUser/manageSubCats.php',
                                                        data: {

                                                            mainCatID: inputValue,

                                                        },
                                                        success: function (response) {
                                                                                // We get the element having id of display_info and put the
                                                                                //  response inside it
                                                                                $('#sltsubCatToAddProductDropDown').empty();
                                                                                $('#sltsubCatToAddProductDropDown').append(response);
                                                                            }

                                                                        });
                                                }
                                                
                                                else
                                                {
                                                    $( '#sltsubCatToAddProductDropDown' ).append("No sub Categories");
                                                    $("#sltsubCatToAddProductDropDown").val("0");
                                                    document.getElementById("sltsubCatToAddProductDropDown").disabled = true;
                                                }

                                            };
                                        </script>
                                    </div>
                                    <div class="row">
                                        <!-- Sub Catogeries -->
                                        <div class="col form-group form-inline" id="divOfSltsubCatToAddProductDropDown">
                                            <label class="col-4" for="sltsubCatToAddProductDropDown">
                                                <strong>Sub category </strong>
                                            </label>
                                            <select class="col form-control custom-select custom-select-md" id="sltsubCatToAddProductDropDown" name="sltsubCatToAddProductDropDown" style="width: 300px;">
                                                <option value="0">- Select Sub Category -</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col form-group form-inline">
                                            <!-- Suppliers -->
                                            <label class="col-4" for="sltSupplierToSubCatDropDown" >
                                                <strong>Manufacture</strong>
                                            </label>
                                            <?php
                                            try
                                            {
                                                $Connection = setConnection();
                                                
                                                $myCoCommand = "SELECT * FROM `tb_company` WHERE `Company_Active` = '1' ";
                                                $CoResult=mysqli_query($Connection, $myCoCommand);

                                                $suppliersToAddProductInDropDown = '<select id="sltSupplierToSubCatDropDown" name="sltSupplierToSubCatDropDown" class="col form-control custom-select custom-select-md" >';
                                                $suppliersToAddProductInDropDown .='<option value=0> - Select Manufacture / Supplier - </option>';

                                                while ($record = mysqli_fetch_assoc($CoResult)) 
                                                {
                                                    $supplierId=$record['Company_ID'];
                                                    $supplierName=$record['Company_Name'];

                                                    $suppliersToAddProductInDropDown .='<option value="'.$supplierId.'">'.$supplierName.'</option>';
                                                }
                                                $suppliersToAddProductInDropDown .='</select>&nbsp;';
                                                echo $suppliersToAddProductInDropDown;
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
                                    <div class="row">
                                        <!-- Agents -->
                                        <div class="col form-group form-inline">
                                            <label class="col-4" for="sltAgentToSubCatDropDown">
                                                <strong>Agent</strong>
                                            </label>
                                            <?php
                                            try
                                            {
                                                $Connection = setConnection();
                                                
                                                $myCoCommand = "SELECT * FROM `tb_agent` WHERE `Agent_Active` = '1' ";
                                                $CoResult=mysqli_query($Connection, $myCoCommand);

                                                $agentsToAddProductInDropDown = '<select id="sltAgentToSubCatDropDown" name="sltAgentToSubCatDropDown" class="col form-control custom-select custom-select-md" style="width: 300px;">';
                                                $agentsToAddProductInDropDown .='<option value=0> - Select Agent - </option>';

                                                while ($record = mysqli_fetch_assoc($CoResult)) 
                                                {
                                                    $AgentId=$record['Agent_ID'];
                                                    $AgentName=$record['Agent_Name'];
                                                    $AgentNIC=$record['Agent_NIC'];

                                                    $agentsToAddProductInDropDown .='<option value="'.$AgentId.'">'.$AgentNIC.' | '.$AgentName.'</option>';

                                                    
                                                }
                                                $agentsToAddProductInDropDown .='</select>&nbsp;';
                                                echo $agentsToAddProductInDropDown;
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

                            <div class="">
                                <!-- Reorder Level and Expire Remain -->
                                <div class="row">
                                    <!-- Reorder level -->
                                    <div class="col-4 form-group form-inline">
                                        <label class="col">
                                            <strong>Reorder Level Qty</strong>
                                        </label>
                                        <input class="col form-control" type="text" onkeypress="return isNumberKey(event)" title="Enter as a unit count" id="txtReOrderLevel" name="txtReOrderLevel" required>
                                    </div>
                                    <!-- Expire Date range -->
                                    <div class="col-8 form-group form-inline">
                                        <label class="col-4">
                                            <strong>
                                                Expire Remain dates
                                            </strong>
                                        </label>
                                        <input class="col form-control" type="text" onkeypress="return isNumberKey(event)" title="Enter as a date count" title="Example: 10" id="txtExpireRemainDates" name="txtExpireRemainDates" required>
                                    </div>
                                </div>

                                <!-- Open Sale -->
                                <div class="row">
                                    <div class="col-12 form-group form-inline">
                                        <label class="col-2" for="slctSellOnInternet">
                                            <strong>Open for Sell Online</strong>
                                        </label>
                                        <select class="col form-control custom-select custom-select-md" id="slctSellOnInternet" name="slctSellOnInternet">
                                            <option value="1">Yes, Sell on Online</option>
                                            <option value="0">No, Can not Sell on Online</option>
                                        </select>
                                    </div>
                                </div>
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
                        </script>

                        <!-- Submit Buttons -->
                        <div class="row">
                            <div class=" col-4 form-group form-inline">
                            </div>
                            <div class="form-group form-inline">
                                <div class="col-4 form-inine form-group">
                                    <button class="btn btn-primary btn-md" id="btnAdd_Product" name="btnAdd_Product" type="submit">Add New </button>
                                </div> 
                                <div class="col-4 form-inine form-group">
                                    <button class="btn btn-warning btn-md" id="btnUpdate_Product" name="btnUpdate_Product" type="submit">Update</button>
                                </div>
                                <div class="col-4 form-inine form-group">
                                    <button class="btn btn-danger btn-md" id="btnDelete_Product" name="btnDelete_Product" type="submit">Delete</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
            <!-- Form end here -->
        </div>
    </div>
</div>
<!-- Main Cat end -->
</div>
</div>
<!-- Manage product Section end-->

<!-- View product Section -->
<div id="viewProduct" class="container-fluid" style="display:none;">
    <div class="card shadow">
        <!-- view all items here -->
        <div class="card-header py-3">
            <p class="text-primary m-0 font-weight-bold">All Products</p>
            <!-- Search item here -->
            <div class="input-group md-form form-sm form-1 pl-0">
                <input class="form-control my-0 py-1" type="text" onkeyup="myProductSearchFunctionA(0)" id="searchInputB" placeholder="by Name..." aria-label="Search" name="searchInputB">
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 text-nowrap">
                    <!-- View All Products -->
                    <div class="table-responsive table mt-2" id="productDataTable">
                        <?php 
                        try{

                            $Connection = setConnection();

                            $myPrdctCommand = "SELECT * FROM `tb_product` INNER JOIN `tb_company` ON `tb_product`.`tb_Company_Company_ID` = `tb_company`.`Company_ID` INNER JOIN `tb_subcategory` ON `tb_product`.`tb_SubCategory_SubCategory_ID` = `tb_subcategory`.`SubCategory_ID` INNER JOIN `tb_maincategory` ON `tb_subcategory`.`tb_MainCategory_MainCategory_ID`=`tb_maincategory`.`MainCategory_ID`  WHERE `Product_Active`=1 ORDER BY `Product_ProductName` ASC";
                            $prdctResult=mysqli_query($Connection, $myPrdctCommand);

                            $table='<table class="table my-0" id="productDataTable">';
                            $table.='<thead><tr>
                            <td><strong>Product ID</strong></td>
                            <td><strong>Product Name</strong></td>
                            <td><strong>Manufacture</strong></td>
                            <td><strong>Main Category</strong></td>
                            <td><strong>Sub Category</strong></td>
                            <td><strong>Edit / Delete</strong></td>
                            </tr></thead><tbody>';
                            $numMainRowsProducts = mysqli_num_rows($prdctResult);

                            if ($numMainRowsProducts > 100) {
                                $numMainRemainRowsProducts = mysqli_num_rows($prdctResult) - 100;
                                echo "There are {$numMainRowsProducts} record(s) detected. Remain to show {$numMainRemainRowsProducts} record(s)";
                            }
                            else{
                                echo "There are {$numMainRowsProducts} record(s) detected.";
                            }

                            
                            $n = 0;
                            while ($record = mysqli_fetch_assoc($prdctResult)) 
                            {
                                $Id=$record['Product_ID'];
                                $ProductName=$record['Product_ProductName'];
                                $CompanyName=$record['Company_Name'];
                                $MainCategoryName=$record['MainCategory_Name'];
                                $SubCategoryName=$record['SubCategory_Name'];

                                $SubCatIDForPrduct = $record['tb_SubCategory_SubCategory_ID'];
                                $MainCatIDForPrduct = $record['MainCategory_ID'];
                                $CompanyIDForPrduct = $record['Company_ID'];
                                $AgentIDForPrduct = $record['tb_Agent_Agent_ID'];
                                $ReorderLevelForPrduct = $record['Product_ReOrderLevelQty'];
                                $ExpireDatesForPrduct = $record['Product_ExpireRemainDates'];
                                $OpenSaleForPrduct = $record['Product_OpenSale'];
                                $imgLocation = $record['Product_ImageLocation'];


                                $n += 1;
                                if ($n<101) {
                                    $table.='<tr id="'.$Id.'">';
                                    $table.='<td>'.$Id.'</td>';
                                    $table.='<td>'.$ProductName.'</td>';
                                    $table.='<td>'.$CompanyName.'</td>';
                                    $table.='<td>'.$MainCategoryName.'</td>';
                                    $table.='<td>'.$SubCategoryName.'</td>';

                                    $table.='<td hidden>'.$SubCatIDForPrduct.'</td>';
                                    $table.='<td hidden>'.$MainCatIDForPrduct.'</td>';
                                    $table.='<td hidden>'.$CompanyIDForPrduct.'</td>';
                                    $table.='<td hidden>'.$AgentIDForPrduct.'</td>';
                                    $table.='<td hidden>'.$ReorderLevelForPrduct.'</td>';
                                    $table.='<td hidden>'.$ExpireDatesForPrduct.'</td>';
                                    $table.='<td hidden>'.$OpenSaleForPrduct.'</td>';
                                    $table.='<td hidden>'.$imgLocation.'</td>';



                                    $table.='<td>
                                    <button class="btn btn-warning" onclick="myPrdctUpdateFunction('.$Id.')"><i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" onclick="myPrdctDeleteFunction('.$Id.')"><i class="fas fa-trash"></i>
                                    </button>
                                    </td>';
                                    $table.='</tr>';
                                                ////
                                }
                                else{
                                    $table.='<tr id="'.$Id.'" style="display:none;">';
                                    $table.='<td>'.$Id.'</td>';
                                    $table.='<td>'.$ProductName.'</td>';
                                    $table.='<td>'.$CompanyName.'</td>';
                                    $table.='<td>'.$MainCategoryName.'</td>';
                                    $table.='<td>'.$SubCategoryName.'</td>';

                                    $table.='<td hidden>'.$SubCatIDForPrduct.'</td>';
                                    $table.='<td hidden>'.$MainCatIDForPrduct.'</td>';
                                    $table.='<td hidden>'.$CompanyIDForPrduct.'</td>';
                                    $table.='<td hidden>'.$AgentIDForPrduct.'</td>';
                                    $table.='<td hidden>'.$ReorderLevelForPrduct.'</td>';
                                    $table.='<td hidden>'.$ExpireDatesForPrduct.'</td>';
                                    $table.='<td hidden>'.$OpenSaleForPrduct.'</td>';
                                    $table.='<td hidden>'.$imgLocation.'</td>';



                                    $table.='<td>
                                    <button class="btn btn-warning" onclick="myPrdctUpdateFunction('.$Id.')"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger" onclick="myPrdctDeleteFunction('.$Id.')"><i class="fas fa-trash"></i></button></td>';
                                    $table.='</tr>';
                                }
                                

                            }
                            $table.='</tbody> </table>';
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
        <!-- Main Cat end -->
    </div>
    <br>
</div>
<!-- View product Section end-->

<!-- Main Category Section -->
<div id="mainCat" class="container-fluid" style="display:none;">
    <div class="card shadow">
        <!-- Main Cat start -->
        <div class="card-header py-3">
            <p class="text-primary m-0 font-weight-bold">Product Main Categories
                &nbsp;&nbsp;
                <button id="btnNewmainCatExtra" onclick="btnNewmainCatExtra()" class="btn btn-info" hidden>New</button>
            </p>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 text-nowrap">
                    <form action="../../control/AdminUser/manageCategory.php" method="POST">
                        <div class="form-row">
                            <div class="col">
                                <div>
                                    <strong><center><label class="" id="msg" hidden></label></center></strong>
                                </div>
                                <div class="form-group">
                                    <label for="txtmCateName">
                                        <strong>Category Name 
                                            <!-- Tootip -->
                                            <a href="#" data-toggle="tooltip" title="Enter Main Category.">
                                                <i class="fas fa-question-circle" style="color: black;">
                                                </i>
                                            </a>
                                        </strong>
                                    </label>
                                    <input type="text" name="txtmCateID" id="txtmCateID" hidden>

                                    <input class="form-control" type="text" placeholder="Category Name" name="txtmCateName" id="txtmCateName" required="">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            &nbsp;&nbsp;
                            <div class="form-group"><button class="btn btn-primary btn-md" type="submit" id="btnAdd_MCategory" name="btnAdd_MCategory">Add New </button></div> &nbsp;&nbsp;&nbsp;
                            <div class="form-group"><button class="btn btn-warning btn-md" type="submit" id="btnUpdate_MCategory" name="btnUpdate_MCategory">Update</button></div> &nbsp;&nbsp;&nbsp;
                            <div class="form-group"><button class="btn btn-danger btn-md" type="submit" id="btnDelete_MCategory" name="btnDelete_MCategory">Delete</button></div> &nbsp;&nbsp;&nbsp;
                        </div>
                        <?php  ?>
                    </form>    
                    <!-- Show Current added Main Cats -->
                    <input class="form-control col-4" style="float: right;" type="text" id="myMainCatInput" onkeyup="myMainCatFunction(0)" placeholder="Search Category by Name..." title="Type in a name"><br><br>

                    <div class="table-responsive table mt-2" id="mainDataTable">

                        <?php 
                        try{

                            $Connection = setConnection();

                            $myCoCommand = "SELECT * FROM `tb_maincategory` WHERE `MainCategory_Active` = '1' ORDER BY `tb_maincategory`.`MainCategory_ID` DESC";
                            $CoResult=mysqli_query($Connection, $myCoCommand);

                            $table='<table class="table my-0" id="mainCategoryDataTable">';
                            $table.='<thead><tr><td><strong>Category ID</strong></td><td><strong>Category Name</strong></td><td><strong>Edit / Delete</strong></td></tr></thead><tbody>';
                            $numMainRowsSubCats = mysqli_num_rows($CoResult);

                            if ($numMainRowsSubCats > 5) {
                                $numMainRemainRowsSubCats = mysqli_num_rows($CoResult) - 5;
                                echo "There are {$numMainRowsSubCats} record(s) detected. Remain to show {$numMainRemainRowsSubCats} record(s)";
                            }
                            else{
                                echo "There are {$numMainRowsSubCats} record(s) detected.";
                            }

                            
                            $n = 0;
                            while ($record = mysqli_fetch_assoc($CoResult)) 
                            {
                                $Id=$record['MainCategory_ID'];
                                $Name=$record['MainCategory_Name'];

                                $n += 1;
                                if ($n<6) {
                                    $table.='<tr id="'.$Id.'">';
                                    $table.='<td>'.$Id.'</td>';
                                    $table.='<td>'.$Name.'</td>';
                                    $table.='<td>
                                    <button class="btn btn-warning" onclick="myMainCatUpdateFunction('.$Id.')"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger" onclick="myMainCatDeleteFunction('.$Id.')"><i class="fas fa-trash"></i></button></td>';
                                    $table.='</tr>';
                                                ////
                                }
                                else{
                                    $table.='<tr id="'.$Id.'" style="display:none;">';
                                    $table.='<td>'.$Id.'</td>';
                                    $table.='<td>'.$Name.'</td>';
                                    $table.='<td>
                                    <button class="btn btn-warning" onclick="myMainCatUpdateFunction('.$Id.')"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger" onclick="myMainCatDeleteFunction('.$Id.')"><i class="fas fa-trash"></i></button></td>';
                                    $table.='</tr>';
                                }
                                

                            }
                            $table.='</tbody> </table>';
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
        <!-- Main Cat end -->
    </div>
    <br>
</div>
<!-- Main Category Section end-->

<!-- Sub Category Section -->
<div id="subCat" class="container-fluid" style="display:none;">
    <div class="card shadow">
        <!-- Main Cat start -->
        <div class="card-header py-3">
            <p class="text-primary m-0 font-weight-bold">Product Sub Categories
                &nbsp;&nbsp;
                <button id="btnNewSubCatExtra" onclick="btnNewSubCatExtra()" class="btn btn-info" hidden>New</button></p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 text-nowrap">
                        <form action="../../control/AdminUser/manageCategory.php" method="POST">
                            <div class="form-row">
                                <div class="col">
                                    <div>
                                        <strong><center><label class="" id="subCatMsg" hidden></label></center></strong>
                                    </div>
                                    <div class="form-group">
                                        <label for="mainCatDropDown"><strong>Select Main Category 
                                            <!-- Tootip -->
                                            <a href="#" data-toggle="tooltip" title="Select Main Category for add new sub Categories!">
                                                <i class="fas fa-question-circle" style="color: black;">
                                                </i>
                                            </a>
                                        </strong>
                                    </label>
                                    <!-- View main categories in the drop down menu -->
                                    <?php
                                    try
                                    {
                                        $Connection = setConnection();
                                        
                                        $myCoCommand = "SELECT * FROM `tb_maincategory` WHERE `MainCategory_Active` = '1' ";
                                        $CoResult=mysqli_query($Connection, $myCoCommand);

                                        $mCatViewInDropDown = '<div class="dropdown"><label><select id="sltSunMainCatDropDown" name="sltSunMainCatDropDown" class="form-control custom-select custom-select-md" style="width: 300px;">';

                                        while ($record = mysqli_fetch_assoc($CoResult)) 
                                        {
                                            $mCatId=$record['MainCategory_ID'];
                                            $mCatName=$record['MainCategory_Name'];

                                            $mCatViewInDropDown .='<option value="'.$mCatId.'">'.$mCatName.'</option>';
                                        }
                                        $mCatViewInDropDown .='</select>&nbsp; *Select Needed Main Category';
                                        $mCatViewInDropDown .='</label></div>';
                                        echo $mCatViewInDropDown;
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
                        <div>
                            <div>
                                <div>
                                    <input type="text" id="txtsubCatId" name="txtsubCatId" hidden>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="subCatName"><strong>Sub Category Name</strong></label>
                                    <input class="form-control" type="text" placeholder="Category Name" id="txtsubCatName" name="txtsubCatName">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group"><button class="btn btn-primary" id="btnSubCatAdd" name="btnSubCatAdd" type="submit">Add New </button></div> 
                            &nbsp;&nbsp;&nbsp;
                            <div class="form-group"><button class="btn btn-warning" id="btnSubCatUpdate" name="btnSubCatUpdate" type="submit">Update</button></div> 
                            &nbsp;&nbsp;&nbsp;
                            <div class="form-group"><button class="btn btn-danger" id="btnSubCatdelete" name="btnSubCatdelete" type="submit">Delete</button></div> 
                            <!-- &nbsp;&nbsp;&nbsp; -->
                        </div>
                    </form>

                    <br>
                    <!-- Show Current added sub cats according to selected main cat -->
                    <input class="form-control col-4" style="float: right;" type="text" id="mySubCatInput" onkeyup="mySubCatFunction(0)" placeholder="Search Category by Name..." title="Type in a name"><br><br>

                    <div class="table-responsive table mt-2" id="mainDataTable">
                        <?php 
                        try{

                            $Connection = setConnection();

                            $myCoCommand = "SELECT * FROM `tb_subcategory` INNER JOIN `tb_maincategory` ON `tb_subcategory`.`tb_MainCategory_MainCategory_ID` = `tb_maincategory`.`MainCategory_ID` WHERE `SubCategory_Active`=1 ORDER BY `tb_subcategory`.`SubCategory_ID` DESC";
                            $CoResult=mysqli_query($Connection, $myCoCommand);

                            $numRowsSubCats = mysqli_num_rows($CoResult);
                            if ($numRowsSubCats > 5) {
                                $numRemainRowsSubCats = mysqli_num_rows($CoResult) - 5;
                                echo "There are {$numRowsSubCats} record(s) detected. Remain to show {$numRemainRowsSubCats} record(s)";
                            }
                            else{
                                echo "There are {$numRowsSubCats} record(s) detected.";
                            }


                            $table='<table class="table my-0" id="subCategoryDataTable">';
                            $table.='<thead><tr><td><strong>Sub Category ID</strong></td><td><strong>Sub Category Name</strong></td><td><strong>Main Category Name</strong></td><td><strong>Edit / Delete</strong></td></tr></thead><tbody>';

                            $numRecord = mysqli_num_rows($CoResult) - 5;

                            $n = 0;
                            while ($record = mysqli_fetch_assoc($CoResult)) 
                            {
                                $subId=$record['SubCategory_ID'];
                                $subMainName=$record['MainCategory_Name'];
                                $subName=$record['SubCategory_Name'];
                                $subMainId=$record['MainCategory_ID']; 

                                $n += 1;
                                if ($n<6) {
                                    $table.='<tr id="'.$subId.'">';
                                    $table.='<td>'.$subId.'</td>';
                                    $table.='<td>'.$subName.'</td>';
                                    $table.='<td>'.$subMainName.'</td>';
                                    $table.='<td style="display:none;">'.$subMainId.'</td>';
                                    $table.='<td>
                                    <button class="btn btn-warning" onclick="mySubCatUpdateFunction('.$subId.')"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger" onclick="mySubCatDeleteFunction('.$subId.')"><i class="fas fa-trash"></i></button></td>';
                                    $table.='</tr>';
                                                // if ($n = 5 && mysqli_num_rows($CoResult)>4 ) {
                                                //     $numRecord = mysqli_num_rows($CoResult) - 5;
                                                //     $table.='<tr>';
                                                //     $table.='<td colspan="3">There are '.$numRecord.'  record(s) more..</td>';
                                                //     $table.='</tr>';
                                                // }
                                                ////
                                }
                                else{
                                    $table.='<tr id="'.$Id.'" style="display:none;">';
                                    $table.='<td>'.$subId.'</td>';
                                    $table.='<td>'.$subName.'</td>';
                                    $table.='<td>'.$subMainName.'</td>';
                                    $table.='<td style="display:none;">'.$subMainId.'</td>';
                                    $table.='<td>
                                    <button class="btn btn-warning" onclick="mySubCatUpdateFunction('.$subId.')"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger" onclick="mySubCatDeleteFunction('.$subId.')"><i class="fas fa-trash"></i></button></td>';
                                    $table.='</tr>';
                                }
                                

                            }
                            $table.='</tbody> </table>';
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
        <!-- Main Cat end -->
    </div>
    <br>
</div>







<script type="text/javascript">
    document.getElementById("sltsubCatToAddProductDropDown").disabled = true;

    function show(thisPanel, toThisPanel) {
        document.getElementById(toThisPanel).innerHTML= document.getElementById(thisPanel).innerHTML;
    }

    function hide(thisPanel){
        document.getElementById(thisPanel).style.display = "none";
    }

</script>



<!-- Footer part Start from here -->
<?php include('../../control/AdminUser/HeadAndFooter/footer.php');?>

<script>
//For Product Manage section - Start
document.getElementById("btnUpdate_Product").style.display = 'none';
document.getElementById("btnDelete_Product").style.display = 'none';

function myProductSearchFunctionA() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("searchInputB");
  filter = input.value.toUpperCase();
  table = document.getElementById("productDataTable");
  tr = table.getElementsByTagName("tr");
  var n = 1;
  for (i = 1; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1 && n<101) {
        tr[i].style.display = "";
        n += 1;
    } else {
        tr[i].style.display = "none";
    }
}  
} 
}



function myPrdctUpdateFunction(mg){

    $('td').click(function(){
        var col = $(this).parent().children().index($(this));
        var row = $(this).parent().parent().children().index($(this).parent());
        // alert('Row: ' + row + ', Column: ' + col);
        // alert("Hello! I am an alert box!!" + mg);

        var newRow = row + 1;
        table = document.getElementById("productDataTable");
        tr = table.getElementsByTagName("tr");
        document.getElementById("txtProductID").value =  tr[newRow].getElementsByTagName("td")[0].innerHTML;
        document.getElementById("txtProductName").value =  tr[newRow].getElementsByTagName("td")[1].innerHTML;
        document.getElementById("txtReOrderLevel").value =  tr[newRow].getElementsByTagName("td")[9].innerHTML;
        document.getElementById("txtExpireRemainDates").value =  tr[newRow].getElementsByTagName("td")[10].innerHTML;
        document.getElementById("sltsubCatToAddProductDropDown").value =  tr[newRow].getElementsByTagName("td")[5].innerHTML;
        document.getElementById("sltMainCatToSubCatDropDown").value =  tr[newRow].getElementsByTagName("td")[6].innerHTML;
        document.getElementById("sltAgentToSubCatDropDown").value =  tr[newRow].getElementsByTagName("td")[8].innerHTML;
        document.getElementById("slctSellOnInternet").value =  tr[newRow].getElementsByTagName("td")[11].innerHTML;
        document.getElementById("sltSupplierToSubCatDropDown").value =  tr[newRow].getElementsByTagName("td")[7].innerHTML;




        var img = document.getElementById('profileDisplay');   
        function ChangeImg() { 
            img.src = "prd_Images/"+ tr[newRow].getElementsByTagName("td")[12].innerHTML; 
        }
        ChangeImg();

        document.getElementById("btnExtraNewProduct").hidden = false;
        document.getElementById("btnAdd_Product").style.display = 'none';
        document.getElementById("btnUpdate_Product").style.display = 'block';
        document.getElementById("btnDelete_Product").style.display = 'none';

        loadSubCatData();
        document.getElementById("sltsubCatToAddProductDropDown").value =  tr[newRow].getElementsByTagName("td")[5].innerHTML;

        document.getElementById("msgForProducts").hidden = true;

        document.getElementById("txtProductName").disabled = false;
        document.getElementById("txtReOrderLevel").disabled = false;
        document.getElementById("txtExpireRemainDates").disabled = false;
        document.getElementById("sltMainCatToSubCatDropDown").disabled = false;
        document.getElementById("sltAgentToSubCatDropDown").disabled = false;
        document.getElementById("sltsubCatToAddProductDropDown").disabled = false;
        document.getElementById("sltSupplierToSubCatDropDown").disabled = false;
        document.getElementById("slctSellOnInternet").disabled = false;
        // 
        

    });

    hide('manageProduct'); show('manageProduct','mainPanel');

        // This prevents the page from scrolling down to where it was previously.
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
    // This is needed if the user scrolls down during page load and you want to make sure the page is scrolled to the top once it's fully loaded. This has Cross-browser support.
    window.scrollTo(0,0);
}

function btnExtraNewProduct() {
    document.getElementById("msgForProducts").hidden = true;

    document.getElementById("txtProductName").disabled = false;
    document.getElementById("txtReOrderLevel").disabled = false;
    document.getElementById("txtExpireRemainDates").disabled = false;
    document.getElementById("sltMainCatToSubCatDropDown").disabled = false;
    document.getElementById("sltAgentToSubCatDropDown").disabled = false;
    document.getElementById("sltsubCatToAddProductDropDown").disabled = true;
    document.getElementById("sltSupplierToSubCatDropDown").disabled = false;
    document.getElementById("slctSellOnInternet").disabled = false;

    document.getElementById("txtProductName").value = "";
    document.getElementById("txtReOrderLevel").value = "";
    document.getElementById("txtExpireRemainDates").value = "";
    document.getElementById("sltMainCatToSubCatDropDown").selectedIndex = 0;
    document.getElementById("sltAgentToSubCatDropDown").selectedIndex = 0;
    document.getElementById("sltsubCatToAddProductDropDown").value = 0;
    document.getElementById("sltSupplierToSubCatDropDown").selectedIndex = 0;
    document.getElementById("slctSellOnInternet").selectedIndex = 0;
    
    var img = document.getElementById('profileDisplay');   
    function ChangeImg() { 
        img.src = "prd_Images/default_prdct_img.png"; 
    }
    ChangeImg();

    document.getElementById("btnExtraNewProduct").hidden = true;
    document.getElementById("btnAdd_Product").style.display = 'block';
    document.getElementById("btnUpdate_Product").style.display = 'none';
    document.getElementById("btnDelete_Product").style.display = 'none';

            // This prevents the page from scrolling down to where it was previously.
            if ('scrollRestoration' in history) {
                history.scrollRestoration = 'manual';
            }
        // This is needed if the user scrolls down during page load and you want to make sure the page is scrolled to the top once it's fully loaded. This has Cross-browser support.
        window.scrollTo(0,0);
    }

    function myPrdctDeleteFunction(gh){

        $('td').click(function(){
            var col = $(this).parent().children().index($(this));
            var row = $(this).parent().parent().children().index($(this).parent());
        // alert('Row: ' + row + ', Column: ' + col);
        // alert("Hello! I am an alert box!!" + mg);

        var newRow = row + 1;
        table = document.getElementById("productDataTable");
        tr = table.getElementsByTagName("tr");
        document.getElementById("txtProductID").value =  tr[newRow].getElementsByTagName("td")[0].innerHTML;
        document.getElementById("txtProductName").value =  tr[newRow].getElementsByTagName("td")[1].innerHTML;
        document.getElementById("txtReOrderLevel").value =  tr[newRow].getElementsByTagName("td")[9].innerHTML;
        document.getElementById("txtExpireRemainDates").value =  tr[newRow].getElementsByTagName("td")[10].innerHTML;
        document.getElementById("sltsubCatToAddProductDropDown").value =  tr[newRow].getElementsByTagName("td")[5].innerHTML;
        document.getElementById("sltMainCatToSubCatDropDown").value =  tr[newRow].getElementsByTagName("td")[6].innerHTML;
        document.getElementById("sltAgentToSubCatDropDown").value =  tr[newRow].getElementsByTagName("td")[8].innerHTML;
        document.getElementById("slctSellOnInternet").value =  tr[newRow].getElementsByTagName("td")[11].innerHTML;
        document.getElementById("sltSupplierToSubCatDropDown").value =  tr[newRow].getElementsByTagName("td")[7].innerHTML;

        var img = document.getElementById('profileDisplay');   
        function ChangeImg() { 
            img.src = "prd_Images/"+ tr[newRow].getElementsByTagName("td")[12].innerHTML; 
        }
        ChangeImg();

        document.getElementById("btnExtraNewProduct").hidden = false;
        document.getElementById("btnAdd_Product").style.display = 'none';
        document.getElementById("btnUpdate_Product").style.display = 'none';
        document.getElementById("btnDelete_Product").style.display = 'block';

        document.getElementById("txtProductName").disabled = true;
        document.getElementById("txtReOrderLevel").disabled = true;
        document.getElementById("txtExpireRemainDates").disabled = true;
        document.getElementById("sltMainCatToSubCatDropDown").disabled = true;
        document.getElementById("sltAgentToSubCatDropDown").disabled = true;
        document.getElementById("sltSupplierToSubCatDropDown").disabled = true;
        document.getElementById("slctSellOnInternet").disabled = true;
        document.getElementById("profileDisplay").disabled = true;

        document.getElementById("msgForProducts").hidden = false;
        document.getElementById("msgForProducts").innerHTML = "Do you want to Delete this Product?";
        document.getElementById("msgForProducts").style.color = 'red';
        loadSubCatData();
        // alert("Dropdown Value before" + document.getElementById("sltsubCatToAddProductDropDown").value);
        var x = tr[newRow].getElementsByTagName("td")[5].innerHTML;
        // document.getElementById("sltsubCatToAddProductDropDown").Selected = x;

        // alert("Value now" + x);
        // alert("Dropdown Value now" + document.getElementById("sltsubCatToAddProductDropDown").Selected);
        document.getElementById('sltsubCatToAddProductDropDown').value =x;

        // var ddl = document.getElementById('sltsubCatToAddProductDropDown');

        // var x = tr[newRow].getElementsByTagName("td")[5].innerHTML;

        // var opts = ddl.options.length;

        // for (var i=0; i<opts; i++){
        //     if (ddl.options[i].value == x){
        //         ddl.options[i].selected = true;
        //         break;
        //     }
        // }

        

    });
        
        hide('manageProduct'); show('manageProduct','mainPanel');

        // This prevents the page from scrolling down to where it was previously.
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
    // This is needed if the user scrolls down during page load and you want to make sure the page is scrolled to the top once it's fully loaded. This has Cross-browser support.
    window.scrollTo(0,0);
}
//For Product Manage section - End




//For Main Category Section - Start
document.getElementById("btnUpdate_MCategory").style.display = 'none';
document.getElementById("btnDelete_MCategory").style.display = 'none';

function myMainCatFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myMainCatInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("mainCategoryDataTable");
  tr = table.getElementsByTagName("tr");
  var n = 1;
  for (i = 1; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
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

function myMainCatUpdateFunction(mg){

    $('td').click(function(){
        var col = $(this).parent().children().index($(this));
        var row = $(this).parent().parent().children().index($(this).parent());
        // alert('Row: ' + row + ', Column: ' + col);
        // alert("Hello! I am an alert box!!" + mg);

        var newRow = row + 1;
        table = document.getElementById("mainCategoryDataTable");
        tr = table.getElementsByTagName("tr");
        document.getElementById("txtmCateID").value =  tr[newRow].getElementsByTagName("td")[0].innerHTML;
        document.getElementById("txtmCateName").value =  tr[newRow].getElementsByTagName("td")[1].innerHTML;

        document.getElementById("msg").hidden = true;

        document.getElementById("txtmCateID").disabled = false;
        document.getElementById("txtmCateName").disabled = false;
        // 
        document.getElementById("btnNewmainCatExtra").hidden = false;
        document.getElementById("btnAdd_MCategory").style.display = 'none';
        document.getElementById("btnUpdate_MCategory").style.display = 'block';
        document.getElementById("btnDelete_MCategory").style.display = 'none';

    });
        // This prevents the page from scrolling down to where it was previously.
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
    // This is needed if the user scrolls down during page load and you want to make sure the page is scrolled to the top once it's fully loaded. This has Cross-browser support.
    window.scrollTo(0,0);
}

function btnNewmainCatExtra() {
    document.getElementById("msg").hidden = true;

    document.getElementById("txtmCateID").disabled = false;
    document.getElementById("txtmCateName").disabled = false;

    document.getElementById("txtmCateID").value = "";
    document.getElementById("txtmCateName").value = "";
    
    document.getElementById("btnNewmainCatExtra").hidden = true;
    document.getElementById("btnAdd_MCategory").style.display = 'block';
    document.getElementById("btnUpdate_MCategory").style.display = 'none';
    document.getElementById("btnDelete_MCategory").style.display = 'none';

            // This prevents the page from scrolling down to where it was previously.
            if ('scrollRestoration' in history) {
                history.scrollRestoration = 'manual';
            }
        // This is needed if the user scrolls down during page load and you want to make sure the page is scrolled to the top once it's fully loaded. This has Cross-browser support.
        window.scrollTo(0,0);
    }

    function myMainCatDeleteFunction(gh){

        $('td').click(function(){
            var col = $(this).parent().children().index($(this));
            var row = $(this).parent().parent().children().index($(this).parent());
        // alert('Row: ' + row + ', Column: ' + col);
        // alert("Hello! I am an alert box!!" + mg);

        var newRow = row + 1;
        table = document.getElementById("mainCategoryDataTable");
        tr = table.getElementsByTagName("tr");
        document.getElementById("txtmCateID").value =  tr[newRow].getElementsByTagName("td")[0].innerHTML;
        document.getElementById("txtmCateName").value =  tr[newRow].getElementsByTagName("td")[1].innerHTML;

        document.getElementById("msg").hidden = false;
        document.getElementById("msg").innerHTML = "Do you want to Delete this Main Category?";
        document.getElementById("msg").style.color = 'red';

        // document.getElementById("txtmCateID").disabled = true;
        document.getElementById("txtmCateName").disabled = true;

        document.getElementById("btnNewmainCatExtra").hidden = false;
        document.getElementById("btnAdd_MCategory").style.display = 'none';
        document.getElementById("btnUpdate_MCategory").style.display = 'none';
        document.getElementById("btnDelete_MCategory").style.display = 'block';

    });
        // This prevents the page from scrolling down to where it was previously.
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
    // This is needed if the user scrolls down during page load and you want to make sure the page is scrolled to the top once it's fully loaded. This has Cross-browser support.
    window.scrollTo(0,0);
}
//For Main Category Section - End

//Sub Main Category Section - Start
document.getElementById("btnSubCatUpdate").style.display = 'none';
document.getElementById("btnSubCatdelete").style.display = 'none';

function mySubCatFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("mySubCatInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("subCategoryDataTable");
  tr = table.getElementsByTagName("tr");
  var n = 1;
  for (i = 1; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
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

function mySubCatUpdateFunction(mg){

    $('td').click(function(){
        var col = $(this).parent().children().index($(this));
        var row = $(this).parent().parent().children().index($(this).parent());
        // alert('Row: ' + row + ', Column: ' + col);
        // alert("Hello! I am an alert box!!" + mg);

        var newRow = row + 1;
        table = document.getElementById("subCategoryDataTable");
        tr = table.getElementsByTagName("tr");
        document.getElementById("txtsubCatId").value =  tr[newRow].getElementsByTagName("td")[0].innerHTML;
        document.getElementById("txtsubCatName").value =  tr[newRow].getElementsByTagName("td")[1].innerHTML;
        document.getElementById("sltSunMainCatDropDown").value =  tr[newRow].getElementsByTagName("td")[2].innerHTML;
        document.getElementById("sltSunMainCatDropDown").value =  tr[newRow].getElementsByTagName("td")[3].innerHTML;

        document.getElementById("subCatMsg").hidden = true;

        document.getElementById("txtsubCatId").disabled = false;
        document.getElementById("txtsubCatName").disabled = false;
        document.getElementById("sltSunMainCatDropDown").disabled = false;
        // 
        document.getElementById("btnNewSubCatExtra").hidden = false;
        document.getElementById("btnSubCatAdd").style.display = 'none';
        document.getElementById("btnSubCatUpdate").style.display = 'block';
        document.getElementById("btnSubCatdelete").style.display = 'none';

    });
        // This prevents the page from scrolling down to where it was previously.
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
    // This is needed if the user scrolls down during page load and you want to make sure the page is scrolled to the top once it's fully loaded. This has Cross-browser support.
    window.scrollTo(0,0);
}

function btnNewSubCatExtra() {
    document.getElementById("subCatMsg").hidden = true;

    document.getElementById("txtsubCatId").disabled = false;
    document.getElementById("txtsubCatName").disabled = false;
    document.getElementById("sltSunMainCatDropDown").disabled = false;

    document.getElementById("txtsubCatId").value = "";
    document.getElementById("txtsubCatName").value = "";
    
    document.getElementById("btnNewSubCatExtra").hidden = true;
    document.getElementById("btnSubCatAdd").style.display = 'block';
    document.getElementById("btnSubCatUpdate").style.display = 'none';
    document.getElementById("btnSubCatdelete").style.display = 'none';
            // This prevents the page from scrolling down to where it was previously.
            if ('scrollRestoration' in history) {
               history.scrollRestoration = 'manual';
           }
        // This is needed if the user scrolls down during page load and you want to make sure the page is scrolled to the top once it's fully loaded. This has Cross-browser support.
        window.scrollTo(0,0);
    }

    function mySubCatDeleteFunction(gh){

        $('td').click(function(){
            var col = $(this).parent().children().index($(this));
            var row = $(this).parent().parent().children().index($(this).parent());
        // alert('Row: ' + row + ', Column: ' + col);
        // alert("Hello! I am an alert box!!" + mg);

        var newRow = row + 1;
        table = document.getElementById("subCategoryDataTable");
        tr = table.getElementsByTagName("tr");
        document.getElementById("txtsubCatId").value =  tr[newRow].getElementsByTagName("td")[0].innerHTML;
        document.getElementById("txtsubCatName").value =  tr[newRow].getElementsByTagName("td")[1].innerHTML;
        document.getElementById("sltSunMainCatDropDown").value =  tr[newRow].getElementsByTagName("td")[2].innerHTML;
        document.getElementById("sltSunMainCatDropDown").value =  tr[newRow].getElementsByTagName("td")[3].innerHTML;

        document.getElementById("subCatMsg").hidden = false;
        document.getElementById("subCatMsg").innerHTML = "Do you want to Delete this Sub-Category?";
        document.getElementById("subCatMsg").style.color = 'red';

        document.getElementById("txtsubCatName").disabled = true;
        document.getElementById("sltSunMainCatDropDown").disabled = true;

        document.getElementById("btnNewSubCatExtra").hidden = false;
        document.getElementById("btnSubCatAdd").style.display = 'none';
        document.getElementById("btnSubCatUpdate").style.display = 'none';
        document.getElementById("btnSubCatdelete").style.display = 'block';

    });
    // This prevents the page from scrolling down to where it was previously.
    if ('scrollRestoration' in history) {
        history.scrollRestoration = 'manual';
    }
    // This is needed if the user scrolls down during page load and you want to make sure the page is scrolled to the top once it's fully loaded. This has Cross-browser support.
    window.scrollTo(0,0);
}
//Sub Main Category Section - End


</script>

<?php 


// msgForProducts

// txtProductID
// txtProductName
// txtReOrderLevel
// txtExpireRemainDates

// sltMainCatToSubCatDropDown
// sltAgentToSubCatDropDown       value=id
// sltSupplierToSubCatDropDown     value=id

// sltsubCatToAddProductDropDown    value=id

// btnExtraNewProduct

// slctSellOnInternet = 1/Yes

// productDataTable

// myPrdctUpdateFunction
// myPrdctDeleteFunction

// btnAdd_Product
// btnUpdate_Product
// btnDelete_Product

// MainCategoryName

// tb_product.Product_ID
// tb_product.Product_ProductName
// tb_company.Company_Name
// tb_maincategory.MainCategory_Name
// tb_subcategory.SubCategory_Name


// hide('manageProduct'); show('manageProduct','mainPanel');


?>
