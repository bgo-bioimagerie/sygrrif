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
	<form role="form" class="form-horizontal" action="sygrrifpricing/statpriceunits"
		method="post" id="statform">
	
	
		<div class="page-header">
			<h1>
				<?php echo  SyTranslator::Pricing_Unit($lang) ?>
				<br> <small></small>
			</h1>
		</div>
		
		<?php
		if ($errorMessage != ''){
			?>
			<div class="alert alert-danger">
				<p><?php echo  $errorMessage ?></p>
			</div>
		<?php } ?>
		
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  SyTranslator::Date_Start($lang) ?></label>
				<div class="col-xs-9">
				<div class='input-group date form_date_<?php echo  $lang ?>'>
					<input type='text' class="form-control" name="searchDate_start" id="searchDate_start"
					       value="<?php echo  CoreTranslator::dateFromEn($searchDate_start, $lang) ?>" />
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
		    </div>
		</div>
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  SyTranslator::Date_End($lang) ?></label>
				<div class="col-xs-9">
				<div class='input-group date form_date_<?php echo  $lang ?>'>
					<input id="test32" type='text' class="form-control" name="searchDate_end"
					       value="<?php echo  CoreTranslator::dateFromEn($searchDate_end, $lang) ?>" />
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
		    </div>
		    				<div class="col-xs-1">
				<input type="submit" class="btn btn-primary" value="<?php echo  SyTranslator::Ok($lang) ?>" />
				</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  SyTranslator::Unit($lang) ?></label>
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
					<OPTION value="<?php echo  $unitId?>" <?php echo  $checked ?>> <?php echo $unitName?> </OPTION>
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
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  SyTranslator::Responsible($lang) ?></label>
			<div class="col-xs-10">
					<select class="form-control" name="responsible">
					<OPTION value="0" > ... </OPTION>
					<?php 
					foreach ($responsiblesList as $resp){
						$respId = $this->clean( $resp['id'] );	
						$respName = $this->clean( $resp['name'] . " " . $resp['firstname']);
					?>
					<OPTION value="<?php echo  $respId?>"> <?php echo $respName?> </OPTION>
					<?php
					}
					?>
				</select>
			</div>
		</div>	
		<br>
				<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  SyTranslator::Export_type($lang) ?></label>
			<div class="col-xs-10">
					<select class="form-control" name="export_type">
					<OPTION value="0" > ... </OPTION>
					<OPTION value="1" > <?php echo  SyTranslator::counting($lang) ?> </OPTION>
					<OPTION value="2" > <?php echo  SyTranslator::detail($lang) ?> </OPTION>
					<OPTION value="3" > <?php echo  SyTranslator::bill($lang) ?> </OPTION>
				</select>
			</div>
		</div>	
		
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  SyTranslator::Ok($lang) ?>" />
				<button type="button" onclick="location.href='sygrrifpricing'" class="btn btn-default"><?php echo  SyTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php include 'Modules/core/View/timepicker_script.php'; ?>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
