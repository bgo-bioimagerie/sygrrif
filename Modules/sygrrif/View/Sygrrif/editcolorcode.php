<?php $this->title = "SyGRRiF Edit Color Code"?>

<?php echo $navBar?>

<head>
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
	<form role="form" class="form-horizontal" action="sygrrif/editcolorcodequery"
		method="post">
	
	
		<div class="page-header">
			<h1>
				Edit Color Code <br> <small></small>
			</h1>
		</div>
	
		<div class="form-group">
		<label for="inputEmail" class="control-label col-xs-2">ID</label>
			<div class="col-xs-10">
			<input class="form-control" id="id" type="text"  name="id" value="<?= $colorcode['id']?>" readonly/>
		</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Name</label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name"
				       value="<?= $colorcode['name'] ?>"  
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Color: #</label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="color"
				       value="<?= $colorcode['color'] ?>"  
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Display order</label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="number" name="display_order"
				       value="<?= $colorcode['display_order'] ?>"  
				/>
			</div>
		</div>
		<br></br>
		<div class="col-xs-6 col-xs-offset-6" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Save" />
		        <button type="button" onclick="location.href='sygrrif/deletecolorcode/<?= $colorcode['id'] ?>'" class="btn btn-danger" id="navlink">Delete</button>
				<button type="button" onclick="location.href='sygrrif/colorcodes'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
