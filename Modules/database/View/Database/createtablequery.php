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
<div class="col-md-6 col-md-offset-3">
	<!-- Main component for a primary marketing message or call to action -->
	<div class="jumbotron">
		<?php 
		if ($result){
			echo 'The table have been successfully created';
		}
		else{
			echo 'Unable to create the table. Please verify that the table does not already exists
    		      and that the settings of the database connection are correct';
		}
		?>
		<br>
        <div class="col-md-1 col-md-offset-10">
			<input onclick="location.href='database/createtable'" type="submit" class="btn btn-primary" value="Ok" />
		</div>
	</div>
  </div>
</div> <!-- /container -->

    

<?php if (isset($msgError)): ?>
    <p><?= $msgError ?></p>
<?php endif; ?>