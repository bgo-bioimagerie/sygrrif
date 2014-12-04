<?php $this->title = "SyGRRiF Ressources"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1>
				Ressources<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped">
			<thead>
				<tr>
					<td><a href="sygrrif/resources/id">ID</a></td>
					<td><a href="sygrrif/resources/room_name">Nom</a></td>
					<td><a href="sygrrif/resources/area_id">Domaine</a></td>
					<td>Type</td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $resourcesArray as $resource ) : ?> 
				<tr>
					<?php $resourceId = $this->clean ( $resource ['id'] ); ?>
					<td><?= $resourceId ?></td>
				    <td><?= $this->clean ( $resource ['room_name'] ); ?></td>
				    <td><?= $this->clean ( $resource ['area'] ); ?></td>
				    <td><?= $this->clean ( $resource ['type_name'] ); ?></td>
				    <td>
				      <button type='button' onclick="location.href='sygrrif/editresource/<?= $resourceId ?>'" class="btn btn-xs btn-primary" id="navlink">Edit</button>
				    </td>  
	    		</tr>
	    		<?php endforeach; ?>
				
			</tbody>
		</table>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
