<?php $this->title = "SyGRRiF Visa"?>

<?php echo $navBar?>
<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1>
				VISA<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped">
			<thead>
				<tr>
					<td><a href="sygrrif/visa/id">Id</a></td>
					<td><a href="sygrrif/visa/name">Name</a></td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $visaTable as $visa ) : ?>
				<?php $visaId = $this->clean ( $visa ['id'] ); 
					if ($visaId > 1){
				?> 
				<tr>
					<td><?= $visaId ?></td>
				    <td><?= $this->clean ( $visa ['name'] ); ?></td>
				    <td>
				      <button type='button' onclick="location.href='sygrrif/editvisa/<?= $visaId ?>'" class="btn btn-xs btn-primary" id="navlink">Edit</button>
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
