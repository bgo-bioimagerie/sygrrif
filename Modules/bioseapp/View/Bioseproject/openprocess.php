<?php $this->title = "Platform-Manager" ?>

<?php echo $navBar ?>
<?php include "Modules/bioseapp/View/Bioseproject/tabs.php"; ?>


<div class="col-xs-12" style="border-top: 1px solid #dddddd; margin-top: 15px;">
    
</div>
<div class="col-xs-12">
    
    <div class="col-xs-4">
        
        <form role="form" class="form-horizontal" action="bioseproject/runprocess"
          method="post">
        <?php 
        $toolName = "tophat";
        if($toolName == "tophat"){
            include "Modules/bioseapp/View/Bioseproject/tophatparams.php"; 
        }
        else if($toolName == "wilcoxon"){
            include "Modules/bioseapp/View/Bioseproject/wilcoxonparams.php"; 
        }
        
        ?>
        
        <input type="hidden" name="id_proj" value="<?php echo $id_proj?>">    
            
        <!-- RUN BUTTON -->
        <div class="col-xs-12" style="margin-top: 15px;">
            <div class="col-xs-3 col-xs-offset-9">
                <input type="submit" class="btn btn-primary" value="Run"> 
            </div>
        </div>
        
        
    </div>
    <div class="col-lg-8">
        <?php include "www.google.com" ?>
    </div>
    
</div>


<?php if (isset($msgError)): ?>
    <p><?php echo $msgError ?></p>
<?php endif;
