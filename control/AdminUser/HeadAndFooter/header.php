<?php
require_once __DIR__ . '/../../../model/auth.php';
require_staff();
?>
<!DOCTYPE html>
<html>
<head>
    <title>PMS-Sotuion</title>

    <link rel = "icon" href ="../../assets/img/pmslogo.png" type = "image/x-icon"> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="../../assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../../assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="../../assets/css/Login-Form-Dark.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    
    <style type="text/css">
        ul {
            list-style-type: none;
        }
        ul a:link {color: #ffffff;}
    </style>

</head>

<body id="page-top" onload=display_ct();>
    <div id="wrapper">
        <!-- Start Slide nav bar -->
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-dark p-0">
            <div class="container-fluid d-flex flex-column p-0">
                <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon"><img src="../../assets/img/pmsLogo.png" height="50px"></div>

                    <div class="sidebar-brand-text mx-2"><span>Asiri Medical</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="nav navbar-nav text-light" id="accordionSidebar">

                    <?php 
                    // $userAccess = array('IDs' => , );
                    //0 - S Admin
                    //1 - Admin
                    //2 - Store Keeper
                    //3 - Cashier

                    $lvl = $_SESSION["UserLevel"];

                    // Nav Bar List Start
                    if ($lvl == 2 || $lvl == 3 ) {
                        ?>
                        <li class="nav-item" role="presentation"><a class="nav-link" href="lawLevelHome.php"><i class="fas fa-home"></i><span>Home</span></a></li>
                        <?php 
                    }

                    if ($lvl == 0 || $lvl == 1 ) {
                        ?>
                        <li class="nav-item" role="presentation"><a class="nav-link" href="home.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                        <?php 
                    }
                    if ($lvl == 0 || $lvl == 1 || $lvl == 3 ) {
                        ?>
                        <li class="nav-item" role="presentation"><a class="nav-link" href="pos.php"><i class="fa fa fa-money-bill"></i><span>POS</span></a></li>
                        <?php 
                    }
                    if ($lvl == 0 || $lvl == 1 || $lvl == 2 ) {
                        ?>
                        <li class="nav-item" role="presentation"  data-toggle="collapse" data-target="#productAndStockDiv">
                            <div class="nav-link">
                                <i class="fas fa-box-open"></i>
                                <span>Product</span><i style="float: right;" class="fas fa-chevron-circle-down"></i>
                            </div>
                        </li>
                        <ul class="sub-menu collapse" id="productAndStockDiv">

                            <?php

                            if ($lvl == 0 || $lvl == 1) {
                                ?>
                                <li class="nav-item" role="presentation"><a href="product.php"> <i class="fas fa-chevron-circle-right"></i> Products</a></li>
                                <?php 
                            }
                            ?>                            
                            <li class="nav-item" role="presentation"><a href="purchase.php"> <i class="fas fa-chevron-circle-right"></i> Purchase</a></li>
                            <li class="nav-item" role="presentation"><a href="stock.php"> <i class="fas fa-chevron-circle-right"></i> Stock</a></li>
                        </ul>
                        <?php 
                    }

                    if ($lvl == 0 || $lvl == 1) {
                        ?>
                        <!-- Supplier and Agents Management -->
                        <li class="nav-item" role="presentation"  data-toggle="collapse" data-target="#supAndAgntDiv">
                            <div class="nav-link">
                                <i class="fas fa-building"></i>
                                <span>Company</span><i style="float: right;" class="fas fa-chevron-circle-down"></i>
                            </div>
                        </li>
                        <ul class="sub-menu collapse" id="supAndAgntDiv">
                            <li class="nav-item"><a href="supplier.php"> <i class="fas fa-chevron-circle-right"></i> Suppliers / Company</a>
                            </li>
                            <li class="nav-item"><a href="agent.php"> <i class="fas fa-chevron-circle-right"></i> Agents</a>
                            </li>
                        </ul>

                        <!-- Retunr -->
                        <li class="nav-item" role="presentation"  data-toggle="collapse" data-target="#returnDiv">
                            <div class="nav-link">
                                <i class="fas fa-undo"></i>
                                <span>Return</span><i style="float: right;" class="fas fa-chevron-circle-down"></i>
                            </div>
                        </li>
                        <ul class="sub-menu collapse" id="returnDiv">
                            <li class="nav-item"><a href="sreturn.php"> <i class="fas fa-chevron-circle-right"></i> Sales Return</a>
                            </li>
                            <li class="nav-item"><a href="preturn.php"> <i class="fas fa-chevron-circle-right"></i> Purchase Return</a>
                            </li>
                        </ul>



                        <li class="nav-item" role="presentation"><a class="nav-link" href="payment.php"><i class="fas fa-search-dollar"></i><span>Payment</span></a></li>

                        <!-- User Manage -->
                        <li class="nav-item" role="presentation"  data-toggle="collapse" data-target="#userDiv">
                            <div class="nav-link">
                                <i class="fas fa-user-circle"></i>
                                <span>Users</span><i style="float: right;" class="fas fa-chevron-circle-down"></i>
                            </div>
                        </li>
                        <ul class="sub-menu collapse" id="userDiv">
                            <li class="nav-item">
                                <a href="AdminUser.php"> <i class="fas fa-chevron-circle-right"></i> User Manage</a>
                            </li>
                            <li class="nav-item" hidden>
                                <a href="AdminUser.php"> <i class="fas fa-chevron-circle-right"></i> User Roles</a>
                            </li>
                            <li class="nav-item" hidden>
                                <a href="AdminUser.php"> <i class="fas fa-chevron-circle-right"></i> User Role Permission</a>
                            </li>
                        </ul>

                        <!-- Reports -->
                        <li class="nav-item" role="presentation"  data-toggle="collapse" data-target="#reportsDiv">
                            <div class="nav-link">
                                <i class="fas fa-chart-line"></i>
                                <span>Reports</span><i style="float: right;" class="fas fa-chevron-circle-down"></i>
                            </div>
                        </li>
                        <ul class="sub-menu collapse" id="reportsDiv">
                            <li class="nav-item">
                                <a href="reportSales.php"> <i class="fas fa-chevron-circle-right"></i> Sales Report</a>
                            </li>
                            <li class="nav-item">
                                <a href="#.php"> <i class="fas fa-chevron-circle-right"></i> Report</a>
                            </li>
                        </ul>

                        <!-- Specail Settings -->
                        <li style="display: none;" class="nav-item" role="presentation"><a class="nav-link" href="settings.php"><i class="fas fa-cog"></i><span>Special Settings</span></a></li> 

                        <?php 
                    }
                    ?>

                    <!-- Profile -->
                    <li class="nav-item" role="presentation"><a class="nav-link" href="profile.php"><i class="fas fa-user"></i><span>Profile</span></a></li>  

                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button>
                </div>
            </div>
        </nav>
        <!-- End Slide nav bar -->

        <!-- Rest of peice of the page start -->
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-info shadow mb-2 topbar static-top" style="height: 40px;">
                    <div class="container-fluid">
                        <button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button">
                            <i class="fas fa-bars"></i>
                        </button>
                        <!-- Date and Time - RealtimeWorking -->
                        <div style="color: white;">
                            <script type="text/javascript"> 
                                function display_c(){
                                        var refresh=1000; // Refresh rate in milli seconds
                                        mytime=setTimeout('display_ct()',refresh)
                                    }

                                    function display_ct() {
                                        var x = new Date()

                                        // date part ///
                                        var month=x.getMonth()+1;
                                        var day=x.getDate();
                                        var year=x.getFullYear();

                                        if (month <10 ){month='0' + month;}
                                        if (day <10 ){day='0' + day;}

                                        var x3= 'Date: '+year+'/' +month+'/'+day;

                                        // time part //
                                        var hour=x.getHours();
                                        var minute=x.getMinutes();
                                        var second=x.getSeconds();

                                        if(hour <10 ){hour='0'+hour;}
                                        if(minute <10 ) {minute='0' + minute; }
                                        if(second<10){second='0' + second;}
                                        var x3 = x3 +'&nbsp;&nbsp;&nbsp;'+ 'Time: '+  hour+':'+minute+':'+second

                                        document.getElementById('ct').innerHTML = x3;
                                        display_c();
                                    }
                                </script>
                                <span id='ct' ></span>
                            </div>

                            <ul class="nava navbar-nav flex-nowrap ml-auto">
                                <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><i class="fas fa-search"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right p-3 animated--grow-in" role="menu" aria-labelledby="searchDropdown">
                                        <form class="form-inline mr-auto navbar-search w-100">
                                            <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                                <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                                            </div>
                                        </form>

                                    </div>
                                </li>

                                <?php 

                                $conn = db();

                                $prdctIds = "SELECT * FROM `tb_product`";
                                $prdctIdsResult = mysqli_query($conn, $prdctIds);
                                $n = 0;
                                
                                $PrdctArr = array();
                                while ($record = mysqli_fetch_assoc($prdctIdsResult)) 
                                {

                                    $PrdctArr[$n] = array();
                                    $PrdctArr[$n][0] = $record['Product_ID'];
                                    $PrdctArr[$n][1] = $record['Product_ReOrderLevelQty'];
                                    $PrdctArr[$n][2] = $record['Product_ExpireRemainDates'];
                                    $n++;
                                }

                                $invenIds = "SELECT `tb_Product_Product_ID`, SUM(`Inventory_CurrentQty`) FROM `tb_inventory`  WHERE `Inventory_Active`=1 AND 0<`Inventory_CurrentQty` GROUP BY `tb_Product_Product_ID`";
                                $invenIdsResult = mysqli_query($conn, $invenIds);
                                $j = 0;
                                $InventSumArr = array();
                                while ($record = mysqli_fetch_assoc($invenIdsResult))
                                {
                                    $InventSumArr[$j] = array();
                                    $InventSumArr[$j][0] = $record['tb_Product_Product_ID'];                                    
                                    $InventSumArr[$j][1] = $record['SUM(`Inventory_CurrentQty`)'];
                                    $j++;
                                }

                                // Check Reorder Count
                                $ReorderCount = 0;
                                for ($i=0; $i < count($InventSumArr) ; $i++) { 
                                    for ($k=0; $k < count($PrdctArr); $k++) { 
                                        if ($InventSumArr[$i][0] == $PrdctArr[$k][0]) {
                                            if ($PrdctArr[$k][1] < $InventSumArr[$i][1]) {
                                            }
                                            else{
                                                $ReorderCount++;
                                            }
                                        }
                                    }
                                }

                                $invenExpIds = "SELECT * FROM `tb_inventory` WHERE `Inventory_Active`=1 AND 0<`Inventory_CurrentQty`";
                                $invenExpIdsResult = mysqli_query($conn, $invenExpIds);
                                $p = 0;
                                $InventExpArr = array();
                                while ($record = mysqli_fetch_assoc($invenExpIdsResult)) 
                                {
                                    $InventExpArr[$p] = array();
                                    $InventExpArr[$p][0] = $record['Inventory_ID'];
                                    $InventExpArr[$p][1] = $record['tb_Product_Product_ID'];                                    
                                    $InventExpArr[$p][2] = $record['Inventory_CurrentQty'];
                                    $InventExpArr[$p][3] = $record['Inventory_ExpireDate'];
                                    $j++;
                                }

                                $ExpCount = 0;
                                for ($i=0; $i < count($InventExpArr) ; $i++) { 
                                    for ($k=0; $k < count($PrdctArr); $k++) { 
                                        if ($InventExpArr[$i][1] == $PrdctArr[$k][0]) {

                                            $Today = date("Y/m/d");
                                            $date1 = $InventExpArr[$i][3];
                                            $date2 = $Today;

                                            $diff = abs(strtotime($date2) - strtotime($date1));
                                            $dateRange = floor($diff/ (60*60*24));

                                            if(strtotime($date2) < strtotime($date1))
                                            {
                                                $dateRange = 0 - $dateRange;
                                            }

                                            $gd = abs(strtotime($PrdctArr[$k][2]));
                                            $prdctDateCount = floor($gd/ (60*60*24));

                                            if ($dateRange < $prdctDateCount) 
                                            {
                                            }
                                            else{
                                                $ExpCount++;
                                            }
                                        }
                                    }
                                }



                                if (isset($PaidResult) && 0<mysqli_num_rows($PaidResult)) {
                                    $count += mysqli_num_rows($PaidResult);
                                    ?>
                                    <a class="d-flex align-items-center dropdown-item" href="#">
                                        <div class="mr-3">
                                            <div class="badge-danger icon-circle"><i class="fas fa-donate text-white"></i></div>
                                        </div>
                                        <div>Paid but not shipped Orders Pending. - Orders (<?php echo (mysqli_num_rows($PaidResult)); ?>)
                                        </div>
                                    </a>
                                    <br>
                                    <?php 
                                }

                                ?>
                                

                                <li id="alrtWindow" class="nav-item dropdown no-arrow mx-1" role="presentation">
                                    <div class="nav-item dropdown no-arrow">
                                        <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">
                                            <span id="stckAlertCount" class="badge badge-danger badge-counter"></span>
                                            <i class="fas fa-bell fa-fw"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-list dropdown-menu-right animated--grow-in"
                                        role="menu">
                                        <h6 class="dropdown-header">Stock alerts center</h6>

                                        <?php 
                                        $ExpAndReOrderCount = 0;

                                        if (0 < $ExpCount) {
                                            $ExpAndReOrderCount += $ExpCount;
                                            ?>

                                            <a class="d-flex align-items-center dropdown-item" href="#">
                                                <div class="mr-3">
                                                    <div class="bg-danger icon-circle"><i class="fas fa-file-alt text-white"></i></div>
                                                </div>
                                                <div><?php echo $ExpCount; ?> of Item(s) going to expire.
                                                </div>
                                            </a>

                                            <?php  

                                        }
                                        if (0 < $ReorderCount) {
                                            $ExpAndReOrderCount += $ReorderCount;
                                            ?>

                                            <a class="d-flex align-items-center dropdown-item" href="#">
                                                <div class="mr-3">
                                                    <div class="bg-danger icon-circle"><i class="fas fa-file-alt text-white"></i></div>
                                                </div>
                                                <div><?php echo $ReorderCount; ?> of Item(s) going to end from the Stock.
                                                </div>
                                            </a>

                                            <?php  
                                        }

                                        if (0 < $ExpAndReOrderCount) {
                                            ?>
                                            <script type="text/javascript">
                                                document.getElementById('stckAlertCount').innerHTML = <?php echo $ExpAndReOrderCount; ?>;
                                            </script>
                                            <?php 
                                        }

                                        ?>
                                    </div>
                                </div>
                            </li>

                            <?php
                            if ($lvl == 0 || $lvl == 1 ) {
                                ?>
                                <script type="text/javascript">
                                    document.getElementById('alrtWindow').style.display = "block";
                                </script>
                                <?php 
                            } 
                            else{
                                ?>
                                <script type="text/javascript">
                                    document.getElementById('alrtWindow').style.display = "none";
                                </script>
                                <?php 
                            }
                            ?>

                            <!-- Order Alert Center -->
                            <!-- <li id="orderAlertWindow" class="nav-item dropdown no-arrow mx-1" role="presentation">
                                <div class="nav-item dropdown no-arrow">
                                    <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">
                                        <i class="fas fa-envelope fa-fw"></i>
                                        <span id="pendOrderCount" class="badge badge-danger badge-counter"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-list dropdown-menu-right animated--grow-in"
                                    role="menu">
                                    <h6 class="dropdown-header">Orders alerts center</h6>
                                    <a class="d-flex align-items-center dropdown-item" href="#">

                                        <?php
                                        $count= 0;

                                            // Paid and Pending Orders
                                        $findPaidOrders = "SELECT * FROM `tb_onlinesellinvoices` WHERE `OnlineSellInvoices_PymntStatus`='1' AND `OnlineSellInvoices_OrderStatus`='0'";
                                        $PaidResult=mysqli_query($conn, $findPaidOrders);

                                            // Unpaid and Pending Orders
                                        $findUnpaidOrders = "SELECT * FROM `tb_onlinesellinvoices` WHERE `OnlineSellInvoices_PymntStatus`='0' AND `OnlineSellInvoices_OrderStatus`='0'"; 
                                        $UnpaidResult=mysqli_query($conn, $findUnpaidOrders);



                                        if (isset($PaidResult) && 0<mysqli_num_rows($PaidResult)) {
                                            $count += mysqli_num_rows($PaidResult);
                                            ?>
                                            <a class="d-flex align-items-center dropdown-item" href="#">
                                                <div class="mr-3">
                                                    <div class="badge-danger icon-circle"><i class="fas fa-donate text-white"></i></div>
                                                </div>
                                                <div>Paid but not shipped Orders Pending. - Orders (<?php echo (mysqli_num_rows($PaidResult)); ?>)
                                                </div>
                                            </a>
                                            <br>
                                            <?php 
                                        }
                                        if (isset($UnpaidResult) && 0<mysqli_num_rows($UnpaidResult)) {
                                            $count += mysqli_num_rows($UnpaidResult);
                                            ?>
                                            <a class="d-flex align-items-center dropdown-item" href="#">
                                                <div class="mr-3">
                                                    <div class="bg-warning icon-circle"><i class="fas fa-donate text-white"></i></div>
                                                </div>
                                                <div>Unpaid and not shipped Orders Pending. - Orders (<?php echo (mysqli_num_rows($UnpaidResult)); ?>)
                                                </div>
                                            </a>
                                            <br>
                                            <?php 
                                        }
                                        if (0 < $count) {
                                            ?>
                                            <script type="text/javascript">
                                                document.getElementById('pendOrderCount').innerHTML = <?php echo $count; ?>;
                                            </script>
                                            <?php 
                                        }
                                        ?>
                                    </a>
                                </div>
                            </div>
                            <div class="shadow dropdown-list dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown"></div>
                        </li> -->


                        <?php
                        if ($lvl == 0 || $lvl == 1 ) {
                            ?>
                            <script type="text/javascript">
                                document.getElementById('orderAlertWindow').style.display = "block";
                            </script>
                            <?php 
                        } 
                        else{
                            ?>
                            <script type="text/javascript">
                                document.getElementById('orderAlertWindow').style.display = "none";
                            </script>
                            <?php 
                        }
                        ?>


                        <div class="d-none d-sm-block topbar-divider"></div>

                        <!-- Profile Nav -->
                        <li class="nav-item dropdown no-arrow" role="presentation">
                            <div class="nav-item dropdown no-arrow">
                                <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">
                                    <span class="d-none d-lg-inline mr-2 text-gray small" style="color: black;"><?php echo e($_SESSION["UserName"]); ?></span>
                                    <img class="border rounded-circle img-profile" src="../../assets/img/Davatar.jpg">
                                </a>
                                <div class="dropdown-menu shadow dropdown-menu-right animated--grow-in" role="menu">
                                    <a class="dropdown-item" role="presentation" href="profile.php">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                        &nbsp; <span style="color: black;">Profile</span>
                                    </a>
                                    <a style="display: none;" class="dropdown-item" role="presentation" href="settings.php">
                                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                        &nbsp; <span style="color: black;">Settings</span>
                                    </a>
                                    <div class="dropdown-divider"></div>    
                                    <a  class="dropdown-item" role="presentation" href="logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        &nbsp; <span style="color: black;">Logout</span>
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Header part over from here -->

            <script type="text/javascript">

            </script>