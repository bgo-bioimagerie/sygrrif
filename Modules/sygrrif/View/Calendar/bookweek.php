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
	padding:0px;
    margin:0px;
    position:relative;
}

#colDivleft{
	padding-right:0px;
	margin-right:0px;
	position:relative;
}

#colDivright{
	padding-left:0px;
	margin-left:0px;
	position:relative;
}


#tcellResa{
	-moz-border-radius: 9px;
	border-radius: 9px;
	border: 1px solid #f1f1f1;
	
}

#resa_link{
	font-family: Arial;
	font-size: 10px;
	line-height: 9px;
	letter-spacing: 1px;
	font-weight: normal;
	color: #002070;
	font-weight : bold;

}

@media (min-width: 1200px) {
  .seven-cols .col-md-1,
  .seven-cols .col-sm-1,
  .seven-cols .col-lg-1 {
    width: 20%;
    *width: 20%;
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
	<?php if ($message != ""){ 
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
	<?php } ?>

</div>
</div>

<div class="col-lg-12">

<div class="col-md-8 text-left">
<button type="submit" class="btn btn-default" onclick="location.href='calendar/bookweek/dayweekbefore'">&lt;</button>
<button type="submit" class="btn btn-default" onclick="location.href='calendar/bookweek/dayweekafter'">></button>
<button type="submit" class="btn btn-default" onclick="location.href='calendar/bookweek/thisWeek'"><?= SyTranslator::This_week($lang) ?></button>
<?php 
$d = explode("-", $mondayDate);
$time = mktime(0,0,0,$d[1],$d[2],$d[0]);
$dayStream = date("l", $time);
$monthStream = date("F", $time);
$dayNumStream = date("d", $time);
$yearStream = date("Y", $time);
$sufixStream = date("S", $time);

?>
<b> <?= SyTranslator::DateFromTime($time, $lang) ?> -  </b>
<?php 
$d = explode("-", $sundayDate);
$time = mktime(0,0,0,$d[1],$d[2],$d[0]);
$dayStream = date("l", $time);
$monthStream = date("F", $time);
$dayNumStream = date("d", $time);
$yearStream = date("Y", $time);
$sufixStream = date("S", $time);

?>
<b><?= SyTranslator::DateFromTime($time, $lang) ?> </b>

</div>


<div class="col-md-4 text-right">
<button type="button" onclick="location.href='calendar/bookday'" class="btn btn-default"><?= SyTranslator::Day($lang) ?></button>
<button type="button" class="btn btn-default active"><?= SyTranslator::Week($lang) ?></button>
<button type="button" onclick="location.href='calendar/bookweekarea'" class="btn btn-default "><?= SyTranslator::Week_Area($lang) ?></button>
<button type="button" onclick="location.href='calendar/bookmonth/thisMonth'" class="btn btn-default"><?= SyTranslator::Month($lang) ?></button>
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

	<div id="tcelltop" style="height: 100px;"></div> <!-- For the resource title space -->
	
	<?php 
	// Hours
	for ($h = $day_begin ; $h < $day_end ; $h++){
		$heightCol = "0px";
		if ($size_bloc_resa == 900){
			$heightCol = "140px";
		}
		else if($size_bloc_resa == 1800){
			$heightCol = "140px";
		}
		else if($size_bloc_resa == 3600){
			$heightCol = "140px";
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

	
	<div class="row seven-cols">
	
	<?php 
	for ($d = 0 ; $d < 7 ; $d++){
	$isDayAvailable = false;
		if ($available_days[$d] == 1){
			$isDayAvailable = true;
		
		
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
		
		$dayTitle = SyTranslator::DateFromTime($date_unix, $lang);
		//$dayTitle = $dayStream . " " . $monthStream . ". " . $dayNumStream . $sufixStream;
		
		?>
		
		
		<div class="col-lg-1 col-md-3 col-sm-4 col-xs-6" id="<?= $idcss ?>">
		
		<div id="tcelltop" style="height: 50px;">
		<p class="text-center"><b> <?= $dayTitle ?></b> </p>
		</div>
		
		<?php 
		// test if the day is available
		
		
		bookday($size_bloc_resa, $date_unix, $day_begin, $day_end, $calEntries, $calRes, $isUserAuthorizedToBook, $isDayAvailable);
		
		
		?>
		
		</div>
			<?php 
		}
	}
	?>
	</div>
	
</div>

<?php include "Modules/sygrrif/View/colorcodenavbar.php"; ?>

</div>
<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
