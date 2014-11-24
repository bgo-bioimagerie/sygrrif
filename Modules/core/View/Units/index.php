<?php $this->title = "SyGRRiF Database units"?>

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
	<div class="col-md-6 col-md-offset-3">

		<table id="dataTable" class="table table-striped">
			<thead>
				<tr>
					<td>Id</td>
					<td>Name</td>
					<td>Address</td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $unitsArray as $unit ) : ?> 
				<tr>
					<?php $unitId = $this->clean ( $unit ['id'] ); ?>
					<td><?= $unitId ?></td>
				    <td><?= $this->clean ( $unit ['name'] ); ?></td>
				    <td><?= $this->clean ( $unit ['adress'] ); ?></td>
				    <td><button onclick="location.href='units/edit/<?= $unitId ?>'" class="btn btn-xs btn-primary" id="navlink">Edit</button></td>  
	    		</tr>
	    		<?php endforeach; ?>
				
			</tbody>
		</table>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
