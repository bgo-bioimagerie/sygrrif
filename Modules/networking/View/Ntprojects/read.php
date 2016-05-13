<?php $this->title = "Pltaform-Manager"?>

<?php echo $navBar?>

<div class="col-xs-12" style="background-color: #e9eaed; padding-top: 50px;">
    <p></p>
</div>
<div class="col-xs-12" style="background-color: #e9eaed;">
    
    <?php include 'Modules/networking/View/navbar.php'; ?>
    
    <div class="col-xs-6">
    <div class="col-xs-12" style="padding: 25px; background-color: #fff; border: 1px solid #ccc; border-radius: 5px;">
    
        <p style="border-bottom: 1px solid #ddd; font-size: 24px; text-align: center;"><?php echo $project["name"] ?></p>
        <div class="col-xs-12 text-center"> 
            <img src="<?php echo $project["image_url"] ?>" alt="" style="max-width:50%;">
        </div>  
        <div class="col-xs-12"> 
            <p style="border-bottom: 1px solid #ddd; text-transform: uppercase"><?php echo NtTranslator::adressed_problem($lang) ?></p>
            
            <p><?php echo $project["adressed_problem"] ?></p>
            <br/>
        </div> 
        <div class="col-xs-12"> 
            <p style="border-bottom: 1px solid #ddd; text-transform: uppercase"><?php echo NtTranslator::expected_results($lang) ?></p>
            
            <p><?php echo $project["expected_results"] ?></p>
            <br/>
        </div>  
        <div class="col-xs-12"> 
            <p style="border-bottom: 1px solid #ddd; text-transform: uppercase"><?php echo NtTranslator::protocol($lang) ?></p>
            
            <p><?php echo $project["protocol"] ?></p>
            <br/>
        </div>  
         <div class="col-xs-2 col-xs-offset-10">    
        <button type="button" class="btn btn-primary" onclick="window.location.href='ntprojects/edit/<?php echo $project["id"] ?>'">
        <?php echo CoreTranslator::Edit($lang) ?>
        </button>
         </div>
        
    </div>
    <?php if ($project_id > 0){?>
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
    <?php if ($project_id > 0){?>
    
    <div class="col-xs-4">
    
    <div class="col-xs-12" style="padding: 25px; background-color: #fff; border: 1px solid #ccc; border-radius: 5px;">
        <div class="col-xs-12">
        <p style="border-bottom: 1px solid #ddd; text-transform: uppercase;"><?php echo NtTranslator::Files($lang) ?></p>
        <?php echo $formFilesHtml ?>
        </div>
        <div class="col-xs-12">
        <p style="border-bottom: 1px solid #ddd; margin-top:12px;"></p>
        <ul style="padding-left: 5px; padding-top: 5px;">
            <?php 
            foreach ($dataList as $data){
                ?>
            <li>
                <a href="<?php echo $data["data_url"] ?>"><?php echo str_replace("data/networking/projects/", "", $data["data_url"]) ?></a>
                    
            </li> 
            <?php } ?> 
            
        </ul>    
           </div>
    </div>    
        
    <div class="col-xs-12" style="padding: 25px; background-color: #fff; border: 1px solid #ccc; border-radius: 5px;">
        <div class="col-xs-12">
            <p style="border-bottom: 1px solid #ddd; text-transform: uppercase;"><?php echo CoreTranslator::Users($lang) ?></p>
            <?php echo $formUserHtml ?>
        </div>
        <div class="col-xs-12">
            <p style="border-bottom: 1px solid #ddd; margin-top:12px;"></p>
            <?php echo $groupusershtml ?> 
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
