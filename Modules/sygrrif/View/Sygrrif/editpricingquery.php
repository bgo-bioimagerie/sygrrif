<?php $this->title = "SyGRRiF edit a pricing"?>

<?php echo $navBar?>

<?php include "Modules/sygrrif/View/navbar.php"; ?>

<div class="container">
	<div class="col-md-6 col-md-offset-3">
		
		<div class="page-header">
			<h1>
				<?php echo  SyTranslator::Edit_pricing($lang) ?>
				<br> <small></small>
			</h1>
		</div>
		
		<div>
		<?php if (isset($msgError)){ ?>
			<p> Unable to modify the pricing</p>
			<p> <?php echo  $msgError ?></p>
		<?php }else{?>
			<p> The pricing has been successfully modified !</p>
		<?php } ?>
		</div>
		<div class="col-md-1 col-md-offset-10">
			<button onclick="location.href='sygrrif/pricing'" class="btn btn-success" id="navlink"><?php echo  SyTranslator::Ok($lang) ?></button>
		</div>
		
     </div>
</div>