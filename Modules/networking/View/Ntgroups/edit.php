<?php $this->title = "Pltaform-Manager"?>

<?php echo $navBar?>
<?php include 'Modules/networking/View/adminnavbar.php'; ?>

<div class="col-xs-12">
    <?php echo $formHtml; ?> 
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif;
