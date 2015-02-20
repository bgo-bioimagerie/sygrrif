<?php $this->title = "Supplies units"?>

<?php echo $navBar?>

<head>
<style>
#button-div{
	padding-top: 20px;
}
</style>
</head>


<?php include "Modules/supplies/View/navbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-6 col-md-offset-3">
	<form role="form" class="form-horizontal" action="suppliesunits/editquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
			<?= CoreTranslator::Edit_Unit($lang) ?>
			 <br> <small></small>
			</h1>
		</div>
	
		<input class="form-control" id="id" type="hidden"  name="id" value="<?= $unit['id']?>" />
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Name($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name"
				       value="<?= $unit['name'] ?>"  
				/>
			</div>
		</div>
		<br></br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Address($lang) ?></label>
			<div class="col-xs-10">
				<textarea class="form-control" id="address" type="textarea" name="address"
				><?= $unit['address'] ?></textarea>
			</div>
		</div>
		
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?= CoreTranslator::Save($lang) ?>" />
				<button type="button" onclick="location.href='suppliesunits'" class="btn btn-default" id="navlink"><?= CoreTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
