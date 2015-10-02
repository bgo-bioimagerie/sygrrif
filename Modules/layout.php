<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <base href="<?php echo  $rootWeb ?>" >
        <!-- <link rel="stylesheet" href="Themes/style.css" />  -->
        <title><?php echo  $title ?></title>
    </head>

    <body>
     <!-- 
        <div id="global">
        
            <header>
                <a href=""><h1 id="titreBlog">Mon Blog</h1></a>
                <p>Je vous souhaite la bienvenue sur ce modeste blog.</p>
            </header>
        -->
            <div id="contenu">
                <?php echo  $content ?>
            </div> <!-- #contenu -->
         <!-- 
            <footer id="piedBlog">
                Blog réalisé avec PHP, HTML5 et CSS.
            </footer>
            
        </div> 
     -->    
    </body>

     
</html>