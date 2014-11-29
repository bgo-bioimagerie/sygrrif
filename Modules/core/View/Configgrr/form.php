<?php $this->title = "SyGRRiF Database config GRR" ?>

<head>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<div class="container">

<div class="col-md-6 col-md-offset-3">
	<form role="form" class="form-horizontal" action="configgrr/form/send"
		method="post">

		<div class="page-header">
			<h1>
				GRR SQL configuration <br> <small>This will create the configuration file</small>
			</h1>
		</div>
		
		
		<?php if ($errorMessage != ''){?>
		<div class="alert alert-danger">
		<p>
		Cannot connect to the database.
		</p>
		<p>
		Error message: <?php echo $errorMessage ?>
		</p>
		</div>
		<?php }?>

		<br>

		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">sql host</label>
			<div class="col-xs-10">
				<input class="form-control" id="sql_host" type="text" name="sql_host" placeholder="localhost" 
				       value = "<?= $sql_host ?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">login</label>
			<div class="col-xs-10">
				<input class="form-control" id="login" type="text" name="login" placeholder="root" 
				       value = "<?= $login ?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">password</label>
			<div class="col-xs-10">
				<input class="form-control" id="password" type="text" name="password"
				value = "<?= $password ?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">db name</label>
			<div class="col-xs-10">
				<input class="form-control" id="db_name" type="text" name="db_name" 
				value = "<?= $db_name ?>" />
			</div>
		</div>

		<div class="col-md-1 col-md-offset-10">
			<input type="submit" class="btn btn-primary" value="Next" />
		</div>
	</form>
</div>

</div> 

<?php if (isset($msgError)): ?>
    <p><?= $msgError ?></p>
<?php endif; ?>
