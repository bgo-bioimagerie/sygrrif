<?php $this->title = "Supplies pricing"?>

<?php echo $navBar?>
<?php include "Modules/supplies/View/navbar.php"; ?>

<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1>
			<?= SuTranslator::Pricing($lang) ?>
				<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped text-center">
			<thead>
				<tr>
				    <td><a href="suppliespricing/index/id">ID</a></td>
					<td><a href="suppliespricing/index/tarif_name"><?= CoreTranslator::Name($lang) ?></a></td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $pricingArray as $price ) : ?> 
				<tr>
					<!--  Id -->
					<?php $pricingId = $this->clean ( $price ['id'] ); ?>
					<td><?= $pricingId ?></td>
				    <!--  name -->
				    <td><?= $this->clean ( $price ['tarif_name'] ); ?></td>
				    
				    <td>
				      <button type='button' onclick="location.href='suppliespricing/editpricing/<?= $pricingId ?>'" class="btn btn-xs btn-primary" id="navlink"><?= CoreTranslator::Edit($lang) ?></button>
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
