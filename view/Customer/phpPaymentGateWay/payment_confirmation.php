<?php
include 'security.php' 
?>


<link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
<link rel="stylesheet" href="../../../assets/fonts/fontawesome-all.min.css">
<link rel="stylesheet" href="../../../assets/fonts/ionicons.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


<link rel="stylesheet" type="text/css" href="payment.css"/>

<style type="text/css">
    legend{
        margin-top: 10px;
        color: black;
        font-family: cursive;
        text-decoration: underline;
    }
    form fieldset #orderCusDetails
    {
        margin-left: 25%;
    }
    form fieldset legend
    {
        text-align: center;
    }
    .fieldName{
        margin-left: -30px;
    }
    [type="submit"]{
        float: right;
        margin-right: 40%;
    }
    #msg{
        margin-left: 15%;
        margin-right: 15%; 
        width: 70%;
        text-align: center;
    }
    .center {
      margin: auto;
      width: 50%;
      border: 1px solid green;
      padding: 10px;
    }
</style>


<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <div class="row">
        <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0 mx-3" href="#" id="navLog">
            <div class="sidebar-brand-icon">
                <img src="../../../assets/img/pmsLogo.png" height="50px">
            </div>
            <div class="sidebar-brand-text mx-2">
                <a class="" href="../home.php" style="font-size: 30px;">
                    <span style="text-decoration: none;"> Asiri Medical</span>
                </a>
            </div>
        </a>
    </div>
</nav>




<br><br><br><br><br>
<div class="container-fluid" style="margin-top: 1000px  0px;">
    <div class='card card-product-grid'>
        <form id="payment_confirmation" class="center" action="https://testsecureacceptance.cybersource.com/pay" method="post"/>
        <?php
        foreach($_REQUEST as $name => $value) {
            $params[$name] = $value;
        }
        ?>
        <fieldset id="confirmation">
            <legend>Review Order Details For Payment</legend>
            <div id="orderCusDetails">
                <?php
                foreach($params as $name => $value) {
                    if ($name == "Customer_Name") {
                       echo "<div>";
                       echo "<span class=\"fieldName\">Customer Name</span><span class=\"fieldValue\">: " . $value . "</span>";
                       echo "</div>\n";
                   }
                   elseif ($name == "Email") {
                    echo "<div>";
                    echo "<span class=\"fieldName\">E-Mail</span><span class=\"fieldValue\">: " . $value . "</span>";
                    echo "</div>\n";
                }
                elseif ($name == "Shipping_Address") {
                    echo "<div>";
                    echo "<span class=\"fieldName\">Shiping Address</span><span class=\"fieldValue\">: " . $value . "</span>";
                    echo "</div>\n";
                }
                elseif ($name == "Order_Number") {
                    echo "<div>";
                    echo "<span class=\"fieldName\">Order Number</span><span class=\"fieldValue\">: " . $value . " </span>";
                    echo "</div>\n";
                }   
                elseif ($name == "Total_Amount_") {
                    echo "<div>";
                    echo "<span class=\"fieldName\">Total Amount</span><span class=\"fieldValue\">: Rs. ".$value. "</span>";
                    echo "</div>\n";
                }              
            }

            ?>
        </div>
    </fieldset>
    <?php
    foreach($params as $name => $value) {
        echo "<input type=\"hidden\" id=\"" . $name . "\" name=\"" . $name . "\" value=\"" . $value . "\"/>\n";
    }
    echo "<input type=\"hidden\" id=\"signature\" name=\"signature\" value=\"" . sign($params) . "\"/>\n";
    ?>
    <input type="submit" class="btn btn-primary" id="submit" value="Confirm and Pay"/>
    <br><br><br>

    <label id="msg" class="alert alert-info col">** Use OrderNumber for track the order.</label>

</form>
</div>
</div>

<script src="../../../assets/js/jquery.min.js"></script>
<script src="../../../assets/bootstrap/js/bootstrap.min.js"></script>
<script src="../../../assets/js/chart.min.js"></script>
<script src="../../../assets/js/bs-init.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
<script src="../../../assets/js/theme.js"></script>



