<?php $this->title = "SyGRRiF Database config GRR" ?>

<head>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<div class="container">

  <div class="col-md-6 col-md-offset-3">
	<div class="page-header">
	  <h1>
		GRR configration <br> <small></small>
	  </h1>
	</div>
	<div class="row">
        <p>A configuration of GRR already exists, do you want to change it ? </p>
	</div>
	<div class="row">
	  <div class="col-md-4 col-md-offset-8">
	    <button onclick="location.href='configgrr/index/1'" class="btn btn-primary" id="navlink">Ok</button>
	    <button onclick="location.href='home'" class="btn btn-default" id="navlink">Cancel</button>
	  </div>
	</div>
</div> 

<?php if (isset($msgError)): ?>
    <p><?= $msgError ?></p>
<?php endif; ?>
