<?php $this->title = "SyGRRiF edit Authorization"?>

<?php echo $navBar?>

<head>
<link href="externals/datepicker/css/bootstrap-datetimepicker.css" rel="stylesheet">
<style>
#button-div{
	padding-top: 20px;
}

</style>


</head>

<?php
$modelCoreConfig = new CoreConfig();
$authorisations_location = $modelCoreConfig->getParam("sy_authorisations_location");

include "Modules/sygrrif/View/navbar.php";

?>

<br>
<div class="col-md-6 col-md-offset-3">
<?php echo $formHtml ?>
</div>

<?php include 'Modules/core/View/timepicker_script.php'?>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
