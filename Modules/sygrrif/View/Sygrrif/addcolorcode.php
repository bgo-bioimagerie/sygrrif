<?php $this->title = "SyGRRiF add color code"?>

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
	<form role="form" class="form-horizontal" action="sygrrif/addcolorcodequery"
		method="post">
	
	
		<div class="page-header">
			<h1>
			<?= SyTranslator::Add_Color_Code($lang) ?>
				<br> <small></small>
			</h1>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?= SyTranslator::Name($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="text" name="name"
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?= SyTranslator::Color_diese($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="text" name="color"
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?= SyTranslator::Display_order($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="number" name="display_order"
				       value="0"  
				/>
			</div>
		</div>
		<br></br>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?= SyTranslator::Add($lang) ?>" />
				<button type="button" onclick="location.href='sygrrif/colorcodes'" class="btn btn-default"><?= SyTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
