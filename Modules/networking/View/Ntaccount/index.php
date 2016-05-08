<?php $this->title = "Pltaform-Manager"?>

<?php echo $navBar?>

<div class="col-xs-12" style="background-color: #e9eaed;">
    <p></p>
</div>
<div class="col-xs-12" style="background-color: #e9eaed;">
    <?php include 'Modules/networking/View/navbar.php'; ?>
    <div class="col-md-10" style="padding: 25px; background-color: #fff; border: 1px solid #ccc; border-radius: 5px;">
        <?php include "Modules/core/view/Coreusers/manageaccount.php" ?>
    </div>    
    
</div>
<div class="col-xs-12" style="background-color: #e9eaed; height:2000px;">
    <p></p>
</div>


<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif;
