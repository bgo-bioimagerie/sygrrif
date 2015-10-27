<?php $this->title = "sprojects statistics"?>

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
	
<?php include "Modules/sprojects/View/navbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-10 col-md-offset-1">
	<form role="form" class="form-horizontal" action="sprojectsstats/index"
		method="post" id="statform">
	
		<div class="page-header">
			<h1>
				<?php echo  SpTranslator::Statistics($lang) ?> <br> <small></small>
			</h1>
		</div>
		
		
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SpTranslator::Open_after_date($lang) ?></label>
				<div class="col-xs-8">
				<div class='input-group date form_date_<?php echo  $lang ?>'>
					<input type='text' class="form-control" data-date-format="YYYY-MM-DD" name="searchDate_min"
					       value="<?php echo  CoreTranslator::dateFromEn($searchDate_min, $lang) ?>" />
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
		    </div>
		</div>
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SpTranslator::Open_before_date($lang) ?></label>
				<div class="col-xs-8">
				<div class='input-group date form_date_<?php echo  $lang ?>'>
					<input type='text' class="form-control" data-date-format="YYYY-MM-DD" name="searchDate_max"
					       value="<?php echo  CoreTranslator::dateFromEn($searchDate_max, $lang) ?>" />
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
		    </div>
		</div>
		
		<div class="col-xs-1 col-xs-offset-11" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  SpTranslator::Ok($lang) ?>" />
		</div>
      </form>
      
      <?php if ($stats != ""){
      ?>
      	<div class="col-md-12">
      	<h3> <?php echo SpTranslator::Bilan_projets($lang) . " " . SpTranslator::period_from($lang) . " " 
		                . CoreTranslator::dateFromEn($searchDate_min, $lang) . " " 
			            . SpTranslator::to($lang) . " " .  CoreTranslator::dateFromEn($searchDate_max, $lang)?>
		</h3>
      	
      	<table class="table table-striped table-bordered">
      		<tr>
      			<td><?php echo SpTranslator::numberNewIndustryTeam($lang) ?></td>
      			<td><?php echo $stats["numberNewIndustryTeam"] . " (". $stats["purcentageNewIndustryTeam"] . "%)" ?></td>
      		</tr>
      		<tr>
      			<td><?php echo SpTranslator::numberIndustryProjects($lang) ?></td>
      			<td><?php echo $stats["numberIndustryProjects"] ?></td>
      		</tr>
      		<tr>
      			<td><?php echo SpTranslator::loyaltyIndustryProjects($lang) ?></td>
      			<td><?php echo $stats["loyaltyIndustryProjects"] . " (". $stats["purcentageloyaltyIndustryProjects"] . "%)"  ?></td>
      		</tr>

      		<tr>
      		<td></td>
      		<td></td>
      		</tr>
      		
      		<tr>
      			<td><?php echo SpTranslator::numberNewAccademicTeam($lang) ?></td>
      			<td><?php echo $stats["numberNewAccademicTeam"]  . " (". $stats["purcentageNewAccademicTeam"] . "%)" ?></td>
      		</tr>
      		<tr>
      			<td><?php echo SpTranslator::numberAccademicProjects($lang) ?></td>
      			<td><?php echo $stats["numberAccademicProjects"] ?></td>
      		</tr>
      		<tr>
      			<td><?php echo SpTranslator::loyaltyAccademicProjects($lang) ?></td>
      			<td><?php echo $stats["loyaltyAccademicProjects"]  . " (". $stats["purcentageloyaltyAccademicProjects"] . "%)"  ?></td>
      		</tr>

      		<tr>
      			<td></td>
      			<td></td>
      		</tr>
      		
      		<tr>
      			<td><?php echo SpTranslator::totalNumberOfProjects($lang) ?></td>
      			<td><?php echo $stats["totalNumberOfProjects"] ?></td>
      		</tr>
      		
		</table>
      	</div>
      	
      	
      <?php	
      }?>
	</div>
</div>

<?php include "Modules/core/View/timepicker_script.php" ?>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
