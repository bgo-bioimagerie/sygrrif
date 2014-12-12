<?php $this->title = "SyGRRiF Statistics"?>

<?php echo $navBar?>

<head>
	<link href="bootstrap/datepicker/css/bootstrap-datetimepicker.css" rel="stylesheet">
	<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	
	<script src="bootstrap/datepicker/js/moments.js"></script>
	<script src="bootstrap/jquery-1.11.1.js"></script>

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
	<form role="form" class="form-horizontal" action="sygrrif/statpriceunits"
		method="post" id="statform">
	
	
		<div class="page-header">
			<h1>
				Statistics/Pricing Units <br> <small></small>
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
			<label for="inputEmail" class="control-label col-xs-2">Date Start</label>
				<div class="col-xs-10">
				<div class='input-group date' id='datetimepicker5'>
					<input type='text' class="form-control" data-date-format="YYYY-MM-DD" name="searchDate_start" id="searchDate_start"
					       value="<?=$searchDate_start?>" />
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
			<script src="bootstrap/datepicker/js/bootstrap-datetimepicker.min.js"></script>
      		<script type="text/javascript">
			$(function () {
				$('#datetimepicker5').datetimepicker({
					pickTime: true
				});
			});
		    </script>
		    </div>
		</div>
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-2">Date End</label>
				<div class="col-xs-10">
				<div class='input-group date' id='datetimepicker6'>
					<input id="test32" type='text' class="form-control" data-date-format="YYYY-MM-DD" name="searchDate_end" 
					       value="<?= $searchDate_end ?>" />
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
			<script src="bootstrap/datepicker/js/bootstrap-datetimepicker.min.js"></script>
      		<script type="text/javascript">
  			$(function () {
				$('#datetimepicker6').datetimepicker({
					pickTime: false
				});
			});
			</script>
		    </div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Unit</label>
			<div class="col-xs-10">
					<select class="form-control" name="unit" id="unit" onchange="updateResponsibe(this);">
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
			<label for="inputEmail" class="control-label col-xs-2">Responsible</label>
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
			<label for="inputEmail" class="control-label col-xs-2">Export type</label>
			<div class="col-xs-10">
					<select class="form-control" name="export_type">
					<OPTION value="0" > ... </OPTION>
					<OPTION value="1" > counting </OPTION>
					<OPTION value="2" > detail </OPTION>
					<OPTION value="3" > bill </OPTION>
				</select>
			</div>
		</div>	
		
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Ok" />
				<button type="button" onclick="location.href='sygrrif'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
