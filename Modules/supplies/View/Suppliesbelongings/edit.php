<?php $this->title = "Pltaform-Manager"?>

<?php echo $navBar?>
<?php include "Modules/supplies/View/navbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-6 col-md-offset-3">
	
	<?php echo  $editForm ?>
	
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
