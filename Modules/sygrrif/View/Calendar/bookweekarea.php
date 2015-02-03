<?php $this->title = "SyGRRiF Booking"?>

<?php echo $navBar?>
<?php 
require_once 'Modules/sygrrif/Model/SyBookingSettings.php';
require_once 'Modules/sygrrif/View/Calendar/bookfunction.php'
?>

<head>

<style>
#tcell{
	border-left: 1px solid #f1f1f1;
	border-right: 1px solid #f1f1f1;
	border-bottom: 1px solid #f1f1f1;
}

#tcelltop{
	border: 1px solid #f1f1f1;
}

#colDiv{
	padding:0;
    margin:0;
}

#colDivglobal{
	padding:0;
    margin:0;
    border: 1px solid #f1f1f1;
}

#colDivleft{
	padding-right:0px;
	margin-right:0px;
}

#colDivright{
	padding-left:0px;
	margin-left:0px;
}


#tcellResa{
	-moz-border-radius: 9px;
	border-radius: 9px;
	border: 1px solid #f1f1f1;
}

#resa_link{
	font-family: Arial;
	font-size: 9px;
	line-height: 9px;
	letter-spacing: 1px;
	font-weight: normal;
}

@media (min-width: 1200px) {
  .seven-cols .col-md-1,
  .seven-cols .col-sm-1,
  .seven-cols .col-lg-1 {
    width: 14.285714285714285714285714285714%;
    *width: 14.285714285714285714285714285714%;
  }
}
/* 14% = 100% (full-width row) divided by 7 */

img{
  max-width: 100%;
}

</style>
</head>

<?php include "Modules/sygrrif/View/bookingnavbar.php"; ?>




<!-- Add the table title -->
<br></br>
<div class="col-lg-12">
<div class="col-lg-10 col-lg-offset-1">
	<?php if ($message != ""): 
		if (strpos($message, "Error") === false){?>
			<div class="alert alert-success text-center">	
		<?php 
		}
		else{
		?>
		 	<div class="alert alert-danger text-center">
		<?php 
		}
	?>
    	<p><?= $message ?></p>
    	</div>
	<?php endif; ?>

</div>
</div>

<div class="col-lg-11 col-lg-offset-1">

<div class="col-md-8 text-left">
<button type="submit" class="btn btn-default" onclick="location.href='calendar/bookweekarea/dayweekbefore'"><</button>
<button type="submit" class="btn btn-default" onclick="location.href='calendar/bookweekarea/dayweekafter'">></button>
<button type="submit" class="btn btn-default" onclick="location.href='calendar/bookweekarea/thisWeek'">This week</button>
<?php 
$d = explode("-", $mondayDate);
$time = mktime(0,0,0,$d[1],$d[2],$d[0]);
$dayStream = date("l", $time);
$monthStream = date("F", $time);
$dayNumStream = date("d", $time);
$yearStream = date("Y", $time);
$sufixStream = date("S", $time);

?>
<b><?php echo $dayStream . ", " . $monthStream . " " .$dayNumStream. $sufixStream . " " .$yearStream  ?>  -  </b>
<?php 
$d = explode("-", $sundayDate);
$time = mktime(0,0,0,$d[1],$d[2],$d[0]);
$dayStream = date("l", $time);
$monthStream = date("F", $time);
$dayNumStream = date("d", $time);
$yearStream = date("Y", $time);
$sufixStream = date("S", $time);

?>
<b><?php echo $dayStream . ", " . $monthStream . " " .$dayNumStream. $sufixStream . " " .$yearStream  ?> </b>

</div>

<div class="col-md-4 text-right">
<button type="button" onclick="location.href='calendar/book'" class="btn btn-default">Day</button>
<button type="button" onclick="location.href='calendar/bookweek'" class="btn btn-default ">Week</button>
<button type="button" class="btn btn-default active">Week Area</button>

</div>
</div>

<br></br>

<!-- hours reservation -->
<div class="col-xs-12" id="colDiv">

	<!--  Area title -->
	<div class="col-xs-1" id="colDiv"></div>
	<div class="col-xs-11" id="colDiv">
	<div id="tcelltop" style="height: 50px;">
	<p class="text-center"><b><?= $this->clean($areaname) ?></p>
	</div>
	</div>

	<!--  days title -->
	<div class="col-xs-1" id="colDiv"></div>
	<div class="col-xs-11" id="colDiv">
		<div class="row seven-cols">
		<?php 
		for ($d = 0 ; $d < 7 ; $d++){
			
			$idcss = "colDiv";
			if ($d == 0){
				$idcss = "colDivleft";
			}
			if ($d == 6){
				$idcss = "colDivright";
			}
			
			// day title
			$temp = explode("-", $mondayDate);
			$date_unix = mktime(0,0,0,$temp[1], $temp[2]+$d, $temp[0]);
			$dayStream = date("l", $date_unix);
			$monthStream = date("M", $date_unix);
			$dayNumStream = date("d", $date_unix);
			$sufixStream = date("S", $date_unix);
			
			$dayTitle = $dayStream . " " . $monthStream . ". " . $dayNumStream . $sufixStream;
			
			?>
			
			
			<div class="col-lg-1 col-md-3 col-sm-4 col-xs-6" id="<?= $idcss ?>">
			
			<div id="tcelltop" style="height: 50px;">
			<p class="text-center"><b> <?= $dayTitle ?> </p>
			</div>
		  </div>
		<?php	
		}	
		?>
	</div>
	</div>
	
	<div class="col-xs-12" id="colDiv">
	<?php 
		$resourceCount = -1;
		$modelBookingSetting = new SyBookingSettings();
		$moduleProject = new Project();
		$ModulesManagerModel = new ModulesManager();
		$isProjectMode = $ModulesManagerModel->getDataMenusUserType("projects");
		
		foreach($resourcesBase as $ResourceBase){
			
			$resourceCount++;
			$resourceID = $resourcesBase[$resourceCount]["id"];
			//echo "resource id = " . $resourcesBase[$resourceCount]["id"] . "</br>";
			// resource title
			?>
			<div class="col-xs-12" id="colDivglobal">
			<div class="col-xs-1" id="colDiv">
			<div>
				<p class="text-center"><b><?= $this->clean($ResourceBase['name']) ?></b></br><?= $this->clean($ResourceBase['description']) ?></p>
			</div>
			</div>
			<div class="col-xs-11" id="colDiv">
				<!-- Content of each day -->
				<div class="row seven-cols">
					<?php 
					for ($d = 0 ; $d < 7 ; $d++){
						
						$idcss = "colDiv";
						if ($d == 0){
							$idcss = "colDivleft";
						}
						if ($d == 6){
							$idcss = "colDivright";
						}
						
						// day title
						$temp = explode("-", $mondayDate);
						$date_unix = mktime(0,0,0,$temp[1], $temp[2]+$d, $temp[0]);
						$dayStream = date("l", $date_unix);
						$monthStream = date("M", $date_unix);
						$dayNumStream = date("d", $date_unix);
						$sufixStream = date("S", $date_unix);
						
						$dayTitle = $dayStream . " " . $monthStream . ". " . $dayNumStream . $sufixStream;
						
						?>
						
						
						<div class="col-lg-1 col-md-3 col-sm-4 col-xs-6" id="<?= $idcss ?>">
						
						<div>
						<!-- Print the reservations for the given day -->
						<?php
						$temp = explode("-", $mondayDate);
						$date_unix = mktime(0,0,0,$temp[1], $temp[2]+$d, $temp[0]);
									
						$day_begin = $this->clean($resourcesInfo[$resourceCount]['day_begin']);
						$day_end = $this->clean($resourcesInfo[$resourceCount]['day_end']);
						$size_bloc_resa = $this->clean($resourcesInfo[$resourceCount]['size_bloc_resa']);
						$available_days = $this->clean($resourcesInfo[$resourceCount]['available_days']);
						$available_days = explode(",", $available_days);
						
						$isDayAvailable = false;
						if ($available_days[$d] == 1){
							$isDayAvailable = true;
						}
							
						// add here the reservations
						foreach ($calEntries as $entry){
							if ($entry["resource_id"] == $resourceID && $entry["start_time"] >= $date_unix && $entry["start_time"] <= $date_unix+86400){
								// draw entry
								$shortDescription = $entry['short_description'];
								if ($isProjectMode){
									$shortDescription = $moduleProject->getProjectName($entry['short_description']);
								}
								$text = date("H:i", $entry["start_time"]) . " - " . date("H:i", $entry["end_time"]) . "<br/>";
								$text .= $modelBookingSetting->getSummary($entry["recipient_fullname"], $entry['phone'],
										$shortDescription, $entry['full_description'], false);
								?>
								<div class="text-center" id="tcellResa" style="background-color:#<?=$entry["color"]?>;">
									<a class="text-center" id="resa_link" href="calendar/editreservation/r_<?= $entry['id'] ?>"><?=$text?></a>
								</div>
								<?php 
							}
						}
						
						// plus button
						?>
						<?php 
						if ($isDayAvailable){
							if ($isUserAuthorizedToBook[$resourceCount]){
								$dateString = date("Y-m-d", $date_unix);
								?>
								<div class="text-center">
								<a class="glyphicon glyphicon-plus" href="calendar/editreservation/t_<?= $dateString."_"."8"."_".$resourceID ?>"></a>
								</div>
								<?php 
							}
						}
						?>
						
						</div>
						</div>
					<?php	
					}	
					?>
				</div>
			</div>	
		  </div>
		<?php 	
		}
		?>
	</div>

<?php include "Modules/sygrrif/View/colorcodenavbar.php"; ?>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
