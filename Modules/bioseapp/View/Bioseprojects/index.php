<?php $this->title = "Pltaform-Manager" ?>

<?php echo $navBar ?>

<?php 
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>

<div class="container">
	
    
        <?php if($tableHtml == ""){
            ?>
            <div class="col-xs-12" style="height:100px;">
                <p></p>
            </div>   
    
            <div class="col-xs-6 col-xs-offset-3" style="height:100px; border: 1px dashed #000; text-align: center;">
                <p> <?php echo BiTranslator::NewProjectText($lang) ?></p> 
                <button class="btn btn-primary" type="button" onclick="location.href = 'bioseproject/info'" ><?php echo BiTranslator::NewProject($lang) ?></button> 
            </div>    
            <?php
        }
        else{
            ?>
            <div class="col-xs-12" style="height:100px;">
                <p></p>
            <div class="col-xs-2 col-xs-offset-10">    
                    <button class="btn btn-primary" type="button" onclick="location.href = 'bioseproject/info'" ><?php echo BiTranslator::NewProject($lang) ?></button> 
            </div>
            </div>  
    <div class="col-xs-12" style="margin-top: -50px;">
            <?php echo $tableHtml ?>
        </div>  
        <?php } ?>    
        
</div> <!-- /container -->




<?php if (isset($msgError)): ?>
    <p><?php echo  $msgError ?></p>
<?php endif;
