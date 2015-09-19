<?php $this->title = "SyGRRiF Booking"?>

<?php echo $navBar?>
<?php 
require_once 'Modules/sygrrif/Model/SyBookingSettings.php';
require_once 'Modules/sygrrif/View/Calendar/bookfunction.php';
		
$available_days = $this->clean($resourceInfo['available_days']);
$available_days = explode(",", $available_days);

$dayWidth = 0;
for($c = 0 ; $c < count($available_days) ; $c++){
	if ($available_days[$c] > 0){
		$dayWidth++;
	}
}

$dayWidth = 100/$dayWidth;
?>

<head>

<style>

a{
	width: 100%;
	color: <?= "#".$agendaStyle["header_background"] ?>;
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
	border: 1px solid #d1d1d1;
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
<button type="button" onclick="location.href='calendar/bookdayarea'" class="btn btn-default"><?= SyTranslator::Day_Area($lang) ?></button>
<button type="button" class="btn btn-default active"><?= SyTranslator::Week($lang) ?></button>
<button type="button" onclick="location.href='calendar/bookweekarea'" class="btn btn-default "><?= SyTranslator::Week_Area($lang) ?></button>
<button type="button" onclick="location.href='calendar/bookmonth'" class="btn btn-default"><?= SyTranslator::Month($lang) ?></button>
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

<?php 
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
	<div id="tcelltop" style="height: <?= $agendaStyle["line_height"]+50 ?>px; background-color:<?= "#" . $agendaStyle["header_background"]?>; color: <?= "#" . $agendaStyle["header_color"]?>"></div> <!-- For the resource title space -->
	
	<?php 
	// Hours
	for ($h = $day_begin ; $h < $day_end ; $h++){

		?>
	
		<div id="tcell" style="height: <?= $heightCol ?>; background-color: <?= "#" . $agendaStyle["header_background"]?>; color: <?= "#" . $agendaStyle["header_color"]?>; font-size: <?= $agendaStyle["header_font_size"]?>px">
		<?=$h?>:00
		</div>
	<?php 	
	}
	?>	
</div>	
	
<!-- hours reservation -->
<div class="col-xs-11" id="colDiv">

	<div id="tcelltop" style="height: <?= $agendaStyle["line_height"] ?>; background-color:<?= "#" . $agendaStyle["header_background"]?>; color: <?= "#" . $agendaStyle["header_color"]?>">
	<p class="text-center"><b><?= $this->clean($resourceBase['name']) ?></b></br><?= $this->clean($resourceBase['description']) ?></p>
	</div>

	
	<div class="row seven-cols">
	
	<?php 
	for ($d = 0 ; $d < 7 ; $d++){
		
		// test if the day is available
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
			
			<div id="tcelltop" style="height: 50px; background-color:<?= "#" . $agendaStyle["header_background"]?>; color: <?= "#" . $agendaStyle["header_color"]?>">
			<p class="text-center"><b> <?= $dayTitle ?></b> </p>
			</div>
			
			<?php 
			bookday($size_bloc_resa, $date_unix, $day_begin, $day_end, $calEntries, $isUserAuthorizedToBook, $isDayAvailable, $agendaStyle);
			?>
			
			</div>
				<?php
		} 
	}
	?>
	</div>
	
</div>

<div class="col-xs-12">

<?php include "Modules/sygrrif/View/colorcodenavbar.php"; ?>
</div>

</div>
<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
