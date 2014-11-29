<?php $this->title = "SyGRRiF Database config GRR" ?>

<head>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<div class="container">

  <div class="col-md-6 col-md-offset-3">
	<div class="page-header">
	  <h1>
		GRR Synchronisation <br> <small></small>
	  </h1>
	</div>
	<div class="row">
        <p>The configuration of the GRR database is correct. Click next to import the
           GRR users into SyGRRif, or finish to end the configuration </p>
	</div>
	<div class="row">
	  <div class="col-md-4 col-md-offset-8">
	    <button onclick="location.href='configgrr/sync'" class="btn btn-primary" id="navlink">Next</button>
	    <button onclick="location.href='home'" class="btn btn-default" id="navlink">Finish</button>
	  </div>
	</div>
</div> 

<?php if (isset($msgError)): ?>
    <p><?= $msgError ?></p>
<?php endif; ?>
