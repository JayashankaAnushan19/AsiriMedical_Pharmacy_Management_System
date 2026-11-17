<?php
require_once __DIR__ . '/../../model/auth.php';
require_staff();
include('../../model/db_connection.php'); 

if (isset($_POST["btnAdd"])) {
    
    try{

        runQuary("INSERT INTO `tb_company`(`Company_Name`, `Company_Tel`, `Company_Address`, `Company_Active`) VALUES ('$_POST[txtComName]', '$_POST[txtComTel]', '$_POST[txtComAddress]', '1')","New Record Added Successfully !!!");

    }
    catch(Exception $e) {
        echo "<script type='text/javascript'>alert('Error Occured.')</script>";
    }

}
elseif (isset($_POST["btnUpdate"])) {


    try{
        runQuary("UPDATE `tb_company` SET `Company_Name`='$_POST[txtComName]', `Company_Tel`='$_POST[txtComTel]', `Company_Address`='$_POST[txtComAddress]' WHERE `Company_ID` = '$_POST[txtComID]'","Supplier Updated Successfully !!!");

    }
    catch(Exception $e) {
        echo "<script type='text/javascript'>alert('Error Occured.')</script>";
    }
}
elseif (isset($_POST["btnDelete"])) {


    try{
        runQuary("UPDATE `tb_company` SET `Company_Active`=0 WHERE `Company_ID` = '$_POST[txtComID]'","Company Deleted Successfully !!!");

    }
    catch(Exception $e) {
        echo "<script type='text/javascript'>alert('Error Occured.')</script>";
    }
}

?>

<html>
    <head>
        <meta http-equiv="Refresh" content="0;url=../../view/AdminUser/supplier.php">
        <title>Loading ...</title>
    </head>
    <body>
    </body>
</html>