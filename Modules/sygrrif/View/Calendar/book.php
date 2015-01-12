<?php $this->title = "SyGRRiF Booking"?>

<?php echo $navBar?>
<?php require_once 'Modules/sygrrif/Model/SyBookingSettings.php';?>

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

#tcellResa{
	-moz-border-radius: 9px;
	border-radius: 9px;
	border: 1px solid #f1f1f1;
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

<div class="col-lg-12">

<?php include "Modules/sygrrif/View/colorcodenavbar.php"; ?>
<div class="col-lg-10">

<div class="col-lg-12">

<div class="col-md-8 text-left">
<button type="submit" class="btn btn-default" onclick="location.href='calendar/book/daybefore'"><</button>
<button type="submit" class="btn btn-default" onclick="location.href='calendar/book/dayafter'">></button>
<button type="submit" class="btn btn-default" onclick="location.href='calendar/book/today'">Today</button>
<?php 
$d = explode("-", $date);
$time = mktime(0,0,0,$d[1],$d[2],$d[0]);
$dayStream = date("l", $time);
$monthStream = date("F", $time);
$dayNumStream = date("d", $time);
$yearStream = date("Y", $time);
$sufixStream = date("S", $time);

?>
<b><?php echo $dayStream . ", " . $monthStream . " " .$dayNumStream. $sufixStream . " " .$yearStream  ?></b>
</div>


<div class="col-md-4 text-right">
<button type="button" class="btn btn-default active">Day</button>
<button type="button" class="btn btn-default ">Week</button>
<button type="button" class="btn btn-default">Month</button>

</div>
</div>

<br></br>

<?php 
$day_begin = $resourceInfo['day_begin'];
$day_end = $resourceInfo['day_end'];
?>

<!-- hours column -->
<div class="col-xs-12">
<div class="col-xs-1" id="colDiv">

	<div id="tcelltop" style="height: 50px;">

	</div>
	<?php 
	// Hours
	for ($h = $day_begin ; $h < $day_end ; $h++){
	?>
		<div id="tcell" style="height: 50px;">
		<?=$h?>:00
		</div>
	<?php 	
	}
	?>	
</div>	
	
<!-- hours reservation -->	
<div class="col-xs-11" id="colDiv">

	<div id="tcelltop" style="height: 50px;">
	<p class="text-center"><b><?= $this->clean($resourceBase['name']) ?></b></br><?= $this->clean($resourceBase['description']) ?></p>
	</div>

	<?php 
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
				
				$text = "";
				if ($blocNumber <= 2){
					$text = $modelBookingSetting->getSummary($calEntry["recipient_fullname"], $calEntry['phone'], $calEntry['short_description'], $calEntry['full_description'], true);
					//$text = "<b>User: </b>". $calEntry["recipient_fullname"] . ", <b>Phone:</b>".$calEntry['phone']. ", <b>Desc:</b> " .$calEntry['short_description']."";
				}
				else{
					$text = $modelBookingSetting->getSummary($calEntry["recipient_fullname"], $calEntry['phone'], $calEntry['short_description'], $calEntry['full_description'], false);
					//$text = $text = "<b>User: </b>". $calEntry["recipient_fullname"] . ", </br><b>Phone:</b>".$calEntry['phone']. ", </br><b>Desc:</b> " .$calEntry['short_description']."";
				}	
				?>
					<div class="text-center" id="tcellResa" style="height: <?=$pixelHeight?>px; background-color:#<?=$calEntry["color"]?>;">
					<a class="text-center" href="calendar/editreservation/r_<?= $calEntry['id'] ?>"><?=$text?></a>
					</div>
				<?php
				$h+= $blocNumber*0.5 - 0.5;
			}
		}
		if (!$foundStartEntry){
		?>
			<div class="text-center" id="tcell" style="height: 25px;">
			<?php if ($isUserAuthorizedToBook){?>
			<a class="glyphicon glyphicon-plus" href="calendar/editreservation/t_<?= $h ?>"></a>
			<?php }?>
			</div>
		<?php 
		}	
	}
	?>


</div>
</div>
</div>

</div>
<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
