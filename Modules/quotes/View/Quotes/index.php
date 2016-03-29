<?php $this->title = "Pltaform-Manager"?>

<?php echo $navBar?>
<?php include('Modules/quotes/View/navbar.php') ?>

<div class="col-xs-12">
    <?php echo $tableHtml; ?> 
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif;
