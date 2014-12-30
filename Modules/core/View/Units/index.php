<?php $this->title = "SyGRRiF Database units"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="externals/datepicker/css/bootstrap-datetimepicker.min.css"
	rel="stylesheet">
</head>

<?php include "Modules/core/View/Users/usersnavbar.php"; ?>

<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1>
				Units<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped">
			<thead>
				<tr>
					<td><a href="units/index/id">Id</a></td>
					<td><a href="units/index/name">Name</a></td>
					<td><a href="units/index/address">Address</a></td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $unitsArray as $unit ) : 
				if ($unit ['id'] > 1){
				?> 
				<tr>
					<?php $unitId = $this->clean ( $unit ['id'] ); ?>
					<td><?= $unitId ?></td>
				    <td><?= $this->clean ( $unit ['name'] ); ?></td>
				    <td><?= $this->clean ( $unit ['address'] ); ?></td>
				    <td>
				      <button type='button' onclick="location.href='units/edit/<?= $unitId ?>'" class="btn btn-xs btn-primary" id="navlink">Edit</button>
				    </td>  
	    		</tr>
	    		<?php }endforeach; ?>
				
			</tbody>
		</table>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
