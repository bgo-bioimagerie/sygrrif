<?php $this->title = "Pltaform-Manager"?>

<?php echo $navBar?>

<div class="col-xs-12" style="background-color: #e9eaed;">
    <p></p>
</div>
<div class="col-xs-12" style="background-color: #e9eaed;">
    
    <?php include 'Modules/networking/View/navbar.php'; ?>
    
    <div class="col-xs-6" style="padding: 25px; background-color: #fff; border: 1px solid #ccc; border-radius: 5px;">
    

        <form role="form" class="form-horizontal" action="ntgroups/deletequery/" method="post">
        
            <input type="hidden" name="id_group" value="<?php echo $group["id"] ?>">
            
            <p> 
            <?php echo NtTranslator::ConfirmDeleteGroup($group["name"], $lang) ?>
            </p>
            <input type="submit" class="btn btn-primary" value="<?php echo CoreTranslator::Ok($lang) ?>"/>
            <button type="button" onclick="location.href='ntgroups/edit/<?php echo $group["id"] ?>'" class="btn btn-default"><?php echo CoreTranslator::Cancel($lang) ?></button>
    	
        
        </form>
            
            
    </div>
 
</div>
<div class="col-xs-12" style="background-color: #e9eaed; height:2000px;">
    <p></p>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif;
