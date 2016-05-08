<?php $this->title = "Pltaform-Manager"?>

<?php echo $navBar?>

<div class="col-xs-12" style="background-color: #e9eaed;">
    <p></p>
</div>
<div class="col-xs-12" style="background-color: #e9eaed;">
    
    <?php include 'Modules/networking/View/navbar.php'; ?>
    
    <div class="col-xs-6">
    <div class="col-xs-12" style="padding: 25px; background-color: #fff; border: 1px solid #ccc; border-radius: 5px;">
    
        <p style="border-bottom: 1px solid #ddd; text-transform: uppercase;"><?php echo NtTranslator::Group_info($lang) ?></p>
        <div class="col-xs-4"> 
            <img src="<?php echo $group["image_url"] ?>" alt="" style="max-width:100%;">
        </div>
        <div class="col-xs-8"> 
            <?php echo $formHtml; ?> 
        </div>
    </div>
    <?php if ($group_id > 0){?>
    <div class="col-xs-12" style="padding: 25px; background-color: #fff; border: 1px solid #ccc; border-radius: 5px;">
        <p style="border-bottom: 1px solid #ddd; text-transform: uppercase;"><?php echo NtTranslator::Comment($lang) ?></p>
        <?php echo $formCommentHtml; ?> 
    </div>
    
    <?php 
    foreach ($comments as $comment){
        ?>
    <div class="col-xs-12" style="padding: 25px; background-color: #fff; border: 1px solid #ccc; border-radius: 5px;">
        <p style="border-bottom: 1px solid #ddd;"> <?php echo  "<b>" . $comment["authorname"] . " " . $comment["authorfirstname"] . "</b> " . NtTranslator::WroteThe($lang) .  " <b>" . CoreTranslator::dateFromEn(date("Y-m-d", $comment["unix_date"]), $lang) . "</b> " . NtTranslator::at($lang) . " " . date("H:i", $comment["unix_date"])  ?> </p>
        <?php echo $comment["text"]; ?> 
    </div> 
        
    <?php } ?>
    <?php }?>
        
    </div>
    <?php if ($group_id > 0){?>
    
    <div class="col-xs-4">
    <div class="col-xs-12" style="padding: 25px; background-color: #fff; border: 1px solid #ccc; border-radius: 5px;">
        <div class="col-xs-12">
        <p style="border-bottom: 1px solid #ddd; text-transform: uppercase;"><?php echo CoreTranslator::Users($lang) ?></p>
        <?php echo $formUserHtml ?>
        </div>
        <div class="col-xs-12">
        <p style="border-bottom: 1px solid #ddd; margin-top:12px;"></p>
        <ul style="padding-left: 5px; padding-top: 5px;">
        <?php echo $groupusershtml ?> 
            
        </ul>    
           </div>
    </div>
        
    </div>    
    <?php } ?>
</div>
<div class="col-xs-12" style="background-color: #e9eaed; height:2000px;">
    <p></p>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif;
