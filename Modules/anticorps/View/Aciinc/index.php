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
				AcI-Inc<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th><a href="aciinc/index/id">Id</a></th>
					<th><a href="aciinc/index/nom">Nom</a></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $aciincs as $aciinc ) : ?> 
				<tr>
					<?php $aciincId = $this->clean ( $aciinc ['id'] ); ?>
					<td><?php echo  $aciincId ?></td>
				    <td><?php echo  $this->clean ( $aciinc ['nom'] ); ?></td>
				    <td>
				      <button type='button' onclick="location.href='aciinc/edit/<?php echo  $aciincId ?>'" class="btn btn-xs btn-primary">Edit</button>
				    </td>  
	    		</tr>
	    		<?php endforeach; ?>
				
			</tbody>
		</table>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
