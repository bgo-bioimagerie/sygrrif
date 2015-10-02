<?php $this->title = "SyGRRiF statisics" ?>

<?php echo $navBar ?>

<head>
    <style>
    #camembert-area{
    	border: 1px dashed #000;
    	margin-top: 25px;
    }
    #graph-area{
    	border: 1px dashed #000;
    	margin-top: 25px;
    }
    </style> 
         
</head>

<?php include "Modules/sygrrif/View/navbar.php"; ?>



<!-- -------------------------------------------- -->
<!-- Plot the curve number reservations in a year -->
<!-- -------------------------------------------- -->
<?php
$titre = '<text x="375" y="30" fill="black" stroke-width="0px" stroke="black" font-size="15px" text-anchor="middle">' . SyTranslator::Annual_review_of_the_number_of_reservations_of($lang) . Configuration::get("name") . '</text>';
$stat = '<text x="670" y="110" fill="black" stroke-width="0px" stroke="black" font-size="15px" text-anchor="start">' . SyTranslator::Year($lang) . ": " . $annee . '</text>';
$stat .= '<text x="670" y="130" fill="black" stroke-width="0px" stroke="black" font-size="15px" text-anchor="start">' . SyTranslator::Reservation_number($lang) . ": " . $numTotal . '</text>';

$m = max ( $graph );
if ($m == 0) {
	$m = 1;
}
$inc = 250 / $m; // incrément selon l'axe y
$aff = ceil ( $m / 10 );

$i = 0;
$igrec = 300;
$axeY = '';
while ( $igrec > 50 ) {
	$igrec = round ( 300 - $i * $aff * $inc );
	$val = $aff * $i;
	$axeY .= '<text x="90" y="' . $igrec . '" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="end" baseline-shift="-0.5ex">' . $val . '</text>';
	$i ++;
}

$path = "M";
$points = '';
$courbe = '';
for($i = 1; $i <= 12; $i ++) {
	$x = 100 + ($i - 1) * 50;
	$y = round ( 300 - ($graph [$i] * $inc) );
	if ($i != 1) {
		$path .= " L";
	}
	$path .= " " . $x . " " . $y;
	$points .= '<circle cx="' . $x . '" cy="' . $y . '" r="3" fill="black" stroke-width="3" stroke="black"/>';
}

$courbe .= '<path d="' . $path . '" fill="none" stroke-width="1px" stroke="red"/>';

?>

<div class="row">
<div class='col-md-9 col-md-offset-1 text-center'id="graph-area">
		<?php
		$gAnnee = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xml="fr" width="950" height="360">';
		$gAnnee .= '<g><rect x="0" y="0" width="950" height="360" style="fill:white;stroke:black;stroke-width:0"/></g>';
		$gAnnee .= '<g><rect x="100" y="50" width="550" height="250" style="fill:#dfdfdf;stroke:black;stroke-width:2"/></g>';
		$gAnnee .= '<g>';
		$gAnnee .= $titre;
		$gAnnee .= $stat;
		$gAnnee .= '</g>';
		$gAnnee .= '<g>';
		$gAnnee .= '<text x="375" y="350" fill="black" stroke-width="0px" stroke="black" font-size="15px" text-anchor="middle">'. SyTranslator::Year($lang) . " " .  $annee . '</text>';
		$gAnnee .= '<text x="100" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">'. SyTranslator::Jan($lang). '</text>';
		$gAnnee .= '<text x="150" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">'. SyTranslator::Feb($lang). '</text>';
		$gAnnee .= '<text x="200" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">'. SyTranslator::Mar($lang). '</text>';
		$gAnnee .= '<text x="250" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">'. SyTranslator::Apr($lang). '</text>';
		$gAnnee .= '<text x="300" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">'. SyTranslator::May($lang). '</text>';
		$gAnnee .= '<text x="350" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">'. SyTranslator::Jun($lang). '</text>';
		$gAnnee .= '<text x="400" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">'. SyTranslator::July($lang). '</text>';
		$gAnnee .= '<text x="450" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">'. SyTranslator::Aug($lang). '</text>';
		$gAnnee .= '<text x="500" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">'. SyTranslator::Sept($lang). '</text>';
		$gAnnee .= '<text x="550" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">'. SyTranslator::Oct($lang). '</text>';
		$gAnnee .= '<text x="600" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">'. SyTranslator::Nov($lang). '</text>';
		$gAnnee .= '<text x="650" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">'. SyTranslator::Dec($lang). '</text>';
		$gAnnee .= '</g>';
		$gAnnee .= '<g>';
		$gAnnee .= '<text x="60" y="175" fill="black" stroke-width="0px" stroke="black" font-size="15px" text-anchor="middle" baseline-shift="-0.5ex" transform="rotate(-90,60,175)"> '. SyTranslator::Reservation_number($lang) .'</text>';
		$gAnnee .= $axeY;
		$gAnnee .= '</g>';
		$gAnnee .= $points;
		$gAnnee .= $courbe;
		$gAnnee .= '</svg>';
		
		echo $gAnnee;
		
		if (Configuration::get("saveImages") == "enable"){
			$nameFile = "data/temp/bilan_resaSVG.svg";
			$openFile = fopen($nameFile,"w");
			$toWrite = $gAnnee;
			fwrite($openFile, $toWrite);
			fclose($openFile);
			
			exec('sudo /usr/bin/inkscape -D data/temp/bilan_resaSVG.svg -e data/temp/bilan_resaJPG.jpg -b "#ffffff" -h800');
		}
		?>
	</div>
	<?php if (Configuration::get("saveImages") == "enable"){ ?>
	<div class='col-md-2 col-md-offset-1'>
	<button type="button" onclick="location.href='data/temp/bilan_resaJPG.jpg'" download="bilan_reservations<?php echo $annee?>" class="btn btn-primary" id="navlink"><?php echo  SyTranslator::Export_as_jpeg($lang) ?></button>
	</div>
	<?php } ?>
	
	
	
<!-- -------------------------------------------- -->
<!-- Plot the curve time reservations in a year -->
<!-- -------------------------------------------- -->
<?php
$titre = '<text x="375" y="30" fill="black" stroke-width="0px" stroke="black" font-size="15px" text-anchor="middle">' . SyTranslator::Annual_review_of_the_time_of_reservations_of($lang) . Configuration::get("name") . '</text>';
$stat = '<text x="670" y="110" fill="black" stroke-width="0px" stroke="black" font-size="15px" text-anchor="start">' . SyTranslator::Year($lang) . ": " . $annee . '</text>';
$stat .= '<text x="670" y="130" fill="black" stroke-width="0px" stroke="black" font-size="15px" text-anchor="start">' . SyTranslator::Reservation_time($lang) . ": " . $this->clean($graphTimeArray["timeTotal"]) . '</text>';
$graph = $graphTimeArray["graph"];
$m = max ( $graph );
if ($m == 0) {
	$m = 1;
}
$inc = 250 / $m; // incrément selon l'axe y
$aff = ceil ( $m / 10 );

$i = 0;
$igrec = 300;
$axeY = '';
while ( $igrec > 50 ) {
	$igrec = round ( 300 - $i * $aff * $inc );
	$val = $aff * $i;
	$axeY .= '<text x="90" y="' . $igrec . '" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="end" baseline-shift="-0.5ex">' . $val . '</text>';
	$i ++;
}

$path = "M";
$points = '';
$courbe = '';
for($i = 1; $i <= 12; $i ++) {
	$x = 100 + ($i - 1) * 50;
	$y = round ( 300 - ($graph [$i] * $inc) );
	if ($i != 1) {
		$path .= " L";
	}
	$path .= " " . $x . " " . $y;
	$points .= '<circle cx="' . $x . '" cy="' . $y . '" r="3" fill="black" stroke-width="3" stroke="black"/>';
}

$courbe .= '<path d="' . $path . '" fill="none" stroke-width="1px" stroke="red"/>';

?>

<div class="row">
<div class='col-md-9 col-md-offset-1 text-center'id="graph-area">
		<?php
		$gAnnee2 = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xml="fr" width="950" height="360">';
		$gAnnee2 .= '<g><rect x="0" y="0" width="950" height="360" style="fill:white;stroke:black;stroke-width:0"/></g>';
		$gAnnee2 .= '<g><rect x="100" y="50" width="550" height="250" style="fill:#dfdfdf;stroke:black;stroke-width:2"/></g>';
		$gAnnee2 .= '<g>';
		$gAnnee2 .= $titre;
		$gAnnee2 .= $stat;
		$gAnnee2 .= '</g>';
		$gAnnee2 .= '<g>';
		$gAnnee2 .= '<text x="375" y="350" fill="black" stroke-width="0px" stroke="black" font-size="15px" text-anchor="middle">'. SyTranslator::Year($lang) . " " .  $annee . '</text>';
		$gAnnee2 .= '<text x="100" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">'. SyTranslator::Jan($lang). '</text>';
		$gAnnee2 .= '<text x="150" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">'. SyTranslator::Feb($lang). '</text>';
		$gAnnee2 .= '<text x="200" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">'. SyTranslator::Mar($lang). '</text>';
		$gAnnee2 .= '<text x="250" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">'. SyTranslator::Apr($lang). '</text>';
		$gAnnee2 .= '<text x="300" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">'. SyTranslator::May($lang). '</text>';
		$gAnnee2 .= '<text x="350" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">'. SyTranslator::Jun($lang). '</text>';
		$gAnnee2 .= '<text x="400" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">'. SyTranslator::July($lang). '</text>';
		$gAnnee2 .= '<text x="450" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">'. SyTranslator::Aug($lang). '</text>';
		$gAnnee2 .= '<text x="500" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">'. SyTranslator::Sept($lang). '</text>';
		$gAnnee2 .= '<text x="550" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">'. SyTranslator::Oct($lang). '</text>';
		$gAnnee2 .= '<text x="600" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">'. SyTranslator::Nov($lang). '</text>';
		$gAnnee2 .= '<text x="650" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">'. SyTranslator::Dec($lang). '</text>';
		$gAnnee2 .= '</g>';
		$gAnnee2 .= '<g>';
		$gAnnee2 .= '<text x="60" y="175" fill="black" stroke-width="0px" stroke="black" font-size="15px" text-anchor="middle" baseline-shift="-0.5ex" transform="rotate(-90,60,175)"> '. SyTranslator::Reservation_time($lang) .'</text>';
		$gAnnee2 .= $axeY;
		$gAnnee2 .= '</g>';
		$gAnnee2 .= $points;
		$gAnnee2 .= $courbe;
		$gAnnee2 .= '</svg>';
		
		echo $gAnnee2;
		
		if (Configuration::get("saveImages") == "enable"){
			$nameFile = "data/temp/bilan_resaSVG.svg";
			$openFile = fopen($nameFile,"w");
			$toWrite = $gAnnee2;
			fwrite($openFile, $toWrite);
			fclose($openFile);
			
			exec('sudo /usr/bin/inkscape -D data/temp/bilan_resaSVG.svg -e data/temp/bilan_resaJPG.jpg -b "#ffffff" -h800');
		}
		?>
	</div>
	<?php if (Configuration::get("saveImages") == "enable"){ ?>
	<div class='col-md-2 col-md-offset-1'>
	<button type="button" onclick="location.href='data/temp/bilan_resaJPG.jpg'" download="bilan_reservations<?php echo $annee?>" class="btn btn-primary" id="navlink"><?php echo  SyTranslator::Export_as_jpeg($lang) ?></button>
	</div>
	<?php } ?>	
	
<!-- -------------------------------------------- -->
<!-- Plot the camembert -->
<!-- -------------------------------------------- -->	

		<div class='col-md-9 col-md-offset-1 text-center' id="camembert-area">
		<h3> <?php echo  SyTranslator::Booking_number_year($lang) ?>  </h3>
		<?php
			$camembert = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 600" width="600" height="300" font-family="Verdana">';
			$camembert .= '<title> </title>';
			$camembert .= '<desc></desc>';
			$camembert .= $camembertContent;		
			$camembert .= '</svg>';
			echo $camembert;
			
			if (Configuration::get("saveImages") == "enable"){
				$nameFile = "data/temp/camembert_resaSVG.svg";
				$openFile = fopen($nameFile,"w");
				$toWrite = $camembert;
				fwrite($openFile, $toWrite);
				fclose($openFile);
		
				exec('sudo /usr/bin/inkscape -D data/temp/camembert_resaSVG.svg -e data/temp/camembert_resaJPG.jpg -b "#ffffff" -h800');
			}
		?>
		</div>
		<?php if (Configuration::get("saveImages") == "enable"){ ?>
		<div class='col-md-2 col-md-offset-1'>
		<button type="button" onclick="location.href='data/temp/camembert_resaJPG.jpg'" download="pie_chart_booking<?php echo $annee?>" class="btn btn-primary" id="navlink"><?php echo  SyTranslator::Export_as_jpeg($lang) ?></button>
		</div>
		<?php }?>
		
</div>

<!-- -------------------------------------------- -->
<!-- Plot the camembert -->
<!-- -------------------------------------------- -->	

		<div class='col-md-9 col-md-offset-1 text-center' id="camembert-area">
		<h3> <?php echo  SyTranslator::Booking_time_year($lang) ?> </h3>
		<?php
			$camembert2 = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 600" width="600" height="300" font-family="Verdana">';
			$camembert2 .= '<title> </title>';
			$camembert2 .= '<desc></desc>';
			$camembert2 .= $camembertTimeContent;		
			$camembert2 .= '</svg>';
			echo $camembert2;
			
			if (Configuration::get("saveImages") == "enable"){
				$nameFile = "data/temp/camembert_resaSVG.svg";
				$openFile = fopen($nameFile,"w");
				$toWrite = $camembert2;
				fwrite($openFile, $toWrite);
				fclose($openFile);
		
				exec('sudo /usr/bin/inkscape -D data/temp/camembert_resaSVG.svg -e data/temp/camembert_resaJPG.jpg -b "#ffffff" -h800');
			}
		?>
		</div>
		<?php if (Configuration::get("saveImages") == "enable"){ ?>
		<div class='col-md-2 col-md-offset-1'>
		<button type="button" onclick="location.href='data/temp/camembert_resaJPG.jpg'" download="pie_chart_booking<?php echo $annee?>" class="btn btn-primary" id="navlink"><?php echo  SyTranslator::Export_as_jpeg($lang) ?></button>
		</div>
		<?php }?>
		
</div>
