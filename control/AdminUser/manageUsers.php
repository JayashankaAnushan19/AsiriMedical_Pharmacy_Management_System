<?php
include('../../model/db_connection.php'); 
// print_r($_POST);

if (isset($_POST["btn_AddUser"])) {
    
    try{

        runQuary("INSERT INTO `tb_adminuser`(`user_NIC`, `user_Name`, `user_Tel`, `user_Address`, `user_Role`, `user_Uname`, `user_Password`, `user_Active`) VALUES ('$_POST[txtNICNumber]', '$_POST[txtUserName]', '$_POST[txtUserTel]', '$_POST[txtUserAddress]', '$_POST[txtUserRole]', '$_POST[txtUserUName]', '$_POST[txtPassword]', '1')","New User Added Successfully !!!");

    }
    catch(Exception $e) {
        echo "<script type='text/javascript'>alert('Error Occured.')</script>";
    }

}
elseif (isset($_POST["btn_UpdateUser"])) {


    try{
        runQuary("UPDATE `tb_adminuser` SET `user_NIC`='$_POST[txtNICNumber]',`user_Name`='$_POST[txtUserName]',`user_Tel`='$_POST[txtUserTel]',`user_Address`='$_POST[txtUserAddress]',`user_Role`='$_POST[txtUserRole]',`user_Uname`='$_POST[txtUserUName]',`user_Password`='$_POST[txtPassword]' WHERE `user_ID`= '$_POST[txtUserID]'","User Updated Successfully !!!");

    }
    catch(Exception $e) {
        echo "<script type='text/javascript'>alert('Error Occured.')</script>";
    }
}
elseif (isset($_POST["btn_DeleteUser"])) {


    try{
        runQuary("UPDATE `tb_adminuser` SET `user_Active`= 0 WHERE `user_ID`= '$_POST[txtUserID]'","User Deleted Successfully !!!");

    }
    catch(Exception $e) {
        echo "<script type='text/javascript'>alert('Error Occured.')</script>";
    }
}

?>

    <html>
        <head>
            <meta http-equiv="Refresh" content="0;url=../../view/AdminUser/AdminUser.php">
            <title>Loading ...</title>
        </head>
        <body>
        </body>
    </html>