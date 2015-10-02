<?php $this->title = "Anticorps: Statut"?>

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
				Statut Tissus<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th><a href="status/index/id">Id</a></th>
					<th><a href="status/index/nom">Nom</a></th>
					<th><a href="status/index/color">Couleur</a></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $status as $statu ) : ?> 
				<tr>
					<?php $statuId = $this->clean ( $statu ['id'] ); ?>
					<td><?php echo  $statuId ?></td>
				    <td><?php echo  $this->clean ( $statu ['nom'] ); ?></td>
				    <td>#<?php echo  $this->clean ( $statu ['color'] ); ?></td>
				    <td>
				      <button type='button' onclick="location.href='status/edit/<?php echo  $statuId ?>'" class="btn btn-xs btn-primary" id="navlink">Edit</button>
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
