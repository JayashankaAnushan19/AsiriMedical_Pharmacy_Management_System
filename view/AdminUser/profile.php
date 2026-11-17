<?php 
include('../../control/AdminUser/HeadAndFooter/header.php'); 
include('../../model/db_connection.php'); 
?>


<?php 

$UID = (int) $_SESSION["UserId"];

if (isset($_POST["btnChangeBasicInfo"])) {
    if (!csrf_valid()) {
        echo "<script>alert('Your session expired. Please try again.')</script>";
    } elseif (db_exec(
        "UPDATE `tb_adminuser` SET `user_Name` = ?, `user_Tel` = ?, `user_Address` = ? WHERE `user_ID` = ?",
        [trim((string) $_POST['txtName']), trim((string) $_POST['txtTel']), trim((string) $_POST['txtAddress']), $UID],
        'Profile Updated Successfully !!!'
    )) {
        $_SESSION['UserName'] = trim((string) $_POST['txtName']);
    }
}

if (isset($_POST["btnChangePass"])) {
    $current = (string) ($_POST["txtCurrentPass"] ?? '');
    $new     = (string) ($_POST["txtNewPass"] ?? '');
    $retype  = (string) ($_POST["txtReTypePass"] ?? '');
    $row     = db_row("SELECT `user_Password` FROM `tb_adminuser` WHERE `user_ID` = ?", [$UID]);

    if (!csrf_valid()) {
        echo "<script>alert('Your session expired. Please try again.')</script>";
    } elseif (!$row || !check_password($current, $row['user_Password'])) {
        echo "<script>alert('Current password is incorrect.')</script>";
    } elseif ($new !== $retype) {
        echo "<script>alert('New passwords do not match.')</script>";
    } elseif (strlen($new) < 6) {
        echo "<script>alert('New password must be at least 6 characters.')</script>";
    } else {
        db_exec("UPDATE `tb_adminuser` SET `user_Password` = ? WHERE `user_ID` = ?", [hash_password($new), $UID],
            'Password Updated Successfully !!!');
    }
}

$record = db_row("SELECT * FROM `tb_adminuser` WHERE `user_ID` = ?", [$UID]);

if ($record)
{

    $UserID = $record['user_ID'];
    $NIC = $record['user_NIC'];
    $Name = $record['user_Name'];
    $Tel = $record['user_Tel'];
    $Address = $record['user_Address'];
    $URoll = $record['user_Role'];
    $UName = $record['user_Uname'];

    if ($URoll == 0) {
        $URollName = "Super Admin";
    }
    elseif ($URoll == 1) {
        $URollName = "Admin";
    }
    elseif ($URoll == 2) {
        $URollName = "Store Keeper";
    }
    elseif ($URoll == 3) {
        $URollName = "Cashier";
    }
    else{
        $URollName = "No Authorization";
    }
}


?>

<div class="container-fluid">

    <div class="card shadow mb-2">
        <h3 class="text-dark mt-2 mb-2 ml-3">Profile Manage</h3>
    </div>

    <div class="card shadow mb-2">
        <div class="card-header py-3">
            <p class="text-primary m-0 font-weight-bold">Basic Settings</p>
        </div>
        <div class="card-body py">
            <form action="profile.php" method="POST">
                <?= csrf_field() ?>
                <div class="form-row">
                    <div class="col">
                        <div class="form-group">
                            <label for="txtUserID"><strong>User ID</strong></label>
                            <input class="form-control form-control-sm" type="text" placeholder="User ID" value="<?php echo e($UserID ?? ''); ?>" name="txtUserID" disabled>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="txtUserNIC"><strong>NIC</strong></label>
                            <input class="form-control form-control-sm" type="text" placeholder="NIC" value="<?php echo e($NIC ?? ''); ?>" name="txtUserNIC" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <div class="form-group">
                            <label for="txtName"><strong>Name</strong></label>
                            <input class="form-control form-control-sm" type="text" placeholder="Name" value="<?php echo e($Name ?? ''); ?>" name="txtName">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="txtTel"><strong>Telephone</strong></label>
                            <input class="form-control form-control-sm" type="tel" pattern="[0-9]{10}" title="Ex: 0712345678" placeholder="Telephone" value="<?php echo e($Tel ?? ''); ?>" name="txtTel">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="txtAddress"><strong>Address</strong></label>
                    <input class="form-control form-control-sm" type="text" placeholder="Sunset Blvd, 38" value="<?php echo e($Address ?? ''); ?>" name="txtAddress">
                </div>
                <div class="form-group">
                    <button class="btn btn-warning btn-sm" type="submit" id="btnChangeBasicInfo" name="btnChangeBasicInfo">Update&nbsp;Settings</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-2">
        <div class="card-header py-3">
            <p class="text-primary m-0 font-weight-bold">Authorization Settings</p>
        </div>
        <div class="card-body py"> 
            <div class="form-row">
                <div class="col">
                    <div class="form-group">
                        <label for="txtUserRoll"><strong>User Roll</strong></label>
                        <input class="form-control form-control-sm" type="text" placeholder="Los Angeles" value="<?php echo e($URollName ?? ''); ?>" name="txtUserRoll" disabled>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="txtUserName"><strong>User Name</strong></label>
                        <input class="form-control form-control-sm" type="text" placeholder="USA" value="<?php echo e($UName ?? ''); ?>" name="txtUserName" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card shadow">
        <div class="card-header py-3 form-inline">
            <p class="text-primary m-0 font-weight-bold">Password Settings</p>
            &nbsp;&nbsp;&nbsp;
            <button class="btn btn-info btn-sm" id="btnChangePassShow" onclick="changePassNow()">Change&nbsp;Password</button> 
            
        </div>
        <div class="card-body">
            <form action="profile.php" method="POST">
                <?= csrf_field() ?>
                <div class="form-row">
                    <div class="col">
                        <div class="form-group">
                            <label for="txtCurrentPass"><strong>Current Password</strong></label>
                            <input class="form-control form-control-sm" type="Password" placeholder="Current Password" value="" autocomplete="current-password" id="txtCurrentPass" name="txtCurrentPass">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="country"><strong>&nbsp;</strong></label><br>
                            <div class="form-control form-control-sm" >
                                <input type="checkbox" value="show password" onclick="showPasswordFun()"> &nbsp; Show Password
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row" id="newPassDiv">
                    <div class="col">
                        <div class="form-group">
                            <label for="txtNewPass"><strong>New Password</strong></label>
                            <input class="form-control form-control-sm" type="Password" placeholder="New Password" id="txtNewPass" name="txtNewPass">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="txtReTypePass"><strong>Re-Type Password</strong></label>
                            <input class="form-control form-control-sm" type="Password" placeholder="Re-Type Password" id="txtReTypePass" name="txtReTypePass">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-warning btn-sm" id="btnChangePassCancel" onclick="changePassCancel()">Cancel</button> 
                    <button class="btn btn-primary btn-sm" id="btnChangePass" type="submit" name="btnChangePass">Change&nbsp;Password</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
    <script>
        function showPasswordFun() 
        {
            var x = document.getElementById("txtCurrentPass");
            var y = document.getElementById("txtNewPass");
            var z = document.getElementById("txtReTypePass");

            if (x.type === "password" || y.type === "password" || z.type === "password") 
            {
                x.type = "text";
                y.type = "text";
                z.type = "text";
            }
            else {
                x.type = "password";
                y.type = "password";
                z.type = "password";
            }
        }

        document.getElementById("txtCurrentPass").disabled = true;
        document.getElementById("txtNewPass").disabled = true;
        document.getElementById("txtReTypePass").disabled = true;
        document.getElementById("btnChangePassShow").hidden = false;
        document.getElementById("btnChangePassCancel").hidden = true;
        document.getElementById("btnChangePass").hidden = true;
        document.getElementById("newPassDiv").hidden = true;

        function changePassNow(){
            document.getElementById("txtCurrentPass").disabled = false;
            document.getElementById("txtNewPass").disabled = false;
            document.getElementById("txtReTypePass").disabled = false;
            document.getElementById("btnChangePassShow").hidden = true;
            document.getElementById("btnChangePassCancel").hidden = false;
            document.getElementById("btnChangePass").hidden = false;
            document.getElementById("newPassDiv").hidden = false;
        }
        function changePassCancel(){
            document.getElementById("txtCurrentPass").disabled = true;
            document.getElementById("txtNewPass").disabled = true;
            document.getElementById("txtReTypePass").disabled = true;
            document.getElementById("btnChangePassShow").hidden = false;
            document.getElementById("btnChangePassCancel").hidden = true;
            document.getElementById("btnChangePass").hidden = true;
            document.getElementById("newPassDiv").hidden = true;
        }

    </script>
</div>

<!-- Footer part Start from here -->
<?php include('../../control/AdminUser/HeadAndFooter/footer.php');?>

<script src="../../assets/js/jquery.min.js"></script>
<script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
<script src="../../assets/js/chart.min.js"></script>
<script src="../../assets/js/bs-init.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
<script src="../../assets/js/theme.js"></script>