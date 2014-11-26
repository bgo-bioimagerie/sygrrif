<?php $this->title = "SyGRRiF Database Add" ?>

<head>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<div class="container">
	<div class="col-md-6 col-md-offset-3">
		
		<div class="page-header">
			<h1>
				Add User <br> <small></small>
			</h1>
		</div>
		
		<div>
		<?php if (isset($msgError)){ ?>
			<p> Unable to add the user</p>
			<p> <?= $errorMessage ?></p>
		<?php }else{?>
			<p> The user had been successfully added !</p>
		<?php } ?>
		</div>
		<div class="col-md-1 col-md-offset-10">
			<button onclick="location.href='users'" class="btn btn-success" id="navlink">Ok</button>
		</div>
		
     </div>
</div>