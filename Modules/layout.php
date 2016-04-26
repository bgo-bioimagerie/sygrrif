<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <base href="<?php echo  $rootWeb ?>" >
        <title><?php echo  $title ?></title>
        
        <style>
            select {
    -moz-appearance: none;
    background: rgba(0, 0, 0, 0) url("Themes/dropdown.png") no-repeat scroll 100% center / 20px 13px !important;
    border: 1px solid #ccc;
    overflow: hidden;
    padding: 6px 20px 6px 6px !important;
    width: auto;
}
        </style>
            
        
    </head>

    <body>
        <div id="contenu"/>
        	<?php echo  $content ?>
        </div>
    </body>
</html>