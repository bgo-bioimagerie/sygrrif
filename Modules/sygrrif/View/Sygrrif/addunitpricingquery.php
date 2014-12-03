<?php $this->title = "SyGRRiF add pricing"?>

<?php echo $navBar?>


<head>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<?php include "Modules/sygrrif/View/navbar.php"; ?>

<div class="container">
	<div class="col-md-6 col-md-offset-3">
		
		<div class="page-header">
			<h1>
				Associer tarif à une unité <br> <small></small>
			</h1>
		</div>
		
		<div>
		<?php if (isset($msgError)){ ?>
			<p> Impossible d'associer le tarif à l'unité</p>
			<p> <?= $msgError ?></p>
		<?php }else{?>
			<p> Le tarif a été associé à l'unité avec success !</p>
		<?php } ?>
		</div>
		<div class="col-md-1 col-md-offset-10">
			<button onclick="location.href='sygrrif/unitpricing'" class="btn btn-success" id="navlink">Ok</button>
		</div>
		
     </div>
</div>