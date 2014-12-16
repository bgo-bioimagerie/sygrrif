<?php $this->title = "SyGRRiF add resource"?>

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


<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-6 col-md-offset-3">
	<form role="form" class="form-horizontal" action="sygrrif/addresource"
		method="post">
	
		<div class="page-header">
				<h1>
					Add a resource <br> <small>Select the resource type</small>
				</h1>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-3">Resource type</label>
			<div class="col-xs-9">
					<select class="form-control" name="resource_type">
					<?php 
					    foreach ($resourcesTypes as $type){
					          $typename = $this->clean( $type['name']  );
					          $typeId = $this->clean( $type['id'] );
					    ?>
						<OPTION value="<?= $typeId ?>" > <?= $typename ?> </OPTION>
					<?php } ?>
				</select>
			</div>
		</div>
		<br></br>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <button type="button" onclick="location.href='resources'" class="btn btn-default" id="navlink">Cancel</button>
		        <input type="submit" class="btn btn-primary" value="Next" />
		</div>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
