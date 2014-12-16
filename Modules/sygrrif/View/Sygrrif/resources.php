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
					<td><a href="sygrrif/resources/name">Name</a></td>
					<td><a href="sygrrif/resources/description">description</a></td>
					<td><a href="sygrrif/resources/area_name">Area</a></td>
					<td><a href="sygrrif/resources/type_name">Type</a></td>
					<td><a href="sygrrif/resources/category_name">Category</a></td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $resourcesArray as $resource ) : ?> 
				<tr>
					<?php $resourceId = $this->clean ( $resource ['id'] ); ?>
					<td><?= $resourceId ?></td>
				    <td><?= $this->clean ( $resource ['name'] ); ?></td>
				    <td><?= $this->clean ( $resource ['description'] ); ?></td>
				    <td><?= $this->clean ( $resource ['area_name'] ); ?></td>
				    <td><?= $this->clean ( $resource ['type_name'] ); ?></td>
				    <td><?= $this->clean ( $resource ['category_name'] ); ?></td>
				    <td>	
				      <button type='button' onclick="location.href='<?= $resource ["controller"]."/".$resource ["edit_action"]."/".$resourceId ?>'" class="btn btn-xs btn-primary" id="navlink">Edit</button>
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
