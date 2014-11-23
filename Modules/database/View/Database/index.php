<?php $this->title = "SyGRRiF Database" ?>

<?php echo $navBar ?>

<head>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap/datepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">   
</head>



<?php include "Modules/database/View/navbar.php"; ?>


<br></br>
<div class="container">
	<!-- Main component for a primary marketing message or call to action -->
	<div class="jumbotron">
        <p> This tool allows you to create tables in the database and generate automatic tools to interact 
		with these tables</p>
	</div>

</div> <!-- /container -->

    

<?php if (isset($msgError)): ?>
    <p><?= $msgError ?></p>
<?php endif; ?>