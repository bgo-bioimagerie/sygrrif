<?php $this->title = "SyGRRiF pricing"?>

<?php echo $navBar?>
<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1>
				Pricing<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped text-center">
			<thead>
				<tr>
				    <td><a href="sygrrif/pricing/id">ID</a></td>
					<td><a href="sygrrif/pricing/tarif_name">Name</a></td>
					<td><a href="sygrrif/pricing/tarif_unique">Unique price</a></td>
					<td><a href="sygrrif/pricing/tarif_night">Price night</a></td>
					<td><a href="sygrrif/pricing/tarif_we">Price weekend</a></td>
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
				    <!--  unique -->
				    <td>
				    <?php 
				    	$unique = $this->clean ( $price ['tarif_unique'] );
						if ($unique == 1){
							echo "yes";
						}			  
						else{
							echo "no";
						}  
				    ?>
				    </td>
				    <!--  night -->
				    <td>
				    <?php 
				    	$night = $this->clean ( $price ['tarif_night'] );
						if ($night == 1){
							?>
							<p> yes </p>
							<p> <?= $this->clean ( $price ['night_start']) ?>h - <?= $this->clean ( $price ['night_end']) ?>h </p>
					 <?php 	
						}			  
						else{
							echo "no";
						}  
				    ?>
				    </td>
				    <!--  weekend -->
				    <td>
				    <?php 
				    	$we = $this->clean ( $price ['tarif_we'] );
						if ($we == 1){
						  ?>
						  <p> yes </p>
						  <p>
						  <?php 	
						 	$jours = $this->clean ( $price ['choice_we'] );
						 	$list = explode(",", $jours);
						 	$isFirst = true;
						 	if ($list[0]==1){ "lundi"; $isFirst = false;}
						 	if ($list[1]==1){if (!$isFirst){echo ", "; }echo "mardi"; $isFirst = false;}
						 	if ($list[2]==1){if (!$isFirst){echo ", "; }echo "mercredi"; $isFirst = false;}
						 	if ($list[3]==1){if (!$isFirst){echo ", "; }echo "jeudi"; $isFirst = false;}
						 	if ($list[4]==1){if (!$isFirst){echo ", "; }echo "vendredi"; $isFirst = false;}
						 	if ($list[5]==1){if (!$isFirst){echo ", "; }echo "samedi"; $isFirst = false;}
						 	if ($list[6]==1){if (!$isFirst){echo ", "; }echo "dimanche";}
						   ?>
						   </p>
					<?php
						}			  
						else{
							echo "no";
						}  
				    ?>
				    </td>
				    <td>
				      <button type='button' onclick="location.href='sygrrif/editpricing/<?= $pricingId ?>'" class="btn btn-xs btn-primary" id="navlink">Edit</button>
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
