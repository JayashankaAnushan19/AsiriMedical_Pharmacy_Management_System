<?php 
session_start();
?>   
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>PMS-Sotuion</title>
<link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
<link rel="stylesheet" href="../../assets/fonts/fontawesome-all.min.css">
<link rel="stylesheet" href="../../assets/fonts/ionicons.min.css">
<link rel="stylesheet" href="../../assets/css/Login-Form-Dark.css">

<div>
    <div class="login-dark">
        <form action="#" method="post">
            <center>
                <a href="../../index.html">
                    <img src="../../assets/img/pmsLogo.png" height="150px" style="margin-top: -20px">
                </a>
            </center>
            <h3><center style="margin-top: 10px">Asiri Medical <br><br> <h6 style="margin-top: -20px"><i>Pharmacy Management System</i></h6></center></h3>
            <hr style="background-color: white;">
            <!-- <h6><center>Internal User Login</center></h6> -->
            <div ><label id="ErrMsg" style="color: red;"></label></div>
            <!-- <div class="illustration"><i class="icon ion-ios-locked-outline"></i></div> -->
            <div class="form-group"><input class="form-control" type="text" name="uname" placeholder="Username"></div>
            <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password"></div>
            <div class="form-group">
                <button class="btn btn-primary btn-block" name="btnLog" type="submit">Log In</button>
            </div>
        </form>

    </div>
    <script src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>

    <?php 

    include('../../model/db_connection.php'); 

    

    if (isset($_POST["btnLog"]))
    {
        $Connection = setConnection();
        

        $unam = $_POST['uname'];
        $pass = $_POST['password'];

        if($unam == ""){
            ?>
            <script type="text/javascript">
                document.getElementById('ErrMsg').innerHTML = "Enter Username.";
                // alert("Enter Username.");
            </script>
            <?php
        }
        else if($pass == ""){
            ?>
            <script type="text/javascript">
                document.getElementById('ErrMsg').innerHTML = "Enter Username Again and Enter valid Password.";
                // alert("Enter Password.");
            </script>
            <?php
        }
        else{

            $myCommand = "SELECT * FROM `tb_adminuser` WHERE `user_Uname`='".$unam."' AND `user_Password`='".$pass."' LIMIT 1"; //SQL Query
            $RecoResult=mysqli_query($Connection, $myCommand); //Run SQL Query
            
            if (mysqli_num_rows($RecoResult)==1) {

                $record = mysqli_fetch_assoc($RecoResult);

                // session_destroy();

                $_SESSION["UserId"] = $record['user_ID'];
                $_SESSION["UserName"] = $record['user_Name'];
                $_SESSION["UserLevel"] = $record['user_Role'];

                $User = $_SESSION["UserId"];

                $Date = date("Y/m/d");

                try {
                    $Connection = setConnection();

                    $invoiceAddCmd = "INSERT INTO `tb_login_history`(`login_History_User_ID`, `login_History_LogDate`, `tb_user_user_ID`) VALUES ('$User','$Date','$User')";

                    mysqli_query($Connection, $invoiceAddCmd);

                } catch (Exception $e) {

                }


                if ($_SESSION["UserLevel"] == 0 || $_SESSION["UserLevel"] == 1) {
                    header("location: home.php");
                }
                if ($_SESSION["UserLevel"] == 2 || $_SESSION["UserLevel"] == 3) {
                    header("location: lawLevelHome.php");
                }

                
            }
            else {
                ?>
                <script type="text/javascript">
                    document.getElementById('ErrMsg').innerHTML = "Password and Username error !!";
                    // alert("Enter Password.");
                </script>
                <?php
                // echo "<script type='text/javascript'>alert('Password and Username error !!')</script>";
            }
        }
    } 
    else{
        session_destroy();
    }
    ?>

</div>