<?php $this->title = "Anticorps: especes"?>

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
				Enzymes<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th><a href="enzymes/index/id">Id</a></th>
					<th><a href="enzymes/index/nom">Nom</a></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $enzymes as $enzyme ) : ?> 
				<tr>
					<?php $enzymeId = $this->clean ( $enzyme ['id'] ); ?>
					<td><?= $enzymeId ?></td>
				    <td><?= $this->clean ( $enzyme ['nom'] ); ?></td>
				    <td>
				      <button type='button' onclick="location.href='enzymes/edit/<?= $enzymeId ?>'" class="btn btn-xs btn-primary" id="navlink">Edit</button>
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
