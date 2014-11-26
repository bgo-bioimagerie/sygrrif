<?php $this->title = "SyGRRiF Database teams"?>

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

		<div class="page-header">
			<h1>
				Teams<br> <small></small>
			</h1>
		</div>
	
		<table id="dataTable" class="table table-striped">
			<thead>
				<tr>
					<td><a href="teams/index/id">Id</a></td>
					<td><a href="teams/index/name">Name</a></td>
					<td><a href="teams/index/adress">Address</a></td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $teamsArray as $team ) : ?> 
				<tr>
					<?php $teamId = $this->clean ( $team ['id'] ); ?>
					<td><?= $teamId ?></td>
				    <td><?= $this->clean ( $team ['name'] ); ?></td>
				    <td><?= $this->clean ( $team ['adress'] ); ?></td>
				    <td>
				      <button type='button' onclick="location.href='teams/edit/<?= $teamId ?>'" class="btn btn-xs btn-primary" id="navlink">Edit</button>
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
