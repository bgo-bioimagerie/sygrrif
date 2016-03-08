<?php $this->title = "SyGRRiF Project bill"?>

<?php echo $navBar?>
	
<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="col-md-8 col-md-offset-2">
	<?php echo $formHtml ?>
</div>

<?php include "Modules/core/View/timepicker_script.php" ?>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
