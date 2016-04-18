<?php $this->title = "Platform-Manager" ?>

<?php echo $navBar ?>

<?php include "Modules/petshop/View/petshopnavbar.php"; ?>

<?php if (isset($msgError)): ?>
    <p><?= $msgError ?></p>
<?php endif; ?>
