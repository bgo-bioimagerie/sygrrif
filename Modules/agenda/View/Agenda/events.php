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

<!-- MENU -->
<?php include("Modules/agenda/View/Agenda/agendanav.php")?>

<!-- 
<div class="col-lg-2 col-lg-offset-1" style="background-color: #f1f1f1; margin-top:50px; padding-top:10px;">
<ul>
<?php 
foreach ($allevents as $event){
	?>
	<li><a href="agenda/events/<?= $event["id"] ?>" style="color:#515151;">
	<?php echo CoreTranslator::dateFromEn($event["date_begin"], $lang) . " " . $event["name"]  ?>
	</a></li>
	
	<?php
}
?>
</ul>

</div>
-->
<!-- DISPLAY EVENTS -->
<div class="col-lg-9" style="margin-top:50px;">
<?php 
foreach ($events as $event){
?>

<div style="border-bottom: thin solid #e1e1e1">

<div style="background-color:#f1f1f1; padding-top:10px; padding-bottom:5px; padding-left:10px;">
<p style="text-transform:uppercase;; color:#337ab7;"><?= $event["name"] ?></p>
<p>
    <b>date début:</b>  <?php echo CoreTranslator::dateFromEn($event["date_begin"], $lang) ?>
     <?php echo $event["time_begin"] ?>
<br/>
<b>date fin:</b> <?php echo CoreTranslator::dateFromEn($event["date_end"], $lang) ?> <?php echo $event["time_end"] ?>
</p>
</div>

<div style="padding-left:10px;">
<?php echo $event["content"] ?>
</div>
</div>

<?php 
}
?>


</div>
</div>


<?php if (isset($msgError)): ?>
    <p><?= $msgError ?></p>
<?php endif; ?>
