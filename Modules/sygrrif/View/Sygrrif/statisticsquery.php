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
$titre = '<text x="375" y="30" fill="black" stroke-width="0px" stroke="black" font-size="15px" text-anchor="middle">Annual review of the number of reservations of ' . Configuration::get("name") . '</text>';
$stat = '<text x="670" y="110" fill="black" stroke-width="0px" stroke="black" font-size="15px" text-anchor="start">Year ' . $annee . '</text>';
$stat .= '<text x="670" y="130" fill="black" stroke-width="0px" stroke="black" font-size="15px" text-anchor="start">Reservations number : ' . $numTotal . '</text>';

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
		$gAnnee .= '<text x="375" y="350" fill="black" stroke-width="0px" stroke="black" font-size="15px" text-anchor="middle">Year ' . $annee . '</text>';
		$gAnnee .= '<text x="100" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">Janv.</text>';
		$gAnnee .= '<text x="150" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">Févr.</text>';
		$gAnnee .= '<text x="200" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">Mars</text>';
		$gAnnee .= '<text x="250" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">Avri.</text>';
		$gAnnee .= '<text x="300" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">Mai</text>';
		$gAnnee .= '<text x="350" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">Juin</text>';
		$gAnnee .= '<text x="400" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">Juil</text>';
		$gAnnee .= '<text x="450" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">Août</text>';
		$gAnnee .= '<text x="500" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">Sept.</text>';
		$gAnnee .= '<text x="550" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">Oct.</text>';
		$gAnnee .= '<text x="600" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">Nov.</text>';
		$gAnnee .= '<text x="650" y="320" fill="black" stroke-width="0px" stroke="black" font-size="12px" text-anchor="middle">Déc.</text>';
		$gAnnee .= '</g>';
		$gAnnee .= '<g>';
		$gAnnee .= '<text x="60" y="175" fill="black" stroke-width="0px" stroke="black" font-size="15px" text-anchor="middle" baseline-shift="-0.5ex" transform="rotate(-90,60,175)">Reservations number</text>';
		$gAnnee .= $axeY;
		$gAnnee .= '</g>';
		$gAnnee .= $points;
		$gAnnee .= $courbe;
		$gAnnee .= '</svg>';
		
		echo $gAnnee;
		
		//$nameFile = "temp/bilan_resaSVG.svg";
		//$openFile = fopen($nameFile,"w");
		//$toWrite = $gAnnee;
		//fwrite($openFile, $toWrite);
		//fclose($openFile);
		
		//exec('sudo /usr/bin/inkscape -D temp/bilan_resaSVG.svg -e temp/bilan_resaJPG.jpg -b "#ffffff" -h800');
		
		?>
	</div>
	<div class='col-md-2 col-md-offset-1'>
	<button type="button" onclick="location.href='temp/bilan_resaJPG.jpg'" download="bilan_reservations<?=$annee?>" class="btn btn-primary" id="navlink">Export as jpeg</button>
	</div>
<!-- -------------------------------------------- -->
<!-- Plot the camembert -->
<!-- -------------------------------------------- -->	

		<div class='col-md-9 col-md-offset-1 text-center' id="camembert-area">

		<?php
			$camembert = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 600" width="500" height="300" font-family="Verdana">';
			$camembert .= '<title>Best Foods</title>';
			$camembert .= '<desc></desc>';
			$camembert .= $camembertContent;		
			$camembert .= '</svg>';
			echo $camembert;
			
			//$nameFile = "temp/camembert_resaSVG.svg";
			//$openFile = fopen($nameFile,"w");
			//$toWrite = $camembert;
			//fwrite($openFile, $toWrite);
			//fclose($openFile);
		
			//exec('sudo /usr/bin/inkscape -D temp/camembert_resaSVG.svg -e temp/camembert_resaJPG.jpg -b "#ffffff" -h800');
		?>
		</div>
		<div class='col-md-2 col-md-offset-1'>
		<button type="button" onclick="location.href='temp/camembert_resaJPG.jpg'" download="pie_chart_booking<?=$annee?>" class="btn btn-primary" id="navlink">Export as jpeg</button>
		</div>
</div>
