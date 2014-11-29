<?php $this->title = "Anticorps: Isotypes"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


<?php include "Modules/anticorps/View/navbar.php"; ?>

<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1>
				Isotypes<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped">
			<thead>
				<tr>
					<td><a href="isotypes/index/id">Id</a></td>
					<td><a href="isotypes/index/nom">Name</a></td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $isotypes as $isotype ) : ?> 
				<tr>
					<?php $isotypeId = $this->clean ( $isotype ['id'] ); ?>
					<td><?= $isotypeId ?></td>
				    <td><?= $this->clean ( $isotype ['nom'] ); ?></td>
				    <td>
				      <button type='button' onclick="location.href='isotypes/edit/<?= $isotypeId ?>'" class="btn btn-xs btn-primary" id="navlink">Edit</button>
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
