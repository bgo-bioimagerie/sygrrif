<?php $this->title = "SyGRRiF add pricing"?>

<?php echo $navBar?>

<?php include "Modules/sygrrif/View/navbar.php"; ?>

<div class="container">
	<div class="col-md-6 col-md-offset-3">
		
		<div class="page-header">
			<h1>
				<?php echo  SyTranslator::Associate_a_pricing_to_a_unit($lang) ?> <br> <small></small>
			</h1>
		</div>
		
		<div>
		<?php if (isset($msgError)){ ?>
			<p> <?php echo  SyTranslator::Unable_to_associate_the_pricing_with_the_unit($lang) ?> </p>
			<p> <?php echo  $msgError ?></p>
		<?php }else{?>
			<p> <?php echo  SyTranslator::The_pricing_has_been_successfully_associated_to_the_unit($lang) ?></p>
		<?php } ?>
		</div>
		<div class="col-md-1 col-md-offset-10">
			<button onclick="location.href='sygrrif/unitpricing'" class="btn btn-success" id="navlink"><?php echo  SyTranslator::Ok($lang) ?></button>
		</div>
		
     </div>
</div>