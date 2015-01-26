<?php $this->title = "SyGRRiF Add Area"?>

<?php echo $navBar?>

<head>
</head>


<?php include "Modules/supplies/View/navbar.php"; ?>



<br>
<div class="contatiner">

	<div class="col-md-10 col-md-offset-1">

		<div class="page-header">
			<h1>
				Supplies Users<br> <small></small>
			</h1>
		</div>
		
		<table id="dataTable" class="table table-striped">
			<thead>
				<tr>
					<td><a href="comsomusers/index/id">Id</a></td>
					<td><a href="comsomusers/index/name">Name</a></td>
					<td><a href="comsomusers/index/firstname">Firstname</a></td>
					<td><a href="comsomusers/index/email">Email</a></td>
					<td><a href="comsomusers/index/tel">Phone</a></td>
					<td><a href="comsomusers/index/id_unit">Unit</a></td>
					<td><a href="comsomusers/index/id_responsible">Responsible</a></td>
					<td><a href="comsomusers/index/id">Is responsible</a></td>
					<td><a href="comsomusers/index/date_created">User from</a></td>
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
				    <td><?= $this->clean ( $user ['email'] ); ?></td>
				    <td><?= $this->clean ( $user ['tel'] ); ?></td>
				    <td><?= $this->clean ( $user ['unit'] ); ?></td>
				    <td><?= $this->clean ( $user ['fullname'] ); ?></td>
				    <td><?php if($this->clean ( $user ['is_responsible'] )){echo "true";}else{echo "false";} ?></td>
				    <td><?= $this->clean ( $user ['date_created'] ); ?></td>
				    <td><button onclick="location.href='suppliesusers/edit/<?= $userId ?>'" class="btn btn-xs btn-primary" id="navlink">Edit</button></td>  
	    		</tr>
	    		<?php }endforeach; ?>
				
			</tbody>
		</table>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>

