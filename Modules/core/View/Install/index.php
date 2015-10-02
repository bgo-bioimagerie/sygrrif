<?php $this->title = "SyGRRiF Database Install" ?>

<head>
    <!-- Bootstrap core CSS -->
    <link href="externals/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<?php if ($alreadyInstalled){?>

<div class="container">
	<div class="jumbotron">
        <h1>Permission denied</h1>
        <p>The SyGRRif database has already been installed ! </p>
	</div>

</div> 

<?php }else{?>

<div class="container">

<div class="col-md-6 col-md-offset-3">
	<form role="form" class="form-horizontal" action="install/configdatabase"
		method="post">

		<div class="page-header">
			<h1>
				SQL configuration <br> <small>This will edit the configuration file</small>
			</h1>
		</div>

		<br>

		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">sql host</label>
			<div class="col-xs-10">
				<input class="form-control" id="sql_host" type="text" name="sql_host" placeholder="localhost" />
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">login</label>
			<div class="col-xs-10">
				<input class="form-control" id="login" type="text" name="login" placeholder="root" />
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">password</label>
			<div class="col-xs-10">
				<input class="form-control" id="password" type="password" name="password" />
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">db name</label>
			<div class="col-xs-10">
				<input class="form-control" id="db_name" type="text" name="db_name" />
			</div>
		</div>

		<div class="col-md-1 col-md-offset-10">
			<input type="submit" class="btn btn-primary" value="Next" />
		</div>
	</form>
</div>

</div> 

<?php }?>


<?php if (isset($msgError)): ?>
    <p><?php echo  $msgError ?></p>
<?php endif; ?>
