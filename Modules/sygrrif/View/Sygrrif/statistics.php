<?php $this->title = "SyGRRiF Statistics"?>

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
	<div class="col-md-8 col-md-offset-2">
	<form role="form" class="form-horizontal" action="sygrrif/statisticsquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
			<?= SyTranslator::Statistics($lang) ?>
				<br> <small></small>
			</h1>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Year($lang) ?></label>
			<div class="col-xs-10">
				<select class="form-control" name="year">
					<?php 
					for($i=2010; $i<=date('Y')+1; $i++){
						$checked = "";
						if ($i == date('Y')){
							$checked = ' selected="selected"';
						}
					?>
					<OPTION value="<?= $i?>" <?= $checked?>> <?=$i?> </OPTION>
					<?php
					}
					?>
				</select>
			</div>
		</div>	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Export($lang) ?></label>
			<div class="col-xs-10">
				<select class="form-control" name="export_type"> 
					<OPTION value="1" > Graph </OPTION>
					<OPTION value="2" > csv </OPTION>
				</select>
			</div>
		</div>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?= SyTranslator::Ok($lang) ?>" />
				<button type="button" onclick="location.href='sygrrif'" class="btn btn-default" id="navlink"><?= SyTranslator::Cancel($lang)?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
