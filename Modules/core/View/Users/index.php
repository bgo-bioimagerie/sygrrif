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
					<td><a href="users/index/id">Id</a></td>
					<td><a href="users/index/name">Name</a></td>
					<td><a href="users/index/firstname">Firstname</a></td>
					<td><a href="users/index/login">Login</a></td>
					<td><a href="users/index/email">Email</a></td>
					<td><a href="users/index/tel">Phone</a></td>
					<td><a href="users/index/id_unit">Unit</a></td>
					<td><a href="users/index/id_team">Team</a></td>
					<td><a href="users/index/id_responsible">Responsible</a></td>
					<td><a href="users/index/id_status">Status</a></td>
					<td><a href="users/index/id">Is responsible</a></td>
					<td><a href="users/index/convention">Convention</a></td>
					<td><a href="users/index/date_created">User from</a></td>
					<td><a href="users/index/date_last_login">Last connection</a></td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $usersArray as $user ) : ?> 
				<?php if ($user ['id'] > 1){ ?>
				<tr>
					<?php $userId = $this->clean ( $user ['id'] ); ?>
					<td><?= $userId ?></td>
				    <td><?= $this->clean ( $user ['name'] ); ?></td>
				    <td><?= $this->clean ( $user ['firstname'] ); ?></td>
				    <td><?= $this->clean ( $user ['login'] ); ?></td>
				    <td><?= $this->clean ( $user ['email'] ); ?></td>
				    <td><?= $this->clean ( $user ['tel'] ); ?></td>
				    <td><?= $this->clean ( $user ['unit'] ); ?></td>
				    <td><?= $this->clean ( $user ['team'] ); ?></td>
				    <td><?= $this->clean ( $user ['fullname'] ); ?></td>
				    <td><?= $this->clean ( $user ['status'] ); ?></td>
				    <td><?php if($this->clean ( $user ['is_responsible'] )){echo "true";}else{echo "false";} ?></td>
				    <td> 
				    	<?php 
				    	$convno = $this->clean ( $user ['convention'] );
				    	if ($convno == 0){
				    		$convTxt = "no convention";	
				    	}
				    	else{
				    		$convTxt = "<p> No:" . $convno . "</p>"
				    				   ."<p>" . $this->clean ( $user ['date_convention'] ) . "</p>";
				    	}
				    	?>
				    
				      <?= $convTxt ?>
				    </td>
				    <td><?= $this->clean ( $user ['date_created'] ); ?></td>
				    <td><?= $this->clean ( $user ['date_last_login'] ); ?></td>
				    <td><button onclick="location.href='users/edit/<?= $userId ?>'" class="btn btn-xs btn-primary" id="navlink">Edit</button></td>  
	    		</tr>
	    		<?php }endforeach; ?>
				
			</tbody>
		</table>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
