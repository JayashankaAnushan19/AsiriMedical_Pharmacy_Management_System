<?php
require_once __DIR__ . '/../../model/auth.php';
require_staff(); 
include('../../model/db_connection.php'); 
// print_r($_POST);

$id=0;
$act='';



if (isset($_POST["btnAdd_Product"])) {
    echo "<script type='text/javascript'>alert('add btn ')</script>";
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

                echo "<script type='text/javascript'>alert('Came to Success here')</script>";

                runQuary("INSERT INTO `tb_product`(`Product_ProductName`, `Product_ExpireRemainDates`, `Product_ReOrderLevelQty`, `Product_Active`, `Product_OpenSale`, `Product_ImageLocation`, `tb_Company_Company_ID`, `tb_SubCategory_SubCategory_ID`, `tb_Agent_Agent_ID`) VALUES ('$_POST[txtProductName]','$_POST[txtExpireRemainDates]','$_POST[txtReOrderLevel]','1','$_POST[slctSellOnInternet]', '$profileImageName','$_POST[sltSupplierToSubCatDropDown]','$_POST[sltsubCatToAddProductDropDown]','$_POST[sltAgentToSubCatDropDown]')","New Product Added Successfully !!!");

            } else {
                echo "<script type='text/javascript'>alert('Image Moving Error.')</script>";
            }
        }
    }
    catch(Exception $e) {

        try
        {
            echo "<script type='text/javascript'>alert('Came to image error here')</script>";

            $profileImageName = "default_prdct_img.png";

            runQuary("INSERT INTO `tb_product`(`Product_ProductName`, `Product_ExpireRemainDates`, `Product_ReOrderLevelQty`, `Product_Active`, `Product_OpenSale`, `Product_ImageLocation`, `tb_Company_Company_ID`, `tb_SubCategory_SubCategory_ID`, `tb_Agent_Agent_ID`) VALUES ('$_POST[txtProductName]','$_POST[txtExpireRemainDates]','$_POST[txtReOrderLevel]','1','$_POST[slctSellOnInternet]', '$profileImageName','$_POST[sltSupplierToSubCatDropDown]','$_POST[sltsubCatToAddProductDropDown]','$_POST[sltAgentToSubCatDropDown]')","New Product Added Successfully !!!");
        }
        catch(Exception $e){
            echo "<script type='text/javascript'>alert('Unknown Error Occured.')</script>";
        }
        
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

            } else {
                echo "<script type='text/javascript'>alert('Error Occured.')</script>";
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

<!--  <html>
    <head>
        <meta http-equiv="Refresh" content="0;url=../../view/AdminUser/product.php">
        <title>Loading ...</title>
    </head>
    <body>
    </body>
</html> -->