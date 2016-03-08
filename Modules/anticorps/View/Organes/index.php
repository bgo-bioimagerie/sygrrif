<?php $this->title = "Anticorps: organes"?>

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
				organes<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th><a href="organes/index/id">Id</a></th>
					<th><a href="organes/index/nom">Name</a></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $organes as $organe ) : ?> 
				<tr>
					<?php $organeId = $this->clean ( $organe ['id'] ); ?>
					<td><?php echo  $organeId ?></td>
				    <td><?php echo  $this->clean ( $organe ['nom'] ); ?></td>
				    <td class="text-center">
				      <button type='button' onclick="location.href='organes/edit/<?php echo  $organeId ?>'" class="btn btn-xs btn-primary">Edit</button>
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
