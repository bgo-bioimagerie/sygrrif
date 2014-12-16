<?php $this->title = "SyGRRiF Edit Area"?>

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
	<form role="form" class="form-horizontal" action="sygrrif/editareaquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
				Edit area <br> <small></small>
			</h1>
		</div>
	
		<input class="form-control" id="id" type="hidden"  name="id" value="<?= $area['id']?>" />
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Name</label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name"
				       value="<?= $area['name'] ?>"  
				/>
			</div>
		</div>
	    <div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Is resticted</label>
			<div class="col-xs-10">
					<select class="form-control" name="restricted">
						<?php $restricted = $this->clean($area['restricted']) ?>
						<OPTION value="1" <?php if ($restricted==1){echo "selected=\"selected\"";}?>> Yes </OPTION>
						<OPTION value="0" <?php if ($restricted==0){echo "selected=\"selected\"";}?>> No </OPTION>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Display order</label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="number" name="display_order"
				       value="<?= $area['display_order'] ?>"  
				/>
			</div>
		</div>
		<br></br>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Save" />
				<button type="button" onclick="location.href='visa'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
