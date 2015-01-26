<?php $this->title = "Supplies pricing per unit"?>

<?php echo $navBar?>
<?php include "Modules/supplies/View/navbar.php"; ?>

<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1>
				Pricing per unit<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped text-center">
			<thead>
				<tr>
				    <td>ID</td>
					<td>Name</td>
					<td>Pricing</td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $pricingArray as $price ) : ?> 
				<tr>
					<!--  Id -->
					<?php $unitId = $this->clean ( $price ['unit_id'] ); ?>
					<td><?= $unitId ?></td>
				    <!--  name -->
				    <td><?= $this->clean ( $price ['unit_name'] ); ?></td>
				    <!--  tarif -->
					<td><?= $this->clean ( $price ['pricing_name'] ); ?></td>
				    <td>
				      <button type='button' onclick="location.href='suppliespricing/editunitpricing/<?= $unitId ?>'" class="btn btn-xs btn-primary" id="navlink">Edit</button>
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
