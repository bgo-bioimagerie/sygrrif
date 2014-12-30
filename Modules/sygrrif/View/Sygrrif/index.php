<?php $this->title = "SyGRRiF Database" ?>

<?php echo $navBar ?>

<head>
    <!-- Bootstrap core CSS -->
    <link href="externals/datepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">   
</head>

<?php include "Modules/sygrrif/View/navbar.php"; ?>

<div class="container">
    <br></br>
	<div class="col-md-3 col-md-offset-1 text-center">
			<img src="Themes/logo_sygrrif.jpg" alt="SyGRRiF" border="0" height="200px";/>
	</div>
	<div class="col-md-4 text-center" style="padding-top: 50px;">
		<h1> SyGRRiF </h1>
	</div>
	<div class="col-md-3 col-md-offset-1 text-center">
			<img src="Themes/logo_sygrrif.jpg" alt="SyGRRiF" border="0" height="200px";/>
	</div>
</div>
       

<?php if (isset($msgError)): ?>
    <p><?= $msgError ?></p>
<?php endif; ?>