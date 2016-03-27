<?php $this->title = "Pltaform-Manager" ?>

<?php echo $navBar ?>
<?php include "Modules/bioseapp/View/Bioseproject/tabs.php"; ?>

<?php 
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>

<head>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">

<script type="text/javascript">
            $(document).ready(function() {
                <?php foreach($mainCols as $mainCol){  
                    ?>
                    $('#wrapper_<?php echo $mainCol["id"]?>').dialog({
                        autoOpen: false,
                        title: 'Basic Dialog'
                    });
                    $('#opener_<?php echo $mainCol["id"]?>').click(function() {
                        $('#wrapper_<?php echo $mainCol["id"]?>').dialog('open');
    //                  return false;
                    });
                    
                <?php } ?>
            });
        </script>
    
</head>

<!--
Display the properties
-->
<?php foreach($mainCols as $mainCol){
    ?>

    <div id="wrapper_<?php echo $mainCol["id"]?>" class="col-xs-12">
        <?php echo file_get_contents("data/bioseapp/proj_".$id_proj."/col_".$mainCol["id"]."/info.txt"); ?>
    </div>

<?php
}
?>


<div class="col-xs-12">
	
    <p style="height:15px;"> </p>
    
    <table class="table table-striped table-bordered">
        <thead>	 
            <tr>
                <?php foreach($mainCols as $mainCol){
                ?>
                    <th class="text-center" colspan="<?php echo $mainCol["num_sub_col"] ?>" style="color:#337AB7;"><?php echo $mainCol["name"] ?>
                    <?php if ($mainCol["name"] != "Data"){
                        ?>
                    <button id="opener_<?php echo $mainCol["id"] ?>" class="btn btn-xs btn-default" ><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></button>
                        <button id="remover" class="btn btn-xs btn-default" ><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                   
                    <?php } ?>
                    
                        
                    </th>
                <?php
                }
                ?>
            </tr>		 
            <tr>			
               <?php foreach($mainCols as $mainCol){
                   foreach($subCols as $subCol){
                        if ($subCol["id_main_col"] == $mainCol["id"]){
                        ?>
                            <th class="text-center" style="color:#337AB7;"><?php echo $subCol["name"] ?>
                            </th>
                        <?php    
                       }
                   }
                }
                ?>
            </tr>
	</thead>
	<tbody>
           
            <?php
                $modelProjectData = new BiProjectData();
                foreach($lineIdxs as $lineIdx){
            ?>
                <tr> 
            <?php
                    foreach($mainCols as $mainCol){
                        foreach($subCols as $subCol){
                            if ($subCol["id_main_col"] == $mainCol["id"]){
                                
                                $lineData = $modelProjectData->getLineData($id_proj, $subCol["id"], $lineIdx[0]);
                                
                                ?>
                    
                                <?php
                                if($subCol["datatype"] == "image" || $subCol["name"] == "Data"){
                                    
                                    $imageFile = $lineData ['url'];
                                    if (!file_exists($imageFile) || is_dir($imageFile)){
                                        $imageFile = "Modules/catalog/View/images_icon.png";
                                    }
                                    list($width, $height, $type, $attr) = getimagesize($imageFile);
                                    ?>
                                    <td>
                                        <a href="<?php echo $imageFile?>" itemprop="contentUrl" data-size="<?php echo $width?>x<?php echo $height?>">
                                            <img src="<?php echo $imageFile?>" itemprop="thumbnail" alt="photo" width="100" height="100"/>
                                        </a>
                                    </td>
                                <?php
                                }
                                else{
                                ?>
                    
                    
                    
                    
                                    <td class="text-left"><?php echo $lineData ['url'] ?></td>
                                <?php
                                }
                            }
                        }
                    }
             ?>
               </tr>
            <?php
            } 
            ?>
        </tbody> 
    </table>
    
        
</div> <!-- /container -->




<?php if (isset($msgError)): ?>
    <p><?php echo  $msgError ?></p>
<?php endif;
