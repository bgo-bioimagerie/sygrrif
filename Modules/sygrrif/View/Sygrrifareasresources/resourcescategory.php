<?php $this->title = "SyGRRiF resource categories"?>

<?php echo $navBar?>
<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
		<?php echo $tableHtml ?>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
