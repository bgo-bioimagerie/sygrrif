<?php $this->title = "Supplies Bills"?>

<?php echo $navBar?>

<head>

</head>

<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="col-md-8 col-md-offset-2">
	<?php echo $tableHtml?>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>

