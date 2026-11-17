<?php
require_once __DIR__ . '/../../../model/db_connection.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>AMPS</title>

	<link rel = "icon" href ="../../assets/img/pmslogo.png" type = "image/x-icon"> 
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

	<link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
	<link rel="stylesheet" href="../../assets/fonts/fontawesome-all.min.css">
	<link rel="stylesheet" href="../../assets/fonts/ionicons.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

	<style type="text/css">
		body
		{
			background:url(../../assets/img/cusBG.png);
			margin-top: -10px;
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-position: center;
		}
		body nav{
			height: 50px;
			font-size: 15px;
		}
		body nav img{
			height: 30px;
		}
		body nav #navLog{
			
		}
		footer {
			position: fixed;
			padding-top: 10px;
			left: 0;
			bottom: 0;
			width: 100%;
			height: 30px;
			font-size: 12px;
		}
		#headNavBarForm{
			height: 10px;
			margin-top: -20px;
		}
	</style>

</head>
<body>
	<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
		<div class="row">
			<a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0 mx-3" href="../../index.html" id="navLog">
				<div class="sidebar-brand-icon">
					<img src="../../assets/img/pmsLogo.png" height="20px">
				</div>
				<div class="sidebar-brand-text mx-2">
					<span>Asiri Medical</span>
				</div>
			</a>

			<div class="collapse navbar-collapse" id="headNavBar">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="flex-sm-fill text-sm-center nav-link" href="home.php">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<i class="fa fa-home" aria-hidden="true"></i>
							Home
						</a>
					</li>
					<li class="nav-item">
						<a class="flex-sm-fill text-sm-center nav-link" href="CusShowShopCart.php">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<i class="fas fa-shopping-cart"></i>
							Cart
							<span class="badge badge-light">
								<?php echo (isset($_SESSION['CartArr'])) ? count($_SESSION['CartArr']) : '0'; ?>
							</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="flex-sm-fill text-sm-center nav-link" href="CusOrderTrack.php">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<i class="fas fa-dumpster"></i>
							Order track
						</a>
					</li>
					<li class="nav-item">
						<a class="flex-sm-fill text-sm-center nav-link disabled" href="#">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="d-flex justify-content-end my-auto mx-auto">
			<form action="home.php" class="form-inline ml-5" id="headNavBarForm" method="POST">
				<input name="txtSearchPrdtsUser" class="form-control " type="text" placeholder="Search medicine..." aria-label="Search">
				<button name="btnSearchPrdtsUser" class="btn btn-success ml-1" type="submit">Search</button>
			</form>
		</div>
	</nav>

	
