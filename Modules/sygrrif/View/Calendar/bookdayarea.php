<?php $this->title = "SyGRRiF Booking"?>

<?php echo $navBar?>
<?php 
require_once 'Modules/sygrrif/Model/SyBookingSettings.php';
require_once 'Modules/sygrrif/View/Calendar/bookfunction.php';
?>


<?php 
$dayWidth = 100/count($resourcesBase);
?>

<head>
 
<style>

a{
	width: 100%;
	color: <?= $agendaStyle["header_background"] ?>;
}

#tcell{
	border-left: 1px solid #d1d1d1;
	border-right: 1px solid #d1d1d1;
	border-bottom: 1px solid #d1d1d1;
}

#tcelltop{
	border: 1px solid #d1d1d1;
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
	-moz-border-radius: 0px;
	border-radius: 0px;
	border: 1px solid #f1f1f1;
}

#resa_link{
	font-family: Arial;
	font-size: 12px;
	line-height: 12px;
	letter-spacing: 1px;
	font-weight: normal;
	color: #000;
}

@media (min-width: 1200px) {
  .seven-cols .col-md-1,
  .seven-cols .col-sm-1,
  .seven-cols .col-lg-1 {
    width: <?=$dayWidth?>%;
    *width: <?=$dayWidth?>%;
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

<div class="col-lg-12">

<div class="col-md-8 text-left">
<button type="submit" class="btn btn-default" onclick="location.href='calendar/bookdayarea/daybefore'"> &lt; </button>
<button type="submit" class="btn btn-default" onclick="location.href='calendar/bookdayarea/dayafter'"> > </button>
<button type="submit" class="btn btn-default" onclick="location.href='calendar/bookdayarea/today'"><?= SyTranslator::Today($lang) ?></button>
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
<b><?= SyTranslator::DateFromTime($time, $lang) ?></b>
</div>


<div class="col-md-4 text-right">
<button type="button" onclick="location.href='calendar/bookday'" class="btn btn-default"><?= SyTranslator::Day($lang) ?></button>
<button type="button" class="btn btn-default active"><?= SyTranslator::Day_Area($lang) ?></button>
<button type="button" onclick="location.href='calendar/bookweek'" class="btn btn-default "><?= SyTranslator::Week($lang) ?></button>
<button type="button" onclick="location.href='calendar/bookweekarea'" class="btn btn-default "><?= SyTranslator::Week_Area($lang) ?></button>
<button type="button" onclick="location.href='calendar/bookmonth'" class="btn btn-default"><?= SyTranslator::Month($lang) ?></button>
</div>
</div>

<br></br>

<?php 
$day_begin = $this->clean($resourcesInfo[0]['day_begin']);
$day_end = $this->clean($resourcesInfo[0]['day_end']);
$size_bloc_resa = $this->clean($resourcesInfo[0]['size_bloc_resa']);


?>

<!-- hours column -->
<div class="col-xs-12">
<div class="col-xs-1" id="colDiv">

	<div id="tcelltop" style="height: <?=$agendaStyle["header_height"]?>px; background-color:<?= $agendaStyle["header_background"]?>;">

	</div>
	<?php 
	// Hours
	for ($h = $day_begin ; $h < $day_end ; $h++){
		$heightCol = "0px";
		if ($size_bloc_resa == 900){
			$heightCol = 4*$agendaStyle["line_height"] . "px";
		}
		else if($size_bloc_resa == 1800){
			$heightCol = 2*$agendaStyle["line_height"] . "px";;
		}
		else if($size_bloc_resa == 3600){
			$heightCol = $agendaStyle["line_height"] . "px";;
		}
		?>
	
		<div id="tcell" style="height: <?= $heightCol ?>; background-color: <?= $agendaStyle["header_background"]?>; color: <?= $agendaStyle["header_color"]?>; font-size: <?= $agendaStyle["header_font_size"]?>px">
		<?=$h?>:00
		</div>
	<?php 	
	}
	?>	
</div>	
	
<!-- hours reservation -->	
<div class="col-xs-11" id="colDiv">
	
	<div class="row seven-cols" id="colDiv">
	<?php 
	for($r = 0 ; $r < count($resourcesBase) ; $r++){
	?>
	
	<div class="col-lg-1 col-md-3 col-sm-4 col-xs-6" id="colDiv">

	<div id="tcelltop" style="height: <?=$agendaStyle["header_height"]?>px; background-color: <?= $agendaStyle["header_background"]?>; color: <?= $agendaStyle["header_color"]?>; font-size: <?= $agendaStyle["header_font_size"]?>px">
	<p class="text-center"><b><?= $this->clean($resourcesBase[$r]['name']) ?></b><br/><?= $this->clean($resourcesBase[$r]['description']) ?></p>
	</div>

	<?php 
	
	$available_days = $this->clean($resourcesInfo[$r]['available_days']);
	$available_days = explode(",", $available_days);
	
	$curentDay = date("w", $date_unix);
	$curentDay++;
	//echo "curent day = " . $curentDay;
	
	if ($curentDay == 8){
		$curentDay = 0;
	}
	
	
	$isAvailableDay = false;
	if ($available_days[$curentDay] == 1){
		$isAvailableDay = true;
	}
	
	bookday($size_bloc_resa, $date_unix, $day_begin, $day_end, $calEntries[$r], $isUserAuthorizedToBook[$r], $isAvailableDay, $agendaStyle, $resourcesBase[$r]["id"]);
	?>
	
	</div>
	<?php 
	}
	?>
</div>
</div>

<div class="col-xs-12">

<?php include "Modules/sygrrif/View/colorcodenavbar.php"; ?>

</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
