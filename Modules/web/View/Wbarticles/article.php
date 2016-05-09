<?php $this->title = "Platform-Manager"?>

<head>
    <link href="Modules/web/View/Wbarticles/article.css" rel="stylesheet"> 
    
    <link href="externals/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="Themes/navbar-fixed-top.css" rel="stylesheet">
</head>

<div class="col-lg-12" style="background-color: #f1f1f1; border-bottom: 0px solid #e1e1e1;">
<div class="col-lg-offset-1">
<h4><?php echo $article["title"] ?></h4>
</div>
</div>

<div class="col-lg-12">
<br/>
</div>

<div class="col-xs-12">
	
    <?php if($article["id_parent_menu"] > 0){ ?>
    <!-- MENU -->
    <div class="col-md-2 col-md-offset-1" style="margin-top:25px; background-color:#f1f1f1;">

    <h5 id="nav_title">
    <?php echo $menuInfo["title"] ?>
    </h5>
    <ul>
        <?php foreach ($menuItems as $item){ ?>
            <li><a id="nav_link" href="<?php echo $item["url"] ?>"> <?php echo $item["title"] ?> </a></li>
        <?php } ?>
    </ul>
    </div>
    <?php } ?>
    
    <!-- CONTENT -->
    <?php if($article["id_parent_menu"] > 0){ ?>
        <div class="col-md-8" style="margin-top:25px;">
    <?php }else{ ?>  
        <div class="col-md-12" style="margin-top:25px;">    
    <?php } 
        echo $article["content"]
    ?>    
    </div>        
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif;
