<?php $this->title = "SyGRRiF Statistics"?>

<?php echo $navBar?>

<head>
	<link href="externals/datepicker/css/bootstrap-datetimepicker.css" rel="stylesheet">
	<link href="externals/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<style>
#button-div{
	padding-top: 20px;
}

</style>

</head>
	
<?php include "Modules/sygrrif/View/navbar.php"; 
require_once 'Modules/core/Model/CoreTranslator.php';
?>

<br>
<div class="container">
	<div class="col-md-8 col-md-offset-2">
	<form role="form" class="form-horizontal" action="sygrrif/statpriceunits"
		method="post" id="statform">
	
	
		<div class="page-header">
			<h1>
				<?= SyTranslator::Pricing_Unit($lang) ?>
				<br> <small></small>
			</h1>
		</div>
		
		<?php
		if ($errorMessage != ''){
			?>
			<div class="alert alert-danger">
				<p><?= $errorMessage ?></p>
			</div>
		<?php } ?>
		
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Date_Start($lang) ?></label>
				<div class="col-xs-10">
				<div class='input-group date form_date_<?= $lang ?>'>
					<input type='text' class="form-control" name="searchDate_start" id="searchDate_start"
					       value="<?= CoreTranslator::dateFromEn($searchDate_start, $lang) ?>" />
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
		    </div>
		</div>
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Date_End($lang) ?></label>
				<div class="col-xs-10">
				<div class='input-group date form_date_<?= $lang ?>'>
					<input id="test32" type='text' class="form-control" name="searchDate_end"
					       value="<?= CoreTranslator::dateFromEn($searchDate_end, $lang) ?>" />
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
		    </div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Unit($lang) ?></label>
			<div class="col-xs-10">
					<select class="form-control" name="unit" id="unit" onchange="updateResponsibe(this);"
						>
					<OPTION value=""> -- </OPTION>	
					<?php 
					foreach ($unitsList as $unit){
						$unitId = $this->clean( $unit['id'] );	
						$unitName = $this->clean( $unit['name'] );
						$checked = "";
						if ($selectedUnitId == $unitId){
							$checked = ' selected="selected"';
						}
					?>
					<OPTION value="<?= $unitId?>" <?= $checked ?>> <?=$unitName?> </OPTION>
					<?php
					}
					?>
				</select>
				<script type="text/javascript">
    				function updateResponsibe(sel) {
    					$( "#statform" ).submit();
    				}
				</script>
			</div>
		</div>	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Responsible($lang) ?></label>
			<div class="col-xs-10">
					<select class="form-control" name="responsible">
					<OPTION value="0" > ... </OPTION>
					<?php 
					foreach ($responsiblesList as $resp){
						$respId = $this->clean( $resp['id'] );	
						$respName = $this->clean( $resp['name'] . " " . $resp['firstname']);
					?>
					<OPTION value="<?= $respId?>"> <?=$respName?> </OPTION>
					<?php
					}
					?>
				</select>
			</div>
		</div>	
		<br>
				<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Export_type($lang) ?></label>
			<div class="col-xs-10">
					<select class="form-control" name="export_type">
					<OPTION value="0" > ... </OPTION>
					<OPTION value="1" > <?= SyTranslator::counting($lang) ?> </OPTION>
					<OPTION value="2" > <?= SyTranslator::detail($lang) ?> </OPTION>
					<OPTION value="3" > <?= SyTranslator::bill($lang) ?> </OPTION>
				</select>
			</div>
		</div>	
		
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?= SyTranslator::Ok($lang) ?>" />
				<button type="button" onclick="location.href='sygrrif'" class="btn btn-default"><?= SyTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php include 'Modules/core/View/timepicker_script.php'; ?>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
