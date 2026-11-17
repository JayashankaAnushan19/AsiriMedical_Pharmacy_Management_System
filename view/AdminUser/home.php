<?php 
include('../../control/AdminUser/HeadAndFooter/header.php');

if (!isset($_SESSION["UserId"])) {
    session_destroy();
    header("location: Adminlogin.php");
    exit();
}


 //print_r($_SESSION)
?>


<?php 

include('../../model/db_connection.php'); 

$Connection = setConnection();

$MedNoCommand = "SELECT * FROM `tb_product` WHERE `Product_Active` = '1'";
$MedNoResult=mysqli_query($Connection, $MedNoCommand);
$NoOfMed = mysqli_num_rows($MedNoResult);

$Today = date("Y/m/d");

$SaleNoCommand = "SELECT * FROM `tb_saleinvoice` WHERE `SalesInvoice_Active`='1' AND `SaleInvoice_Date`='".$Today."'";
$SaleNoResult=mysqli_query($Connection, $SaleNoCommand);
$NoOfSale = mysqli_num_rows($SaleNoResult);

$EmpNoCommand = "SELECT * FROM `tb_adminuser` WHERE `user_Active`='1'";
$EmpNoResult=mysqli_query($Connection, $EmpNoCommand);
$NoOfEmp = mysqli_num_rows($EmpNoResult);

$SupNoCommand = "SELECT * FROM `tb_company` WHERE `Company_Active`='1'";
$SupNoResult=mysqli_query($Connection, $SupNoCommand);
$NoOfSup = mysqli_num_rows($SupNoResult);

?>





<div class="container-fluid">
    
    <!-- Summary Count show -->
    <div class="row">
        
        <div class="column">
            <div class="card shadow"> 
                <div class="card-header">
                    <strong style="font-size: 50px;"><?php echo $NoOfMed; ?></strong>
                    <i class="fas  fa-chevron-circle-up" style="color: orange;"></i>
                    <br>
                    Total Medicines
                </div>
                <div class=" card-body">
                    <div class=""><img src="../../assets/img/bgchart25.jpg" width="225.17px"></div>
                </div>
            </div>
        </div> 
        &nbsp;
        <div class="column">
            <div class="card shadow"> 
                <div class="card-header">
                    <strong style="font-size: 50px;"><?php echo $NoOfSale; ?></strong>
                    <i class="fas  fa-chevron-circle-up" style="color: orange;"></i>
                    <br>
                    Today sales (<?php echo $Today; ?>)
                </div>
                <div class=" card-body">
                    <div class=""><img src="../../assets/img/bgchart25.jpg" width="225.17px"></div>
                </div>
            </div>
        </div>
        &nbsp;
        <div class="column">
            <div class="card shadow"> 
                <div class="card-header">
                    <strong style="font-size: 50px;"><?php echo $NoOfEmp; ?></strong>
                    <i class="fas  fa-chevron-circle-up" style="color: orange;"></i>
                    <br>
                    Total of Employees
                </div>
                <div class=" card-body">
                    <div class=""><img src="../../assets/img/bgchart25.jpg" width="225.17px"></div>
                </div>
            </div>
        </div>
        &nbsp;
        <div class="column">
            <div class="card shadow"> 
                <div class="card-header">
                    <strong style="font-size: 50px;"><?php echo $NoOfSup; ?></strong>
                    <i class="fas  fa-chevron-circle-up" style="color: orange;"></i>
                    <br>
                    Total Suppliers
                </div>
                <div class=" card-body">
                    <div class=""><img src="../../assets/img/bgchart25.jpg" width="225.17px"></div>
                </div>
            </div>
        </div>
    </div>  
    <hr><hr>    
    <!-- Report and quick links -->
    <Center>
        <div class="row">

            <div class="column">
                <div class="card shadow"> 
                    <div class="card-header">
                        <i class="fa fa fa-money-bill" style="color: black; width:225.17px; font-size: 50px;"></i>
                    </div>
                    <div class="card-body shadow">
                        <a href="pos.php">
                            Create New Sale
                            <i class="fa fa fa-chevron-circle-right" style="color: black;"></i>
                        </a>
                        
                    </div>
                </div>
            </div>
            &nbsp;
            <div class="column">
                <div class="card shadow"> 
                    <div class="card-header">
                        <i class="fa fa fa-shopping-basket" style="color: black; width:225.17px; font-size: 50px;"></i>
                    </div>
                    <div class="card-body shadow">
                        <a href="product.php">
                            Add Medicine
                            <i class="fa fa fa-chevron-circle-right" style="color: black;"></i>
                        </a>
                    </div>
                </div>
            </div>
            &nbsp;
            <div class="column">
                <div class="card shadow"> 
                    <div class="card-header">
                        <i class="fa fa-retweet" style="color: black; width:225.17px; font-size: 50px;"></i>
                    </div>
                    <div class="card-body shadow">
                        <a href="return.php">
                            Return
                            <i class="fa fa fa-chevron-circle-right" style="color: black;"></i>
                        </a>
                    </div>
                </div>
            </div>
            &nbsp;
            <div class="column">
                <div class="card shadow"> 
                    <div class="card-header">
                        <i class="fa fa fa-archive" style="color: black; width:225.17px; font-size: 50px;"></i>
                    </div>
                    <div class="card-body shadow">
                        <a href="purchase.php">
                            Add Stock   
                            <i class="fa fa fa-chevron-circle-right" style="color: black;"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            
            <div class="column">
                <div class="card shadow"> 
                    <div class="card-header">
                        <i class="fa fa fa-qrcode" style="color: black; width:225.17px; font-size: 50px;"></i>
                    </div>
                    <div class="card-body shadow">
                        <a href="#">
                            Purchase report
                            <i class="fa fa fa-chevron-circle-right" style="color: black;"></i>
                        </a>
                    </div>
                </div>
            </div>
            &nbsp;
            <div class="column">
                <div class="card shadow"> 
                    <div class="card-header">
                        <i class="fa fa fa-table" style="color: black; width:225.17px; font-size: 50px;"></i>
                    </div> 
                    <div class="card-body shadow">
                        <a href="#">
                            Stock Report
                            <i class="fa fa fa-chevron-circle-right" style="color: black;"></i>
                        </a>
                    </div>
                </div>
            </div>
            &nbsp;
            <div class="column">
                <div class="card shadow"> 
                    <div class="card-header">
                        <i class="fa fa fa-tags" style="color: black; width:225.17px; font-size: 50px;"></i>
                    </div>
                    <div class="card-body shadow">
                        <a href="reportSales.php">
                            Sales Report
                            <i class="fa fa fa-chevron-circle-right" style="color: black;"></i>
                        </a>
                    </div>
                </div>
            </div>
            &nbsp;
            <div class="column">
                <div class="card shadow"> 
                    <div class="card-header">
                        <i class="fa fa fa-balance-scale" style="color: black; width:225.17px; font-size: 50px;"></i>
                    </div>
                    <div class="card-body shadow">
                        <a href="#">
                         Account Summary
                         <i class="fa fa fa-chevron-circle-right" style="color: black;"></i> 
                     </a>
                 </div>
             </div>
         </div>
     </div>
 </Center>
 <hr>    
</div>

<!-- Footer part Start from here -->
<?php include('../../control/AdminUser/HeadAndFooter/footer.php');?>