<?php $this->title = "SyGRRiF Color codes"?>

<?php echo $navBar?>
<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="col-md-6 col-md-offset-3">
	<?php echo $tableHtml ?>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
