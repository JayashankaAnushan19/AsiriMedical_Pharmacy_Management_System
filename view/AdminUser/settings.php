<?php 
include('../../control/AdminUser/HeadAndFooter/header.php'); 
include('../../model/db_connection.php'); 
?>


<div class="container-fluid">
	<div class="card shadow"> 
		<div class="card-header">
			<div class="row">
				<div class="col">
					<h1><u><i>Backup and Restore Database</i></u></h1><br>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<form action="../../control/AdminUser/dbBackup.php" method="post">
						Backup Database : 
						<input type="submit" class="btn btn-primary btn-sm" value="Backup Database" name="DoBackup" id="DoBackup" />
					</form>
				</div>
				<div class="col">
					<form action="../../control/AdminUser/dbBackup.php" method="post">
						Restore Database : 
						<input type="submit" class="btn btn-primary btn-sm" value="Restore Database" name="" id="" />
					</form>
				</div>
			</div>
		</div>
		<div class="card-body shadow">
			Need to add Settings things
		</div>
	</div>

</div>

<!-- Footer part Start from here -->
<?php include('../../control/AdminUser/HeadAndFooter/footer.php');?>