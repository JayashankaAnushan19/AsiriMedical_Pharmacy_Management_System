    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>SignUp - Asiri Medical</title>
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="../../assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../../assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="../../assets/css/SignUp-Form.css">

    <div>
        <div class="sign-dark">
            <form action="#" method="post">
                <h3>
                    <center style="margin-top: 10px">
                       Asiri Medical - Pharmacy System_ Create New Account....
                   </center form-inline>
               </h3>
               <hr style="background-color: white;">

               <div><label id="ErrUname" style="color: red;"></label></div>

               <div class="form-group form-inline row">
                <label class="col-2">
                    NIC Number 
                </label>
                <input class="form-control col-10" type="text" name="uname" placeholder="Enter NIC"></div>

                <div class="form-group form-inline row">
                    <label class="col-2">
                        Name 
                    </label>
                    <input class="form-control col-10" type="text" name="uname" placeholder="Enter Name"></div>

                    <div class="form-group form-inline row">
                        <label class="col-2">
                            Tel Number 
                        </label>
                        <input class="form-control col-10" type="text" name="uname" placeholder="Enter Tel"></div>

                        <div class="form-group form-inline row">
                            <label class="col-2">
                                Address 
                            </label>
                            <input class="form-control col-10" type="text" name="uname" placeholder="Enter Address"></div>

                            <div class="form-group form-inline row">
                                <label class="col-2">
                                    Username 
                                </label>
                                <input class="form-control col-10" type="text" name="uname" placeholder="Enter Username"></div>

                                <div class="form-group form-inline row">
                                    <label class="col-2">
                                        Password 
                                    </label><input class="form-control col-8" type="password" id="txtpassword" name="txtpassword" placeholder="Enter Password">
                                    <div class="form col-2" ><input type="checkbox" value="show password" onclick="showPasswordFun()"> &nbsp; Show Password</div>
                                </div>                            

                                <div class="form-group form-inline row">
                                    <label class="col-2">
                                        Re-type Password 
                                        
                                    </label><input class="form-control col-10" type="password" name="password" placeholder="Re-Enter Password"></div>


                                    <div ><label id="ErrMsg" style="color: red;" hidden></label></div>

                                    <div class="form-group">
                                        <button class="btn btn-primary btn-block col-md-4" name="btnLog" type="submit">Create Account</button>
                                        <br>
                                        Already registered? <a href="Customerlogin.php">Login</a>
                                    </div>
                                </form>

                            </div>
                            <script src="../assets/js/jquery.min.js"></script>
                            <script src="../assets/bootstrap/js/bootstrap.min.js"></script>

                            <script>
                                function showPasswordFun() 
                                {
                                    var x = document.getElementById("txtpassword");
                                    if (x.type === "password") {
                                        x.type = "text";
                                    }
                                    else {
                                        x.type = "password";
                                    }
                                }
                            </script>

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
                document.getElementById('ErrMsg').innerHTML = "Enter Username Again Enter Password.";
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
            header("location: home.php");
        }
    } 
    else{
    }
    ?>
    
</div>