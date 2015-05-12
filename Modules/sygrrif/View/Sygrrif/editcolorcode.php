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
			<?= SyTranslator::Edit_Color_Code($lang) ?>
				 <br> <small></small>
			</h1>
		</div>
	
		<div class="form-group">
		<label for="inputEmail" class="control-label col-xs-2">ID</label>
			<div class="col-xs-10">
			<input class="form-control" id="id" type="text"  name="id" value="<?= $colorcode['id']?>" readonly/>
		</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Name($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name"
				       value="<?= $colorcode['name'] ?>"  
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Color_diese($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="color"
				       value="<?= $colorcode['color'] ?>"  
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Display_order($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="number" name="display_order"
				       value="<?= $colorcode['display_order'] ?>"  
				/>
			</div>
		</div>
		<br></br>
		<div class="col-xs-6 col-xs-offset-6" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?= SyTranslator::Save($lang) ?>" />
		        <button type="button" onclick="location.href='sygrrif/deletecolorcode/<?= $colorcode['id'] ?>'" class="btn btn-danger" id="navlink"><?= SyTranslator::Delete($lang) ?></button>
				<button type="button" onclick="location.href='sygrrif/colorcodes'" class="btn btn-default"><?= SyTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
