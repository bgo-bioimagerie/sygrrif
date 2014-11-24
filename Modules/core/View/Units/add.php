<?php $this->title = "SyGRRiF Database users"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
#button-div{
	padding-top: 20px;
}

</style>


</head>


<?php include "Modules/core/View/Users/usersnavbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-6 col-md-offset-3">
	<form role="form" class="form-horizontal" action="units/addquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
				Add Unit <br> <small></small>
			</h1>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Name</label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name"
				/>
			</div>
		</div>
		<br></br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Address</label>
			<div class="col-xs-10">
				<textarea class="form-control" id="address" type="textarea" name="address"
				></textarea>
			</div>
		</div>
		
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Add" />
				<button onclick="location.href='units'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
