<?php $this->title = "SyGRRiF pricing"?>

<?php echo $navBar?>
<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1>
			    <?php echo  SyTranslator::Pricing($lang) ?>   
				<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped text-center table-bordered">
			<thead>
				<tr>
				    <th><a href="sygrrif/pricing/id">ID</a></td>
					<th><a href="sygrrif/pricing/tarif_name"><?php echo  SyTranslator::Name($lang) ?></a></th>
					<th><a href="sygrrif/pricing/tarif_unique"><?php echo  SyTranslator::Unique_price($lang) ?></a></th>
					<th><a href="sygrrif/pricing/tarif_night"><?php echo  SyTranslator::Price_night($lang) ?></a></th>
					<th><a href="sygrrif/pricing/tarif_we"><?php echo  SyTranslator::Price_weekend($lang) ?></a></th>
					<th></th>
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
				    <!--  unique -->
				    <td>
				    <?php 
				    	$unique = $this->clean ( $price ['tarif_unique'] );
						if ($unique == 1){
							echo SyTranslator::Yes($lang);
						}			  
						else{
							echo SyTranslator::No($lang);
						}  
				    ?>
				    </td>
				    <!--  night -->
				    <td>
				    <?php 
				    	$night = $this->clean ( $price ['tarif_night'] );
						if ($night == 1){
							?>
							<p> <?php echo  SyTranslator::Yes($lang) ?> </p>
							<p> <?php echo  $this->clean ( $price ['night_start']) ?>h - <?php echo  $this->clean ( $price ['night_end']) ?>h </p>
					 <?php 	
						}			  
						else{
							echo SyTranslator::No($lang);
						}  
				    ?>
				    </td>
				    <!--  weekend -->
				    <td>
				    <?php 
				    	$we = $this->clean ( $price ['tarif_we'] );
						if ($we == 1){
						  ?>
						  <p> <?php echo  SyTranslator::Yes($lang) ?> </p>
						  <p>
						  <?php 	
						 	$jours = $this->clean ( $price ['choice_we'] );
						 	$list = explode(",", $jours);
						 	$isFirst = true;
						 	if ($list[0]==1){ echo SyTranslator::Monday($lang); $isFirst = false;}
						 	if ($list[1]==1){if (!$isFirst){echo ", "; }echo SyTranslator::Tuesday($lang); $isFirst = false;}
						 	if ($list[2]==1){if (!$isFirst){echo ", "; }echo SyTranslator::Wednesday($lang); $isFirst = false;}
						 	if ($list[3]==1){if (!$isFirst){echo ", "; }echo SyTranslator::Thursday($lang); $isFirst = false;}
						 	if ($list[4]==1){if (!$isFirst){echo ", "; }echo SyTranslator::Friday($lang); $isFirst = false;}
						 	if ($list[5]==1){if (!$isFirst){echo ", "; }echo SyTranslator::Saturday($lang); $isFirst = false;}
						 	if ($list[6]==1){if (!$isFirst){echo ", "; }echo SyTranslator::Sunday($lang);}
						   ?>
						   </p>
					<?php
						}			  
						else{
							echo SyTranslator::No($lang);
						}  
				    ?>
				    </td>
				    <td>
				      <button type='button' onclick="location.href='sygrrif/editpricing/<?php echo  $pricingId ?>'" class="btn btn-xs btn-primary" id="navlink"><?php echo  SyTranslator::Edit($lang) ?></button>
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
