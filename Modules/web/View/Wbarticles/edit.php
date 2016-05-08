<?php $this->title = "Platform-Manager"?>

<?php echo $navBar?>
<?php include "Modules/web/View/webnavbar.php" ?>

<div class="col-xs-12">
	<?php echo $formHtml ?>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif;
