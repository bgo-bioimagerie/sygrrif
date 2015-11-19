<?php $this->title = "SyGRRiF Visa"?>

<?php echo $navBar?>

<?php
$modelCoreConfig = new CoreConfig();
$authorisations_location = $modelCoreConfig->getParam("sy_authorisations_location");

include "Modules/sygrrif/View/navbar.php"; 
?>

<br>
<div class="col-md-6 col-md-offset-3">
	<?php echo $tableHtml ?>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
