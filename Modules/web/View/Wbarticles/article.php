<?php $this->title = "Platform-Manager"?>

<head>
    <link href="Modules/web/View/Wbarticles/article.css" rel="stylesheet"> 
    <link href="externals/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="Themes/navbar-fixed-top.css" rel="stylesheet">
    
    <style>


#keylink{
	color:#000000;
}

h1{
	color:#337ab7; /* color:#018181; */
	font-size: 150%;
	text-transform:uppercase;
	border-bottom: 1px solid #337ab7;
}

h2{
	color:#337ab7;
	font-size: 115%;
	border-bottom: 1px solid #337ab7;
}

h3{
	color:#337ab7;
	font-size: 100%;
	border-bottom: 1px solid #337ab7;
}

#nav_title{
color:#337ab7;
	font-size: 150%;
	/*text-transform:uppercase;*/
	border-bottom: 1px solid #337ab7;
}

#nav_link{
	color:#313131;
}

p{
text-indent: 50px;
text-align: justify;
}
</style>

</head>

<div class="col-lg-12" style="background-color: #fff; border-bottom: 1px solid #e1e1e1;">
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
