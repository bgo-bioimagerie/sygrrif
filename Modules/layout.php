<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <base href="<?php echo  $rootWeb ?>" >
        <title><?php echo  $title ?></title>
    </head>

    <body>
        <?php 
        require_once 'Modules/core/Model/CoreConfig.php';
        $modelConfig = new CoreConfig();
        $menuUrl = $modelConfig->getParam("menuUrl");
        if ($menuUrl != ""){
            include $menuUrl;
            ?>
            <div style="height:40px;"/>
                   <p></p>
            </div>
        <?php
        }
        
        ?>
        
        <div id="contenu"/>
        	<?php echo  $content ?>
        </div>
    </body>
</html>