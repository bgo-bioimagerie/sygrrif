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
				Modification ressource calendaire <br> <small></small>
			</h1>
		</div>
		
		<div>
		<?php if (isset($msgError)){ ?>
			<p> Impossible de modifier la ressource calendaire</p>
			<p> <?= $msgError ?></p>
		<?php }else{?>
			<p> Le ressource calendaire a été modifiée avec succès !</p>
		<?php } ?>
		</div>
		<div class="col-md-1 col-md-offset-10">
			<button onclick="location.href='sygrrif/resources'" class="btn btn-success" id="navlink">Ok</button>
		</div>
		
     </div>
</div>