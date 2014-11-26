<?php $this->title = "SyGRRiF Database users"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="bootstrap/datepicker/css/bootstrap-datetimepicker.min.css"
	rel="stylesheet">
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


<?php include "Modules/core/View/Users/usersnavbar.php"; ?>

<br>
<div class="contatiner">

	<div class="col-md-10 col-md-offset-1">

		<div class="page-header">
			<h1>
				Users<br> <small></small>
			</h1>
		</div>
	
		<table id="dataTable" class="table table-striped">
			<thead>
				<tr>
					<td>Id</td>
					<td>Name</td>
					<td>Firstname</td>
					<td>Login</td>
					<td>Email</td>
					<td>Phone</td>
					<td>Unit</td>
					<td>Team</td>
					<td>Responsible</td>
					<td>Status</td>
					<td>User from</td>
					<td>Last connection</td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $usersArray as $user ) : ?> 
				<tr>
					<?php $userId = $this->clean ( $user ['id'] ); ?>
					<td><?= $userId ?></td>
				    <td><?= $this->clean ( $user ['name'] ); ?></td>
				    <td><?= $this->clean ( $user ['firstname'] ); ?></td>
				    <td><?= $this->clean ( $user ['login'] ); ?></td>
				    <td><?= $this->clean ( $user ['email'] ); ?></td>
				    <td><?= $this->clean ( $user ['tel'] ); ?></td>
				    <td><?= $this->clean ( $user ['id_unit'] ); ?></td>
				    <td><?= $this->clean ( $user ['id_team'] ); ?></td>
				    <td><?= $this->clean ( $user ['id_responsible'] ); ?></td>
				    <td><?= $this->clean ( $user ['id_status'] ); ?></td>
				    <td><?= $this->clean ( $user ['date_created'] ); ?></td>
				    <td><?= $this->clean ( $user ['date_last_login'] ); ?></td>
				    <td><button onclick="location.href='users/edit/<?= $userId ?>'" class="btn btn-xs btn-primary" id="navlink">Edit</button></td>  
	    		</tr>
	    		<?php endforeach; ?>
				
			</tbody>
		</table>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
