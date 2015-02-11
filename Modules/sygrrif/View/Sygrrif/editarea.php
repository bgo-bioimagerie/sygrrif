<?php $this->title = "SyGRRiF Edit Area"?>

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
	<form role="form" class="form-horizontal" action="sygrrif/editareaquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
				<?= SyTranslator::Edit_area($lang) ?> <br> <small></small>
			</h1>
		</div>
	
		<input class="form-control" id="id" type="hidden"  name="id" value="<?= $area['id']?>" />
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Name($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name"
				       value="<?= $area['name'] ?>"  
				/>
			</div>
		</div>
	    <div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Is_resticted($lang) ?></label>
			<div class="col-xs-10">
					<select class="form-control" name="restricted">
						<?php $restricted = $this->clean($area['restricted']) ?>
						<OPTION value="1" <?php if ($restricted==1){echo "selected=\"selected\"";}?>> <?= SyTranslator::Yes($lang)?> </OPTION>
						<OPTION value="0" <?php if ($restricted==0){echo "selected=\"selected\"";}?>> <?= SyTranslator::No($lang)?> </OPTION>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Display_order($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="number" name="display_order"
				       value="<?= $area['display_order'] ?>"  
				/>
			</div>
		</div>
		<br></br>
		<div class="col-xs-6 col-xs-offset-6" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?= SyTranslator::Save($lang) ?>" />
		        <button type="button" onclick="location.href='<?="sygrrif/deletearea/".$this->clean($area['id']) ?>'" class="btn btn-danger" id="navlink"><?= SyTranslator::Delete($lang) ?></button>
				<button type="button" onclick="location.href='sygrrif/areas'" class="btn btn-default" id="navlink"><?= SyTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
