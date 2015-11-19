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

		<table id="dataTable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th><a href="isotypes/index/id">Id</a></th>
					<th><a href="isotypes/index/nom">Name</a></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $isotypes as $isotype ) : ?> 
				<tr>
					<?php $isotypeId = $this->clean ( $isotype ['id'] ); ?>
					<td><?php echo  $isotypeId ?></td>
				    <td><?php echo  $this->clean ( $isotype ['nom'] ); ?></td>
				    <td class="text-center">
				      <button type='button' onclick="location.href='isotypes/edit/<?php echo  $isotypeId ?>'" class="btn btn-xs btn-primary" id="navlink">Edit</button>
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
