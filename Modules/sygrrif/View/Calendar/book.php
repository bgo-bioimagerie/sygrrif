<?php $this->title = "SyGRRiF Booking"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

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
	background-color: #dfdfdf;
	-moz-border-radius: 9px;
	border-radius: 9px;
	border: 1px solid #f1f1f1;
}

</style>


</head>


<?php include "Modules/sygrrif/View/bookingnavbar.php"; ?>


<!-- Add the table title -->
<br></br>
<div class="col-md-8 col-md-offset-2">

<div class="col-md-4 col-md-offset-4">
<p>
Date: <?= $date ?>
</p>
</div>

<br></br>

<?php 
$day_begin = $resourceInfo['day_begin'];
$day_end = $resourceInfo['day_end'];
?>

<!-- hours column -->
<div class="col-lg-1" id="colDiv">

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
<div class="col-lg-11" id="colDiv">

	<div id="tcelltop" style="height: 50px;">
	<p class="text-center"><b><?= $this->clean($resourceBase['name']) ?></b></br><?= $this->clean($resourceBase['description']) ?></p>
	</div>

	<?php 
	// resa
	$caseTimeBegin = $date_unix + $day_begin*3600 - 1800;
	$caseTimeEnd = $date_unix + $day_begin*3600;
	$caseTimeLength = 1800;
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
				//$text = "<p><b>".$calEntry['recipient_id']."</b></p>"."<p><b>".$calEntry['short_description']."</b></p>";
				$text = "<p><b>".$calEntry['short_description']."</b></p>";
				?>
					<div class="text-center" id="tcellResa" style="height: <?=$pixelHeight?>px;">
					<a class="text-center" href="calendar/editreservation/r_<?= $calEntry['id'] ?>"><?=$text?></a>
					</div>
				<?php
				$h+= $blocNumber*0.5 - 0.5;
			}
		}
		if (!$foundStartEntry){
		?>
			<div class="text-center" id="tcell" style="height: 25px;">
			<a class="glyphicon glyphicon-plus" href="calendar/editreservation/t_<?= $h ?>"></a>
			</div>
		<?php 
		}	
	}
	?>


</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
