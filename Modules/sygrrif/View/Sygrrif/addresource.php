<?php $this->title = "SyGRRiF add pricing"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
#button-div{
	padding-top: 20px;
}

</style>

</head>


<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-8 col-md-offset-2">
	
		<div class="page-header">
				<h1>
					Ajouter Ressource <br> <small>Selectionner le type de ressources</small>
				</h1>
		</div>
	
		<div class="text-center">
			<button type="button" onclick="location.href='sygrrif/addresourcecalendar'" class="btn btn-default" id="navlink">Calendaire</button>
			<button type="button" onclick="location.href='sygrrif/addresourcequantity'" class="btn btn-default" id="navlink">Unitaire</button>
		</div>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
