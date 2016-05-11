<?php $this->title = "bioimagerie" ?>

<?php require_once "Modules/agenda/View/Agenda/agendafunction.php";?>

<head>
    <link href="externals/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="Themes/styleagenda.css" rel="stylesheet" type="text/css" />
</head>

<div class="col-lg-12" style="background-color: #fff; border-bottom: 1px solid #e1e1e1;">
<div class="col-lg-offset-1">
<h4>Info / Actu</h4>
</div>
</div>

<div class="col-lg-12">

<?php include("Modules/agenda/View/Agenda/agendanav.php")?>

<div class="col-lg-9" style="margin-top:25px;">
<!-- AGENDA TABLE -->
<?php 
drawAgenda($month, $year, $events);
?>
</div>


<!-- color code -->
<div class="col-lg-12" style="margin-top: 20px;">

	<?php 
	$cmpt = 0;
	$colorcodes = $eventTypes;
	for ($i = 0 ; $i < count($colorcodes) ; $i++){
		$colorcode = $colorcodes[$i];
		$name = $this->clean($colorcode["name"]);
		$color = $this->clean($colorcode["color"]);
		$cmpt++;
	if ($cmpt == 1){
		?>
		<div class="col-lg-12">
		<?php 
	}	
	?>
	
	<div class="col-xs-2">
		<p class="text-center" id="colorparagraph" style="background-color: <?=$color?>;"><?=$name?></p>
	</div>
	<?php 
		if ($cmpt == 6 || $i == count($colorcodes)-1){
		?>
			</div>
			<?php 
			$cmpt=0;
		}	
	}
	?>

</div>

</div>




	
<?php if (isset($msgError)): ?>
    <p><?= $msgError ?></p>
<?php endif; ?>
