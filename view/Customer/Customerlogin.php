    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Asiri Medical pvt Ltd</title>
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="../../assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../../assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="../../assets/css/Login-Form-Dark-Cus.css">

    <div>
        <div class="login-dark" style="background:#475d62 url(../assets/img/bg.jpg);">
            <form action="#" method="post">
                <center>
                    <a href="../index.html">
                        <img src="../../assets/img/pmsLogo.png" height="150px" style="margin-top: -20px">
                    </a>
                </center>
                <hr style="background-color: white;">
                <h3><center>Login Form</center></h3>
                <hr style="background-color: white;">
                <div ><label id="ErrMsg" style="color: red;" hidden></label></div>  
                <!--  <div class="illustration"><i class="icon ion-ios-locked-outline"></i></div> -->
                <div class="form-group"><input class="form-control" type="text" name="uname" placeholder="Username"></div>
                <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password"></div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block" name="btnLog" type="submit">Log In</button><br>
                    <span>Create New Account, &nbsp;<a href="SignUp.php">SignUp</a></span>

                    <!-- <span style="padding-bottom: 0px">&nbsp;<a href="adminlogin.php">Admin Login</a></span> -->
                </div>
            </form>

        </div>
        <script src="../../assets/js/jquery.min.js"></script>
        <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>

        <?php 
        if (isset($_POST["btnLog"]))
        {
            $unam = $_POST['uname'];
            $pass = $_POST['password'];
            
            if($unam == ""){
                ?>
                <script type="text/javascript">
                    document.getElementById('ErrMsg').hidden = false;
                    document.getElementById('ErrMsg').innerHTML = "Enter Username.";
                // alert("Enter Username.");
            </script>
            <?php
        }
        else if($pass == ""){
            ?>
            <script type="text/javascript">
                document.getElementById('ErrMsg').hidden = false;
                document.getElementById('ErrMsg').innerHTML = "Enter Username Again and Enter Password.";
                // alert("Enter Password.");
            </script>
            <?php
        }


        // Check Password with database
        

        else{
            ?>
            <script type="text/javascript">
                alert("Login Success");
            </script>
            <?php
            // header("location: home.php");
        }
    } 
    else{
    }
    ?>
    
</div>