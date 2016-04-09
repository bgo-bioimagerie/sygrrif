<?php $this->title = "Platform-Manager"?>

<?php echo $navBar?>
<?php include "Modules/petshop/View/petshopnavbar.php"; ?>

<br>
<div class="container">
    <?php echo $tableHtml ?>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
