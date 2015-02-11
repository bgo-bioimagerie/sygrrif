<?php $this->title = "SyGRRiF add pricing"?>

<?php echo $navBar?>


<head>
</head>
<?php include "Modules/sygrrif/View/navbar.php"; ?>

<div class="container">
	<div class="col-md-6 col-md-offset-3">
		
		<div class="page-header">
			<h1>
			<?= SyTranslator::Add_pricing($lang) ?>
				<br> <small></small>
			</h1>
		</div>
		
		<div>
		<?php if (isset($msgError)){ ?>
			<p> <?= SyTranslator::Unable_to_add_the_pricing($lang) ?> </p>
			<p> <?= $msgError ?></p>
		<?php }else{?>
			<p> <?= SyTranslator::The_pricing_has_been_successfully_added($lang) ?></p>
		<?php } ?>
		</div>
		<div class="col-md-1 col-md-offset-10">
			<button onclick="location.href='sygrrif/pricing'" class="btn btn-success" id="navlink"> <?= SyTranslator::Ok($lang) ?></button>
		</div>
		
     </div>
</div>