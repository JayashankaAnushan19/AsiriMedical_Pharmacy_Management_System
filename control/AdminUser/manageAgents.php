<?php
require_once __DIR__ . '/../../model/auth.php';
require_staff();
include('../../model/db_connection.php'); 
// print_r($_POST);

if (isset($_POST["btn_AddAgent"])) {
    
    try{

        runQuary("INSERT INTO `tb_agent`(`Agent_NIC`, `Agent_Name`, `Agent_Tel`, `Agent_Address`, `Agent_Active`) VALUES ('$_POST[txtNIC]', '$_POST[txtname]', '$_POST[txtTel]', '$_POST[txtAddress]', '1')","New Agent Added Successfully !!!");

    }
    catch(Exception $e) {
        echo "<script type='text/javascript'>alert('Error Occured.')</script>";
    }

}
elseif (isset($_POST["btn_UpdateAgent"])) {


    try{
        runQuary("UPDATE `tb_agent` SET `Agent_NIC`='$_POST[txtNIC]',`Agent_Name`='$_POST[txtname]',`Agent_Tel`='$_POST[txtTel]',`Agent_Address`='$_POST[txtAddress]' WHERE `Agent_ID`= '$_POST[txtID]'","Agent Updated Successfully !!!");

    }
    catch(Exception $e) {
        echo "<script type='text/javascript'>alert('Error Occured.')</script>";
    }
}
elseif (isset($_POST["btn_DeleteAgent"])) {


    try{
        runQuary("UPDATE `tb_agent` SET `Agent_Active`= 0 WHERE `Agent_ID`= '$_POST[txtID]'","Agent Deleted Successfully !!!");

    }
    catch(Exception $e) {
        echo "<script type='text/javascript'>alert('Error Occured.')</script>";
    }
}

?>

<html>
<head>
    <meta http-equiv="Refresh" content="0;url=../../view/AdminUser/agent.php">
    <title>Loading ...</title>
</head>
<body>
</body>
</html>