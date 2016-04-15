<?php $this->title = "Supplies Bills"?>

<?php echo $navBar?>

<head>

</head>

<?php include "Modules/supplies/View/navbar.php"; ?>

<br>
<div class="col-md-12">
	
	<?php echo $tableHtml ?>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
