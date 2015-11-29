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
	<?php echo $formHtml ?>
      
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
