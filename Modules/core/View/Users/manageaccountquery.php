<?php $this->title = "SyGRRiF Database add user"?>

<?php echo $navBar?>

<head>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<div class="container">
	<div class="col-md-6 col-md-offset-3">
		
		<div class="page-header">
			<h1>
				Manage account <br> <small></small>
			</h1>
		</div>
		
		<div>
		<?php if (isset($msgError)){ ?>
			<p> Unable to update the account</p>
			<p> <?= $msgError ?></p>
		<?php }else{?>
			<p> The account has been successfully updated !</p>
		<?php } ?>
		</div>
		<div class="col-md-1 col-md-offset-10">
			<button onclick="location.href='home'" class="btn btn-success" id="navlink">Ok</button>
		</div>
		
     </div>
</div>