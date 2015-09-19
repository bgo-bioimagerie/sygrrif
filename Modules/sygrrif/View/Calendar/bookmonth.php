<?php $this->title = "SyGRRiF Booking"?>

<?php echo $navBar?>
<?php 
require_once 'Modules/sygrrif/Model/SyBookingSettings.php';
require_once 'Modules/sygrrif/View/Calendar/agendafunction.php'
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="Themes/styleagenda.css" rel="stylesheet" type="text/css" />
</head>

<?php include "Modules/sygrrif/View/bookingnavbar.php"; ?>	
	
<div class="col-lg-12">	
<?php 	
drawAgenda($month, $year, $calEntries, $resourceBase);
?>
</div>

<div class="col-xs-12">
<?php include "Modules/sygrrif/View/colorcodenavbar.php"; ?>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
