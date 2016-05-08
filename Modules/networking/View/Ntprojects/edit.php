<?php $this->title = "Pltaform-Manager"?>

<?php echo $navBar?>

<div class="col-xs-12" style="background-color: #e9eaed;">
    <p></p>
</div>
<div class="col-xs-12" style="background-color: #e9eaed;">
    
    <?php include 'Modules/networking/View/navbar.php'; ?>
    
    <div class="col-xs-9">
    <div class="col-xs-12" style="padding: 25px; background-color: #fff; border: 1px solid #ccc; border-radius: 5px;">
    
        <p style="border-bottom: 1px solid #ddd; text-transform: uppercase;"><?php echo NtTranslator::Project_info($lang) ?></p>
        <div class="col-xs-12"> 
            <?php echo $formHtml; ?> 
        </div>
    </div>
    </div>
    
</div>
<div class="col-xs-12" style="background-color: #e9eaed; height:2000px;">
    <p></p>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif;
