<?php $this->title = "Pltaform-Manager"?>

<?php echo $navBar?>

<div class="col-xs-12" style="background-color: #e9eaed;">
    <p></p>
</div>
<div class="col-xs-12" style="background-color: #e9eaed;">
    <?php include 'Modules/networking/View/navbar.php'; ?>
    <div class="col-md-10">
        
    </div>    
    
</div>
<div class="col-xs-12" style="background-color: #e9eaed; height:2000px;">
    <p></p>
</div>


<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif;
