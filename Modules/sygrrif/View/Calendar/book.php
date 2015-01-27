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
$day_position = date("w", $time); // 0 for sunday, 6 for saturday
for ($p = 0 ; $p < count($day_position) ; $p++){
	if ($day_position[$p] == 0){
		$day_position[$p] = 7;
	}
}
?>
<b><?php echo $dayStream . ", " . $monthStream . " " .$dayNumStream. $sufixStream . " " .$yearStream  ?></b>
</div>


<div class="col-md-4 text-right">
<button type="button" class="btn btn-default active">Day</button>
<button type="button" onclick="location.href='calendar/bookweek'" class="btn btn-default ">Week</button>
<button type="button" onclick="location.href='calendar/bookweekarea'" class="btn btn-default ">Week Area</button>

</div>
</div>

<br></br>

<?php 
$day_begin = $this->clean($resourceInfo['day_begin']);
$day_end = $this->clean($resourceInfo['day_end']);
$size_bloc_resa = $this->clean($resourceInfo['size_bloc_resa']);
$available_days = $this->clean($resourceInfo['available_days']);
$available_days = explode(",", $available_days);

?>

<!-- hours column -->
<div class="col-xs-12">
<div class="col-xs-1" id="colDiv">

	<div id="tcelltop" style="height: 50px;">

	</div>
	<?php 
	// Hours
	for ($h = $day_begin ; $h < $day_end ; $h++){
		$heightCol = "0px";
		if ($size_bloc_resa == 900){
			$heightCol = "100px";
		}
		else if($size_bloc_resa == 1800){
			$heightCol = "50px";
		}
		else if($size_bloc_resa == 3600){
			$heightCol = "50px";
		}
		?>
	
		<div id="tcell" style="height: <?= $heightCol ?>;">
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
	$isAvailableDay = false;
	if ($available_days[$day_position-1] == 1){
		$isAvailableDay = true;
	}
	
	bookday($size_bloc_resa, $date_unix, $day_begin, $day_end, $calEntries, $isUserAuthorizedToBook, $isAvailableDay);
	?>
	
</div>

<?php include "Modules/sygrrif/View/colorcodenavbar.php"; ?>

</div>
<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
