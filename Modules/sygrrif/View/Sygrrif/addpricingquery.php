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
				Ajout tarif <br> <small></small>
			</h1>
		</div>
		
		<div>
		<?php if (isset($msgError)){ ?>
			<p> Impossible d'ajouter le tarif</p>
			<p> <?= $msgError ?></p>
		<?php }else{?>
			<p> Le tarif a été ajouté avec success !</p>
		<?php } ?>
		</div>
		<div class="col-md-1 col-md-offset-10">
			<button onclick="location.href='sygrrif/pricing'" class="btn btn-success" id="navlink">Ok</button>
		</div>
		
     </div>
</div>