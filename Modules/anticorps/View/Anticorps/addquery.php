<?php $this->title = "SyGRRiF Database add user"?>

<?php echo $navBar?>
<?php include "Modules/anticorps/View/navbar.php"; ?>

<head>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<div class="container">
	<div class="col-md-6 col-md-offset-3">
		
		<div class="page-header">
			<h1>
				Ajout Anticorps <br> <small></small>
			</h1>
		</div>
		
		<div>
		<?php if (isset($msgError)){ ?>
			<p> Unable to add the user</p>
			<p> <?= $msgError ?></p>
		<?php }else{?>
			<p> L'anticorps a été ajouté avec succes !</p>
		<?php } ?>
		</div>
		<div class="col-md-1 col-md-offset-10">
			<button onclick="location.href='anticorps'" class="btn btn-success" id="navlink">Ok</button>
		</div>
		
     </div>
</div>