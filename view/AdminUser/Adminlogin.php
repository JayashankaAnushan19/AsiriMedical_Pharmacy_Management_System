<?php
require_once __DIR__ . '/../../model/auth.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnLog'])) {
    $unam = trim((string) ($_POST['uname'] ?? ''));
    $pass = (string) ($_POST['password'] ?? '');

    if (!csrf_valid()) {
        $error = 'Your session expired. Please try again.';
    } elseif ($unam === '') {
        $error = 'Enter Username.';
    } elseif ($pass === '') {
        $error = 'Enter Password.';
    } elseif ($user = attempt_staff_login($unam, $pass)) {
        header('Location: ' . home_for_role((int) $user['user_Role']));
        exit;
    } else {
        usleep(random_int(300000, 700000)); // slow down password guessing
        $error = 'Password and Username error !!';
    }
} elseif (is_logged_in()) {
    header('Location: ' . home_for_role(current_role()));
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>PMS-Sotuion</title>
<link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
<link rel="stylesheet" href="../../assets/fonts/fontawesome-all.min.css">
<link rel="stylesheet" href="../../assets/fonts/ionicons.min.css">
<link rel="stylesheet" href="../../assets/css/Login-Form-Dark.css">
</head>
<body>
<div>
    <div class="login-dark">
        <form action="Adminlogin.php" method="post">
            <?= csrf_field() ?>
            <center>
                <a href="../../index.html">
                    <img src="../../assets/img/pmsLogo.png" height="150px" style="margin-top: -20px">
                </a>
            </center>
            <h3><center style="margin-top: 10px">Asiri Medical <br><br> <h6 style="margin-top: -20px"><i>Pharmacy Management System</i></h6></center></h3>
            <hr style="background-color: white;">
            <div><label id="ErrMsg" style="color: red;"><?= e($error) ?></label></div>
            <div class="form-group"><input class="form-control" type="text" name="uname" placeholder="Username" value="<?= e($_POST['uname'] ?? '') ?>" autocomplete="username" autofocus></div>
            <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password" autocomplete="current-password"></div>
            <div class="form-group">
                <button class="btn btn-primary btn-block" name="btnLog" type="submit">Log In</button>
            </div>
        </form>
    </div>
    <script src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
</div>
</body>
</html>
