<?php 
include('../../control/AdminUser/HeadAndFooter/header.php');

if (!isset($_SESSION["UserId"])) {
    session_destroy();
    header("location: Adminlogin.php");
    exit();
}

?>
<style type="text/css">
  .headd
  {
    text-align: center;
}
.msg{
    text-align: center;
}
.msg img{
    margin: auto;
}
</style>

<div class="container-fluid">
    <div class="card shadow"> 
        <div class="card-header">
            <strong style="font-size: 50px;">
                <div class="headd">
                    Welcome !!!
                </div>
            </strong>
        </div>
        <div class=" card-body msg">
            <div class="sidebar-brand-icon">
                <img src="../../assets/img/pmsLogo.png" height="250px">
            </div>
            Asiri Medical Pharmacy Management System.
        </div>
        <div class=" card-footer">
            Copyright © Jmax Software Solution 2020
        </div>
    </div>   
</div>

