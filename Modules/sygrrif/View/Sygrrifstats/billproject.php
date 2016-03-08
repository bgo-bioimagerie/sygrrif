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
				<?php echo  SyTranslator::bill_project($lang) ?> <br> <small></small>
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
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Date_Start($lang) ?></label>
				<div class="col-xs-8">
				<div class='input-group date form_date_<?php echo  $lang ?>'>
					<input type='text' class="form-control" data-date-format="YYYY-MM-DD" name="searchDate_start" id="searchDate_start"
					       value="<?php echo  CoreTranslator::dateFromEn($searchDate_start, $lang) ?>" />
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
		    </div>
		</div>
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Date_End($lang) ?></label>
				<div class="col-xs-8">
				<div class='input-group date form_date_<?php echo  $lang ?>'>
					<input id="test32" type='text' class="form-control" data-date-format="YYYY-MM-DD" name="searchDate_end" 
					       value="<?php echo  CoreTranslator::dateFromEn($searchDate_end, $lang) ?>" />
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
		    </div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Project($lang) ?></label>
			<div class="col-xs-8">
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
					<OPTION value="<?php echo  $projectId?>" <?php echo  $checked ?>> <?php echo $projectName?> </OPTION>
					<?php
					}
					?>
				</select>
			</div>
		</div>	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Pricing($lang) ?></label>
			<div class="col-xs-8">
					<select class="form-control" name="pricing_id">
					<OPTION value="0" > ... </OPTION>
					<?php 
					foreach ($pricings as $pricing){
						$pricingId = $this->clean( $pricing['id'] );	
						$pricingName = $this->clean( $pricing['tarif_name']);
					?>
					<OPTION value="<?php echo  $pricingId?>"> <?php echo $pricingName?> </OPTION>
					<?php
					}
					?>
				</select>
			</div>
		</div>	
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Pricing_by($lang) ?></label>
			<div class="col-xs-8">
					<select class="form-control" name="pricing_type">
					<OPTION value="0" > <?php echo  SyTranslator::Time2($lang) ?> </OPTION>
					<OPTION value="1" > <?php echo  SyTranslator::Reservations_number($lang) ?> </OPTION>
				</select>
			</div>
		</div>	
		
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  SyTranslator::Ok($lang) ?>" />
				<button type="button" onclick="location.href='sygrrif'" class="btn btn-default" id="navlink"><?php echo  SyTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php include "Modules/core/View/timepicker_script.php" ?>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
