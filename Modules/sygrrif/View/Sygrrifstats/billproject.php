<?php $this->title = "SyGRRiF Project bill"?>

<?php echo $navBar?>

<head>
	<link href="externals/datepicker/css/bootstrap-datetimepicker.css" rel="stylesheet">
	<link href="externals/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	
	<script src="externals/datepicker/js/moments.js"></script>
	<script src="externals/jquery-1.11.1.js"></script>

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
	<form role="form" class="form-horizontal" action="sygrrifstats/billproject"
		method="post" id="statform">
	
		<div class="page-header">
			<h1>
				<?= SyTranslator::bill_project($lang) ?> <br> <small></small>
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
				<div class='input-group date' id='datetimepicker5'>
					<input type='text' class="form-control" data-date-format="YYYY-MM-DD" name="searchDate_start" id="searchDate_start"
					       value="<?=$searchDate_start?>" />
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
			<script src="externals/datepicker/js/bootstrap-datetimepicker.min.js"></script>
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
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Date_End($lang) ?></label>
				<div class="col-xs-10">
				<div class='input-group date' id='datetimepicker6'>
					<input id="test32" type='text' class="form-control" data-date-format="YYYY-MM-DD" name="searchDate_end" 
					       value="<?= $searchDate_end ?>" />
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
			<script src="externals/datepicker/js/bootstrap-datetimepicker.min.js"></script>
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
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Project($lang) ?></label>
			<div class="col-xs-10">
					<select class="form-control" name="project_id" id="project_id"
						>
					<?php 
					foreach ($projects as $project){
						$projectId = $this->clean( $project['id'] );	
						$projectName = $this->clean( $project['name'] );
						$checked = "";
						if ($project_id == $projectId){
							$checked = ' selected="selected"';
						}
					?>
					<OPTION value="<?= $projectId?>" <?= $checked ?>> <?=$projectName?> </OPTION>
					<?php
					}
					?>
				</select>
			</div>
		</div>	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Pricing($lang) ?></label>
			<div class="col-xs-10">
					<select class="form-control" name="pricing_id">
					<OPTION value="0" > ... </OPTION>
					<?php 
					foreach ($pricings as $pricing){
						$pricingId = $this->clean( $pricing['id'] );	
						$pricingName = $this->clean( $pricing['tarif_name']);
					?>
					<OPTION value="<?= $pricingId?>"> <?=$pricingName?> </OPTION>
					<?php
					}
					?>
				</select>
			</div>
		</div>	
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Pricing_by($lang) ?></label>
			<div class="col-xs-10">
					<select class="form-control" name="pricing_type">
					<OPTION value="0" > <?= SyTranslator::Time2($lang) ?> </OPTION>
					<OPTION value="1" > <?= SyTranslator::Reservations_number($lang) ?> </OPTION>
				</select>
			</div>
		</div>	
		
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?= SyTranslator::Ok($lang) ?>" />
				<button type="button" onclick="location.href='sygrrif'" class="btn btn-default" id="navlink"><?= SyTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
