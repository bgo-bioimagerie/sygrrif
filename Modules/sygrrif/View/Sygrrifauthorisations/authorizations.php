<?php $this->title = "SyGRRiF Authorizations"?>

<?php echo $navBar?>

<?php
$modelCoreConfig = new CoreConfig();
$authorisations_location = $modelCoreConfig->getParam("sy_authorisations_location");
	
include "Modules/sygrrif/View/navbar.php"; 
?>

<br>
<div class="col-md-8 col-md-offset-2">
	<?php echo $tableHtml ?>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
