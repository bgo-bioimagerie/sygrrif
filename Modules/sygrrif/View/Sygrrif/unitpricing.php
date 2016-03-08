<?php $this->title = "SyGRRiF pricing per unit"?>

<?php echo $navBar?>
<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1>
			<?php echo  SyTranslator::Pricing_Unit($lang) ?>
				<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped text-center table-bordered">
			<thead>
				<tr>
				    <th>ID</th>
					<th class="text-center"><?php echo  SyTranslator::Name($lang) ?></th>
					<th class="text-center"><?php echo  SyTranslator::Pricing($lang) ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $pricingArray as $price ) : ?> 
				<tr>
					<!--  Id -->
					<?php $unitId = $this->clean ( $price ['unit_id'] ); ?>
					<td><?php echo  $unitId ?></td>
				    <!--  name -->
				    <td><?php echo  $this->clean ( $price ['unit_name'] ); ?></td>
				    <!--  tarif -->
					<td><?php echo  $this->clean ( $price ['pricing_name'] ); ?></td>
				    <td>
				      <button type='button' onclick="location.href='sygrrif/editunitpricing/<?php echo  $unitId ?>'" class="btn btn-xs btn-primary" id="navlink"><?php echo  SyTranslator::Edit($lang) ?></button>
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
