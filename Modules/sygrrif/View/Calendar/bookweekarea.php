<?php $this->title = "SyGRRiF Booking"?>

<?php echo $navBar?>
<?php

require_once 'Modules/sygrrif/Model/SyBookingSettings.php';
?>

<head>

<style>
.row {
	display: table;
	width: 100%;
	height:100%;
	border-collapse: collapse;
	overflow:hidden;
}

.row-cell{
 	margin-bottom: -99999px;
    padding-bottom: 99999px;
}

#tcellResa {
	-moz-border-radius: 9px;
	border-radius: 9px;
	border: 1px solid #ffffff;
	font-family: Arial;
	font-size: 9px;
	line-height: 9px;
	letter-spacing: 1px;
	font-weight: normal;
	padding:0px;
    margin:0px;
}

#resa_link {
	font-family: Arial;
	font-size: 9px;
	line-height: 9px;
	letter-spacing: 1px;
	font-weight: normal;
}

</style>
</head>


<?php include "Modules/sygrrif/View/bookingnavbar.php"; ?>


<!-- Add the table title -->
<br></br>

<div class="col-lg-12">
	<div class="col-lg-10 col-lg-offset-1">
		<?php
		
		if ($message != "") {
			if (strpos ( $message, "Error" ) === false) {
				?>
					<div class="alert alert-success text-center">	
				<?php
			} else {
				?>
			 		<div class="alert alert-danger text-center">
				<?php
			}
			?>
	    	<p><?= $message ?></p>
			</div>
		<?php 
		} 
		?>
	</div>
</div>

<div class="container">
<div class="col-lg-11 col-lg-offset-1">

	<div class="col-md-8 text-left">
		<button type="submit" class="btn btn-default"
			onclick="location.href='calendar/bookweekarea/dayweekbefore'">&lt;</button>
		<button type="submit" class="btn btn-default"
			onclick="location.href='calendar/bookweekarea/dayweekafter'">></button>
		<button type="submit" class="btn btn-default"
			onclick="location.href='calendar/bookweekarea/thisWeek'"><?= SyTranslator::This_week($lang) ?></button>
		<?php
		$d = explode ( "-", $mondayDate );
		$time = mktime ( 0, 0, 0, $d [1], $d [2], $d [0] );
		$dayStream = date ( "l", $time );
		$monthStream = date ( "F", $time );
		$dayNumStream = date ( "d", $time );
		$yearStream = date ( "Y", $time );
		$sufixStream = date ( "S", $time );
		
		?>
		<b><?= SyTranslator::DateFromTime($time, $lang) ?>  -  </b>
		<?php
		$d = explode ( "-", $sundayDate );
		$time = mktime ( 0, 0, 0, $d [1], $d [2], $d [0] );
		$dayStream = date ( "l", $time );
		$monthStream = date ( "F", $time );
		$dayNumStream = date ( "d", $time );
		$yearStream = date ( "Y", $time );
		$sufixStream = date ( "S", $time );
		
		?>
		<b><?= SyTranslator::DateFromTime($time, $lang) ?> </b>

	</div>

	<div class="col-md-4 text-right">
		<button type="button" onclick="location.href='calendar/bookday'"
			class="btn btn-default"><?= SyTranslator::Day($lang) ?></button>
		<button type="button" onclick="location.href='calendar/bookweek'"
			class="btn btn-default "><?= SyTranslator::Week($lang) ?></button>
		<button type="button" class="btn btn-default active"><?= SyTranslator::Week_Area($lang) ?></button>
	</div>
</div>
</div>
<br></br>

<!-- hours reservation -->

<div class="container">
<div class="col-lg-12" id="colDiv0">

	<!--  Area title -->
	
	<div class="col-lg-2" id="colDiv0">
	</div>
	<div class="col-lg-8" id="colDiv0">
		<div style="height: 50px;">
			<p class="text-center">
				<b><?= $this->clean($areaname) ?></b>
			</p>
		</div>
	</div>
</div>	
</div>

<div class="">
<div class=row-same-height">
	<?php
	$resourceCount = - 1;
	$modelBookingSetting = new SyBookingSettings ();
	$moduleProject = new Project ();
	$ModulesManagerModel = new ModulesManager ();
	$isProjectMode = $ModulesManagerModel->getDataMenusUserType ( "projects" );
	
	for ($i=-1 ; $i < count($resourcesBase) ; $i++){
	//foreach ( $resourcesBase as $ResourceBase ) {
		
		$resourceID = -1;
		if( $i >=0 ){
			$resourceID = $resourcesBase [$i] ["id"];
		}
		// echo "resource id = " . $resourcesBase[$resourceCount]["id"] . "</br>";
		// resource title
		?>
		
		<?php 
			$styleLine = "";
			if (!($i%2)){
				$styleLine = "style=\"background-color:#f1f1f1; border-right: 1px solid #a1a1a1;\"";
			}
			else{
				$styleLine = "style=\"background-color:#ffffff; border-right: 1px solid #a1a1a1;\"";
			}
			?>
			
			<div class="row" > <!-- id="colDivglobal" -->
			
			<div class="col-lg-12" id="colDiv">
				<!-- Content of each day -->
				<div class="">
				
					<!-- Title -->
					<?php 
					if ( $i > -1){
					?>
					<div class="col-lg-1 col-lg-offset-2 row-cell" <?= $styleLine ?> >
					<p>
					<b><?= $this->clean($resourcesBase[$i]['name']) ?></b>
					</p>
					</div>
					<?php	
					}
					else{
						?>
						<div class="col-lg-1 col-lg-offset-2 row-cell" <?= $styleLine ?>>
						<p> </p>
						</div>
						<?php	
					}
					?>	
				
					<?php
					
					for($d = 0; $d < 7; $d ++) {
						?>
						<?php 
						if ( $i == -1 ){
							// day title
							$temp = explode ( "-", $mondayDate );
							$date_unix = mktime ( 0, 0, 0, $temp [1], $temp [2] + $d, $temp [0] );
							$dayStream = date ( "l", $date_unix );
							$monthStream = date ( "M", $date_unix );
							$dayNumStream = date ( "d", $date_unix );
							$sufixStream = date ( "S", $date_unix );
								
							$dayTitle = SyTranslator::DateFromTime ( $date_unix, $lang );
							
							
						?>
							<div class="col-lg-1 row-cell" <?= $styleLine ?>>

								<div id="tcelltop" style="height: 60px;" class="text-center">
									<p class="text-center">
									<b> <?= $dayTitle ?> </b>
									</p>
								</div>
							</div>
						<?php
						}
						else{
						?>
							<div class="col-lg-1 row-cell" <?= $styleLine ?>>
								<!-- Print the reservations for the given day -->
							<?php
							$resourceCount = $i;
							$temp = explode ( "-", $mondayDate );
							$date_unix = mktime ( 0, 0, 0, $temp [1], $temp [2] + $d, $temp [0] );
							
							$day_begin = $this->clean ( $resourcesInfo [$resourceCount] ['day_begin'] );
							$day_end = $this->clean ( $resourcesInfo [$resourceCount] ['day_end'] );
							$size_bloc_resa = $this->clean ( $resourcesInfo [$resourceCount] ['size_bloc_resa'] );
							$available_days = $this->clean ( $resourcesInfo [$resourceCount] ['available_days'] );
							$available_days = explode ( ",", $available_days );
							
							$isDayAvailable = false;
							if ($available_days [$d] == 1) {
								$isDayAvailable = true;
							}
				
							// add here the reservations
							$foundEntry = false;
							foreach ( $calEntries as $entry ) {
								
								if($entry ["resource_id"] == $resourceID && $entry['start_time']<=$date_unix && $entry['end_time'] >= $date_unix){
										$foundEntry = true;
										// draw entry
										$shortDescription = $entry ['short_description'];
										if ($isProjectMode) {
											$shortDescription = $moduleProject->getProjectName ( $entry ['short_description'] );
										}
										
										$txtEndTime = date ( "H:i", $entry ["end_time"] );
										if (  $entry['end_time'] - $date_unix > 3600*24){
											$txtEndTime = "23:59";
										}
										
										$text = "00:00". " - " . $txtEndTime . "<br />";
										$text .= $modelBookingSetting->getSummary ( $entry ["recipient_fullname"], $entry ['phone'], $shortDescription, $entry ['full_description'], false );
										?>
										<div class="text-center" id="tcellResa" style="background-color:#<?=$entry['color']?>;"> 
											<a class="text-center" id="resa_link"href="calendar/editreservation/r_<?= $entry['id'] ?>">
												<?=$text?>
											</a>
										</div>
										<?php
								}
								
								if ($entry ["resource_id"] == $resourceID && $entry ["start_time"] >= $date_unix && $entry ["start_time"] <= $date_unix + 86400) {
									$foundEntry = true;
									// draw entry
									$shortDescription = $entry ['short_description'];
									if ($isProjectMode) {
										$shortDescription = $moduleProject->getProjectName ( $entry ['short_description'] );
									}
									
									$txtEndTime = date ( "H:i", $entry ["end_time"] );
									if (date ( "d", $entry ["end_time"] ) > date ( "d", $date_unix )){
										$txtEndTime = "23:59";
									}
									
									$text = date ( "H:i", $entry ["start_time"] ) . " - " . $txtEndTime . "<br />";
									$text .= $modelBookingSetting->getSummary ( $entry ["recipient_fullname"], $entry ['phone'], $shortDescription, $entry ['full_description'], false );
									?>
									<div class="text-center" id="tcellResa" style="background-color:#<?=$entry['color']?>;"> 
											<a class="text-center" id="resa_link"href="calendar/editreservation/r_<?= $entry['id'] ?>">
											<?=$text?>
											</a>
									</div>
									<?php
								}
							}
							// plus button
							if ($isDayAvailable) {
								if ($isUserAuthorizedToBook [$resourceCount]) {
									$dateString = date ( "Y-m-d", $date_unix );
									
									$styleTxt = "";
									if (!$foundEntry){
										$styleTxt = "style=\"height: 60px;\"";
									}
									?>
									<div class="text-center">
										<a class="glyphicon glyphicon-plus"
											href="calendar/editreservation/t_<?= $dateString."_"."8"."_".$resourceID ?>">
										</a>
									</div>
									<?php
								}
								else{
								?>
								<div class="text-center">
								<p></p>
								</div>
								<?php 	
								}
							}
							else{
								?>
								<div class="text-center">
								<p></p>
								</div>
								<?php 
							}
							?>
							</div>
					<?php
						} 
					}
					?>
				</div> <!--  seven-cols -->
			</div> <!-- col11 days --> 
			</div> 
	<?php
	}
	?>
</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
