<?php $this->title = "SyGRRiF Database" ?>

<?php echo $navBar ?>

<head>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap/datepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">   
</head>

<?php include "Modules/sygrrif/View/navbar.php"; ?>



<!-- -------------------------------------------- -->
<!-- Plot the curve number reservations in a year -->
<!-- -------------------------------------------- -->
<?php
$titre = '<text x="375" y="30" fill="black" stroke-width="0px" stroke="black" font-size="15px" text-anchor="middle">Bilan annuel du nombre de réservations de la plate-forme ' . Configuration::get("name") . '</text>';
$stat = '<text x="670" y="110" fill="black" stroke-width="0px" stroke="black" font-size="15px" text-anchor="start">Année ' . $annee . '</text>';
$stat .= '<text x="670" y="130" fill="black" stroke-width="0px" stroke="black" font-size="15px" text-anchor="start">Nombre de réservations : ' . $numTotal . '</text>';

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
<div class="text-center">
		<?php
		$gAnnee = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xml="fr" width="950" height="360">';
		$gAnnee .= '<g><rect x="0" y="0" width="950" height="360" style="fill:white;stroke:black;stroke-width:0"/></g>';
		$gAnnee .= '<g><rect x="100" y="50" width="550" height="250" style="fill:#dfdfdf;stroke:black;stroke-width:2"/></g>';
		$gAnnee .= '<g>';
		$gAnnee .= $titre;
		$gAnnee .= $stat;
		$gAnnee .= '</g>';
		$gAnnee .= '<g>';
		$gAnnee .= '<text x="375" y="350" fill="black" stroke-width="0px" stroke="black" font-size="15px" text-anchor="middle">Année ' . $annee . '</text>';
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
		$gAnnee .= '<text x="60" y="175" fill="black" stroke-width="0px" stroke="black" font-size="15px" text-anchor="middle" baseline-shift="-0.5ex" transform="rotate(-90,60,175)">Nombre de réservations</text>';
		$gAnnee .= $axeY;
		$gAnnee .= '</g>';
		$gAnnee .= $points;
		$gAnnee .= $courbe;
		$gAnnee .= '</svg>';
		
		echo $gAnnee;
		?>
	</div>
	
<!-- -------------------------------------------- -->
<!-- Plot the camembert -->
<!-- -------------------------------------------- -->	
	<br></br>
<div class="container">
	<div class="row">
		<div class='col-sm-6 col-sm-offset-3'>

		<?php
			$camembert = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 600" width="500" height="300" font-family="Verdana">';
			$camembert .= '<title>Best Foods</title>';
			$camembert .= '<desc></desc>';
			$camembert .= $camembertContent;		
			$camembert .= '</svg>';
			echo $camembert;
		?>
		</div>
	</div>
</div>