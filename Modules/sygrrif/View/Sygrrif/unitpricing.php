<?php $this->title = "SyGRRiF pricing per unit"?>

<?php echo $navBar?>
<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1>
			<?= SyTranslator::Pricing_Unit($lang) ?>
				<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped text-center table-bordered">
			<thead>
				<tr>
				    <th>ID</th>
					<th class="text-center"><?= SyTranslator::Name($lang) ?></th>
					<th class="text-center"><?= SyTranslator::Pricing($lang) ?></th>
					<th></th>
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
				      <button type='button' onclick="location.href='sygrrif/editunitpricing/<?= $unitId ?>'" class="btn btn-xs btn-primary" id="navlink"><?= SyTranslator::Edit($lang) ?></button>
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
