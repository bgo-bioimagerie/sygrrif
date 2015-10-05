<?php $this->title = "sprojects pricing"?>

<?php echo $navBar?>
<?php include "Modules/sprojects/View/navbar.php"; ?>

<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1>
			<?php echo  SpTranslator::Pricing($lang) ?>
				<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped text-center">
			<thead>
				<tr>
				    <td><a href="sprojectspricing/index/id">ID</a></td>
					<td><a href="sprojectspricing/index/tarif_name"><?php echo  CoreTranslator::Name($lang) ?></a></td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $pricingArray as $price ) : ?> 
				<tr>
					<!--  Id -->
					<?php $pricingId = $this->clean ( $price ['id'] ); ?>
					<td><?php echo  $pricingId ?></td>
				    <!--  name -->
				    <td><?php echo  $this->clean ( $price ['tarif_name'] ); ?></td>
				    
				    <td>
				      <button type='button' onclick="location.href='sprojectspricing/editpricing/<?php echo  $pricingId ?>'" class="btn btn-xs btn-primary"><?php echo  CoreTranslator::Edit($lang) ?></button>
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
