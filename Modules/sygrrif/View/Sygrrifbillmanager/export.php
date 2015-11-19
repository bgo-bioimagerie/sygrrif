<?php $this->title = "SyGRRiF"?>

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
	<form role="form" class="form-horizontal" action="sygrrifbillmanager/export"
		method="post" id="statform">
	
	
		<div class="page-header">
			<h1>
				<?php echo  SyTranslator::BillListExport($lang) ?>
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
				<div class="col-xs-10">
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
				<div class="col-xs-10">
				<div class='input-group date form_date_<?php echo  $lang ?>'>
					<input id="test32" type='text' class="form-control" name="searchDate_end" 
					       value="<?php echo  CoreTranslator::dateFromEn($searchDate_end, $lang) ?>" />
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
		    </div>
		</div>
		
		
			<div class="col-xs-4 col-xs-offset-8" id="button-div">
			<input type="submit" class="btn btn-primary" value="<?php echo  SyTranslator::Ok($lang) ?>" />
			<button type="button" onclick="location.href='sygrrif'" class="btn btn-default"><?php echo  SyTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php include 'Modules/core/View/timepicker_script.php'; ?>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>