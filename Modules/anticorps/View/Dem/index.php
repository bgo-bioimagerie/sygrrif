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
				Dém<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th><a href="dem/index/id">Id</a></th>
					<th><a href="dem/index/nom">Nom</a></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $dems as $dem ) : ?> 
				<tr>
					<?php $demId = $this->clean ( $dem ['id'] ); ?>
					<td><?php echo  $demId ?></td>
				    <td><?php echo  $this->clean ( $dem ['nom'] ); ?></td>
				    <td>
				      <button type='button' onclick="location.href='dem/edit/<?php echo  $demId ?>'" class="btn btn-xs btn-primary">Edit</button>
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
