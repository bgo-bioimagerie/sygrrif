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
    <h4><?php echo WbTranslator::NewArticles($lang) ?></h4>
</div>
</div>

<div class="col-lg-12">
<br/>
</div>

<div class="col-xs-12">
	
    <?php foreach($articles as $article){
        ?>
    <div class="col-xs-12" style="border-top: 0px solid #999999;">
    <h2> <?php echo $article["title"] ?></h2>
    <p style="font-style: italic"> <?php echo WbTranslator::EditedThe($lang) . " " . CoreTranslator::dateFromEn(date("Y-m-d", $article["date_modified"]), $lang) ?></p>
    <p> <?php echo $article["short_desc"] ?></p>
    <button class="btn btn-default" onclick="location.href='wbarticles/article<?php echo $article["id"]?>'"><?php echo WbTranslator::ReadMore($lang) ?></button>
    </div>
        <?php
    }
    ?>
  
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif;
