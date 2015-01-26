<?php 
function bookday($size_bloc_resa, $date_unix, $day_begin, $day_end, $calEntries, $isUserAuthorizedToBook, $isDayAvailable){
	
	$dateString = date("Y-m-d", $date_unix);
	$moduleProject = new Project();
	if ($size_bloc_resa == 900){
		// resa
		$caseTimeBegin = $date_unix + $day_begin*3600 - 900;
		$caseTimeEnd = $date_unix + $day_begin*3600;
		$caseTimeLength = 900;
		
		//echo "cal entries size = " . count($calEntries) . "--";
		//print_r($calEntries);
		$modelBookingSetting = new SyBookingSettings();
		for ($h = $day_begin ; $h < $day_end ; $h = $h+0.25){
				
			$caseTimeBegin = $date_unix + $h*3600;
			$caseTimeEnd = $date_unix + $h*3600 +900;
				
			$foundStartEntry = false;
			foreach ($calEntries as $calEntry){
				if ($calEntry['start_time'] >= $caseTimeBegin && $calEntry['start_time'] < $caseTimeEnd){
					// there is an entry in this half time
					$foundStartEntry = true;
					$blocNumber = ($calEntry['end_time'] - $calEntry['start_time'])/($caseTimeLength);
					$blocNumber = round($blocNumber); if ($blocNumber < 1){$blocNumber=1;}
					$pixelHeight = $blocNumber*25;
						
					$shortDescription = $moduleProject->getProjectName($calEntry['short_description']);
					$text = "";
					if ($blocNumber <= 2){
						$text = $modelBookingSetting->getSummary($calEntry["recipient_fullname"], $calEntry['phone'], $shortDescription, $calEntry['full_description'], true);
						//$text = "<b>User: </b>". $calEntry["recipient_fullname"] . ", <b>Phone:</b>".$calEntry['phone']. ", <b>Desc:</b> " .$calEntry['short_description']."";
					}
					else{
						$text = $modelBookingSetting->getSummary($calEntry["recipient_fullname"], $calEntry['phone'], $shortDescription, $calEntry['full_description'], false);
						//$text = $text = "<b>User: </b>". $calEntry["recipient_fullname"] . ", </br><b>Phone:</b>".$calEntry['phone']. ", </br><b>Desc:</b> " .$calEntry['short_description']."";
					}
					?>
								<div class="text-center" id="tcellResa" style="height: <?=$pixelHeight?>px; background-color:#<?=$calEntry["color"]?>;">
								<a class="text-center" id="resa_link" href="calendar/editreservation/r_<?= $calEntry['id'] ?>"><?=$text?></a>
								</div>
							<?php
							$h+= $blocNumber*0.25 - 0.25;
						}
					}
					if (!$foundStartEntry){
					?>
						<div class="text-center" id="tcell" style="height: 25px;">
						<?php if ($isDayAvailable){?>
						<?php if ($isUserAuthorizedToBook){
							$h2 = str_replace(".", "-", $h);?>
						<a class="glyphicon glyphicon-plus" href="calendar/editreservation/t_<?= $dateString."_".$h2 ?>"></a>
						<?php }}?>
						</div>
					<?php 
					}	
				}
	}
	elseif ($size_bloc_resa == 1800){
		// resa
		$caseTimeBegin = $date_unix + $day_begin*3600 - 1800;
		$caseTimeEnd = $date_unix + $day_begin*3600;
		$caseTimeLength = 1800;
		
		//echo "cal entries size = " . count($calEntries) . "--";
		//print_r($calEntries);
		$modelBookingSetting = new SyBookingSettings();
		for ($h = $day_begin ; $h < $day_end ; $h = $h+0.5){
			
			$caseTimeBegin = $date_unix + $h*3600;
			$caseTimeEnd = $date_unix + $h*3600 +1800;
			
			$foundStartEntry = false;
			foreach ($calEntries as $calEntry){
				if ($calEntry['start_time'] >= $caseTimeBegin && $calEntry['start_time'] < $caseTimeEnd){
					// there is an entry in this half time
					$foundStartEntry = true;
					$blocNumber = ($calEntry['end_time'] - $calEntry['start_time'])/($caseTimeLength);
					$blocNumber = round($blocNumber); if ($blocNumber < 1){$blocNumber=1;}
					$pixelHeight = $blocNumber*25;
					
					$shortDescription = $moduleProject->getProjectName($calEntry['short_description']);
					$text = "";
					if ($blocNumber <= 2){
						$text = $modelBookingSetting->getSummary($calEntry["recipient_fullname"], $calEntry['phone'], $shortDescription, $calEntry['full_description'], true);
						//$text = "<b>User: </b>". $calEntry["recipient_fullname"] . ", <b>Phone:</b>".$calEntry['phone']. ", <b>Desc:</b> " .$calEntry['short_description']."";
					}
					else{
						$text = $modelBookingSetting->getSummary($calEntry["recipient_fullname"], $calEntry['phone'], $shortDescription, $calEntry['full_description'], false);
						//$text = $text = "<b>User: </b>". $calEntry["recipient_fullname"] . ", </br><b>Phone:</b>".$calEntry['phone']. ", </br><b>Desc:</b> " .$calEntry['short_description']."";
					}	
					?>
						<div class="text-center" id="tcellResa" style="height: <?=$pixelHeight?>px; background-color:#<?=$calEntry["color"]?>;">
						<a class="text-center" id="resa_link" href="calendar/editreservation/r_<?= $calEntry['id'] ?>"><?=$text?></a>
						</div>
					<?php
					$h+= $blocNumber*0.5 - 0.5;
				}
			}
			if (!$foundStartEntry){
			?>
				<div class="text-center" id="tcell" style="height: 25px;">
				<?php if ($isDayAvailable){?>
				<?php if ($isUserAuthorizedToBook){
				$h2 = str_replace(".", "-", $h);?>
				<a class="glyphicon glyphicon-plus" href="calendar/editreservation/t_<?= $dateString."_".$h2 ?>"></a>
				<?php }}?>
				</div>
			<?php 
			}	
		}
	}
	elseif ($size_bloc_resa == 3600){
		// resa
		$caseTimeBegin = $date_unix + $day_begin*3600 - 3600;
		$caseTimeEnd = $date_unix + $day_begin*3600;
		$caseTimeLength = 3600;
		
		//echo "cal entries size = " . count($calEntries) . "--";
		//print_r($calEntries);
		$modelBookingSetting = new SyBookingSettings();
		for ($h = $day_begin ; $h < $day_end ; $h = $h+1){
				
			$caseTimeBegin = $date_unix + $h*3600;
			$caseTimeEnd = $date_unix + $h*3600 +3600;
				
			$foundStartEntry = false;
			foreach ($calEntries as $calEntry){
				if ($calEntry['start_time'] >= $caseTimeBegin && $calEntry['start_time'] < $caseTimeEnd){
					// there is an entry in this half time
					$foundStartEntry = true;
					$blocNumber = ($calEntry['end_time'] - $calEntry['start_time'])/($caseTimeLength);
					$blocNumber = round($blocNumber); if ($blocNumber < 1){$blocNumber=1;}
					$pixelHeight = $blocNumber*50;
						
					$shortDescription = $moduleProject->getProjectName($calEntry['short_description']);
					$text = "";
					if ($blocNumber <= 2){
						$text = $modelBookingSetting->getSummary($calEntry["recipient_fullname"], $calEntry['phone'], $shortDescription, $calEntry['full_description'], true);
						//$text = "<b>User: </b>". $calEntry["recipient_fullname"] . ", <b>Phone:</b>".$calEntry['phone']. ", <b>Desc:</b> " .$calEntry['short_description']."";
					}
					else{
						$text = $modelBookingSetting->getSummary($calEntry["recipient_fullname"], $calEntry['phone'], $shortDescription, $calEntry['full_description'], false);
						//$text = $text = "<b>User: </b>". $calEntry["recipient_fullname"] . ", </br><b>Phone:</b>".$calEntry['phone']. ", </br><b>Desc:</b> " .$calEntry['short_description']."";
					}
					?>
								<div class="text-center" id="tcellResa" style="height: <?=$pixelHeight?>px; background-color:#<?=$calEntry["color"]?>;">
								<a class="text-center" id="resa_link" href="calendar/editreservation/r_<?= $calEntry['id'] ?>"><?=$text?></a>
								</div>
							<?php
							$h+= $blocNumber*1 - 1;
						}
					}
					if (!$foundStartEntry){
					?>
						<div class="text-center" id="tcell" style="height: 50px;">
						<?php if ($isDayAvailable){?>
						<?php if ($isUserAuthorizedToBook){
						$h2 = str_replace(".", "-", $h);?>
						<a class="glyphicon glyphicon-plus" href="calendar/editreservation/t_<?= $dateString."_".$h2 ?>"></a>
						<?php }}?>
						</div>
					<?php 
					}	
				}
	}
	}
	?>
