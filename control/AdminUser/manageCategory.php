<?php 
include('../../model/db_connection.php'); 


// Main Category Manage
if (isset($_POST["btnAdd_MCategory"])) {
    
    try{

        runQuary("INSERT INTO `tb_maincategory`( `MainCategory_Name`, `MainCategory_Active`) VALUES ('$_POST[txtmCateName]',1)","New Category Added Successfully !!!");

    }
    catch(Exception $e) {
        echo "<script type='text/javascript'>alert('Error Occured.')</script>";
    }

}
elseif (isset($_POST["btnUpdate_MCategory"])) {


    try{
        runQuary("UPDATE `tb_maincategory` SET `MainCategory_Name`='$_POST[txtmCateName]' WHERE `MainCategory_ID`= '$_POST[txtmCateID]'","Category Updated Successfully !!!");

    }
    catch(Exception $e) {
        echo "<script type='text/javascript'>alert('Error Occured.')</script>";
    }
}
elseif (isset($_POST["btnDelete_MCategory"])) {

    try{
        // echo "<script type='text/javascript'>alert('$_POST[txtmCateID]')</script>";
        runQuary("UPDATE `tb_maincategory` SET `MainCategory_Active`= 0 WHERE `MainCategory_ID`= '$_POST[txtmCateID]'","Category Deleted Successfully !!!");

    }
    catch(Exception $e) {
        echo "<script type='text/javascript'>alert('Error Occured.')</script>";
    }
}

// Sub Category Manage
elseif (isset($_POST["btnSubCatAdd"])) {
    
    try{

        runQuary("INSERT INTO `tb_subcategory`(`SubCategory_Name`, `SubCategory_Active`, `tb_MainCategory_MainCategory_ID`) VALUES ('$_POST[txtsubCatName]',1,'$_POST[sltSunMainCatDropDown]')","New Sub-Category Added Successfully !!!");

    }
    catch(Exception $e) {
        echo "<script type='text/javascript'>alert('Error Occured.')</script>";
    }

}
elseif (isset($_POST["btnSubCatUpdate"])) {


    try{
        runQuary("UPDATE `tb_subcategory` SET `SubCategory_Name`='$_POST[txtsubCatName]',`tb_MainCategory_MainCategory_ID`='$_POST[sltSunMainCatDropDown]' WHERE `SubCategory_ID`= '$_POST[txtsubCatId]'","Category Updated Successfully !!!");

    }
    catch(Exception $e) {
        echo "<script type='text/javascript'>alert('Error Occured.')</script>";
    }
}
elseif (isset($_POST["btnSubCatdelete"])) {

    try{
        // echo "<script type='text/javascript'>alert('$_POST[txtmCateID]')</script>";
        runQuary("UPDATE `tb_subcategory` SET `SubCategory_Active`= 0 WHERE `SubCategory_ID` = '$_POST[txtsubCatId]'","Category Deleted Successfully !!!");

    }
    catch(Exception $e) {
        echo "<script type='text/javascript'>alert('Error Occured.')</script>";
    }
}

?>

<html>
    <head>
        <meta http-equiv="Refresh" content="0;url=../../view/AdminUser/product.php">
        <title>Loading ...</title>
    </head>
    <body>
    </body>
</html>