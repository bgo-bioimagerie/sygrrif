<?php $this->title = "Platform-Manager"?>

<?php echo $navBar?>
<?php include "Modules/web/View/webnavbar.php" ?>

<div class="col-xs-12">
	<?php echo $tableHtml ?>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif;
