<?php $this->title = "SyGRRiF add pricing"?>

<?php echo $navBar?>


<head>
</head>
<?php include "Modules/sygrrif/View/navbar.php"; ?>

<div class="container">
	<div class="col-md-6 col-md-offset-3">
		
		<div class="page-header">
			<h1>
			<?php echo  SyTranslator::Add_pricing($lang) ?>
				<br> <small></small>
			</h1>
		</div>
		
		<div>
		<?php if (isset($msgError)){ ?>
			<p> <?php echo  SyTranslator::Unable_to_add_the_pricing($lang) ?> </p>
			<p> <?php echo  $msgError ?></p>
		<?php }else{?>
			<p> <?php echo  SyTranslator::The_pricing_has_been_successfully_added($lang) ?></p>
		<?php } ?>
		</div>
		<div class="col-md-1 col-md-offset-10">
			<button onclick="location.href='sygrrif/pricing'" class="btn btn-success" id="navlink"> <?php echo  SyTranslator::Ok($lang) ?></button>
		</div>
		
     </div>
</div>